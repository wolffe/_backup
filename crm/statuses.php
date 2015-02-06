<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2>Statuses</h2>
		<p>Edit or delete existing statuses.</p>
	</div>
	<div class="clear"></div>

	<?php
	if(isset($_POST['submit'])) {
		$statusName = $_POST['statusName'];

		$sql = "INSERT INTO statuses (statusName) VALUES ('$statusName');";
		mysql_query($sql) or die();
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">Status added!</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_POST['submit_edit'])) {
		$sID = $_POST['sID'];
		$statusName = $_POST['statusName'];
		mysql_query("UPDATE statuses SET statusName = '$statusName' WHERE sID = '$sID'");	
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">Status modified!</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_GET['action'])) {
		$action = mysql_real_escape_string($_GET['action']);

		if($action == 'edit') {
			$sID = mysql_real_escape_string($_GET['sID']);
			$csql = "SELECT * FROM statuses WHERE sID = '$sID'";
			$result = mysql_query($csql);
			$row = mysql_fetch_array($result);
			?>
			<div class="table-wrap-wide">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<p><input type="hidden" name="sID" value="<?php echo $sID;?>" />Status <input type="text" name="statusName" value="<?php echo $row['statusName'];?>" /> <input type="submit" name="submit_edit" class="button" value="<?php echo $lang['EDIT'];?>" /></p>
				</form>
			</div>
			<div class="clear"></div>
			<?php
		}
		if($action == 'delete') {
			$sID = mysql_real_escape_string($_GET['sID']);
			mysql_query("DELETE FROM statuses WHERE sID= '$sID'");	
			echo '<div class="table-wrap-wide">';
				echo '<div class="confirm">Status deleted!</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
		}
	}
	?>

	<div class="table-wrap">
		<h2>Statuses</h2>
		<ul>
			<?php
			$csql = "SELECT * FROM statuses ORDER BY statusName ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<li>[<a href="?action=edit&amp;sID='.$row['sID'].'">'.$lang['EDIT'].'</a>] [<a href="?action=delete&amp;sID='.$row['sID'].'">'.$lang['DELETE'].'</a>] '.$row['statusName'].'</li>';
			}
			?>
		</ul>
	</div>

	<div class="table-wrap">
		<h2>Add Status</h2>
		<p>Add a new status to database.</p>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p>Status <input type="text" name="statusName" /></p>
			<p><input type="submit" name="submit" class="button" value="Add Status" /></p>
		</form>
	</div>
	<div class="clear"></div>

<?php }?>
<?php include('includes/footer.php');?>
