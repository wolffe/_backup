<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<hr />
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<p>
			<?php echo $lang['SEARCH_BY_CATEGORY'];?>
			<select name="category">
				<?php
				$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
				$result = mysql_query($csql);
				while($row = mysql_fetch_array($result)) {
					echo '<option value="'.$row['cid'].'">'.$row['categoryname'].'</option>';
				}
				?>
			</select>
		</p>
		<p><input type="submit" name="submit_category" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
		<p><?php echo $lang['SEARCH_CONTEXTUAL_1'];?></p>
	</form>
	<hr />
	<?php
	if(isset($_POST['submit_category'])) {
		$category = $_POST['category'];
	
		$ssql = "SELECT * FROM items WHERE category = '$category' AND status = '2'";
		showresults($ssql, $rank);
	}
	else {
		?>
		<h2><?php echo $lang['VIEW'];?> <?php echo $lang['DB_EMPLOYED'];?></h2>
		<p class="helpbox"><?php echo $lang['SORTING_HELP'];?></p>
		<?php
		$ssql = "SELECT * FROM items WHERE status = '2' ORDER BY id ASC";
		showresults($ssql, $rank);
    }
}
?>

<?php include('includes/footer.php');?>
