<?php include('includes/header.php');?>
<?php
if(is_authed()) {
	$aid = mysql_real_escape_string($_GET['aid']);
	mysql_query("DELETE FROM attachments WHERE aid='$aid'");
	echo '<meta http-equiv="refresh" content="0; url='.$_SERVER['HTTP_REFERER'].'" />';
}
?>
<?php include('includes/footer.php');?>
