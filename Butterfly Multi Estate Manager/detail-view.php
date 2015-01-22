<?php
$hasprofile = 1;
$hasdetail = 1;
include('includes/top.php');
?>
<div id="content">
	<?php
	$id = mysql_real_escape_string($_GET['id']);

	$result = mysql_query("SELECT * FROM data WHERE id = '$id'");
	$myrow = mysql_fetch_array($result);
	echo '<h2>'.$myrow['title'].'</h2>';
	?>

	<p>This property has been added on <strong><?php echo date('d/m/Y', strtotime($myrow['date']));?></strong> in category <strong><?php echo $myrow['category'];?></strong> and has been assigned ID <strong><?php echo $myrow['id']?></strong>.</p>
	<ul>
		<li>
			<strong>Transaction type: </strong>
			<?php
			if($myrow['type'] == 1) echo 'For sale';
			elseif($myrow['type'] == 2) echo 'For rent';
			else echo 'n/a';
			?>
		</li>
		<li><strong>Price: </strong><?php echo $myrow['price'].' '.CURRENCY;?></li>
		<li><strong>Year: </strong><?php echo $myrow['year'];?></li>
		<li><strong>Location: </strong><?php echo $myrow['location'];?></li>
	</ul>

	<h2>Description</h2>
	<p><?php echo nl2br($myrow['description']);?></p>
	<div class="gallery">
		<?php
		$image_result = mysql_query("SELECT * FROM upload WHERE upload_parent = '$id'");
		while($image_myrow = mysql_fetch_array($image_result)) {
			echo '<a href="temporary/full/'.$image_myrow['upload_name'].'" rel="colorbox" alt=""><img src="includes/timthumb.php?src=temporary/full/'.$image_myrow['upload_name'].'&h=100&w=100&zc=1"></a>';
		}
		?>
	</div>
	<p><strong>Expires on: </strong><?php echo date('d/m/Y', strtotime($myrow['expire']));?></p>

	<?php
	if($myrow['address'] != '')
		google_singular_maps('0','0','map','8','560','250','ROADMAP',$myrow['address'],'','yes','images/icon-marker.png','no','');
	?>

	<h2>Contact Details</h2>
	<ul>
		<li><strong>Contact person: </strong><?php if($myrow['contact'] != '') echo $myrow['contact']; else echo 'n/a';?></li>
		<li><strong>Phone: </strong><?php if($myrow['phone'] != '') echo $myrow['phone']; else echo 'n/a';?></li>
		<li><strong>Email: </strong><?php if($myrow['email'] != '') echo $myrow['email']; else echo 'n/a';?></li>
		<li><strong>Website: </strong><?php if($myrow['url'] != '') echo $myrow['url']; else echo 'n/a';?></li>
	</ul>

	<div class="profile">
		<?php
		$profile = $myrow['user'];
		$stats_result = mysql_query("SELECT * FROM data WHERE user = '$profile'");
		$stats_row = mysql_fetch_array($stats_result);
		$stats_num = mysql_num_rows($stats_result);
		?>

		<p class="about">About the author:</p>
		<p>This property was added by <strong><?php echo $profile;?></strong> <em>(<?php echo $stats_num;?> properties added)</em> on <strong><?php echo date('d/m/Y', strtotime($myrow['date']));?></strong>.</p>
		<p class="about">Author badges:</p>
		<p>
			<?php
			if($stats_num >= 5 && $stats_num < 20) echo '<img src="images/badges/badge-user-regular.png" class="icon" alt="regular user" title="regular user" />';
			if($stats_num >= 20 && $stats_num < 40) echo '<img src="images/badges/badge-user-power.png" class="icon" alt="power user" title="power user" />';
			if($stats_num >= 40) echo '<img src="images/badges/badge-user-realtor.png" class="icon" alt="realtor" title="realtor" />';
			?>
		</p>
	</div>

	<div class="menubar">
		<a href="detail-category.php?category=<?php echo $myrow['category'];?>" class="bsButton">Back to <strong><?php echo $myrow['category'];?></strong></a>
	</div>
</div>
<?php include('includes/bottom.php');?>
