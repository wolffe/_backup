<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		echo '<h2>My Profile</h2>';

		$user = $_SESSION['username'];

		$result = mysql_query("SELECT * FROM user WHERE username='$user'");
		$row = mysql_fetch_array($result);
		$username = $row[1];
		$password = $row[2];

		$contact = $row[4];
		$phone = $row[5];
		$email = $row[6];
		$url = $row[7];

		if(isset($_POST['update'])) {
			$npassword1 = $_POST['npassword1'];
			$npassword2 = $_POST['npassword2'];

			$ncontact = $_POST['contact'];
			$nphone = $_POST['phone'];
			$nemail = $_POST['email'];
			$nurl = $_POST['url'];

			if($npassword1 != '') {
				if($npassword1 == $npassword2) {
					$sql = "UPDATE user SET password='$npassword1' WHERE username='$user' LIMIT 1";
					mysql_query($sql);
				}
				else {
					echo '<div class="error">Passwords do not match!</div>';
				}
			}

			$sql = "UPDATE user SET contact='$ncontact',phone='$nphone',email='$nemail',url='$nurl' WHERE username='$user' LIMIT 1";
			mysql_query($sql);

			if(mysql_query($sql)) {
				echo '<div class="confirm">Profile updated!</div>';
			}
			else {
				echo('<div class="error">An error ocurred: '.mysql_error().'</div>');
			}
		}
		?>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<table class="display">
				<tr><td colspan="2"><h3>Profile Information</h3></td></tr>
				<tr>
					<td><label for="owner">Username:</label></td>
					<td><input type="text" name="owner" id="owner" style="width:200px" value="<?php echo $username;?>" readonly="readonly" /> <em>Cannot be changed!</em></td>
				</tr>
				<tr><td colspan="2"><h3>Password</h3></td></tr>
				<tr>
					<td>New password:</td>
					<td><input type="password" name="npassword1" id="npassword1" style="width:200px" /></td>
				</tr>
				<tr>
					<td>New password (confirm):</td>
					<td><input type="password" name="npassword2" id="npassword2" style="width:200px" /></td>
				</tr>
				<tr><td colspan="2"><h3>Contact Details</h3></td></tr>
				<tr>
					<td><label for="contact">Contact:</label></td>
					<td><input type="text" name="contact" id="contact" style="width:200px" value="<?php echo $contact;?>" /></td>
				</tr>
				<tr>
					<td><label for="phone">Phone:</label></td>
					<td><input type="text" name="phone" id="phone" style="width:200px" value="<?php echo $phone;?>" /></td>
				</tr>
				<tr>
					<td><label for="email">Email:</label></td>
					<td><input type="text" name="email" id="email" style="width:200px" value="<?php echo $email;?>" /></td>
				</tr>
				<tr>
					<td><label for="url">Website:</label></td>
					<td><input type="text" name="url" id="url" style="width:200px" value="<?php echo $url;?>" /></td>
				</tr>
			</table>
			<input type="submit" name="update" value="Update" />
		</form>
	<?php }
	else restrictedAccess();?>
</div>
<?php include('includes/bottom.php');?>
