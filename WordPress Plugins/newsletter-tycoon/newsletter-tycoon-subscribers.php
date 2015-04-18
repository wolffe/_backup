<?php
defined('ABSPATH') or die('Cannot access this file.');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=newsletter-tycoon-subscribers-" . date('YmdHis') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');
 
$s = '",';
$e = '"';

global $wpdb;
$table = $wpdb->prefix . 'tycoon_members';

$result = mysql_query("SELECT * FROM $table");

while($row = mysql_fetch_array($result)) {
	echo $e . $row['email'] . $s;
	echo $e . $row['state'] . $s;
	echo $e . $row['joined'] . $s;
	echo $e . $row['user'] . $s;
	echo $e . $row['confkey'] . $e;

	echo "\n";
}
?>
