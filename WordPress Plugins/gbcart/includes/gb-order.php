<?php
require_once '../../../../wp-config.php';

global $wpdb;

$id_session = session_id();
$itemId = $_POST['gbID'];

$result = mysql_query("SELECT count(*) FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "' AND itemId = $itemId");
$row = mysql_fetch_row($result);
$numRows = $row[0];

if($numRows == 0) {
	// the item does not exist in cart, add it
	mysql_query("INSERT INTO " . $wpdb->prefix . "gb_cart(sessionId, itemId, qty) VALUES ('" . $id_session . "', $itemId, 1)");
	$msg = 'OK';
}
else {
	// the item already exists in cart, update it
	UpdateProduct($itemId);
}
?>
