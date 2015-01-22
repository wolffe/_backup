<?php include('includes/header.php'); ?>

<h2 class="hp-inner-title">Bookings/Room</h2>

<?php
if(isset($_GET['ruid']))
	$ruid = mysql_real_escape_string($_GET['ruid']);
else
	$ruid = 0;

if(isset($_GET['action'])) {
	$action = mysql_real_escape_string($_GET['action']);
	if($action == 'd') {
		$id = mysql_real_escape_string($_GET['id']);
		mysql_query("DELETE FROM hp_reservations WHERE reservation_id='$id'");
	}
}
?>

<p>
	<label for="reservation_unit_id">Show bookings for </label>
	<select name="reservation_unit_id" id="reservation_unit_id" onchange="location.href='unit-view.php?ruid=' + this.options[this.selectedIndex].value">
		<option>Room...</option>
		<?php
		$result = mysql_query("SELECT * FROM hp_units ORDER BY unit_number ASC");
		while($row = mysql_fetch_array($result)) {
			echo '<option value="' . $row['unit_id'] . '"';
				if($row['unit_id'] == $ruid) echo ' selected';
			echo '>' . $row['unit_number'] . '</option>';
		}
		?>
	</select>
</p>

<?php

$result = mysql_query("SELECT * FROM hp_reservations WHERE reservation_unit_id = '$ruid' ORDER BY reservation_from DESC");

echo '
<table class="hp-datatable">
	<thead>
		<th>Tourist Name</th>
		<th>From</th>
		<th>To</th>
		<th></th>
	</thead>
	<tbody>';
while($row = mysql_fetch_array($result)) {
	$result_tourist = mysql_query("SELECT * FROM hp_tourists WHERE tourist_id = '" . $row['reservation_tourist_id'] . "' LIMIT 1");
	$row_tourist = mysql_fetch_array($result_tourist);

	echo '<tr>';
		echo '<td>' . $row_tourist['tourist_name'] . ' (' . $row_tourist['tourist_contact'] . ')<br>' . $row['gb_package'] . '</td>';
		echo '<td>' . $row['reservation_from'] . '</td>';
		echo '<td>' . $row['reservation_to'] . '</td>';
		echo '<td>';
			echo '<a href="unit-view.php?action=d&amp;id=' . $row['reservation_id'] . '&amp;ruid=' . $ruid . '">Cancel/Remove</a>';
		echo '</td>';
	echo '</tr>';
}
echo '</tbody></table>';
?>

<?php include('includes/footer.php'); ?>
