<?php
if(isset($_POST['submit'])) {
	$type = $_POST['type'];
	$price = $_POST['price'];
	$location = $_POST['location'];
	$category = $_POST['category'];
	$result = mysql_query("SELECT * FROM data WHERE type = '$type' AND (LENGTH('$price') > 0 AND (price <= $price)) AND location LIKE '%$location%' AND category = '$category' AND approved = 1");
	?>
	<h2>Search Results</h2>
	<?php
	$numprops = mysql_num_rows($result);
	if($numprops == 0) {
		echo '<p class="error">No results found!</p>';
	}
	else {
		while($row = mysql_fetch_array($result)) {
			echo '<p><a href="detail-view.php?id='.$row['id'].'&amp;category='.$row['category'].'">'.$row['title'].'</a> added in <strong>'.$row['category'].'</strong> on '.date('d/m/Y', strtotime($row['date'])).'</p>';
		}
	}
}
else {
	?>
	<h2>Property Search</h2>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="search">
		<div>
			<?php
			$result = mysql_query("SELECT * FROM categories");
			echo '<select name="category">';
				while($myrow = mysql_fetch_array($result)) {
					echo '<option value="'.$myrow['category'].'">'.$myrow['category'].'</option>';
				}
			echo '</select>';
			?> 
			<select name="type">
				<option value="1">For sale</option>
				<option value="2">For rent</option>
			</select> in 
			<input type="text" name="location" size="32" placeholder="Location (full or partial)">
		</div>
		<div>
			<?php echo CURRENCY; ?> <input type="number" name="price" value="1000000" min="1" max="9999999"> 
			<input type="submit" name="submit" value="Search">
		</div>
	</form>
<?php }?>
