<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		echo '<h2>Add/Edit Property</h2>';

		$csql = "SELECT * FROM settings";
		$result = mysql_query($csql);
		$row = mysql_fetch_array($result);

		$final_width_of_image = 100;  
		$path_to_image_directory = 'temporary/full/';  

		$currentuser = $_SESSION['username'];

		if(isset($_POST['update'])) {
			$id = $_POST['id'];
			$date = $_POST['date'];
			$type = $_POST['type'];
			$title = $_POST['title'];
			$price = $_POST['price'];
			$year = $_POST['year'];
			$location = $_POST['location'];
			$address = $_POST['address'];
			$description = $_POST['description'];
			$expire = $_POST['expire'];
			$category = $_POST['category'];
			$contact = $_POST['contact'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$url = $_POST['url'];

			$user = $currentuser;

			// begin multiple file upload
			$number_of_file_fields = 0;
			$number_of_uploaded_files = 0;
			$number_of_moved_files = 0;
			$uploaded_files = array();
			$upload_directory = dirname(__file__) . '/temporary/full/'; //set upload directory
			/**
			 * we get a $_FILES['images'] array, we process this array while iterating with simple for loop 
			 * you can check this array by print_r($_FILES['images']); 
			 */

			for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
				$number_of_file_fields++;
				$u = uniqid();
				if($_FILES['file_upload']['name'][$i] != '') { //check if file field empty or not
					$number_of_uploaded_files++;

					$attachmentname = $_FILES['file_upload']['name'][$i];

					$attachmentname = trim($attachmentname);
					$attachmentname = str_replace(' ','-',$attachmentname);
					$attachmentname = str_replace('&','-',$attachmentname);
					$attachmentname = str_replace(';','-',$attachmentname);
					$attachmentname = strtolower($attachmentname);

					$path_parts = pathinfo($upload_directory.$attachmentname);

				//	$attachmentname = $path_parts['filename'].'-'.$u.'.'.$path_parts['extension'];

					$uploaded_files[] = $attachmentname;
					if(move_uploaded_file($_FILES['file_upload']['tmp_name'][$i], $upload_directory.$attachmentname)) {
						$number_of_moved_files++;
					}
				}
				if($number_of_uploaded_files > 0)
					mysql_query("INSERT INTO upload (upload_name, upload_parent) VALUES ('".$attachmentname."', '".$_POST['id']."')");
			}

			$sql = "UPDATE data SET id='$id',date='$date',type='$type',title='$title',price='$price',year='$year',location='$location',address='$address',description='$description',expire='$expire',category='$category',contact='$contact',phone='$phone',email='$email',url='$url',user='$user',approved='0' WHERE id = '$id'";
			$result = mysql_query($sql);
			echo '<div class="confirm">Property updated!</div>';
		}
		else if(isset($_POST['submit'])) {
			$id = $_POST['id'];
			$date = $_POST['date'];
			$type = $_POST['type'];
			$title = $_POST['title'];
			$price = $_POST['price'];
			$year = $_POST['year'];
			$location = $_POST['location'];
			$address = $_POST['address'];
			$description = $_POST['description'];
			$expire = $_POST['expire'];
			$category = $_POST['category'];
			$contact = $_POST['contact'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$url = $_POST['url'];
			$user = $_POST['user'];

			$sql = "INSERT INTO data (id, date, type, title, price, year, location, address, description, expire, category, contact, phone, email, url, user, approved) VALUES ('$id', '$date', '$type', '$title', '$price', '$year', '$location', '$address', '$description', '$expire', '$category', '$contact', '$phone', '$email', '$url', '$user', '0')";
			$result = mysql_query($sql);
			$last_id = mysql_insert_id();

			// begin multiple file upload
			$number_of_file_fields = 0;
			$number_of_uploaded_files = 0;
			$number_of_moved_files = 0;
			$uploaded_files = array();
			$upload_directory = dirname(__file__) . '/temporary/full/'; //set upload directory
			/**
			 * we get a $_FILES['images'] array, we process this array while iterating with simple for loop 
			 * you can check this array by print_r($_FILES['images']); 
			 */

			for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
				$number_of_file_fields++;
				$u = uniqid();
				if($_FILES['file_upload']['name'][$i] != '') { //check if file field empty or not
					$number_of_uploaded_files++;

					$attachmentname = $_FILES['file_upload']['name'][$i];

					$attachmentname = trim($attachmentname);
					$attachmentname = str_replace(' ','-',$attachmentname);
					$attachmentname = str_replace('&','-',$attachmentname);
					$attachmentname = str_replace(';','-',$attachmentname);
					$attachmentname = strtolower($attachmentname);

					$path_parts = pathinfo($upload_directory.$attachmentname);

				//	$attachmentname = $path_parts['filename'].'-'.$u.'.'.$path_parts['extension'];

					$uploaded_files[] = $attachmentname;
					if(move_uploaded_file($_FILES['file_upload']['tmp_name'][$i], $upload_directory.$attachmentname)) {
						$number_of_moved_files++;
					}
				}
				if($number_of_uploaded_files > 0)
					mysql_query("INSERT INTO upload (upload_name, upload_parent) VALUES ('".$attachmentname."', '".$last_id."')");
			}

			if($row['free_listing'] == '1')
				echo '<div class="confirm">Property added to queue! It will be approved after payment has beed validated.</div>';
			else
				header('Location:pay.paypal.php');
		}
	else if(isset($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$result = mysql_query("SELECT * FROM data WHERE id = '$id'");
		$myrow = mysql_fetch_array($result);
		?>
		<form method="post" action="addedit.php?id=<?php echo $myrow['id']?>" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $myrow['id'];?>" />
			<input type="hidden" name="lm" value="<?php echo $currentDate;?>" />

			<div class="listing_l"><input type="text" name="id" readonly="readonly" value="<?php echo $myrow['id'];?>" /> <span class="listing_d">ID</span></div>
			<div class="listing_l"><input type="text" name="date" value="<?php echo $myrow['date'];?>" /> <span class="listing_d">Date</span></div>
			<div class="listing_l">
				<select name="type">
					<?php
					$tresult = mysql_query("SELECT type FROM data WHERE id = '$id'");
					$trow = mysql_fetch_array($tresult);
					if($trow['type'] == '1') $type = 'For sale';
					if($trow['type'] == '2') $type = 'For rent';
					?>
					<option value="<?php echo $trow['type'];?>" selected="selected"><?php echo $type;?></option>
					<option value="1">For sale</option>
					<option value="2">For rent</option>
				</select> <span class="listing_d">Type</span></div>
				<div class="listing_l"><input type="text" name="title" value="<?php echo $myrow['title'];?>" /> <span class="listing_d">Title</span></div>
				<div class="listing_l"><input type="text" name="price" value="<?php echo $myrow['price'];?>" /> <span class="listing_d">Price</span></div>
				<div class="listing_l"><input type="text" name="year" value="<?php echo $myrow['year'];?>" /> <span class="listing_d">Year</span></div>
				<div class="listing_l"><input type="text" name="location" value="<?php echo $myrow['location'];?>" /> <span class="listing_d">Location</span></div>
				<div class="listing_l"><input type="text" name="address" value="<?php echo $myrow['address'];?>" /> <span class="listing_d">Address (for <strong>Google Maps</strong>)</span></div>
				<div class="listing_l"><span class="listing_d">Description</span><br /><textarea name="description" cols="60" rows="8"><?php echo $myrow['description'];?></textarea></div>
				<div class="listing_l">
					<select name="expire">
						<option value="<?php echo $myrow['expire'];?>" selected="selected"><?php echo $myrow['expire'];?></option>
						<option value="<?php echo date('d.'),date('n')+1,date('.Y');?>">1 month</option>
						<option value="<?php echo date('d.'),date('n')+3,date('.Y');?>">3 months</option>
						<option value="<?php echo date('d.'),date('n')+6,date('.Y');?>">6 months</option>
					</select> <span class="listing_d">Ad Duration</span>
				</div>
				<div class="listing_l"><input type="text" name="contact" value="<?php echo $myrow['contact'];?>" /> <span class="listing_d">Contact</span></div>
				<div class="listing_l"><input type="text" name="phone" value="<?php echo $myrow['phone'];?>" /> <span class="listing_d">Phone</span></div>
				<div class="listing_l"><input type="text" name="email" value="<?php echo $myrow['email'];?>" /> <span class="listing_d">Email</span></div>
				<div class="listing_l"><input type="text" name="url" value="<?php echo $myrow['url'];?>" /> <span class="listing_d">Website</span></div>

				<div class="listing_l">
					<?php
					$image_result = mysql_query("SELECT * FROM upload WHERE upload_parent = '$id'");
					while($image_myrow = mysql_fetch_array($image_result)) {
						echo '<div style="float: left; margin: 1px;" class="u' . $image_myrow['upload_id'] . '">';
							echo '<a href="temporary/full/'.$image_myrow['upload_name'].'" rel="colorbox" alt=""><img src="includes/timthumb.php?src=temporary/full/'.$image_myrow['upload_name'].'&h=100&w=100&zc=1"></a>';
							echo '<br><small class="hint"><a href="#" onclick="image_delete(' . $image_myrow['upload_id'] . '); return false;">Delete</a></small>';
						echo '</div>';
					}
					?>
					<div style="clear:both"></div>
				</div>

				<div class="listing_l">
					<input type="file" name="file_upload[]" multiple> Photos<br />
					<br><small class="hint">Maximum attachments: <?php echo ini_get('max_file_uploads'); ?> | Maximum filesize: <?php echo ini_get('upload_max_filesize'); ?> | Allowed file formats: JPG, PNG or GIF</small>
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
	else {
		$user = $_SESSION['username'];

		$result1 = mysql_query("SELECT * FROM user WHERE username='".$currentuser."'");
		$myrow1 = mysql_fetch_array($result1);
		?>
		<form method="post" action="addedit.php" id="myform" enctype="multipart/form-data">
			<input type="hidden" name="user" value="<?php echo $user;?>" />
			<div class="listing_l"><input type="text" name="id" readonly="readonly" /> ID<br /><small class="hint">Transaction ID. This number helps you quickly find a property. Cannot be edited or deleted.</small></div>
			<div class="listing_l"><input type="text" name="date" value="<?php echo date('d/m/Y');?>" /> Date<br /><small class="hint">Date property was added. Default is current date.</small></div>
			<div class="listing_l">
				<select name="type">
					<option value="1">For sale</option>
					<option value="2">For rent</option>
				</select> Transaction type<br /><small class="hint">Transaction type for current property.</small>
			</div>
			<div class="listing_l"><input type="text" name="title" /> Title (<strong>required</strong>) (<strong>no more than 30 characters</strong>)<br /><small class="hint">Title appears in all sitewide listings. Make it suggestive. <em>e.g.: Big house with sea view.</em></small></div>
			<div class="listing_l"><input type="text" name="price" /> <strong><?php echo CURRENCY;?></strong> Price<br /><small class="hint">Final property price. Should contain all taxes.</small></div>
			<div class="listing_l"><input type="text" name="year" /> Year<br /><small class="hint">Year the property was built.</small></div>
			<div class="listing_l"><input type="text" name="location" /> Location<br /><small class="hint">Property location.</small></div>
			<div class="listing_l"><input type="text" name="address" /> <span class="listing_d">Address<br /><small class="hint">Used for <strong>Google Maps</strong>. Use street, number and city.</small></div>
			<div class="listing_l"><textarea name="description" cols="60" rows="8"></textarea> Description<br /><small class="hint">Detailed description with lots of information. <em>e.g.: improvements, positioning, features, etc.</em></small></div>
			<div class="listing_l">
				<select name="expire">
					<option value="<?php echo date('d.'),date('n')+1,date('.Y');?>">1 month</option>
					<option value="<?php echo date('d.'),date('n')+3,date('.Y');?>">3 months</option>
					<option value="<?php echo date('d.'),date('n')+6,date('.Y');?>">6 months</option>
				</select> Ad duration<br /><small class="hint">After expiration, the property will be hidden/deleted. You can edit it regularly if you want to keep it listed.</small>
			</div>

			<div class="listing_l"><input type="text" name="contact" value="<?php echo $myrow1['contact'];?>" /> Contact</div>
			<div class="listing_l"><input type="text" name="phone" value="<?php echo $myrow1['phone'];?>" /> Phone</div>
			<div class="listing_l"><input type="text" name="email" value="<?php echo $myrow1['email'];?>" /> Email</div>
			<div class="listing_l"><input type="text" name="url" value="<?php echo $myrow1['url'];?>" /> Website</div>
			<div class="listing_l"><small class="hint">In order to record/modify this information, go to <strong>My Profile</strong> and change the desired fields.</small></div>

			<div class="listing_l">
				<input type="file" name="file_upload[]" multiple> Photos<br />
				<br><small class="hint">Maximum attachments: <?php echo ini_get('max_file_uploads'); ?> | Maximum filesize: <?php echo ini_get('upload_max_filesize'); ?> | Allowed file formats: JPG, PNG or GIF</small>
			</div>

			<?php
			$result = mysql_query("SELECT * FROM categories");
			echo '<div class="listing_l">';
				echo '<select name="category">';
					echo '<option selected="selected">'.$category.'</option>';
					while($myrow = mysql_fetch_array($result)) {
						echo '<option>'.$myrow['category'].'</option>';
					}
				echo '</select>';
				echo ' Category';
				echo '<br /><small class="hint">Property category.</small>';
			echo '</div>';
			echo '<hr />';
			echo '<div class="listing_l"><input type="submit" name="submit" value="Add property to queue" /></div>';
		}
		?>
		</form>
	<?php }
	else restrictedAccess();?>
</div>
<?php include('includes/bottom.php');?>
