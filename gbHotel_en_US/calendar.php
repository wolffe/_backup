<?php
$monthNames = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$days = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');

if(!isset($_GET['m'])) $_GET['m'] = date('n');
if(!isset($_GET['y'])) $_GET['y'] = date('Y');

$currentMonth = $_GET['m'];
$currentYear = $_GET['y'];

$p_year = $currentYear;
$n_year = $currentYear;
$p_month = $currentMonth - 1;
$n_month = $currentMonth + 1;

if($p_month == 0) {
	$p_month = 12;
	$p_year = $currentYear - 1;
}
if($n_month == 13) {
	$n_month = 1;
	$n_year = $currentYear + 1;
}

if(isset($_GET['ruid']))
	$ruid = mysql_real_escape_string($_GET['ruid']);
else
	$ruid = 0;
?>

<a class="hp-arrow hp-arrow-left" href="<?php echo $_SERVER['PHP_SELF'] . '?m=' . $p_month . '&amp;y=' . $p_year . '&amp;ruid=' . $ruid; ?>">&laquo;</a>
<a class="hp-arrow hp-arrow-right" href="<?php echo $_SERVER['PHP_SELF'] . '?m=' . $n_month . '&amp;y=' . $n_year . '&amp;ruid=' . $ruid; ?>">&raquo;</a>

<table class="hp-calendar">
	<tr>
		<td colspan="7" class="hp_c_head"><?php echo $monthNames[$currentMonth-1].' '.$currentYear; ?></td>
	</tr>
	<tr >
		<?php for($i=1;$i<=7;$i++){ ?>
			<td class="hp-head"><?php echo $days[$i]; ?></td>
		<?php } ?>
	</tr>
	<?php
	$timestamp = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
	$maxday = date('t', $timestamp);
	$thismonth = getdate($timestamp);
	$startday = $thismonth['wday'];
	$startday=$startday - 1;

	for($i = 0; $i < ($maxday + $startday); $i++) {
		// begin check for reservation
		$hp_composed_date = $currentYear . '-' . str_pad((int)$currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad((int)($i - $startday + 1), 2, '0', STR_PAD_LEFT);
		// end check for reservation

		if(($i % 7) == 0)
			echo '<tr>';
		if($i < $startday)
			echo '<td></td>';
		else {
			echo '<td ';

			$result = mysql_query("SELECT * FROM hp_reservations WHERE reservation_unit_id = '$ruid' AND (reservation_from = '$hp_composed_date' OR reservation_to = '$hp_composed_date' OR '$hp_composed_date' BETWEEN reservation_from AND reservation_to)");
			while($row = mysql_fetch_array($result)) {
				if($hp_composed_date == $row['reservation_from'] || $hp_composed_date == $row['reservation_to'])
					echo 'class="margin-date"';
				else
					echo 'class="intermediary-date"';
			}

			echo ">". ($i - $startday + 1) . "</td>";
		}
		if(($i % 7) == 6)
			echo '</tr>';
	}
	?>
</table>
