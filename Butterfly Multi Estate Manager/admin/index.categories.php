<?php include('inc.header.php');?>
<?php if(is_admin()) {?>

<h2>Categories</h2>
<?php
if(isset($_POST['submit'])) {
	$category = $_POST['category'];

	$sql = "INSERT INTO categories (category) VALUES ('$category');";
	mysql_query($sql) or die();
	echo '<div class="confirm">Category added!</div>';
}
if(isset($_POST['submit_edit'])) {
	$cid = $_POST['cid'];
	$category = $_POST['category'];
	mysql_query("UPDATE categories SET category = '$category' WHERE id = '$cid'");
	echo '<div class="confirm">Category updated!</div>';
}
if(isset($_GET['action'])) {
	$action = $_GET['action'];

	if($action == 'edit') {
		$cid = $_GET['cid'];
		$csql = "SELECT * FROM categories WHERE id = '$cid'";
		$result = mysql_query($csql);
		$row = mysql_fetch_array($result);
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p><input type="hidden" name="cid" value="<?php echo $cid;?>" />Category <input type="text" name="category" value="<?php echo $row['category'];?>" /> <input type="submit" name="submit_edit" value="Edit" /></p>
		</form>
		<?php
	}
	if($action == 'delete') {
		$cid = $_GET['cid'];
		mysql_query("DELETE FROM categories WHERE id = '$cid'");	
	}
}
?>

<ul>
<?php
$csql = "SELECT * FROM categories ORDER BY category ASC";
$result = mysql_query($csql);
while($row = mysql_fetch_array($result)) {
	echo '<li><small><a href="?action=edit&amp;cid='.$row['id'].'">Edit</a> <a href="?action=delete&amp;cid='.$row['id'].'">Delete</a></small> '.$row['category'].'</li>';
}
?>
</ul>

<h3>Add new category</h3>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p>Category <input type="text" name="category" /> <input type="submit" name="submit" value="Add category" /></p>
</form>

<?php include('inc.footer.php');?>
<?php }?>
