<?php
require_once('../../../wp-load.php');

$itemName = $_POST['itemName'];
$itemDesc = $_POST['itemDesc'];
$itemPrice = $_POST['itemPrice'];
$itemDiscount = $_POST['itemDiscount'];
$itemCategory = $_POST['itemCategory'];

global $wpdb;

$sql = "INSERT INTO " . $wpdb->prefix . "gb_items (
	itemName,
	itemDesc,
	itemPrice,
	itemDiscount,
	itemCategory
) VALUES (
	'$itemName',
	'$itemDesc',
	'$itemPrice',
	'$itemDiscount',
	'$itemCategory'
)";

$result = mysql_query($sql);
if($result)
	echo json_encode(array('success' => true));
else
	echo json_encode(array('msg' => 'Some errors occured.'));
?>
