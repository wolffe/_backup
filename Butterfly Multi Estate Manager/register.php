<?php include('includes/top.php');?>
<div id="content">
<?php
if(isset($_POST['submit'])) {
	if($_POST['1'] + $_POST['2'] != $_POST['check'])
		echo '<div class="error">Wrong verification answer!</div>';

	// Check if any of the fields are missing
	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmpass'])) {
		// Reshow the form with an error
		$reg_error = '<div class="error">Please fill in <strong>all</strong> fields!</div>';
	}

	// Check if the passwords match
	if($_POST['password'] != $_POST['confirmpass']) {
		// Reshow the form with an error
		$reg_error = '<div class="error">Passwords do not match! Is your CAPS LOCK on?</div>';
	}

	// Check if the username is 'admin'
	if($_POST['username'] == 'admin') {
		// Reshow the form with an error
		$reg_error = '<div class="error">User name <strong>admin</strong> is reserved! Try another one.</div>';
	}

	// Everything is ok, register
	user_register ($_POST['username'], $_POST['password']);
	echo '<div class="confirm">Congratulations! You are registered! Please <a href="login.php">log into your account</a> and enter your personal/company details.</div>';
}
else {
	// Show the form
	?>
	<?php if(isset($reg_error)) { ?>
		<div class="error">ERROR: <?php echo $reg_error;?>, please try again!</div>
	<?php } ?>

	<?php
	$n1 = rand(0, 10);
	$n2 = rand(0, 10);
	?>
	<form action="register.php" method="post">
	<p>
		<label>Username<br />
		<input type="text" size="25" maxlength="20" class="field" name="username" <?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?> /></label>
	</p>
	<p>
		<label>Password<br />
		<input type="password" size="25" maxlength="10" name="password" class="field" /></label>
	</p>
	<p>
		<label>Password (confirm)<br />
		<input type="password" size="25" maxlength="10" name="confirmpass" class="field" /></label>
	</p>
	<p>
		<label>Verification question<br />
		<?php echo $n1.' + '.$n2.' = ';?><input type="text" name="check" size="2" maxlength="2" /></label>
	</p>
	<div>
		<input type="hidden" name="1" value="<?php echo $n1;?>" />
		<input type="hidden" name="2" value="<?php echo $n2;?>" />
	</div>
	<p id="reg_passmail">If you are registered, <a href="login.php">log in here</a>.</p>
	<p class="submit"><input type="submit" name="submit" value="Register" id="button" /></p>
	</form>

	<p>
	<a href="login.php">Log in</a>
	</p>
	<?php
}
?>
</div>
<?php
include('includes/bottom.php');
?>
