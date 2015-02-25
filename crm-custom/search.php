<?php include('includes/header.php');?>

<?php if(is_authed()) {?>

<div class="table-wrap">

<h2><?php echo $lang['BASIC_SEARCH'];?></h2>
<p>Quick search/sort by single or double parameters.</p>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['SEARCH_BY_NAME'];?></strong> <input type="text" name="name" /> <?php echo $lang['NAME'];?></p>
	<p><input type="submit" name="submit_name" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_name'])) {
	$name = $_POST['name'];

	$ssql = "SELECT * FROM items WHERE name LIKE '%$name%'";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p>
		<strong><?php echo $lang['SEARCH_BY_CATEGORY'];?></strong> <select name="category">
			<?php
			$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<option value="'.$row['cid'].'">'.$row['categoryname'].'</option>';
			}
			?>
		</select> <?php echo $lang['CATEGORY'];?>
	</p>
	<p><input type="submit" name="submit_category" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_category'])) {
	$category = $_POST['category'];

	$ssql = "SELECT * FROM items WHERE category = '$category'";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['SEARCH_BY_PROFESSION'];?></strong> <input type="text" name="diplomas" /> <?php echo $lang['QUALIFICATION'];?></p>
	<p><input type="submit" name="submit_diplomas" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_diplomas'])) {
	$diplomas = $_POST['diplomas'];

	$ssql = "SELECT * FROM items WHERE diplomas1 LIKE '%$diplomas%' OR diplomas2 LIKE '%$diplomas%' OR diplomas3 LIKE '%$diplomas%'";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['ADVANCED_SEARCH'];?></strong></p>
	<p>
		<select name="category">
			<?php
			$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<option value="'.$row['cid'].'">'.$row['categoryname'].'</option>';
			}
			?>
		</select> <?php echo $lang['CATEGORY'];?>
	</p>
	<p><input type="text" name="diplomas" /> <?php echo $lang['QUALIFICATION'];?></p>
	<p><input type="submit" name="submit_advanced" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_advanced'])) {
	$category = $_POST['category'];
	$diplomas = $_POST['diplomas'];

	$ssql = "SELECT * FROM items WHERE category = '$category' AND (diplomas1 LIKE '%$diplomas%' OR diplomas2 LIKE '%$diplomas%' OR diplomas3 LIKE '%$diplomas%')";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['SEARCH_BY_CITY'];?></strong> <input type="text" name="location" /> <?php echo $lang['CITY'];?></p>
	<p><input type="submit" name="submit_location" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_location'])) {
	$location = $_POST['location'];

	$ssql = "SELECT * FROM items WHERE location LIKE '%$location%'";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['SEARCH_BY_CURRENT_WORKPLACE'];?></strong> <input type="text" name="current_workplace" /> <?php echo $lang['CURRENT_ROLE'];?></p>
	<p><input type="submit" name="submit_current_workplace" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_current_workplace'])) {
	$current_workplace = $_POST['current_workplace'];

	$ssql = "SELECT * FROM items WHERE currentworkplace LIKE '%$current_workplace%'";
	showresults_slim($ssql, $rank);
}
?>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p><strong><?php echo $lang['SEARCH_BY_LAST_WORKPLACE'];?></strong> <input type="text" name="last_workplace" /> <?php echo $lang['LAST_WORKPLACE'];?></p>
	<p><input type="submit" name="submit_last_workplace" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_last_workplace'])) {
	$last_workplace = $_POST['last_workplace'];

	$ssql = "SELECT * FROM items WHERE lastworkplace LIKE '%$last_workplace%'";
	showresults_slim($ssql, $rank);
}
?>

</div>
<div class="table-wrap">

<h2><?php echo $lang['ADVANCED_SEARCH'];?></h2>
<p>Advanced search by multiple parameters.</p>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<p>
		<select name="category">
			<option value="">Any</option>
			<?php
			$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
			$result = mysql_query($csql);
			while($row = mysql_fetch_array($result)) {
				echo '<option value="'.$row['cid'].'">'.$row['categoryname'].'</option>';
			}
			?>
		</select> Industry
	</p>
	<p><input type="text" name="pqe"<?php if(isset($_POST['pqe'])) echo ' value="'.$_POST['pqe'].'"';?> /> PQE</p>
	<p><input type="text" name="diplomas" /> Qualification</p>
	<p><input type="text" name="currentRole"<?php if(isset($_POST['currentRole'])) echo ' value="'.$_POST['currentRole'].'"';?> /> Current Role</p>
	<p><input type="submit" name="submit_multiple" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
</form>

<?php
if(isset($_POST['submit_multiple'])) {
	if(isset($_POST['category']) && $_POST['category'] != '')
		$category_query = "category LIKE '%".$_POST['category']."%' AND ";
	else $category_query = '';

	if(isset($_POST['pqe']) && $_POST['pqe'] != '')
		$pqe_query = "pqe = '".$_POST['pqe']."' AND ";
	else $pqe_query = '';

	if(isset($_POST['diplomas']) && $_POST['diplomas'] != '')
		$diplomas_query = "(diplomas1 LIKE '%".$_POST['diplomas']."%' OR diplomas2 LIKE '%".$_POST['diplomas']."%' OR diplomas3 LIKE '%".$_POST['diplomas']."%') AND ";
	else $diplomas_query = '';

	if(isset($_POST['currentRole']) && $_POST['currentRole'] != '')
		$currentw_query = "currentRole LIKE '%".$_POST['currentRole']."%' AND ";
	else $currentw_query = '';

	$ssql = "SELECT * FROM items WHERE ".
		$category_query.
		$pqe_query.
		$diplomas_query.
		$currentw_query.
			" 1=1";

	showresults_slim($ssql, $rank);
}
?>


</div>
<?php }?>
<?php include('includes/footer.php');?>
