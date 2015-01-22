<?php include('includes/top.php');?>
<div id="content">
	<?php if(HEADER_DISPLAY != 9) { ?>
		<h2><img src="images/small-marker-hot.png" alt="" class="icon" /> Just Added!</h2>
		<?php
		$latest_result = mysql_query("SELECT address FROM data WHERE approved='1' AND address != '' ORDER BY date DESC LIMIT 1");
		$latest_row = mysql_fetch_array($latest_result);
		google_maps('0','0','map','8','560','250','ROADMAP',$latest_row['address'],'','yes','images/icon-marker.png','no','');
		?>
	<?php } ?>

	<?php include('includes/search.php');?>

	<h2>Add a property now!</h2>
	<ul>
		<li>Advertise your <strong>real estate</strong> company!</li>
		<li>Looking for a house or a flat? <strong>Find it here</strong>!</li>
		<li><a href="register.php"><strong>Register now</strong></a> and add a property!</li>
	</ul>

	<h2>Recently Added</h2>				
	<?php
		$result = mysql_query("SELECT * FROM data WHERE approved='1' ORDER BY id DESC LIMIT 15");

		echo '<table class="display">';
		echo '<thead><tr><th>Date</th><th>Price</th><th>Title</th><th>Type</th><th></th></tr></thead>';

		echo '<tbody>';
		while($myrow = mysql_fetch_array($result)) {
			echo '<tr>';
				echo '<td><div class="tag date"><small>'.date('d/m/Y', strtotime($myrow['date'])).'</small></div></td>';
				echo '<td><div class="tag price"><small>'.CURRENCY.' '.$myrow['price'].'</small></div></td>';
				echo '<td><a href="detail-view.php?id='.$myrow['id'].'" title="Click for more">' . substr($myrow['title'], 0, 42) . '&hellip;</a><br>'.$myrow['location'].'</td>';
				if($myrow['type'] == 1) echo '<td><div class="tag sell"><small>For sale</small></div></td>';
				elseif($myrow['type'] == 2) echo '<td><div class="tag rent"><small>For rent</small></div></td>';
				else echo '<td></td>';
				echo '<td>';
					if($myrow['address'] != '') echo '<img src="images/icon-map.png" alt="This property has Google Maps" title="This property has Google Maps" class="icon" />';
				echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	?>
</div>
<?php include('includes/bottom.php');?>
