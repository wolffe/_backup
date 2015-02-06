<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap">
		<h2><?php echo $lang['ADD_USER'];?></h2>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p><input type="text" name="newusername" /> <?php echo $lang['USERNAME'];?></p>
			<p><input type="text" name="newpassword" /> <?php echo $lang['PASSWORD'];?></p>
			<p>
				<select name="newrank">
					<option value="0">0 - <?php echo $lang['USER_LEVEL_ADMIN'];?></option>
					<option value="1">1 - <?php echo $lang['USER_LEVEL_1'];?></option>
					<option value="2">2 - <?php echo $lang['USER_LEVEL_2'];?></option>
				</select> <?php echo $lang['RANK'];?>
			</p>
			<p><input type="email" name="newemail" /> <?php echo $lang['EMAIL'];?><br /><small><?php echo $lang['BACKUP_EMAIL_TEXT'];?></small></p>
			<p><input type="submit" name="submit" class="button" value="<?php echo $lang['ADD_USER'];?>" /></p>
		</form>
	</div>

	<div class="table-wrap">
		<h2><?php echo $lang['USERS'];?></h2>
		<?php
		if(isset($_POST['submit'])) {
			$newusername = $_POST['newusername'];
			$newpassword = $_POST['newpassword'];
			$newemail = $_POST['newemail'];
			$newrank = $_POST['newrank'];

			$sql = "INSERT INTO users (username, password, email, rank) VALUES ('$newusername', '$newpassword', '$newemail', '$newrank');";
			mysql_query($sql) or die();
			echo '<div class="confirm">'.$lang['USER_ADDED'].'</div>';
		}

		if(isset($_POST['submit_edit'])) {
			$uid = $_POST['uid'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			if($email != '')
				mysql_query("UPDATE users SET password = '$password' WHERE uid = '$uid'");	
			mysql_query("UPDATE users SET email = '$email' WHERE uid = '$uid'");	

			echo '<div class="confirm">User updated!</div>';
		}

		if(isset($_GET['action'])) {
			$action = mysql_real_escape_string($_GET['action']);

			if($action == 'edit') {
				$uid = mysql_real_escape_string($_GET['uid']);
				$usql = "SELECT * FROM users WHERE uid = '$uid'";
				$uresult = mysql_query($usql);
				$urow = mysql_fetch_array($uresult);
				?>
				<div>
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<p><input type="hidden" name="uid" value="<?php echo $uid;?>" />
						<input type="text" name="password" value="" /> Password for <strong><?php echo $urow['username'];?></strong><br />
						<input type="text" name="email" value="<?php echo $urow['email'];?>" /> Email address for <strong><?php echo $urow['username'];?></strong><br />
						<input type="submit" name="submit_edit" class="button" value="<?php echo $lang['EDIT'];?>" /></p>
					</form>
				</div>
				<div class="clear"></div>
				<?php
			}

			if($action == 'delete') {
				$uid = mysql_real_escape_string($_GET['uid']);
				mysql_query("DELETE FROM users WHERE uid = '$uid'");	
			}
		}
		?>

		<ul>
			<?php
			$csql = "SELECT * FROM users WHERE uid != 1";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<li>';
					echo '<a href="?action=delete&amp;uid='.$row['uid'].'"><img src="images/icon-delete.png" alt="'.$lang['DELETE'].'" title="'.$lang['DELETE'].'" /></a> ';
					echo '<strong title="'.$row['password'].'">'.$row['username'].'</strong>';
					if($row['rank'] == '0') echo ' <small>'.$lang['USER_LEVEL_ADMIN'].' [<a href="?action=edit&amp;uid='.$row['uid'].'">EDIT</a>]</small>';
					if($row['rank'] == '1') echo ' <small>'.$lang['USER_LEVEL_1'].'</small>';
					if($row['rank'] == '2') echo ' <small>'.$lang['USER_LEVEL_2'].'</small>';
					if($row['email'] != '') echo '<br />'.$row['email'];
					echo '<hr />';
				echo '</li>';
			}
			?>
		</ul>
	</div>
	<div class="clear"></div>

	<div class="table-wrap-wide">
		<h2><?php echo $lang['HELP'];?></h2>
		<?php echo $lang['HELP_USERS'];?>
	</div>
	<div class="clear"></div>
<?php }?>
<?php include('includes/footer.php');?>
