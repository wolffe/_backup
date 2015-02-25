<?php include('includes/header.php');?>
<?php
$user = $_SESSION['username'];
user_logout();
?>
<h2><?php echo $lang['LOGOUT'];?></h2>
<p><?php echo $lang['ACCOUNT_EXITED'];?></p>
<meta http-equiv="refresh" content="0;url=index.php" />
<?php include('includes/footer.php');?>
