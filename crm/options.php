<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2><?php echo $lang['OPTIONS'];?></h2>
		<?php
		if(isset($_GET['action'])) {
			$action = mysql_real_escape_string($_GET['action']);

			if($action == 'export') {
				$clienti = mysql_query("SELECT * FROM items");
				$fisierCsv = fopen('items.csv', 'w');

				while($client = mysql_fetch_row($clienti)) {
					fputcsv($fisierCsv, $client);
					//echo 'CSV Data Array: ' . print_r($client, true) . '<br />';
				}
				echo '<div class="helpbox">Click here to <a href="items.csv" target="_blank">download items.csv</a></div>';
				fclose($fisierCsv);
			}
			if($action == 'import') {
				$toquery = "
					LOAD DATA INFILE 'items.csv' IGNORE INTO TABLE items
					COLUMNS TERMINATED BY ',' ESCAPED BY '\\'
					LINES TERMINATED BY '\n';
				";
				mysql_query($toquery);
				//echo $toquery;
			}
		}
		?>

		<h3><?php echo $lang['BACKUP'];?></h3>
		<p>
			<a href="modules/backup/run.php" class="button"><?php echo $lang['BACKUP_DB'];?></a> 
			<a href="zip.php?zipit=uploads" class="button"><?php echo $lang['BACKUP_CV'];?></a>
		</p>
		<p><small>You will receive the database backup by email, if you filled in your email address. ZIP backups for CVs and photos may take a while if you have lots of profiles.</small></p>

<h3><?php echo $lang['CURRENT_BACKUPS'];?></h3>
<?php
function listFolder($path) {
$dir_handle = opendir($path) or die("Unable to open $path");
$dirname = end(explode("/", $path));

echo "<ul>\n";
	while(false !== ($file = readdir($dir_handle))) {
		if($file != '.' && $file != '..' && $file != 'index.php' && $file != '.htaccess') {
			if(is_dir($path.'/'.$file)) {
				listFolder($path.'/'.$file);
			}
			else {
				echo '<li><a href="'.$path.$file.'">'.$file.'</a></li>';
			}
		}
	}
	echo "</ul>\n";
	closedir($dir_handle);
}
listFolder('modules/backup/backups/');
?>

<h3><?php echo $lang['CSV_EXPORT'];?>/<?php echo $lang['CSV_IMPORT'];?></h3>
<a href="?action=export"><?php echo $lang['CSV_EXPORT'];?></a> | 
<a href="?action=import"><?php echo $lang['CSV_IMPORT'];?></a>
	</div>
	<div class="clear"></div>

	<div class="table-wrap-wide">
		<h2><?php echo $lang['HELP'];?></h2>
		<?php echo $lang['CSV_CONTENT'];?>
	</div>
	<div class="clear"></div>
<?php }?>
<?php include('includes/footer.php');?>
