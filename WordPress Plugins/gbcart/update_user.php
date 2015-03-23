<?php
require_once('../../../wp-load.php');

$id = intval($_REQUEST['id']);
$itemName = $_POST['itemName'];
$itemDesc = $_POST['itemDesc'];
$itemPrice = $_POST['itemPrice'];
$itemDiscount = $_POST['itemDiscount'];
$itemCategory = $_POST['itemCategory'];

global $wpdb;

$sql = "UPDATE " . $wpdb->prefix . "gb_items SET 
	itemName = '$itemName',
	itemDesc = '$itemDesc',
	itemPrice = '$itemPrice',
	itemDiscount = '$itemDiscount',
	itemCategory = '$itemCategory'
WHERE itemId = $id";

$result = mysql_query($sql);
if($result)
	echo json_encode(array('success' => true));
else
	echo json_encode(array('msg' => 'Some errors occured.'));
?>
