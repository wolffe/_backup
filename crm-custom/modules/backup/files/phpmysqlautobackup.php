<?php
$phpMySQLAutoBackup_version = '1.5.5';

$backup_type = "\n\n BACKUP Type: Full database backup (all tables included)\n\n";
if(isset($table_select)) {
	$backup_type="\n\n BACKUP Type: partial, includes tables:\n";
	foreach($table_select as $key => $value) $backup_type.= "  $value;\n";
}
if(isset($table_exclude)) {
	$backup_type="\n\n BACKUP Type: partial, EXCLUDES tables:\n";
	foreach ($table_exclude as $key => $value) $backup_type.= "  $value;\n";
}

$backup_info = $backup_type;

include(LOCATION.'phpmysqlautobackup_extras.php');
include(LOCATION.'schema_for_export.php');

$backup_info.= $recordBackup->get();
mysql_close();

// zip the backup and email it
$backup_file_name = 'mysql_'.$db.strftime("_%d_%b_%Y_time_%H_%M_%S.sql",time()).'.gz';
$dump_buffer = gzencode($buffer);

if($save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);

// FTP backup file to remote server
if(isset($ftp_username)) {
	// write the backup file to local server ready for transfer if not already done so
	if(!$save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
	$transfer_backup = new transfer_backup();
	$backup_info .= $transfer_backup->transfer_data($ftp_username,$ftp_password,$ftp_server,$ftp_path,$backup_file_name);
	if(!$save_backup_zip_file_to_server) unlink(LOCATION.'../backups/'.$backup_file_name);
}
if($send_email_backup) xmail($to_emailaddress,$from_emailaddress, "Tycoon CRM SQL Backup: $backup_file_name", $dump_buffer, $backup_file_name, $backup_type, $newline, $phpMySQLAutoBackup_version);
if($send_email_report) {
	$msg_email_backup = '';
	$msg_ftp_backup = '';
	$msg_local_backup = '';
	if($send_email_backup) $msg_email_backup = "\nthe email with the backup attached has been sent to: $to_emailaddress \n";
	if(isset($ftp_username)) $msg_ftp_backup = "\nthe backup zip file has been transferred via ftp to: $ftp_server (user: $ftp_username) - folder: $ftp_path \n";
	if($save_backup_zip_file_to_server) $msg_local_backup = "\nthe backup zip file has been saved to the same server: ".dirname(__FILE__)."/backups/ \n";
	mail($report_emailaddress,
		"REPORT on recent backup using Tycoon CRM SQL Backup ($backup_file_name)",
		"SAVE or DELETE THIS MESSAGE\n - no backup is attached $msg_email_backup $msg_ftp_backup $msg_local_backup \n\n$backup_info \n\n Tycoon CRM SQL Backup (version $phpMySQLAutoBackup_version)",
		"From: $from_emailaddress\nReply-To:$from_emailaddress");
}

if(DEBUG) echo '<textarea cols="150" rows="10">'.$backup_info.'</textarea>';
?>
<p>SQL Backup completed!</p>
<p>You will be automatically redirected to <strong>Tycoon CRM</strong> in 5 seconds.</p>
<meta http-equiv="refresh" content="5;url=../../" />

