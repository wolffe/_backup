<?php
require_once '../../../../wp-config.php';

global $wpdb;

$id_session = session_id();
$itemId = $_POST['gbID'];

$result = mysql_query("DELETE FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "' AND itemId = $itemId");
?>
