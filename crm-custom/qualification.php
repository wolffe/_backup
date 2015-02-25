<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2>Qualification</h2>
		<p>Edit or delete existing qualification.</p>
	</div>
	<div class="clear"></div>

	<?php
	if(isset($_POST['submit'])) {
		$qualificationName = $_POST['qualificationName'];

		$sql = "INSERT INTO qualification (qualificationName) VALUES ('$qualificationName');";
		mysql_query($sql) or die();
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">Qualification added!</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_POST['submit_edit'])) {
		$qID = $_POST['qID'];
		$qualificationName = $_POST['qualificationName'];
		mysql_query("UPDATE qualification SET qualificationName = '$qualificationName' WHERE qID = '$qID'");	
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">Qualification modified!</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_GET['action'])) {
		$action = mysql_real_escape_string($_GET['action']);

		if($action == 'edit') {
			$qID = mysql_real_escape_string($_GET['qID']);
			$csql = "SELECT * FROM qualification WHERE qID = '$qID'";
			$result = mysql_query($csql);
			$row = mysql_fetch_array($result);
			?>
			<div class="table-wrap-wide">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<p><input type="hidden" name="qID" value="<?php echo $qID;?>" />Qualification <input type="text" name="qualificationName" value="<?php echo $row['qualificationName'];?>" /> <input type="submit" name="submit_edit" class="button" value="<?php echo $lang['EDIT'];?>" /></p>
				</form>
			</div>
			<div class="clear"></div>
			<?php
		}
		if($action == 'delete') {
			$qID = mysql_real_escape_string($_GET['qID']);
			mysql_query("DELETE FROM qualification WHERE qID= '$qID'");	
			echo '<div class="table-wrap-wide">';
				echo '<div class="confirm">Qualification deleted!</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
		}
	}
	?>

	<div class="table-wrap">
		<h2>Qualification</h2>
		<ul>
			<?php
			$csql = "SELECT * FROM qualification ORDER BY qualificationName ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<li>[<a href="?action=edit&amp;qID='.$row['qID'].'">'.$lang['EDIT'].'</a>] [<a href="?action=delete&amp;qID='.$row['qID'].'">'.$lang['DELETE'].'</a>] '.$row['qualificationName'].'</li>';
			}
			?>
		</ul>
	</div>

	<div class="table-wrap">
		<h2>Add Qualification</h2>
		<p>Add a new qualification to database.</p>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p>Qualification <input type="text" name="qualificationName" /></p>
			<p><input type="submit" name="submit" class="button" value="Add Qualification" /></p>
		</form>
	</div>
	<div class="clear"></div>

<?php }?>
<?php include('includes/footer.php');?>
