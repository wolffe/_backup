<?php
include('includes/config.php');

$upload_id = $_POST['uid'];
$sql = "DELETE FROM upload WHERE upload_id = '$upload_id' LIMIT 1";

$result = mysql_query($sql);
?>
