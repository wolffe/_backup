<?php include('includes/header.php'); ?>

<h2 class="hp-inner-title">New Booking</h2>

<?php
if(isset($_GET['ruid']))
	$ruid = mysql_real_escape_string($_GET['ruid']);
else
	$ruid = 0;

if(isset($_POST['reservation_create'])) {
	$reservation_unit_id = $_POST['reservation_unit_id'];

	$tourist_name = $_POST['tourist_name'];
	$tourist_contact = $_POST['tourist_contact'];
	$gb_package = $_POST['gb_package'];

	// convert from HTML5 date input type
	$reservation_temp_from = new DateTime($_POST['reservation_from']);
	$reservation_from = $reservation_temp_from->format('Y-m-d');

	// convert from HTML5 date input type
	$reservation_temp_to = new DateTime($_POST['reservation_to']);
	$reservation_to = $reservation_temp_to->format('Y-m-d');

	mysql_query("INSERT INTO hp_tourists (tourist_name, tourist_contact) VALUES ('$tourist_name', '$tourist_contact')");
	$tourist_transaction_id = mysql_insert_id();

	mysql_query("INSERT INTO hp_reservations (reservation_unit_id, reservation_tourist_id, reservation_from, reservation_to, gb_package) VALUES ('$reservation_unit_id', '$tourist_transaction_id', '$reservation_from', '$reservation_to', '$gb_package')");

	echo '<div class="updated fade"><p>New booking for <b>' . $tourist_name . '</b> during ' . $reservation_from . ' - ' . $reservation_to . '.</p></div>';
}

include('calendar.php');
?>

<form method="post">
	<p>
		<select name="reservation_unit_id" id="reservation_unit_id" onchange="location.href='index.php?ruid=' + this.options[this.selectedIndex].value">
			<option>Room...</option>
			<?php
			$result = mysql_query("SELECT * FROM hp_units ORDER BY unit_id ASC");
			while($row = mysql_fetch_array($result)) {
				echo '<option value="' . $row['unit_id'] . '"';
					if($row['unit_id'] == $ruid) echo ' selected';
				echo '>' . $row['unit_number'] . '</option>';
			}
			?>
		</select> 
		<input type="text" name="tourist_name" id="tourist_name" size="56" placeholder="Tourist Name"> 
		<input type="text" name="tourist_contact" id="tourist_contact" size="32" placeholder="Tourist Phone">
	</p>
	<p>
		<input type="text" name="gb_package" id="gb_package" size="107" placeholder="Extra Booking Package Details">
	</p>
	<p>
		<label for="reservation_from">From</label> <input type="date" name="reservation_from" id="reservation_from"> <label for="reservation_to">to</label> 
		<input type="date" name="reservation_to" id="reservation_to"> 
		<input type="submit" name="reservation_create" value="Add New Booking">
	</p>
</form>

<?php include('includes/footer.php'); ?>
