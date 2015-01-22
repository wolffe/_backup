<?php
include('includes/top.php');

$id = mysql_real_escape_string($_GET['id']);
$del = mysql_real_escape_string($_GET['del']);

mysql_query("UPDATE `data` SET `$del` = '' WHERE `id` =$id LIMIT 1");

echo '<div class="confirm">Image deleted!</div>';
echo '<p><a href="addedit.php?id='.$id.'">Back to property</a></p>';

include('includes/bottom.php');
?>
