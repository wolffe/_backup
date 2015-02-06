<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
<div class="table-wrap-wide">

<h2>Search and manage reports<?php //echo $lang['CREATE_REPORT'];?></h2>
<p>Create a new report using the desired search options.</p>

<hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>#results" method="post">
	<table class="display">
		<tr>
			<td>
	<p><input type="text" name="name"<?php if(isset($_POST['name'])) echo ' value="'.$_POST['name'].'"';?> /> <?php echo $lang['FIRSTNAME'];?></p>
	<p><input type="text" name="lastname"<?php if(isset($_POST['lastname'])) echo ' value="'.$_POST['lastname'].'"';?> /> <?php echo $lang['LASTNAME'];?></p>
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
		</select> <?php echo $lang['CATEGORY'];?>
	</p>
	<p><input type="text" name="location"<?php if(isset($_POST['location'])) echo ' value="'.$_POST['location'].'"';?> /> <?php echo $lang['CITY'];?></p>
			</td>
			<td>
	<p><input type="text" name="diplomas"<?php if(isset($_POST['diplomas'])) echo ' value="'.$_POST['diplomas'].'"';?> /> Qualification</p>
	<p><input type="text" name="current_workplace"<?php if(isset($_POST['current_workplace'])) echo ' value="'.$_POST['current_workplace'].'"';?> /> <?php echo $lang['CURRENT_ROLE'];?></p>
	<p><input type="text" name="last_workplace"<?php if(isset($_POST['last_workplace'])) echo ' value="'.$_POST['last_workplace'].'"';?> /> <?php echo $lang['LAST_WORKPLACE'];?></p>
			</td>
		</tr>
		<tr>
			<td colspan="2">
	<p>
		<input type="checkbox" name="showemail" id="showemail" value="1" /> <label for="showemail">Show email in report?</label> | 
		<input type="checkbox" name="showphone" id="showphone" value="1" /> <label for="showphone">Show phone in report?</label> | 
		<input type="checkbox" name="showmobile" id="showmobile" value="1" /> <label for="showmobile">Show mobile in report?</label>
	</p>

	<p><input type="submit" name="submit_multiple" class="button" value="<?php echo $lang['SEARCH'];?>" /></p>
			</td>
		</tr>
	</table>
</form>

<?php
if(isset($_POST['submit_multiple'])) {
	if(isset($_POST['name']) && $_POST['name'] != '')
		$name_query = "name LIKE '%".$_POST['name']."%' AND ";
	else $name_query = '';

	if(isset($_POST['lastname']) && $_POST['lastname'] != '')
		$lastname_query = "lastname LIKE '%".$_POST['lastname']."%' AND ";
	else $lastname_query = '';

	if(isset($_POST['category']) && $_POST['category'] != '')
		$category_query = "category LIKE '%".$_POST['category']."%' AND ";
	else $category_query = '';

	if(isset($_POST['location']) && $_POST['location'] != '')
		$location_query = "location LIKE '%".$_POST['location']."%' AND ";
	else $location_query = '';

	if(isset($_POST['diplomas']) && $_POST['diplomas'] != '')
		$diplomas_query = "(diplomas1 LIKE '%".$_POST['diplomas']."%' OR diplomas2 LIKE '%".$_POST['diplomas']."%' OR diplomas3 LIKE '".$_POST['diplomas']."%') AND ";
	else $diplomas_query = '';

	if(isset($_POST['current_workplace']) && $_POST['current_workplace'] != '')
		$currentw_query = "currentworkplace LIKE '%".$_POST['current_workplace']."%' AND ";
	else $currentw_query = '';

	if(isset($_POST['last_workplace']) && $_POST['last_workplace'] != '')
		$lastw_query = "currentworkplace LIKE '%".$_POST['last_workplace']."%' AND ";
	else $lastw_query = '';

	$showemail 	= 0;
	$showphone 	= 0;
	$showmobile = 0;

	if(isset($_POST['showemail']) == 1)
		$showemail = 1;
	if(isset($_POST['showphone']) == 1)
		$showphone = 1;
	if(isset($_POST['showmobile']) == 1)
		$showmobile = 1;

	$ssql = "SELECT * FROM items WHERE ".
		$name_query.
		$lastname_query.
		$category_query.
		$location_query.
		$diplomas_query.
		$currentw_query.
		$lastw_query.
			" 1=1";
	?>
	<div class="alignright">
		<form action="modules/export/save2doc.php" method="post" target="_blank" onsubmit='$("#datatodisplaydoc").val($("<div>").append($("#items").eq(0).clone()).html())' style="display: inline">
			<a class="printme button" href="#">Print this report</a>
			<input type="hidden" id="datatodisplaydoc" name="datatodisplaydoc" />
			<input type="submit" name="submit" value="Export as .doc file" class="button" />
		</form>
		<form action="modules/export/save2xls.php" method="post" target="_blank" onsubmit='$("#datatodisplayxls").val($("<div>").append($("#items").eq(0).clone()).html())' style="display: inline">
			<input type="hidden" id="datatodisplayxls" name="datatodisplayxls" />
			<input type="submit" name="submit" value="Export as .xls file" class="button" />
		</form>
	</div>
	<?php
	echo '<a name="results"></a>';
	echo '<div id="printable">';
		showresults_report($ssql, $rank, $showemail, $showphone, $showmobile);
	echo '</div>';
}
?>

</div>
<?php }?>
<?php include('includes/footer.php');?>
