<?php include_once('../includes/config.php');?>
<?php include_once('../includes/settings.php');?>
<?php include_once('../includes/functions.php');?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<title>Estate Manager Administration</title>
<?php
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['username'])) {
	echo '<link rel="stylesheet" href="style.admin.css" type="text/css" />';
	echo '<div class="restricted">';
		echo '<h3>Restricted Area</h3>';
		echo '<p>Log in as <strong>admin</strong> on the front page, then click on <strong>Administration</strong> link in your navigation bar.</p>';
	echo '</div>';
}
if(isset($_GET['do'])) {
	$do = mysql_real_escape_string($_GET['do']);

	if($_POST) {
		if($_POST['name'] == 'admin' && $_POST['pass'] == $lrow['adminpass']) {
			$_SESSION['username'] = 'admin';
		}
	}
	if($do == 'logout') {
		session_destroy();
		unset($_SESSION['username']);
		echo '<p>You have successfully logged out! <a href="index.php">Click here to return</a></p>';
	}
}
?>

<?php if(is_admin()) {
		$sql_0 = mysql_query("SELECT * FROM data WHERE approved=0");
		$sql_1 = mysql_query("SELECT * FROM data WHERE approved=1");
		$sql_u = mysql_query("SELECT * FROM user");
		$sql_c = mysql_query("SELECT * FROM categories");
		$numresults_0 = mysql_num_rows($sql_0);
		$numresults_1 = mysql_num_rows($sql_1);
		$numresults_u = mysql_num_rows($sql_u);
		$numresults_c = mysql_num_rows($sql_c);
?>

<link rel="stylesheet" href="style.admin.css" type="text/css" />
</head>
<body>
<div id="content">
	<ul id="navbar" class="topmenu">
		<li class="topfirst"><a href="index.php">Dashboard</a></li>
		<li class="topmenu"><a href="#">Properties</a>
			<ul>
				<li><a href="index.properties.php">View approved properties (<?php echo $numresults_1;?>)</a></li>
				<li><a href="index.pending.php">View pending properties (<?php echo $numresults_0;?>)</a></li>
			</ul>
		</li>
		<li class="topmenu"><a href="index.categories.php">Categories</a></li>
		<li class="topmenu"><a href="index.users.php">Users</a></li>
		<li class="topmenu"><a href="index.settings.php">Settings</a></li>
		<li class="topmenu"><a href="?do=logout">Log out</a></li>
		<li class="toplast"><a href="../">Visit Site &raquo;</a></li>
	</ul>
	<div class="clear"></div>

<?php }?>
