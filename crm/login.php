<?php include('includes/header.php');?>

<h2><?php echo $lang['LOGIN'];?></h2>
<?php
if(isset($_POST['submit'])) {
	// Try and login with the given username & pass
	$result = user_login($_POST['username'], $_POST['password']);
	if ($result != 'Correct') {
	// Reshow the form with the error
		$login_error = '<div class="error">'.$lang['INCORRECT_CREDENTIALS'].'</div>';
		session_unset();
		session_destroy();
		echo '<meta http-equiv="refresh" content="0;url=index.php" />';
	}
	else {
		$user = $_SESSION['username'];

		echo $lang['ACCOUNT_ENTERED'];
		echo '<meta http-equiv="refresh" content="0;url=index.php" />';
	}
}
else {
	// Reshow the form with the error
	$login_error = '<div class="error">'.$lang['INCORRECT_CREDENTIALS'].'/div>';
	echo '<meta http-equiv="refresh" content="0;url=index.php" />';
}
?>

<?php include('includes/footer.php');?>
