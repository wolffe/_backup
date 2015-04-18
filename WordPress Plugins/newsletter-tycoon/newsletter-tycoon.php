<?php
/*
Plugin Name: Newsletter Tycoon
Version: 1.5.2
Plugin URI: http://getbutterfly.com/wordpress-plugins/newsletter-tycoon/
Description: A complete newsletter solution allowing webmasters to send HTML newsletters to subscribers containing the blog latest posts or a custom message.
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/

Copyright 2011, 2012, 2013 - Ciprian Popescu (email: getbutterfly@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//
define('TYCOON_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('TYCOON_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('NEWSLETTER_TYCOON_VERSION', '1.5.2');

// plugin localization
$plugin_dir = basename(dirname(__FILE__)); 
load_plugin_textdomain('tycoon', false, $plugin_dir . '/languages'); 
//

function tycoon_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', TYCOON_PLUGIN_URL . '/js/functions.js', array('jquery', 'media-upload', 'thickbox'));
	wp_enqueue_script('my-upload');
}
function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

// newsletter shortcode
function nt_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'pitch' => '',
		'button' => '',
	), $atts));

	// the_widget echoes the code instead of returning it, so I'll use output buffering
	$out = '';
	ob_start();
		the_widget('WP_Widget_Tycoon', 'title=' . $title . '&pitch=' . $pitch . '&button=' . $button . '');
		$out .= ob_get_contents();
	ob_end_clean();
	return $out;
}
add_shortcode('newsletter-tycoon', 'nt_shortcode');


class tycoonNewsletter {
	function tycoonNewsletter() {
		add_action('admin_menu', array('tycoonNewsletter', 'add_pages'));

		add_action('admin_print_scripts', 'tycoon_admin_scripts');
		add_action('admin_print_styles', 'my_admin_styles');

		register_activation_hook(__FILE__, array('tycoonNewsletter', 'install'));
		add_action('init', array('tycoonNewsletter', 'process_newsletterSub'));
		add_action('init', array('tycoonNewsletter', 'checkAutomaticNewsletter'));
		add_action('publish_post', array('tycoonNewsletter', 'checkEveryNewsletter'));
	}

	function checkEveryNewsletter() {
		$period = get_option('tycoon_period');

		if($period != 'every')
			return;

		$last = get_option('tycoon_last');
		$count = get_option('tycoon_count');

		$posts = tycoonNewsletter::getPostsSince('', $last);
		$postCount = count($posts);

		if($postCount >= $count) {
			$content = tycoonNewsletter::generateContent($posts,$count);
			tycoonNewsletter::sendNewsletter($content);
		}
	}

	// Get date based on a year and week date
	function getDateByWeek($wk_num, $yr, $first = 1, $format = 'Y-n-d') {
		$wk_num--;
		if($wk_num < 0 || !is_numeric($wk_num))
			$wk_num = 0;
		$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
		$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
		return date($format, $mon_ts);
	}

	// Add the needed leading zeros to create strings with a fixed size
	function NumberToString($number, $digits = 2) {
		$string = "$number";
		$length = strlen($string);
		while($length < $digits){
			$string = '0' . $string;
			$length ++;
		}
		return $string;
	}

	// Check if the newsletter should be sent
	function checkAutomaticNewsletter(){
		$period = get_option('tycoon_period');

		// we only want to check weekly and monthly newsletters
		if($period == 'manual' || $period == 'every')
			return;

		// check if we are on the blog homepage
		$checkString = $_SERVER['REQUEST_URI'];
		if(strstr(get_bloginfo('url').'/' , $checkString) === false)
			return;
		$last = get_option('tycoon_last');
		$count = get_option('tycoon_count');
		$sendFlag = false;
		$since = '';

		switch($period) { 
			case 'month':
				// see if a month since last submit has elapsed and if posts are available
				$lastMonth = mysql2date("n",$last) + 0;
				$thisMonth = date("n",mktime()) + 0;
				$lastYear = mysql2date("Y",$last) + 0;
				$thisYear = date("Y",mktime()) + 0;

				if($lastYear < $thisYear && $thisMonth == 1) {
					$since .= tycoonNewsletter::NumberToString($thisYear -1, 4);
					$since .= '-';
				}
				else
					$since .= tycoonNewsletter::NumberToString($thisYear, 4).'-';
				if($thisMonth == 1)
					$since .= "12-01";
				else
					$since .= (tycoonNewsletter::NumberToString($thisMonth - 1, 2))."-01";

				$to = $thisYear."-".tycoonNewsletter::NumberToString($thisMonth, 2)."-01";

				$posts = tycoonNewsletter::getPostsSince($to,$since);
				$postCount = count($posts);

				if(($lastYear < $thisYear || $lastMonth < $thisMonth) && $postCount > 0) {
					$content = tycoonNewsletter::generateContent($posts);
					tycoonNewsletter::sendNewsletter($content, mysql2date("Y-m-d H:i:s",$to));
				}
				break;
			case 'week':
				$lastWeek = mysql2date("W",$last) + 0;
				$thisWeek = date("W",mktime()) + 0;

				$lastYear = mysql2date("Y",$last) + 0;
				$thisYear = date("Y",mktime()) + 0;

				if($lastYear < $thisYear && $thisWeek == 1)
					$since = tycoonNewsletter::getDateByWeek($thisWeek - 1, $thisYear - 1);
				else
					$since = tycoonNewsletter::getDateByWeek($thisWeek - 1, $thisYear);

				$to = tycoonNewsletter::getDateByWeek($thisWeek, $thisYear);
				$posts = tycoonNewsletter::getPostsSince($to,$since);

				$postCount = count($posts);
				if(($lastYear < $thisYear || $lastWeek < $thisWeek) && $postCount > 0) {
					$content = tycoonNewsletter::generateContent($posts);
					tycoonNewsletter::sendNewsletter($content, mysql2date("Y-m-d H:i:s",$to));
				}
				break;
			default:
				break;
		}
	}

	function add_pages() {
		add_options_page('Newsletter Tycoon', 'Newsletter Tycoon', 'manage_options', __FILE__, array('tycoonNewsletter','newsletterConfig'));
	}

	function newsletterConfig(){
		include_once('backoffice.php');
	}

	/**
	 * Checks if a table already exists
	 *
	 * @param string $table - table name
	 * @return boolean True if the table already exists
	 **/
	function tableExists($table){
		global $wpdb;

		return strcasecmp($wpdb->get_var("show tables like '$table'"), $table) == 0;
	}
	
	/**
	 * Installation function, creates tables if needed and sets default values for settings
	 **/
	function install() {
		global $table_prefix, $wpdb;

		$table = $table_prefix . 'tycoon_members';

		if(!tycoonNewsletter::tableExists($table)) {
			$sql = "CREATE TABLE $table (
			id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			email varchar(100) NOT NULL,
			state ENUM('active', 'waiting') NOT NULL,
			joined datetime NOT NULL,
			user int(11) UNSIGNED,
			confkey varchar(100),
			UNIQUE KEY id (id)
			);";

			$wpdb->query($sql);

			$wpdb->query("ALTER TABLE $table ADD UNIQUE (`email`)");
		}
	  	add_option('tycoon_count', 5);
	  	add_option('tycoon_period', 'manual');
	  	add_option('tycoon_template', '<h2>{TITLE}</h2><br /><p><small>{DATE} - Posted by {AUTHOR}</small></p><br /><br /><p>{EXCERPT}</p><br /><p><small><a href="{URL}">{URL}</a></small></p>');
	  	add_option('tycoon_last', '1970-01-01 00:00:00');
	  	add_option('tycoon_last_letter', '1970-01-01 00:00:00');
	  	add_option('tycoon_header', '');
	  	add_option('tycoon_footer', '<p><small>This email was sent to you because you opted in on our website or a partner website.</small></p>');
	  	add_option('tycoon_subject', get_bloginfo() . ' - Newsletter');
	  	add_option('tycoon_from', get_bloginfo('admin_email'));
	  	add_option('tycoon_sender', '');

		add_option('tycoon_spp', 10);
		add_option('letterPostType', 'post');
		add_option('tycoon_go', 'Subscribe');
	}
	
	/**
	 * Subscribes the user to the newsletter
	 *
	 * @param string $email Email to subscribe the newsletter
	 * @return array An array with two values: 
	 * 	['result'] boolean with True is subscribed, false otherwise; 
	 * 	['message'] string with the success or error message.
	 */
	function subscribe($email) {
		$returnVal = array();

		$state = tycoonNewsletter::getSubscriptionState($email);
		// test if subscription already exists
		if($state != 'active') {
			if($state == '') { // new email
				// generate confkey
				$confKey = md5(uniqid(rand(), 1));
				if(tycoonNewsletter::sendConfEmail($email, $confKey)) {
					if(tycoonNewsletter::addMember($email, $confKey)) {
						$returnVal['result'] = true;
						$returnVal['message'] = __('A confirmation message has been sent to your email address.', 'tycoon');
						return $returnVal;
					}
				}

				$returnVal['result'] = false;
				$returnVal['message'] = __('An error occured. Please try again later.', 'tycoon');
				return $returnVal;
				
			}
			else { // existing subscriber but in an inactive state, we will resend the activation email
				if(tycoonNewsletter::resendConfEmail($email)){
					$returnVal['result'] = true;
					$returnVal['message'] = __('A confirmation was resent to your email.', 'tycoon');
				}
				else {
					$returnVal['result'] = false;
					$returnVal['message'] = __('An error occured. Please try again later.', 'tycoon');
				}
				return $returnVal;
			}
		}
		else { // active email requested a subscription
			$returnVal['result'] = false;
			$returnVal['message'] = __('The email is already subscribed.', 'tycoon');
			return $returnVal;
		}
	}
	
	/**
	 * Resends a subscription confirmation to a given email
	 * 
	 * @param string $email The destination email 
	 */
	function resendConfEmail($email){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";
		$email = addslashes( $email );
		$key = $wpdb->get_var("SELECT confkey FROM $table WHERE email = '$email'");
		return tycoonNewsletter::sendConfEmail($email, $key);
	}
	
	/**
	 * Gets the subscription state for the given email
	 * 
	 * @param string $email The destination email
	 * 
	 * @return string The state of the current subscription. 
	 * 	An empty string is sent if no subscription exists
	 */
	function getSubscriptionState($email){
		global $table_prefix, $wpdb;
		$table = $table_prefix.'tycoon_members';
		$email = addslashes($email);
		return $wpdb->get_var("SELECT state FROM $table WHERE email = '$email'");
	}
	
	/**
	 * Adds a subscriber to the newsletter table
	 * 
	 * @param string $email Email of the subscriber
	 * @param string $confKey Confirmation key
	 * @param string $status Status of the subscriber (waiting or active)
	 * 
	 * @return boolean True if added successfully, false otherwise
	 */
	function addMember($email,$confKey, $status="waiting"){
		global $table_prefix, $wpdb;
		
		$userid = tycoonNewsletter::getUser($email);
		
		/*plugin tables*/
		$table = $table_prefix . "tycoon_members";
		
		$query = "INSERT INTO $table (email,state,confkey,joined, user) ";
		$query .= "VALUES ('$email','$status','$confKey', NOW(), $userid);";
        $results = $wpdb->query( $query );
		return $results != '';
	}
	
	/**
	 * Gets the user based on email address or on its login
	 * 
	 * @param string $email Email of the subscriber
	 * 
	 * @return int Id of the user or Zero if no user is found
	 */
	function getUser($email){
		global $user_ID, $wpdb;;
		if(is_numeric($user_ID)){
			return $user_ID;
		}
		//not logged in, so we have to check if the email is already used by a user
		$query = "SELECT * FROM {$wpdb->users} WHERE user_email='$email';";
		$results = $wpdb->get_row( $query );
		if($results != "")
			return $results->ID;
		return 0;
	}
	
	/**
	 * Gets all member to the newsletter
	 * 
	 * @param string $status Status of the members (waiting or active). If empty all will be displayed
	 * @return boolean True if added successfully, false otherwise
	 */
	function getMemberCount($status=""){
		global $table_prefix, $wpdb;
		
		/*plugin tables*/
		$table = $table_prefix . "tycoon_members";
		$query = "SELECT Count(*) as Count FROM $table";
		if($status != ""){
			$query .= " WHERE state='$status'";
		}
		$query .= ";";
        $results = $wpdb->get_var( $query );
		return $results;
	}
	
	/**
	 * Gets all newsletter subscribers
	 * 
	 * @param string $status Status of the members (waiting or active). If empty all will be displayed
	 * 
	 * @return boolean True if added successfully, false otherwise
	 */
	function getMembers($status = '') {
		global $table_prefix, $wpdb;

		/*plugin tables*/
		$table = $table_prefix . "tycoon_members";
		$query = "SELECT * FROM $table";
		if($status != ""){
			$query .= " WHERE state='$status'";
		}
		$query .= ";";
        $results = $wpdb->get_results( $query );
		return $results;
	}

	/**
	 * Checks if a user is already a subscriber
	 * 
	 * @param string $email Email to test
	 * @param int $userID User identifier to test
	 * 
	 * @return boolean True the user already subscribed, false otherwise
	 */
	function isSubscriber($email="", $userID=null){
		global $table_prefix, $wpdb;
		
		
		if($email != "" && tycoonNewsletter::getSubscriptionState($email) != ""){
			return true;
		}
	
		if($userID == null || !is_numeric($userID))
			return false;
		
		/*plugin tables*/
		$table = $table_prefix . "tycoon_members";
		
		$query = "SELECT COUNT(*) FROM $table ";
		$query .= "WHERE user = $userID;";
        $result = $wpdb->get_var( $query );
		return $result > 0;
	}
	
	/**
	 * Tests if a confirmation key is valid
	 * 
	 * @param string $confKey Confirmation key
	 * 
	 * @return boolean True if the key is valid, false otherwise
	 */
	function isConfirmation($confKey){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";
		return $wpdb->get_var("SELECT id FROM $table WHERE confkey = '$confKey';") != "";
	}
	
	/**
	 * Gets subscription Id based on confirmation key
	 * 
	 * @param string $confKey Confirmation key
	 * 
	 * @return boolean True if the key is valid, false otherwise
	 */
	function getConfirmationId($confKey){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";
		return $wpdb->get_var("SELECT id FROM $table WHERE confkey = '$confKey';");
	}
	
	/**
	 * Gets subscription email based on confirmation key
	 * 
	 * @param string $id Id of the email
	 * 
	 * @return string Email address or empty string if it does not exist
	 */
	function getSubscriptionEmail($id){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";
		return $wpdb->get_var("SELECT email FROM $table WHERE id = '$id';");
	}
	
	/**
	 * Activates a subscriber
	 * 
	 * @param  int $id Subscriber identifier
	 * 
	 * @return boolean True on success, false otherwise
	 */
	function activateSubscriber($id){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";
		
		$query = "SELECT * FROM $table WHERE id='$id';";
		$result = $wpdb->get_row( $query );
		if($result != "" && $result->state == "waiting"){
			if(tycoonNewsletter::sendSubSuccess($result->email,$result->confkey)){
				$query = "UPDATE $table Set state = 'active' WHERE id='$id';";
				$results = $wpdb->query( $query );
				return $results == 1;
			}else{
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Removes a subscriber
	 * 
	 * @param  int $id Subscriber identifier
	 * 
	 * @return boolean True on success, false otherwise
	 */
	function removeSubscriber($id){
		global $table_prefix, $wpdb;
		$table = $table_prefix . "tycoon_members";

		$query = "DELETE FROM $table WHERE id='$id';";
		$results = $wpdb->query( $query );
		return true;
	}
	
	/**
	 * Updates settings in the database
	 * 
	 * @param array $settingsArray Contains the pairs array[key]=value for the plugin settings
	 */
	function saveSettings($settingsArray) {
		$keys = array_keys($settingsArray);
		foreach($keys as $key) {
			tycoonNewsletter::update_option("tycoon_".$key,$settingsArray[$key]);
		}
	}

	// Display the plugin administration page (3 functions)
	// Function 1: OVERVIEW
	function printSendDiv($manualLimit = 0) {
		$period 		= get_option('tycoon_period');
		$last 			= get_option('tycoon_last');
		$lastNewsLetter = get_option('tycoon_last_letter');
		?>
		<div class="wrap has-right-sidebar">
			<div class="icon32" id="icon-options-general"></div>
			<h2><strong>Newsletter</strong> Tycoon</h2>
			<div class="metabox-holder has-right-sidebar">
				<?php include('newsletter-sidebar.php');?>
				<div id="post-body">
					<div id="post-body-content">
						<h3><img src="<?php echo TYCOON_PLUGIN_URL;?>/images/ribbon-overview.png" alt="Campaign Overview" title="Campaign Overview" /></h3>
						<?php
						$date = mysql2date(get_option('date_format'), $lastNewsLetter);
						$time = mysql2date(get_option('time_format'), $lastNewsLetter);

						$year = mysql2date('Y', $lastNewsLetter);
						if($year != '1970') {
							if($last != $lastNewsLetter) {
								$postsBefore = ', with posts published before <b>';
								$postsBefore .= mysql2date(get_option('date_format'),$last). '</b> at <b>';
								$postsBefore .= mysql2date(get_option('time_format'), $last) .'</b>';
							}
							$lastMessage = '<p>The newsletter was last sent on '.$date.' at '.$time.' '.$postsBefore.'.</p>';
						} else {
								$lastMessage = '<p>The newsletter was never sent.</p>';
						}

						switch($period) {
							case 'every':
								$count = get_option('tycoon_count');
								$postText = '';

								$posts = tycoonNewsletter::getPostsSince('', $last);
								$numPosts = count($posts);

								$postText = tycoonNewsletter::getNumberText($count, 'post');
								$countText = tycoonNewsletter::getNumberText($numPosts, 'post');
								if($numPosts == 1)
									$countText = 'is <b>'.$countText.'</b>';
								else
									$countText = 'are <b>'.$countText.'</b>';

								echo '<p>This is done automatically every time a new post is published, if there are at least '.$postText.' in queue and an active subscriber.<br />Currently, there '.$countText.' in queue.</p>';
								echo $lastMessage;
								break;
							case 'manual':
								$posts = tycoonNewsletter::getPostsSince(); // ($to, $since)
								$numPosts = count($posts);

								$members = tycoonNewsletter::getMemberCount('active');

								$disable = 0;
								$disable = ($numPosts == 0 || $members== 0);

								// $postText = tycoonNewsletter::getNumberText($numPosts, 'post');
								$membersText = tycoonNewsletter::getNumberText($members, 'subscriber');
								?>
								<p><span class="description"><?php echo $lastMessage; ?></span></p>
								<?php
								if(is_string($manualLimit) || $manualLimit != 0)
									$sendValue = $manualLimit;
								else
									$sendValue = $numPosts;
								?>
								<form method="post" id="newsSend" name="newsSend">
									<p>
										Send the last <input<?php if($disable) echo ' disabled'; ?> type="number" name="postLimit" id="postLimit" value="<?php echo $sendValue; ?>" min="1" max="<?php echo $sendValue; ?>"> posts/pages/items 
										<input type="submit" name="send" value="Send Newsletter"<?php if($disable) echo ' disabled'; ?> class="button button-primary"> 
										to <?php echo $membersText; ?>
									</p>
								</form>
								<?php
								break;
							case 'month':
							case 'week':
								echo '<p>Sending a newsletter is done automatically every <strong>'.$period.'</strong> if at least one post was published since the last newsletter, a new user has subscribed, or a '.$period.' has ended.</p>';
								echo $lastMessage;
								break;
							default:
								break;
						}
	}

	// Function 1: CAMPAIGN SETTINGS
	function settings() {
		$spp 				= get_option('tycoon_spp');
		$letterPostType 	= get_option('tycoon_letterPostType');
		$count 				= get_option('tycoon_count');
		$period 			= get_option('tycoon_period');
		$header 			= get_option('tycoon_header');
		$template 			= get_option('tycoon_template');
		$footer 			= get_option('tycoon_footer');
		$subject 			= stripslashes(get_option('tycoon_subject'));
		$go 				= stripslashes(get_option('tycoon_go'));
		$from 				= stripslashes(get_option('tycoon_from'));
		$sender 			= stripslashes(get_option('tycoon_sender'));
		?>
		<script>
		function toggleState(value, elementId) {
			var element = document.getElementById(elementId);
			element.disabled = value;
			return true;
		}
		</script>
		<h3><img src="<?php echo TYCOON_PLUGIN_URL; ?>/images/ribbon-settings.png" alt="Campaign Settings" title="Campaign Settings" /></h3>
		<form id="settings" name="settings" method="post">
			<p>
				<strong>Newsletter send mode:</strong> 
				<input<?php if($period == 'manual') echo ' checked'; ?> type="radio" id="period_0" name="period" value="manual" onclick="toggleState(true, 'count');"><label for="period_0"> Manual</label> | 
				<input<?php if($period == 'week') 	echo ' checked'; ?> type="radio" id="period_1" name="period" value="week" onclick="toggleState(true, 'count');"><label for="period_1"> Weekly</label> | 
				<input<?php if($period == 'month') 	echo ' checked'; ?> type="radio" id="period_2" name="period" value="month" onclick="toggleState(true, 'count');"><label for="period_2"> Monthly</label> | 
				<input<?php if($period == 'every') 	echo ' checked'; ?> type="radio" id="period_3" name="period" value="every" onclick="toggleState(false, 'count');"><label for="period_3"> Every</label> 
				<input<?php if($period != 'every') 	echo ' disabled'; ?> type="number" name="count" id="count" value="<?php echo $count; ?>" min="1"><label for="count"> posts</label>
			</p>

			<table class="widefat">
				<tr>
					<td>
						<p><?php wp_editor($header, 'letterHeader', array('teeny' => true, 'textarea_rows' => 2, 'media_buttons' => false)); ?></p>
						<p><?php wp_editor($template, 'letterTemplate', array('teeny' => true, 'textarea_rows' => 12, 'media_buttons' => false)); ?></p>

						<p><?php wp_editor($footer, 'letterFooter', array('teeny' => true, 'textarea_rows' => 3, 'media_buttons' => false)); ?></p>
					</td>
					<td>
						<h4>Newsletter Details</h4>
						<p>
							<input type="number" name="spp" id="spp" value="<?php echo $spp; ?>" min="1" max="500"> <label for="spp">Subscribers per page</label><br />
							<span class="description">How many subscribers to show per page.</span>
						</p>
						<p>
							<select name="letterPostType" id="letterPostType">
								<?php
								$post_types = get_post_types('', 'names');
								$selectedLetterType = '';
								foreach($post_types as $post_type) {
									if($letterPostType == $post_type) $selectedLetterType = ' selected';
									echo '<option' . $selectedLetterType . '>' . $post_type . '</option>';
									$selectedLetterType = '';
								}
								?>
							</select> <label for="letterPostType">Content (post) type</label><br>
							<span class="description"><small>Don't touch this unless you have custom post types.</small></span>
						</p>
						<p>
							<input type="text" name="letterSender" id="letterSender" value="<?php echo $sender; ?>" size="30"> <label for="letterSender">Sender's Name</label><br />
							<span class="description">This email name appears in recipient's <strong>From</strong> field.</span>
						</p>
						<p>
							<input type="email" name="letterFrom" id="letterFrom" value="<?php echo $from; ?>" size="30"> <label for="letterFrom">From</label><br />
							<span class="description">This email address appears in recipient's <strong>From</strong> field.</span>
						</p>
						<p>
							<input type="text" name="letterSubject" id="letterSubject" value="<?php echo $subject; ?>" size="30"> <label for="letterSubject">Subject</label><br />
							<span class="description">This is the subject of your newsletter.</span>
						</p>
						<p>
							<input type="text" name="letterGo" id="letterGo" value="<?php echo $go; ?>" size="30"> <label for="letterGo">Button Label</label><br>
							<span class="description">This is the subscription form buton label.</span>
						</p>
						<hr>
						<h4>Newsletter Template</h4>
						<p>Use the boxes to the left to define a general header and footer template.</p>
						<p>Use the fullscreen mode of the editor to have a better view when composing the newsletter template or when writing a custom newsletter.</p>
						<p class="description">You can use the following tags to get the post information:</p>
						<p>
							<code>{TITLE}</code> - Post title<br>
							<code>{URL}</code> - Post URL (permalink)<br>
							<code>{DATE}</code> - Post date<br>
							<code>{TIME}</code> - Post time (hour and minute)<br>
							<code>{AUTHOR}</code> - Post author (uses display name)<br>
							<code>{EXCERPT}</code> - Post excerpt<br>
							<code>{CONTENT}</code> - Post content (full)
						</p>
						<p>Use <code>{UPTITLE}</code> instead of <code>{TITLE}</code> to display the post title in uppercase.</p>
						<p class="description">All messages are sent in HTML format with plain text fallback. <strong>Header</strong> and <strong>footer</strong> areas accept (X)HTML tags.</p>
					</td>
				</tr>
			</table>

			<hr />
			<p>
				<input name="submit" type="submit" value="Update" class="button-primary">
			</p>
		</form>
		<?php
	}

	// Function 1: SUBSCRIBERS LIST
	function manageMembers() {
		global $wpdb;
		$table = $wpdb->prefix . 'tycoon_members';
		?>
		<script>
		function DelConfirm(email) {
			var message= 'You are about to delete the subscription of "' + email + '", do you wish to continue?';
			return confirm(message);
		}
		function ActivateConfirm(email) {
			var message= 'You are about to activate the subscription of "' + email + '", do you wish to continue?';
			return confirm(message);
		}
		</script>
		<a name="tycoon_list"></a>
		<h3><img src="<?php echo TYCOON_PLUGIN_URL; ?>/images/ribbon-list.png" alt="Subscribers List" title="Subscribers List" /></h3>


		<?php
		if(isset($_POST['tycoon_csv_import'])) {
			$contents = file($_POST['tycoon_csv_file']);
			for($i=0; $i<sizeof($contents); $i++) {
				$no = $contents[$i];
				$wpdb->query("INSERT INTO $table (email, state, joined, user, confkey) values ($no)");
			}
		}

		// BEGIN PAGINATION HEAD
		$pr = get_option('tycoon_spp'); // rows per page
		$show = isset($_GET['show']) ? (int) $_GET['show'] : 1;

		$pages = mysql_num_rows(mysql_query("SELECT * FROM $table"));
		$numpages = $pages;
		$pages = ceil($pages / $pr);

		$querystring = '';
		foreach($_GET as $key => $value) {
			if($key != 'show') $querystring .= "$key=$value&amp;";
		}
		// END PAGINATION HEAD
		?>
		<div class="postbox">
			<h3>Import/Export Subscribers</h3>
			<div class="inside">
				<form method="post">
					<p>
						<input id="tycoon_csv_upload" name="tycoon_csv_upload" type="submit" value="Upload CSV File" class="button-secondary">
						<input id="tycoon_csv_file" name="tycoon_csv_file" type="text" size="24" placeholder="CSV File Path"> and 
						<input id="tycoon_csv_import" name="tycoon_csv_import" type="submit" value="Import Subscribers" class="button-secondary"> or 
						<a href="<?php echo TYCOON_PLUGIN_URL; ?>/newsletter-tycoon-subscribers.php" class="button-secondary">Export <b><?php echo $numpages; ?></b> Subscribers in CSV Format</a>
					</p>
				</form>
			</div>
		</div>
		<table class="widefat">
			<thead>
				<tr>
					<th>Subscriber E-mail</th>
					<th>Username</th>
					<th>Subscription Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$result = mysql_query("SELECT * FROM $table LIMIT ".(($show - 1) * $pr).', '.$pr);

			while($row = mysql_fetch_array($result)) {
				echo '<tr>';
					echo '<td>'.$row['email'].'</td>';
					echo '<td>';

						if($row['user'] != 0 && is_numeric($row['user'])) {
							$user = get_userdata($row['user']);
							echo $user->user_nicename;
						}
						else
							echo '(not registered)';
					echo '</td>';

					echo '<td>'.$row['joined'].'</td>';
					echo '<td>';
						if($row['state'] == 'waiting')
							echo '<a class="edit" href="'.$_SERVER['REQUEST_URI'].'&amp;actv='.$row['id'].'#msgMembers" onclick="return ActivateConfirm(\''.$row['email'].'\');">Activate</a>';
						else
							echo 'Active';
						echo ' | ';
						echo '<a class="delete" href="'.$_SERVER['REQUEST_URI'].'&amp;del='.$row['id'].'#msgMembers" onclick="return DelConfirm(\''.$row['email'].'\');">Delete</a>';
					echo '</td>';
				echo '</tr>';
			}
			?>
			</tbody>
		</table>
		<?php
		// BEGIN PAGINATION DISPLAY
		echo '
		<div class="tablenav">
			<div class="tablenav-pages">
				<span class="displaying-num">'.$numpages.' subscribers</span>
				<span class="pagination-links">
					';
					for($i = 1; $i <= $pages; $i++) {
						echo '<a '.($i == $show ? 'class="disabled" ' : ' ');
						echo 'href="?'.$querystring.'show='.$i;
						echo '#tycoon_list">'.$i.'</a> ';
					}
					echo '
				</span>
			</div>
		</div>';
		// END PAGINATION DISPLAY

		echo '</div><!-- #post-body-content -->
		</div><!-- #post-body -->
	</div><!-- .metabox-holder -->
</div>
';
	}

	function getNumberText($number, $word) {
		if($number == 1)
			return $number.' '.$word;
		else
			return $number.' '.$word.'s';
	}
	
	/**
	 * Get all posts in a given interval
	 * @param string $to The date and time to when we wish to get the posts. (Format: Y-m-d H:i:s)
	 * @param string $since The date and time from when we wish to get the posts. (Format: Y-m-d H:i:s) The default value is an empty string.
	 * @return array An array of posts
	 */
	function getPostsSince($to = '', $since = '') {
		global $table_prefix, $wpdb;

		$table = $table_prefix . 'tycoon_members';
		$results = array();

		if($since != '') $sinceString = "AND post_date >= '$since'";
		else $sinceString = '';
		if($to != '') $toString = "AND post_date < '$to'";
		else $toString = '';

		$query = "SELECT * FROM {$wpdb->posts} WHERE post_type='" . get_option('tycoon_letterPostType') . "' AND post_status='publish' $sinceString $toString ORDER BY post_date DESC;";

		/*
		$query = "SELECT * FROM {$wpdb->posts} p
LEFT OUTER JOIN {$wpdb->term_relationships} r ON r.object_id = p.ID
LEFT OUTER JOIN {$wpdb->term_taxonomy} x ON x.term_taxonomy_id = r.term_taxonomy_id
LEFT OUTER JOIN {$wpdb->terms} t ON t.term_id = x.term_id
WHERE p.post_status = 'publish'
AND p.post_type = '" . get_option('tycoon_letterPostType') . "'
AND t.slug = 'news'";
		*/

		$results = $wpdb->get_results($query);
		return $results;
	}
	
	/**
	 * Generates the post excerpt if it does not caontain one already
	 * //copied from wordpress core
	 * 
	 * @param object $post The post object
	 * @return string The post excerpt
	 */
	function generateExcerpt($post) {
		$text = $post->post_excerpt;
		if ( '' == $text ) {//No excerpt available so we need to fake it
			$text = $post->post_content;
			$text = str_replace(']]>', ']]&gt;', $text);
			$text = strip_tags($text);
			$excerpt_length = 55;
			$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words) > $excerpt_length) {
				array_pop($words);
				array_push($words, '[...]');
				$text = implode(' ', $words);
			}
		}
		return $text;
	}
	
	
	/**
	 * Generates the newsletter content based on the available posts and the template
	 * @param array $posts An array of posts to be added to the newsletter body
	 * @param int $limit The maximum number of posts to send
	 * @return string The newsletter content formated accordingly to the template
	 */
	function generateContent($posts, $limit = 0) {
		$string = '';
		$template = get_option('tycoon_template');
		$postCount = 0;
		foreach($posts as $post) {
			$postContent = $template;
			$excerpt = tycoonNewsletter::generateExcerpt($post);
			$date = mysql2date(get_option('date_format'), $post->post_date);
			$time = mysql2date(get_option('time_format'), $post->post_date);
			$title = $post->post_title;
			$url = get_permalink($post->ID);
			$author = get_userdata($post->post_author)->display_name; // user_login
			query_posts('p=' . $post->ID);
			while(have_posts()) : the_post();
				remove_shortcode('caption');
				$content = get_the_content(); // $post->post_content;
				// remove the caption shortcode
				$content = strip_shortcodes($content);
				$content = preg_replace("/\[caption.*\[\/caption\]/", '', $content);
				$content = str_replace("[/caption]", '', $content);
			endwhile;

			// replace the template tags with real content
			$postContent = str_replace('{EXCERPT}', $excerpt, $postContent);
			$postContent = str_replace('{CONTENT}', $content, $postContent);
			$postContent = str_replace('{AUTHOR}', $author, $postContent);
			$postContent = str_replace('{URL}', $url, $postContent);
			$postContent = str_replace('{TITLE}', $title, $postContent);
			$postContent = str_replace('{UPTITLE}', strtoupper($title), $postContent);
			$postContent = str_replace('{DATE}',$date, $postContent);
			$postContent = str_replace('{TIME}', $time, $postContent);

			$postContent .= "\n";
			$string .= $postContent;

			$postCount++;
			if($limit > 0 && $postCount >= $limit)
				break;
		}
		return $string;
	}

	/**
	 * Sends an email
	 * 
	 * @return bool True if the email was send, false otherwise
	 */
	function sendEmail($from, $to, $subject, $content) {
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html;charset=' . get_option('blog_charset') . "\r\n";
		$headers .= 'From: ' . get_option('tycoon_sender') . ' <' . $from . '>' . "\r\n";

		@$value = mail($to, $subject, $content, $headers);
		return $value;
	}

	/**
	 * Send the newsletter to all subscribers
	 * @param string $content The content to be send in the newsletter
	 * @param string $date The date to overwrite the last newsletter date (optional)
	 * 
	 * @return bool true if all emails were sent, false if an error occured.
	 */
	function sendNewsletter($content, $date = '') {
		$members = tycoonNewsletter::getMembers('active');
		
		$header 	= get_option('tycoon_header');
		$footer 	= get_option('tycoon_footer');
		$subject 	= get_option('tycoon_subject');
		$go 		= get_option('tycoon_go');
		$from 		= get_option('tycoon_from');
		$sender 	= get_option('tycoon_sender');
		
		$sent = false;
		foreach($members as $member){
			$to = $member->email;
			$confirmationURL = TYCOON_PLUGIN_URL . '/confirmation.php?del=' . $member->confkey;

			// compose email message
			$message = '';
			$message .= $header;

			// add compressed WordPress core styles for image alignment and caption rendering
			$message .= '
			<style type="text/css">
			/* =WordPress Core
			-------------------------------------------------------------- */
			.alignnone { margin: 5px 20px 20px 0; }
			.aligncenter, div.aligncenter { display: block; margin: 5px auto 5px auto; }
			.alignright { float: right; margin: 5px 0 20px 20px; }
			.alignleft { float: left; margin: 5px 20px 20px 0; }
			.aligncenter { display: block; margin: 5px auto 5px auto; }

			a img.alignright { float: right; margin: 5px 0 20px 20px; }
			a img.alignnone { margin: 5px 20px 20px 0; }
			a img.alignleft { float: left; margin: 5px 20px 20px 0; }
			a img.aligncenter { display: block; margin-left: auto; margin-right: auto; }

			.wp-caption { background: #ffffff; border: 1px solid #f0f0f0; max-width: 96%; padding: 5px 3px 10px; text-align: center; }
			.wp-caption.alignnone { margin: 5px 20px 20px 0; }
			.wp-caption.alignleft { margin: 5px 20px 20px 0; }
			.wp-caption.alignright { margin: 5px 0 20px 20px; }
			.wp-caption img { border: 0 none; height: auto; margin: 0; max-width: 98.5%; padding: 0; width: auto; }
			.wp-caption p.wp-caption-text { font-size: 11px; line-height: 17px; margin: 0; padding: 0 4px 5px; }
			</style>';

			$message .= wpautop($content);
			$message .= $footer;
			$message .= '<p>--</p>';
			$message .= '<p>If you no longer wish to receive this newsletter, use the following link to unsubscribe:</p>';
			$message .= '<p>' . $confirmationURL . '</p>';

			if(!tycoonNewsletter::sendEmail($from, $to, $subject, $message)) {
				return false;
			}
			$sent = true;
		}

		// we set the new date for the last newsletter
		if($sent) {
			$now = mktime();
			$now++;

			//last post date
			if($date != '')
				update_option('tycoon_last', $date);
			else
				update_option('tycoon_last', date('Y-m-d H:i:s', $now));

			// last newsletter date
			update_option('tycoon_last_letter', date('Y-m-d H:i:s', $now));
		}

		return true;
	}

	/**
	 * Sends a confirmation email to the subscriber
	 * 
	 * @param string $email Email of the subscriber
	 * @param string $confKey Confirmation key
	 * 
	 * @return bool True if the confirmation was sent, false otherwise
	 */
	function sendConfEmail($email, $confKey){
		$from = get_option("tycoon_from");
		$subject = "[Confirm] " .get_option("tycoon_subject");
		$title = get_bloginfo("name");
		//$url = get_bloginfo("wpurl");
		
		$confirmationURL = TYCOON_PLUGIN_URL."/confirmation.php?add=$confKey";
		
		$message = '';
		$message .= '<p>You have requested to subscribe the newsletter from <strong>'.$title.'</strong> at:</p><p>'.$url.'</p>';
		$message .= '<p>In order to confirm your request click on the following link:</p>';
		$message .= '<p><a href="'.$confirmationURL.'">'.$confirmationURL.'</a></p>';
		$message .= '<p>If you do not wish to receive this newsletter, please ignore this email.</p>';
		
		//$message = wordwrap($message, 75, "\n");
		
		return tycoonNewsletter::sendEmail($from,$email,$subject,$message);
	}
	
/**
	 * Sends a subscription success email
	 * 
	 * @param string $email Email of the subscriber
	 * 
	 * @return bool True if the confirmation was sent, false otherwise
	 */
	function sendSubSuccess($email,$key){
		$from = get_option('tycoon_from');
		$subject = '[' . __('Confirmation', 'tycoon') . '] ' . get_option('tycoon_subject');
		$title = get_bloginfo('name');
		$url = get_bloginfo('wpurl');
		
		$confirmationURL = TYCOON_PLUGIN_URL . "/confirmation.php?del=$key";
		
		$message .= '<p>You have successfully subscribed the newsletter from <strong>'.$title.'</strong> at:</p><p>'.$url.'</p>';

		$message .= '<p>If you no longer wish to receive this newsletter, use the following link to unsubscribe:</p>';
		$message .= '</p><a href="' . $confirmationURL . '">'.$confirmationURL.'</a></p>';
		
		return tycoonNewsletter::sendEmail($from, $email, $subject, $message);
	}
	
	/**
	 * Writes the success/error messages
	 * 
	 * @param string $string - message to be displayed
	 * @param boolean $success - boolean that defines if is a success(true) or error(false) message
	 **/
	function printMessage($string, $success=true, $anchor = "message"){
		if($success){
			echo '<div id="'.$anchor.'" class="updated fade"><p>'.$string.'</p></div>';
	 	}else{
	 		echo '<div id="'.$anchor.'" class="error fade"><p>'.$string.'</p></div>';
	 	}
	}
	
	/**
	 * Writes the success/error messages in the front-office
	 * 
	 * @param string $string - message to be displayed
	 * @param boolean $success - boolean that defines if is a success(true) or error(false) message
	 **/     
	function printMessageFO($string, $success=true){
		if($success){
	 		echo '<div class="success">'.$string.'</div>';
	 	}else{
	 		echo '<div class="error">'.$string.'</div>';
	 	}
	}
	
	/**
	 * From wordpress core with some changes to avoid trimming the content
	 */
	function update_option($option_name, $newvalue) {
		global $wpdb;

		// If the new and old values are the same, no need to update.
		$oldvalue = get_option($option_name);
		if($newvalue == $oldvalue)
			return false;

		wp_cache_set($option_name, $newvalue, 'options');

		if(false === $oldvalue) {
			$wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES ('$option_name', '$newvalue', 'yes')");
			return true;
		}
		else {
			$wpdb->query("UPDATE $wpdb->options SET option_value = '$newvalue' WHERE option_name = '$option_name'");
			if($wpdb->rows_affected == 1) {
				do_action("update_option_{$option_name}", $oldvalue, $newvalue);
				return true;
			}
		}
		return false;
	}

	// Display the subscription form with the required includes and containers
	function newsletterForm($labelGo) {
		global $user_ID;
		$email = '';
		if(is_numeric($user_ID)) {
			$user = get_userdata($user_ID);
			$email = $user->user_email;

			// check if the user already subscribed
			if(tycoonNewsletter::isSubscriber($email, $user_ID))
				$email = '';
		}

		$action = $_SERVER['REQUEST_URI'];
		echo '<script src="' . get_bloginfo('wpurl') . '/wp-includes/js/tw-sack.js"></script>';
		?>

		<script src="<?php echo TYCOON_PLUGIN_URL; ?>/js/tycoon_ajax.js"></script>

		<div class="newsletterContainer" id="tycoonNewsletter">
			<?php tycoonNewsletter::subscriptionForm($email, $labelGo); ?>
		</div>
		<div style="display:none" id="newsletterLoading"><img src="<?php echo TYCOON_PLUGIN_URL; ?>/images/loading.gif" alt=""> <?php echo __('Loading...', 'tycoon'); ?></div>
		<?php
	}
	
	// Display only the from for newsletter subscription (auxiliary method, do not use in the template)
	function subscriptionForm($email = '') {
		$action = get_bloginfo('url');
		?>
		<form action="javascript:StartFade('<?php echo $action; ?>', 'tycoonNewsletter', 'newsletterLoading');" name="newsletterForm" id="newsletterForm" method="post">
			<div id="newsletterFormDiv">
				<input class="newsletterTextInput" type="email" name="email" required>
				<input type="hidden" id="newsletter" name="newsletter" value="true">
				<input class="submit" type="submit" name="newsletterSub" value="<?php echo get_option('tycoon_go'); ?>">
			</div>
		</form>
		<?php
	}
	
	/**
	 * Handles Ajax requests for new subscriptions
	 */
	function process_newsletterSub() {
		global $wpdb, $user_identity, $user_ID;
		
		if(empty($_REQUEST['newsletter'])) {
			//It is not a subscription request so we let it be
			return;
		}
		
		$email = $_REQUEST['email'];
		//has the user entered an email ?
		if(!empty($email)) {
			
			// Check For Bot
			$bots_useragent = array('googlebot', 'google', 'msnbot', 'ia_archiver', 'lycos', 'jeeves', 'scooter', 'fast-webcrawler', 'slurp@inktomi', 'turnitinbot', 'technorati', 'yahoo', 'findexa', 'findlinks', 'gaisbo', 'zyborg', 'surveybot', 'bloglines', 'blogsearch', 'ubsub', 'syndic8', 'userland', 'gigabot', 'become.com');
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			foreach ($bots_useragent as $bot) { 
				if (stristr($useragent, $bot) !== false) {
					//goodbye bot
					return;
				} 
			}
			
			$message = "";
			$result = 0;
			$value = tycoonNewsletter::subscribe($email);
			
			tycoonNewsletter::printMessageFO($value['message'], $value['result']);
			if(!$value['result'])
				tycoonNewsletter::subscriptionForm($email);
			else
				tycoonNewsletter::subscriptionForm();
			
			exit();//prevent further processing from wordpress
		}
		tycoonNewsletter::printMessageFO("Please provide an email address.", false);
		tycoonNewsletter::subscriptionForm();
		exit();//prevent further processing from wordpress
	}
	
	/**
	 * Prints the confirmation page with the supplied content
	 */
	function writeConfirmationPage($content){
?><!DOCTYPE HTML>
<html>
<head>
<title>Newsletter</title>
<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl');?>/wp-admin/wp-admin.css" type="text/css" />
<style type="text/css">
#info h1 { text-align: center; }

.errorTitle { margin: 10px 0; background-color: #FFEFF7; border: 1px solid #cc6699; padding: .5em; }

.success { margin: 10px 0; background-color: #CFEBF7; border: 1px solid #2580B2; padding: .5em; }
#info { background-color: #ffffff; border: 1px solid #a2a2a2; margin: 5em auto; padding: 2em; width: 80%; min-width: 35em; }
#info ul { list-style: disc; margin: 0; padding: 0; }
#info ul li { display: list-item; margin-left: 1.4em; text-align: left; }

#inlineList ul { list-style: none; margin: 0; padding: 0; }
#inlineList ul li { display: inline; margin-right: 1.4em; margin-left: 0; text-align: center; }
</style>
</head>
<body>
<div id="info">
	<?php echo $content; ?><br /><br />
	<div id="inlineList">
		<ul>
			<li><a href="<?php bloginfo('home'); ?>">&laquo; <?php _e('Go to', 'tycoon'); ?> <?php echo get_bloginfo('name'); ?></a></li>
		</ul>
	</div>
</div>
</body>
</html><?php
	}
}
//instance of the newsletter to run the constructor
$newsletter = new tycoonNewsletter();

// subscription widget
class WP_Widget_Tycoon extends WP_Widget {
	function WP_Widget_Tycoon() {
		$widget_ops = array('classname' => 'widget_Tycoon', 'description' => __('Display a subscription box for your newsletter'));
		$this->WP_Widget('Newsletter', __('Newsletter', 'tycoon'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		if(!empty($instance['title'])) { 
			echo $before_title.$instance['title'].$after_title; 
		}
		echo '<p>' . $instance['pitch'] . '</p>';
		tycoonNewsletter::newsletterForm($instance['button']);
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	function form($instance) {		
		echo '<div id="tycoon-admin-panel">';
			echo '<p>';
				echo '<label for="'.$this->get_field_id('title').'">Widget Title </label>';
				echo '<input type="text" name="'.$this->get_field_name('title').'" id="'.$this->get_field_id('title').'" value="'.$instance['title'].'">';
			echo '</p>';
			echo '<p>';
				echo '<label for="'.$this->get_field_id('pitch').'">Widget Text </label>';
				echo '<input type="text" name="'.$this->get_field_name('pitch').'" id="'.$this->get_field_id('pitch').'" value="'.$instance['pitch'].'">';
			echo '</p>';
			echo '<p>This widget will display the newsletter subscription box along with a descriptive text.</p>';
			echo '<p><small><strong>Example text:</strong> &quot;If you want to know about future events, updates and releases, leave your email address below to receive our newsletter.&quot;</small></p>';
		echo '</div>';
	}
}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Tycoon");'));
?>
