<?php include('includes/header.php');?>
<?php
if(is_authed()) {
	$id = mysql_real_escape_string($_GET['id']);
	mysql_query("UPDATE items SET photo='' WHERE id='$id'");
	echo '<meta http-equiv="refresh" content="0; url='.$_SERVER['HTTP_REFERER'].'" />';
}
?>
<?php include('includes/footer.php');?>
