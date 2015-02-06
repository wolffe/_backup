<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2><?php echo $lang['CATEGORIES'];?></h2>
		<p>Edit or delete existing categories.</p>
	</div>
	<div class="clear"></div>

	<?php
	if(isset($_POST['submit'])) {
		$categoryname = $_POST['categoryname'];

		$sql = "INSERT INTO categories (categoryname) VALUES ('$categoryname');";
		mysql_query($sql) or die();
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">'.$lang['CATEGORY_ADDED'].'</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_POST['submit_edit'])) {
		$cid = $_POST['cid'];
		$categoryname = $_POST['categoryname'];
		mysql_query("UPDATE categories SET categoryname = '$categoryname' WHERE cid = '$cid'");	
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">'.$lang['CATEGORY_MODIFIED'].'</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	if(isset($_GET['action'])) {
		$action = mysql_real_escape_string($_GET['action']);

		if($action == 'edit') {
			$cid = mysql_real_escape_string($_GET['cid']);
			$csql = "SELECT * FROM categories WHERE cid = '$cid'";
			$result = mysql_query($csql);
			$row = mysql_fetch_array($result);
			?>
			<div class="table-wrap-wide">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<p><input type="hidden" name="cid" value="<?php echo $cid;?>" /><?php echo $lang['CATEGORY'];?> <input type="text" name="categoryname" value="<?php echo $row['categoryname'];?>" /> <input type="submit" name="submit_edit" class="button" value="<?php echo $lang['EDIT'];?>" /></p>
				</form>
			</div>
			<div class="clear"></div>
			<?php
		}
		if($action == 'delete') {
			$cid = mysql_real_escape_string($_GET['cid']);
			mysql_query("DELETE FROM categories WHERE cid = '$cid'");	
			echo '<div class="table-wrap-wide">';
				echo '<div class="confirm">'.$lang['CATEGORY_DELETED'].'</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
		}
	}
	?>

	<div class="table-wrap">
		<h2><?php echo $lang['CATEGORIES'];?></h2>
		<ul>
			<?php
			$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<li>[<a href="?action=edit&amp;cid='.$row['cid'].'">'.$lang['EDIT'].'</a>] [<a href="?action=delete&amp;cid='.$row['cid'].'">'.$lang['DELETE'].'</a>] '.$row['categoryname'].'</li>';
			}
			?>
		</ul>
	</div>

	<div class="table-wrap">
		<h2><?php echo $lang['ADD_CATEGORY'];?></h2>
		<p>Add a new category to database.</p>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p><?php echo $lang['CATEGORY'];?> <input type="text" name="categoryname" /></p>
			<p><input type="submit" name="submit" class="button" value="<?php echo $lang['ADD_CATEGORY'];?>" /></p>
		</form>
	</div>
	<div class="clear"></div>

<?php }?>
<?php include('includes/footer.php');?>
