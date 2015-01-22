<?php
include('../../../wp-load.php');
global $wpdb;

$q = $_GET['q'];

$sql = "SELECT * FROM `{$wpdb->prefix}usermeta` WHERE meta_key='rl_location' AND meta_value LIKE '%{$q}%' GROUP BY meta_value";
$result = mysql_query($sql);

if($result) {
	while($row = mysql_fetch_array($result)) {
		echo $row['meta_value'] . '|';
	}
}
?>
