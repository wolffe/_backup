<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2>Roles of interest</h2>
		<p>Edit or delete existing roles of interest.</p>
	</div>
	<div class="clear"></div>

	<?php
	if(isset($_POST['submit'])) {
		$rolename = $_POST['rolename'];

		$sql = "INSERT INTO roles (rolename) VALUES ('$rolename');";
		mysql_query($sql) or die();
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">'.$lang['ROLE_ADDED'].'</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_POST['submit_edit'])) {
		$cid = $_POST['rid'];
		$rolename = $_POST['rolename'];
		mysql_query("UPDATE roles SET rolename = '$rolename' WHERE rid = '$rid'");	
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">'.$lang['ROLE_MODIFIED'].'</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_GET['action'])) {
		$action = mysql_real_escape_string($_GET['action']);

		if($action == 'edit') {
			$rid = mysql_real_escape_string($_GET['rid']);
			$csql = "SELECT * FROM roles WHERE rid = '$rid'";
			$result = mysql_query($csql);
			$row = mysql_fetch_array($result);
			?>
			<div class="table-wrap-wide">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<p><input type="hidden" name="rid" value="<?php echo $rid;?>" />Role <input type="text" name="rolename" value="<?php echo $row['rolename'];?>" /> <input type="submit" name="submit_edit" class="button" value="<?php echo $lang['EDIT'];?>" /></p>
				</form>
			</div>
			<div class="clear"></div>
			<?php
		}
		if($action == 'delete') {
			$rid = mysql_real_escape_string($_GET['rid']);
			mysql_query("DELETE FROM roles WHERE rid = '$rid'");	
			echo '<div class="table-wrap-wide">';
				echo '<div class="confirm">'.$lang['ROLE_DELETED'].'</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
		}
	}
	?>

	<div class="table-wrap">
		<h2>Roles</h2>
		<ul>
			<?php
			$csql = "SELECT * FROM roles ORDER BY rolename ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<li>[<a href="?action=edit&amp;rid='.$row['rid'].'">'.$lang['EDIT'].'</a>] [<a href="?action=delete&amp;rid='.$row['rid'].'">'.$lang['DELETE'].'</a>] '.$row['rolename'].'</li>';
			}
			?>
		</ul>
	</div>

	<div class="table-wrap">
		<h2>Add role of interest</h2>
		<p>Add a new role to database.</p>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p>Role <input type="text" name="rolename" /></p>
			<p><input type="submit" name="submit" class="button" value="Add Role" /></p>
		</form>
	</div>
	<div class="clear"></div>

<?php }?>
<?php include('includes/footer.php');?>
