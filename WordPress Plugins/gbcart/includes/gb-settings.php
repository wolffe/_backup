<?php
function gbcart_admin_page() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>GBCart Settings</h2>

		<?php
		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings_tab';
		if(isset($_GET['tab']))
			$active_tab = $_GET['tab'];
		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=gbcart_admin_page&amp;tab=settings_tab" class="nav-tab <?php echo $active_tab == 'settings_tab' ? 'nav-tab-active' : ''; ?>">Settings</a>
			<a href="?page=gbcart_admin_page&amp;tab=email_tab" class="nav-tab <?php echo $active_tab == 'email_tab' ? 'nav-tab-active' : ''; ?>">Email</a>
		</h2>
		<br>

		<?php if($active_tab == 'settings_tab') { ?>
			<?php
			if(isset($_POST['isGSSubmit'])) {
				update_option('gbcart_styling', $_POST['gbcart_styling']);
				update_option('gbcart_currency', $_POST['gbcart_currency']);
				update_option('gbc_rc_public', $_POST['gbc_rc_public']);
				update_option('gbc_rc_private', $_POST['gbc_rc_private']);
				update_option('gbc_page_id', $_POST['gbc_page_id']);

				echo '<div class="updated"><p>Settings updated successfully!</p></div>';
			}
			?>
			<div id="poststuff" class="ui-sortable meta-box-sortables">
				<div class="postbox">
					<h3>Display Settings</h3>
					<div class="inside">
						<form method="post" action="">
							<p>
								<select name="gbcart_styling" id="gbcart_styling">
									<option value="0"<?php if(get_option('gbcart_styling') == '0') echo ' selected="selected"'; ?>>Table (default)</option>
									<!--
									<option value="1"<?php if(get_option('gbcart_styling') == '1') echo ' selected="selected"'; ?>>Grid</option>
									<option value="1"<?php if(get_option('gbcart_styling') == '2') echo ' selected="selected"'; ?>>Plain (no styling)</option>
									-->
								</select>
								<label for="gbcart_styling">Cart Styling</label>
								<br><small>How to render the products in cart</small>
							</p>
							<p>
								<input type="text" name="gbcart_currency" id="gbcart_currency" class="regular-text" value="<?php echo get_option('gbcart_currency'); ?>">
								<label for="gbcart_currency">Display Currency</label>
								<br><small>The currency code or symbol will be displayed next to item price (use $, &euro;, USD, GBP and so on)</small>
							</p>
							<p>
								<?php
								$args = array('name' => 'gbc_page_id', 'selected' => get_option('gbc_page_id'));
								wp_dropdown_pages($args);
								?> 
								<label for="page_id">Search Page</label>
								<br><small>Select the search page (the one with the <code>[gbsearch]</code> inside)</small>
							</p>
							<p>
								<input name="gbc_rc_public" id="gbc_rc_public" type="text" size="48" value="<?php echo get_option('gbc_rc_public'); ?>"> <label for="gbc_rc_public">reCAPTCHA&trade; Public Key</label><br>
								<br>
								<input name="gbc_rc_private" id="gbc_rc_private" type="text" size="48" value="<?php echo get_option('gbc_rc_private'); ?>"> <label for="gbc_rc_private">reCAPTCHA&trade; Private Key</label>
								<br><small>Get a key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="external">https://www.google.com/recaptcha/admin/create</a>.</small>
							</p>

							<p>
								<input type="submit" name="isGSSubmit" value="Save Changes" class="button-primary">
							</p>
						</form>
					</div>
				</div>

				<h2>GBCart Description</h2>
				<p>Place one of the existing shortcodes in your post or page. Check the Dashboard page for all possible shortcode combinations.</p>
				<p><em>You are using <b>GBCart</b> version <b><?php echo GBC_PLUGIN_VERSION; ?></b>.</em></p>

				<p>For more information and updates, visit the <a href="http://getbutterfly.com/wordpress-plugins/gbcart/" rel="external">official web site</a></p>
			</div>
		<?php } ?>
		<?php if($active_tab == 'email_tab') { ?>
			<?php
			if(isset($_POST['isGSSubmit'])) {
				update_option('gbcart_notification_email', $_POST['gbcart_notification_email']);

				echo '<div class="updated"><p>Settings updated successfully!</p></div>';
			}
			?>
			<div id="poststuff" class="ui-sortable meta-box-sortables">
				<div class="postbox">
					<h3>Email Settings</h3>
					<div class="inside">
						<form method="post" action="">
							<p>
								<input type="text" name="gbcart_notification_email" id="gbcart_notification_email" value="<?php echo get_option('gbcart_notification_email'); ?>" class="regular-text">
								<label for="gbcart_notification_email">Administrator email (used for new order notification)</label>
								<br><small>The administrator will receive an email notification each time a new order is submitted</small>
								<br><small>Separate multiple addresses with comma</small>
							</p>
							<p>
								<input type="submit" name="isGSSubmit" value="Save Changes" class="button-primary">
							</p>
						</form>
					</div>
				</div>

				<h2>GBCart Description</h2>
				<p>Place one of the existing shortcodes in your post or page. Check the Dashboard page for all possible shortcode combinations.</p>
				<p><em>You are using <b>GBCart</b> version <b><?php echo GBC_PLUGIN_VERSION; ?></b>.</em></p>

				<p>For more information and updates, visit the <a href="http://getbutterfly.com/wordpress-plugins/gbcart/" rel="external">official web site</a></p>
			</div>
		<?php } ?>
	</div>	
	<?php
}
?>
