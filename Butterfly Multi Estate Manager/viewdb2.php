<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		$currentuser = $_SESSION['username'];
		$category = mysql_real_escape_string($_GET['category']);

		echo '<h2>'.$category.'</h2>';
		$result = mysql_query("SELECT * FROM data WHERE user='".$currentuser."' AND category='".$category."' ORDER BY date DESC");

		echo '<table class="display">';
		echo '<thead><tr><th>Title</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>';
		echo '<tbody>';
		while($myrow = mysql_fetch_array($result)) {
			echo '<tr><td><a href="view.php?id='.$myrow['id'].'">'.$myrow['title'].'</a></td><td>'.date('d/m/Y', strtotime($myrow['date'])).'</td>';

			if($myrow['approved'] == '1') echo '<td>Approved</td>';
			if($myrow['approved'] == '0') echo '<td>Pending</td>';

			echo '<td><a href="view.php?id='.$myrow['id'].'">View</a> <a href="addedit.php?id='.$myrow['id'].'">Edit</a> <a href="delete.php?id='.$myrow['id'].'" onclick="return confirmLinkDropACC(this,\'Are you sure you want to delete &lt;'.$myrow['title'].'&gt;?\')">Delete</a></td>';

			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';

		echo '<h2>Add a property</h2>';
		echo '<p>&raquo; <a href="addedit.php">Add a property</a></p>';
	}
	else restrictedAccess();
	?>
</div>
<?php include('includes/bottom.php');?>
