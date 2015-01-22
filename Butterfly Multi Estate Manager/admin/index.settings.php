<?php include('inc.header.php');?>
<?php if(is_admin()) {?>
	<?php
	if(isset($_POST['submit_edit'])) {
		$sitetitle 		= $_POST['sitetitle'];
		$currency 		= $_POST['currency'];
		$emailpaypal 	= $_POST['emailpaypal'];
		$emailnotify 	= $_POST['emailnotify'];
		$price 			= $_POST['price'];
		$free_listing 	= $_POST['free_listing'];

		$header_display = $_POST['header_display'];
		$header_image = $_POST['header_image'];

		mysql_query("UPDATE settings SET 
			sitetitle = '$sitetitle',
			currency = '$currency',
			email_paypal = '$emailpaypal',
			email_notify = '$emailnotify',
			price = '$price',
			free_listing = '$free_listing',

			header_display = '$header_display',
			header_image = '$header_image'
		WHERE sid = '1'");
		echo '<div class="confirm">Settings updated!</div>';
	}

	$csql = "SELECT * FROM settings";
	$result = mysql_query($csql);
	$row = mysql_fetch_array($result);
	?>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="settings-form">
		<h2>General Settings</h2>
		<p>
			<input type="text" name="sitetitle" id="sitetitle" value="<?php echo $row['sitetitle'];?>" size="35" /> <label for="sitetitle">Site title</label>
			<div class="description">The title is used in the &lt;title&gt; and in the top banner.</div>
		</p>
		<p>
			<input type="text" name="price" id="price" value="<?php echo $row['price'];?>" size="4" /> <label for="price">Property listing price</label>
			<div class="description">This is the price for listing a property <em>(e.g. 1.99, 2.49, 3)</em>.</div>
		</p>
		<p>
			<select name="free_listing" id="free_listing">
				<option value="select_option">Select option</option>
				<option value="1"<?php if($row['free_listing'] == '1') echo ' selected="selected"';?>>Yes</option>
				<option value="0"<?php if($row['free_listing'] == '0') echo ' selected="selected"';?>>No</option>
			</select> <label for="free_listing">Allow free listing?</label>
			<div class="description">If free listings are allowed, user will add all properties to pending queue, without paying.</div>
		</p>
		<p>
			<select name="currency" id="currency">
				<option value="select_currency">Select currency</option>
				<?php if(isset($row['currency'])) {?>
					<option value="<?php echo $row['currency'];?>" selected="selected"><?php echo $row['currency'];?></option>
				<?php }?>
				<option value="EUR">EUR</option>
				<option value="AUD">AUD</option>
				<option value="GBP">GBP</option>
				<option value="CAD">CAD</option>
				<option value="CZK">CZK</option>
				<option value="DKK">DKK</option>
				<option value="HKD">HKD</option>
				<option value="HUF">HUF</option>
				<option value="ILS">ILS</option>
				<option value="JPY">JPY</option>
				<option value="MXN">MXN</option>
				<option value="TWD">TWD</option>
				<option value="NZD">NZD</option>
				<option value="NOK">NOK</option>
				<option value="PHP">PHP</option>
				<option value="PLN">PLN</option>
				<option value="SGD">SGD</option>
				<option value="SEK">SEK</option>
				<option value="CHF">CHF</option>
				<option value="THB">THB</option>
				<option value="USD">USD</option>
			</select> <label for="currency">Currency</label>
			<div class="description">The currency is used throughout the site for properties and for PayPal payments.</div>
		</p>
		<p>
			<input type="text" name="emailpaypal" id="emailpaypal" value="<?php echo $row['email_paypal'];?>" size="35" /> <label for="emailpaypal">PayPal email</label>
			<div class="description">This email address is used for PayPal payments.</div>
		</p>
		<p>
			<input type="text" name="emailnotify" id="emailnotify" value="<?php echo $row['email_notify'];?>" size="35" /> <label for="emailnotify">Notification email</label>
			<div class="description">This email address is used for PayPal notification emails.</div>
		</p>

		<h2>Theme Settings</h2>
		<p>
			<select name="header_display" id="header_display">
				<option value="select_option">Select option</option>
				<option value="1"<?php if($row['header_display'] == '1') echo ' selected="selected"';?>>Yes</option>
				<option value="0"<?php if($row['header_display'] == '0') echo ' selected="selected"';?>>No</option>
				<option value="9"<?php if($row['header_display'] == '9') echo ' selected="selected"';?>>Show Google Maps</option>
			</select> <label for="header_display">Display header image?</label>
		</p>
		<p>
			<input type="text" name="header_image" id="header_image" value="<?php echo $row['header_image'];?>" size="35" /> <label for="header_image">Custom header image</label>
			<div class="description">If header image is active and you want to display a custom image, add the full path in the box above. The image will be automatically scaled to 970x266.</div>
		</p>

		<p><input type="submit" name="submit_edit" value="Update settings" /></p>
	</form>
<?php }?>
<?php include('inc.footer.php');?>
