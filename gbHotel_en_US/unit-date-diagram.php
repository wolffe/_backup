<?php include('includes/header.php'); ?>

<h2 class="hp-inner-title">Manage Bookings</h2>

<?php
if(isset($_GET['ruid']))
	$ruid = mysql_real_escape_string($_GET['ruid']);
else
	$ruid = 0;
?>

<form method="post">
	<p>
		<input type="date" name="gb_date" id="gb_date">
		<input name="gb_date_submit" type="submit" value="Show Bookings">
	</p>
</form>


<?php
if(isset($_POST['gb_date_submit'])) {
	echo '<p>Bookings for ' . $_POST['gb_date'] . '</p>';
	$gb_status = '';
	$result = mysql_query("SELECT * FROM hp_units ORDER BY unit_number ASC");
	while($row = mysql_fetch_array($result)) {
		$result_reservations = mysql_query("
		SELECT * FROM hp_reservations 
		WHERE (
			reservation_unit_id = " . $row['unit_id'] . "
		) AND (
			'" . $_POST['gb_date'] . "' BETWEEN reservation_from AND reservation_to
		)
		");

		if(mysql_num_rows($result_reservations) > 0 && $_POST['gb_date'] <= date('Y-m-d')) $gb_status = 'bg-red';
		else if(mysql_num_rows($result_reservations) > 0 && $_POST['gb_date'] > date('Y-m-d')) $gb_status = 'bg-purple';
		else $gb_status = '';

		if($row['unit_type'] == 1) $unit_type_class = 'hp_simple';
		else if($row['unit_type'] == 2) $unit_type_class = 'hp_double';
		else $unit_type_class = '';

		// unit status
		if($row['unit_status'] == 2) $unit_status_class = 'hp_cleaning';
		else $unit_status_class = '';

		$result_type = mysql_query("SELECT * FROM hp_unit_types WHERE unit_type_id='" . $row['unit_type'] . "' LIMIT 1");
		$row_type = mysql_fetch_array($result_type);

		echo '
		<div class="hp_unit_box ' . $unit_type_class . ' ' . $unit_status_class . ' ' . $gb_status . '" title="' . $row_type['unit_type'] . ' (' . $row['unit_description'] . ')">
			<span class="hp_unit_box_main">' . $row['unit_number'] . '</span><br>
			<a class="hp_unit_box_link" href="unit-admin.php?cruid=' . $row['unit_id'] . '" title="Retire this room."><img src="images/icon-clean.png" alt=""></a>
		</div>';
	}

	echo '<div class="clearfix"></div>';
}
?>

<?php include('includes/footer.php'); ?>
