<?php include('includes/top.php'); ?>
<div id="content">
	<?php
	$category = mysql_real_escape_string($_GET['category']);
	echo '<h2>' . $category . '</h2>';

	if(isset($currentuser))
		$currentuser = $_SESSION['username'];

	if(isset($_POST['em_search'])) {
		if($_POST['em_search'] == 1)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY price ASC");
		if($_POST['em_search'] == 2)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY price DESC");
		if($_POST['em_search'] == 3)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY date ASC");
		if($_POST['em_search'] == 4)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY date DESC");
		if($_POST['em_search'] == 5)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY title ASC");
		if($_POST['em_search'] == 6)
			$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY title DESC");
	}
	else {
		$result = mysql_query("SELECT * FROM data WHERE approved='1' AND category='" . $category . "' ORDER BY date DESC");
	}

	$numprops = mysql_num_rows($result);
	if($numprops == 0) echo '<p class="error">This category is empty!</p>';
	else {
		?>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<p>
				<select name="em_search" onchange="this.form.submit();">
					<option>Sort properties by...</option>
					<option value="1" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 1) { echo 'selected'; } ?>>Price (lowest to highest)</option>
					<option value="2" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 2) { echo 'selected'; } ?>>Price (highest to lowest)</option>
					<option value="3" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 3) { echo 'selected'; } ?>>Date (ascending)</option>
					<option value="4" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 4) { echo 'selected'; } ?>>Date (descending)</option>
					<option value="5" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 5) { echo 'selected'; } ?>>Alphabetical (ascending)</option>
					<option value="6" <?php if(isset($_POST['em_search']) && $_POST['em_search'] == 6) { echo 'selected'; } ?>>Alphabetical (descending)</option>
				</select>
			</p>
		</form>
		<?php
		echo '<table class="display">';
		echo '<thead><tr><th>Date</th><th>Price</th><th>Title</th><th>Type</th><th>Location</th><th></th></tr></thead>';

		echo '<tbody>';
		while($myrow = mysql_fetch_array($result)) {
			echo '<tr>';
				echo '<td><div class="tag date"><small>' . $myrow['date'] . '</small></div></td>';
				echo '<td><div class="tag price">'.$myrow['price'].' '.CURRENCY.'</div></td>';
				echo '<td><a href="detail-view.php?id='.$myrow['id'].'" title="Click for more">'.substr($myrow['title'],0 , 30).' <small>[...]</small></a></td>';
				if($myrow['type'] == 1) echo '<td><div class="tag sell">For sale</div></td>';
				elseif($myrow['type'] == 2) echo '<td><div class="tag rent">For rent</div></td>';
				else echo '<td></td>';
				echo '<td>'.$myrow['location'].'</td>';
				echo '<td>';
					if($myrow['address'] != '') echo '<img src="images/icon-map.png" alt="This property has Google Maps" title="This property has Google Maps" class="icon" />';
				echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
?>
</div>
<?php include('includes/bottom.php');?>
