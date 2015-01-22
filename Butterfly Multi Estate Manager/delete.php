<?php
include('includes/top.php');

$id = $_GET['id'];

mysql_query("DELETE FROM data WHERE id=$id",$database);
echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
include('includes/bottom.php');
?>
