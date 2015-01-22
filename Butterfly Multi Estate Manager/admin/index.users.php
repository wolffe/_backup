<?php include('inc.header.php');?>
<?php if(is_admin()) {?>

<h2>Users</h2>
<?php
if(isset($_GET['action'])) {
	$action = $_GET['action'];

	if($action == 'delete') {
		$cid = $_GET['cid'];
		mysql_query("DELETE FROM user WHERE userid = '$cid'");	
	}
}
?>

<ul>
<?php
$csql = "SELECT * FROM user ORDER BY username ASC";
$result = mysql_query($csql);
while($row = mysql_fetch_array($result)) {
	echo '<li>';
		echo '<small><a href="?action=delete&amp;cid='.$row['userid'].'">Delete</a></small> '.$row['username'].' ';
		echo '<small>(<strong>'.$row['contact'].'</strong> | '.$row['phone'].' | '.$row['email'].' | '.$row['url'].')</small><hr />';
	echo '</li>';
}
?>
</ul>

<?php include('inc.footer.php');?>
<?php }?>
