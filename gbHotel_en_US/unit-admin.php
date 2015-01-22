<?php include('includes/header.php'); ?>

<h2 class="hp-inner-title">Manage Rooms</h2>

<?php
if(isset($_POST['unit_create'])) {
	$unit_number = $_POST['unit_number'];
	$unit_description = $_POST['unit_description'];

	$unit_type = $_POST['unit_type'];
	$unit_type_alternative = $_POST['unit_type_alternative'];

	if((!isset($_POST['unit_type']) || $_POST['unit_type'] == '') && !empty($unit_type_alternative)) {
		mysql_query("INSERT INTO hp_unit_types (unit_type) VALUES ('$unit_type_alternative')");
		$unit_type = $unit_type_alternative;
		echo '<div class="updated fade"><p>New room type added.</p></div>';
	}

	mysql_query("INSERT INTO hp_units (unit_number, unit_description, unit_type) VALUES ('$unit_number', '$unit_description', '$unit_type')");

	echo '<div class="updated fade"><p>Room <b>' . $unit_number . '</b> added.</p></div>';
}
if(isset($_GET['druid'])) {
	$druid = $_GET['druid'];

	mysql_query("DELETE FROM hp_units WHERE unit_id = '$druid'");

	echo '<div class="updated fade"><p>Room deleted.</p></div>';
}
if(isset($_GET['cruid'])) {
	$cruid = $_GET['cruid'];

	$result = mysql_query("SELECT unit_status FROM hp_units WHERE unit_id = '$cruid'");
	$row = mysql_fetch_array($result);

	if($row['unit_status'] == 2)
		mysql_query("UPDATE hp_units SET unit_status = 0 WHERE unit_id = '$cruid'");
	else
		mysql_query("UPDATE hp_units SET unit_status = 2 WHERE unit_id = '$cruid'");

	echo '<div class="updated fade"><p>Room checked.</p></div>';
}
?>

<form method="post">
	<p>
		<input type="text" name="unit_number" id="unit_number" size="60" placeholder="Room Number">
	</p>
	<p>
		<input type="text" name="unit_description" id="unit_description" size="60" placeholder="Room Description (optional)">
	</p>
	<p>
		<select name="unit_type" id="unit_type">
			<option value="">Room Type...</option>
			<?php
			$result = mysql_query("SELECT * FROM hp_unit_types ORDER BY unit_type_id ASC");
			while($row = mysql_fetch_array($result)) {
				echo '<option value="' . $row['unit_type_id'] . '">' . $row['unit_type'] . '</option>';
			}
			?>
		</select> <input type="text" name="unit_type_alternative" size="30" placeholder="New Room Type">
	</p>
	<p>
		<input type="submit" name="unit_create" value="Add Room">
	</p>
</form>

<h2>Room List</h2>

<?php
$result = mysql_query("SELECT * FROM hp_units ORDER BY unit_number ASC");
while($row = mysql_fetch_array($result)) {
	// unit type
	if($row['unit_type'] == 1) $unit_type_class = 'hp_simple';
	else if($row['unit_type'] == 2) $unit_type_class = 'hp_double';
	else $unit_type_class = '';

	// unit status
	if($row['unit_status'] == 2) $unit_status_class = 'hp_cleaning';
	else $unit_status_class = '';

	$result_type = mysql_query("SELECT * FROM hp_unit_types WHERE unit_type_id='" . $row['unit_type'] . "' LIMIT 1");
	$row_type = mysql_fetch_array($result_type);

	echo '
	<div class="hp_unit_box ' . $unit_type_class . ' ' . $unit_status_class . '" title="' . $row_type['unit_type'] . ' (' . $row['unit_description'] . ')">
		<span class="hp_unit_box_main">' . $row['unit_number'] . '</span><br>
		<a class="hp_unit_box_link" href="unit-admin.php?druid=' . $row['unit_id'] . '" title="Delete this room!"><img src="images/icon-delete.png" alt=""></a><br>
		<a class="hp_unit_box_link" href="unit-admin.php?cruid=' . $row['unit_id'] . '" title="Retire this room."><img src="images/icon-clean.png" alt=""></a>
	</div>';
}
?>
<div class="clearfix"></div>

<?php include('includes/footer.php'); ?>
