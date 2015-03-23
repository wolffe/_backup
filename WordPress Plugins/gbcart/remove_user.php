<?php
require_once('../../../wp-load.php');

$id = intval($_POST['id']);

global $wpdb;

$sql = "DELETE FROM " . $wpdb->prefix . "gb_items WHERE itemId = $id";

$result = mysql_query($sql);
if($result)
	echo json_encode(array('success' => true));
else
	echo json_encode(array('msg' => 'Some errors occured.'));
?>
