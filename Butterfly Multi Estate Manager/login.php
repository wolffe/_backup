<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(isset($_POST['submit'])) {
		// Try and login with the given username & pass
		$result = user_login($_POST['username'], $_POST['password']);
		if($result == 'Error') {
			// Reshow the form with the error
			$login_error = $result;
			echo '<p id="login_error">ERROR: '.$login_error.', please try again!</p>';
			user_logout();
		}
		if($result == 'Correct') {
			echo '<p>You are logged in! If you did not entered your personal/company details (website, email), <a href="cpanel.php">do it now</a>!</p>';
			echo '<p><a href="index.php">Go to homepage.</a></p>';
		}
	}
	else {
		// Show the form
		?>
		<form id="registerform" action="#" method="post">
			<p>
				<label for="username">Username</label><br />
				<input type="text" name="username" id="username" class="input" value="" size="20" <?php if(isset($_POST['username'])) {?> value="<?php echo $_POST['username'];?>" <?php }?> />
			</p>
			<p>
				<label for="password">Password</label><br />
				<input type="password" name="password" id="password" class="input" value="" size="25" />
			</p>

			<p id="reg_passmail">Log in to add or edit your properties. If you don't have an account, <a href="register.php">register now</a>.</p>
			<p class="submit"><input type="submit" id="button" name="submit" value="Log in" /></p>
		</form>
		<p><a href="register.php">Register</a></p>
		<?php
	}
	?>
</div>
<?php include('includes/bottom.php');?>
