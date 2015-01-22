<?php include('inc.header.php');?>
<?php if(is_admin()) {?>

<h2>Dashboard</h2>
<?php
if(isset($_GET['action'])) {
	$action = mysql_real_escape_string($_GET['action']);

	if($action == 'approve') {
		$sql = "UPDATE data SET approved='1' WHERE id=".$_GET['id']." LIMIT 1";
		$result = mysql_query($sql);
		echo '<div class="confirm">Property ('.$_GET['id'].') approved!</div>';
	}
	elseif($action == 'delete') {
		$sql = "DELETE FROM data WHERE id=".$_GET['id']." LIMIT 1";
		$result = mysql_query($sql);
		echo '<div class="confirm">Property ('.$_GET['id'].') deleted!</div>';
	}
	elseif($action == 'view') {
		$sql = mysql_query("SELECT * FROM data WHERE id=".$_GET['id']);
		$myrow = mysql_fetch_array($sql);
		echo '<h2>'.$myrow['title'].'</h2>';
		?>
		<ul>
			<li><strong>ID:</strong> <?php echo $myrow['id'];?></li>
			<li>Added on <strong><?php echo $myrow['date']?></strong> in category <strong><?php echo $myrow['category']?></strong></li>
			<li><strong>Type:</strong> 
				<?php
				if($myrow['type'] == 1) echo 'For sale';
				if($myrow['type'] == 2) echo 'For rent';
			?></li>
			<li><strong>Price:</strong> <?php echo $myrow['price'].' '.CURRENCY;?></li>
			<li><strong>Year:</strong> <?php echo $myrow['year'];?></a></li>
			<li><strong>Location:</strong> <?php echo $myrow['location'];?></li>
			<li><strong>Expires:</strong> <?php echo $myrow['expire'];?></li>
		</ul>
		<h2>Description</h2>
		<p><?php echo nl2br($myrow['description']);?></p>
		<p>
			<a href="../temporary/full/<?php echo $myrow['photo1'];?>"><img src="../includes/timthumb.php?src=../temporary/full/<?php echo $myrow['photo1'];?>&h=100&w=100&zc=1" alt="" /></a> 
			<a href="../temporary/full/<?php echo $myrow['photo2'];?>"><img src="../includes/timthumb.php?src=../temporary/full/<?php echo $myrow['photo2'];?>&h=100&w=100&zc=1" alt="" /></a> 
			<a href="../temporary/full/<?php echo $myrow['photo3'];?>"><img src="../includes/timthumb.php?src=../temporary/full/<?php echo $myrow['photo3'];?>&h=100&w=100&zc=1" alt="" /></a> 
		</p>
		<h2>Contact Details</h2>
		<ul>
			<li><strong>Contact:</strong> <?php echo $myrow['contact'];?></li>
			<li><strong>Phone:</strong> <?php echo $myrow['phone'];?></li>
			<li><strong>Email:</strong> <?php echo $myrow['email'];?></li>
			<li><strong>Website:</strong> <?php echo $myrow['url'];?></li>
		</ul>
		<?php
	}
	elseif($action == 'edit') {
		$sql = mysql_query("SELECT * FROM data WHERE id=".$_GET['id']);
		$myrow = mysql_fetch_array($sql);
		?>
		<form method="post" action="index.php?id=<?php echo $myrow['id']?>">
			<input type="hidden" name="id" value="<?php echo $myrow['id'];?>" />
			<input type="hidden" name="lm" value="<?php echo $currentDate;?>" />
			<input type="hidden" name="type" value="<?php echo $myrow['type'];?>" />
			<input type="hidden" name="user" value="<?php echo $myrow['user'];?>" />

			<div class="listing_l"><input type="text" name="id" readonly="readonly" value="<?php echo $myrow['id'];?>" /> <span class="listing_d">ID</span></div>
			<div class="listing_l"><input type="text" name="date" value="<?php echo $myrow['date'];?>" /> <span class="listing_d">Date</span></div>
			<div class="listing_l">
				<select name="type">
					<?php
					$tresult = mysql_query("SELECT type FROM data WHERE id = '".$_GET['id']."'");
					$trow = mysql_fetch_array($tresult);
					if($trow['type'] == '1') $type = 'For sale';
					if($trow['type'] == '2') $type = 'For rent';
					?>
					<option value="<?php echo $trow['type'];?>" selected="selected"><?php echo $type;?></option>
					<option value="1">For sale</option>
					<option value="2">For rent</option>
				</select> <span class="listing_d">Type</span>
			</div>
			<div class="listing_l"><input type="text" name="title" value="<?php echo $myrow['title'];?>" /> <span class="listing_d">Title</span></div>
			<div class="listing_l"><input type="text" name="price" value="<?php echo $myrow['price'];?>" /> <span class="listing_d">Price</span></div>
			<div class="listing_l"><input type="text" name="year" value="<?php echo $myrow['year'];?>" /> <span class="listing_d">Year</span></div>
			<div class="listing_l"><input type="text" name="location" value="<?php echo $myrow['location'];?>" /> <span class="listing_d">Location</span></div>
			<div class="listing_l"><textarea name="description" cols="60" rows="8"><?php echo $myrow['description']?></textarea> <span class="listing_d">Descriere</span></div>
			<div class="listing_l">
				<select name="expire">
					<option value="<?php echo $myrow['expire'];?>" selected="selected"><?php echo $myrow['expire'];?></option>
					<option value="<?php echo date('d.'),date('n')+1,date('.Y');?>">1 luna</option>
					<option value="<?php echo date('d.'),date('n')+3,date('.Y');?>">3 luni</option>
					<option value="<?php echo date('d.'),date('n')+6,date('.Y');?>">6 luni</option>
				</select> <span class="listing_d">Ad duration</span>
			</div>
			<div class="listing_l"><input type="text" name="contact" value="<?php echo $myrow['contact'];?>" /> <span class="listing_d">Contact</span></div>
			<div class="listing_l"><input type="text" name="phone" value="<?php echo $myrow['phone'];?>" /> <span class="listing_d">Phone</span></div>
			<div class="listing_l"><input type="text" name="email" value="<?php echo $myrow['email'];?>" /> <span class="listing_d">Email</span></div>
			<div class="listing_l"><input type="text" name="url" value="<?php echo $myrow['url'];?>" /> <span class="listing_d">Website</span></div>

			<div class="listing_l">
				<?php
				if($myrow['photo1']) echo '<input type="hidden" name="photo1" value="'.$myrow['photo1'].'" /><a href="../temporary/full/'.$myrow['photo1'].'"><img src="../includes/timthumb.php?src=../temporary/full/'.$myrow['photo1'].'&h=100&w=100&zc=1"></a> ';
				if($myrow['photo2']) echo '<input type="hidden" name="photo2" value="'.$myrow['photo2'].'" /><a href="../temporary/full/'.$myrow['photo2'].'"><img src="../includes/timthumb.php?src=../temporary/full/'.$myrow['photo2'].'&h=100&w=100&zc=1"></a> ';
				if($myrow['photo3']) echo '<input type="hidden" name="photo3" value="'.$myrow['photo3'].'" /><a href="../temporary/full/'.$myrow['photo3'].'"><img src="../includes/timthumb.php?src=../temporary/full/'.$myrow['photo3'].'&h=100&w=100&zc=1"></a> ';
				?>
			</div>

			<?php
			$result = mysql_query("SELECT * FROM categories");
			echo '<select name="category">';
				echo '<option selected="selected">'.$myrow['category'].'</option>';
				while($myrow = mysql_fetch_array($result)) {
					echo '<option>'.$myrow[1].'</option>';
				}
			echo '</select>';
			?>
			<p><input type="submit" name="update" value="Update" /></p>
		</form>
		<?php
	}
}
if(isset($_POST['update'])) {
	$id 			= $_POST['id'];
	$date 			= $_POST['date'];
	$type 			= $_POST['type'];
	$title 			= $_POST['title'];
	$price 			= $_POST['price'];
	$year 			= $_POST['year'];
	$location 		= $_POST['location'];
	$description 	= $_POST['description'];
	$expire 		= $_POST['expire'];
	$category 		= $_POST['category'];
	$contact 		= $_POST['contact'];
	$phone 			= $_POST['phone'];
	$email 			= $_POST['email'];
	$url 			= $_POST['url'];

	$sql = "UPDATE data SET id='$id',date='$date',type='$type',title='$title',price='$price',year='$year',location='$location',description='$description',expire='$expire',category='$category',contact='$contact',phone='$phone',email='$email',url='$url',approved='0' WHERE id=$id";
	$result = mysql_query($sql);
	echo '<div class="confirm">Property updated!</div>';
}
$result = mysql_query("SELECT * FROM data WHERE approved = '0' LIMIT 10");

echo '<p>Welcome to your administration section!</p>';
echo '<div class="widgetbox">';
	// print tables
	echo '<h3>Pending properties</h3>';
	echo '<p><small>Showing the most recent 10 pending properties</small></p>';
	echo '<table id="tableCategories" width="100%" cellspacing="0" cellpadding="8">';

	while($row = mysql_fetch_array($result)) {
		echo '<tr>';
		echo '<td>'.$row['id'].'. <span class="type_title">'.$row['title'].'</span> <span class="type_content"><em>('.$row['category'].')</em></span> - <span class="type_date">'.$row['date'].'</span>/<span class="type_expire">'.$row['expire'].'</span> [<span class="type_user">'.$row['user'].'</span>]<br />';
		echo '<small>';
		echo '<a href="index.php?id='.$row['id'].'&amp;action=view">View</a> ';
		echo '<a href="index.php?id='.$row['id'].'&amp;action=approve">Approve</a> ';
		echo '<a href="index.php?id='.$row['id'].'&amp;action=edit">Edit</a> ';
		echo '<a href="index.php?id='.$row['id'].'&amp;action=delete">Delete</a>';
		echo '</small>';
		echo '</td>';
		echo "</tr>";
	}

	echo '</tbody>';
	echo '</table>';
echo '</div>';

echo '<div class="widgetbox">';
	echo '<h3>Statistics:</h3> ';
	echo '<ul>';
		echo '<li><strong>'.$numresults_1.'</strong> approved properties</li>';
		echo '<li><strong>'.$numresults_0.'</strong> pending properties</li>';
		echo '<li><strong>'.$numresults_c.'</strong> categories</li>';
		echo '<li><strong>'.$numresults_u.'</strong> users</li>';
	echo '</ul>';
echo '</div>';
?>

<?php include('inc.footer.php');?>
<?php }?>
