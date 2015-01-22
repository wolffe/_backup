<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		$id = mysql_real_escape_string($_GET['id']);

		$result = mysql_query("SELECT * FROM data WHERE id=$id");
		$myrow = mysql_fetch_array($result);
		echo '<h2>'.$myrow['title'].'</h2>';

		if($myrow['approved'] == 1) echo '<p><strong>Approved</strong></p>';
		else echo '<p><strong>Pending</strong></p>';
		?>
		<p>Added on <strong><?php echo date('d/m/Y', strtotime($myrow['date']));?></strong> in category <strong><?php echo $myrow['category'];?></strong></td>
		<table class="display">
			<tr><td><strong>ID:</strong></td><td><?php echo $myrow['id'];?></td></tr>
			<tr><td><strong>Title:</strong></td><td><?php echo $myrow['title'];?></td></tr>
			<tr><td><strong>Price:</strong></td><td><?php echo $myrow['price'];?></td></tr>
			<tr><td><strong>Year:</strong></td><td><?php echo $myrow['year'];?></a></td></tr>
			<tr><td><strong>Location:</strong></td><td><?php echo $myrow['location'];?></td></tr>
			<tr><td colspan="2"><strong>Description:</strong><br /><?php echo nl2br($myrow['description']);?></td></tr>
			<tr><td><strong>Expires on:</strong></td><td><?php echo date('d/m/Y', strtotime($myrow['expire']));?></td></tr>
			<tr><td><strong>Contact:</strong></td><td><?php echo $myrow['contact'];?></td></tr>
			<tr><td><strong>Phone:</strong></td><td><?php echo $myrow['phone'];?></td></tr>
			<tr><td><strong>Email:</strong></td><td><?php echo $myrow['email'];?></td></tr>
			<tr><td><strong>Website:</strong></td><td><?php echo $myrow['url'];?></td></tr>
		</table>
		<?php if($myrow['photo1'] != '') echo '<a href="temporary/full/'.$myrow['photo1'].'" rel="colorbox" title="'.$myrow['photo1'].'"><img src="includes/timthumb.php?src=temporary/full/'.$myrow['photo1'].'&h=100&w=100&zc=1"></a>';?> 
		<?php if($myrow['photo2'] != '') echo '<a href="temporary/full/'.$myrow['photo2'].'" rel="colorbox" title="'.$myrow['photo2'].'"><img src="includes/timthumb.php?src=temporary/full/'.$myrow['photo2'].'&h=100&w=100&zc=1"></a>';?> 
		<?php if($myrow['photo3'] != '') echo '<a href="temporary/full/'.$myrow['photo3'].'" rel="colorbox" title="'.$myrow['photo3'].'"><img src="includes/timthumb.php?src=temporary/full/'.$myrow['photo3'].'&h=100&w=100&zc=1"></a>';?> 
		<?php
		echo '<div class="menubar">';
			echo '<a href="addedit.php?id='.$myrow['id'].'">Edit</a> ';
			echo '<a href="delete.php?id='.$myrow['id'].'" onclick="return confirmLinkDropACC(this, \'Are you sure you want to delete &lt;'.$myrow['title'].'&gt;?\')">Delete</a> ';
			echo '<a href="viewdb2.php?category='.$myrow['category'].'">Back to <strong>'.$myrow['category'].'</strong></a>';
		echo '</div>';
		?>
<?php }
else restrictedAccess();?>
</div>
<?php include('includes/bottom.php');?>
