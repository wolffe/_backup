<?php
$phpMySQLAutoBackup_version = '1.5.5';

function has_data($value) {
	if(is_array($value)) return(sizeof($value) > 0) ? true : false;
	else return (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) ? true : false;
}

function xmail($to_emailaddress,$from_emailaddress, $subject, $content, $file_name, $backup_type, $newline, $ver) {
	$mail_attached = '';
	$boundary = "----=_NextPart_000_01FB_010".md5($to_emailaddress);
	$mail_attached 	.= "--".$boundary.$newline
					."Content-Type: application/octet-stream;$newline name=\"$file_name\"$newline"
					."Content-Transfer-Encoding: base64$newline"
					."Content-Disposition: attachment;$newline filename=\"$file_name\"$newline$newline"
					.chunk_split(base64_encode($content)).$newline;
	$mail_attached .= "--".$boundary."--$newline";
	$add_header ="MIME-Version: 1.0".$newline."Content-Type: multipart/mixed;$newline boundary=\"$boundary\" $newline";
	$mail_content="--".$boundary.$newline."Content-Type: text/plain; $newline charset=\"iso-8859-1\"$newline"."Content-Transfer-Encoding: 7bit$newline $newline BACKUP Successful...$newline $newline Please see attached for your zipped Backup file; $backup_type $newline If this is the first backup then you should test it restores correctly to a test server.$newline $newline".$mail_attached;
	return mail($to_emailaddress, $subject, $mail_content, "From: $from_emailaddress".$newline."Reply-To:$from_emailaddress".$newline.$add_header);
}

function write_backup($gzdata, $backup_file_name) {
	$fp = fopen(LOCATION.'../backups/'.$backup_file_name, "w");
	fwrite($fp, $gzdata);
	fclose($fp);
	//check folder is protected - stop HTTP access
//	if(!file_exists('.htaccess')) {
//		$fp = fopen(LOCATION.'../backups/.htaccess', "w");
//		fwrite($fp, 'deny from all');
//		fclose($fp);
//	}
}
class transfer_backup {
	public $error = '';
	public function transfer_data($ftp_username,$ftp_password,$ftp_server,$ftp_path,$filename) {
		if(function_exists('curl_exec')) {
			$file=LOCATION.'../backups/'.$filename;
			$fp = fopen($file, "r");
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "ftp://$ftp_username:$ftp_password@$ftp_server.$ftp_path".$filename);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_UPLOAD, 1);
			curl_setopt($ch, CURLOPT_INFILE, $fp);
			curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));
			curl_setopt($ch, CURLOPT_TRANSFERTEXT, 1);
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].' - via Tycoon CRM SQL Backup');
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			if(empty($info['http_code'])) $this->error = "\n\nFTP ERROR - Failed to transfer backup file to remote ftp server";
			else {
				$http_codes = parse_ini_file(LOCATION.'http_codes.ini');
				if($info['http_code'] != 226) $this->error = "\n\nFTP ERROR - server response: \n".$info['http_code'].' '.$http_codes[$info['http_code']]."\nfor more detail please refer to: http://www.w3.org/Protocols/rfc959/4_FileTransfer.html";
			}
			curl_close($ch);
		}
		else $this->error = "\n\nWARNING: FTP will not function as PHP CURL does not exist on your hosting account.";
		return $this->error;
	}
}

class record {
	public $error = "";
	public function save($date, $bytes, $lines) {
		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'phpmysqlautobackup_log' "))==0) {
			$q = "
				CREATE TABLE IF NOT EXISTS `phpmysqlautobackup_log` (
				`date` int(11) NOT NULL,
				`bytes` int(11) NOT NULL,
				`lines` int(11) NOT NULL,
				PRIMARY KEY (`date`))";
			$result = mysql_query($q);
			if(!$result) $this->error = "\n\nMySQL error: ".mysql_error()."\n";
		}
		$query = "INSERT INTO `phpmysqlautobackup_log` (`date`, `bytes`, `lines`) VALUES ('$date', '$bytes', '$lines')";
		$result = mysql_query($query);
		if(!$result) $this->error = "\n\nMySQL error: ".mysql_error()."\n";
		$query = "SELECT date FROM `phpmysqlautobackup_log` ORDER BY `date` DESC LIMIT 0 , ".LOG_REPORTS_MAX;
		$result = mysql_query($query);
		if(!$result) $this->error = "\n\nMySQL error: ".mysql_error()."\n";

		$search_date = mysql_result($result,(mysql_num_rows($result)-1), 'date');
		$query = "DELETE FROM `phpmysqlautobackup_log` where date<'$search_date' ";
		$result = mysql_query($query);
		if(!$result) $this->error = "\n\nMySQL error: ".mysql_error()."\n";
		return $this->error;
	}

	public function get() {
		$query = "SELECT * FROM `phpmysqlautobackup_log` ORDER BY `date` DESC ";
		$result = mysql_query($query);
		if(!$result AND DEBUG) echo '<hr />'.mysql_error().'<hr />';
		$report = "\nBelow are the records of the last ".LOG_REPORTS_MAX." backups.\nDATE and TIME (total bytes, Total lines exported)";
		while($row = mysql_fetch_array($result)) {
			$report .= "\n".strftime("%d %b %Y - %H:%M:%S",$row['date'])." (";
			$report .= number_format(($row['bytes']/100), 2, '.', '') ." KB, ";
			$report .= number_format($row['lines'])." lines)";
		}
		return $report;
	}
}
?>
