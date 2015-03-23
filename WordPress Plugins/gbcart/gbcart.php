<?php
/*
Plugin Name: GBCart
Plugin URI: http://getbutterfly.com/wordpress-plugins/gbcart/
Description: <strong>GBCart</strong> is a mail order shopping cart. No payment gateways are available, instead the order goes straight to administrator's email. It can also be used as an inquiry form for items or products.
Author: Ciprian Popescu
Version: 1.5.2
Author URI: http://getbutterfly.com/

GBCart
Copyright (C) 2013, 2014 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

session_start();

//
define('GBC_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('GBC_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('GBC_PLUGIN_VERSION', '1.5.2');
//

// plugin localization
$plugin_dir = basename(dirname(__FILE__)); 
load_plugin_textdomain('gbcart', false, $plugin_dir . '/languages'); 

include('pagination.class.php');

function gbc_styles() {
	wp_enqueue_style('gbc-styles', GBC_PLUGIN_URL . '/css/style.css');
}

function gbc_admin_style() {
    wp_register_style('gbc_admin_css', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '4.0.3');
    wp_enqueue_style('gbc_admin_css');
}
add_action('admin_enqueue_scripts', 'gbc_admin_style');

include(GBC_PLUGIN_PATH . '/includes/gb-dashboard.php');
include(GBC_PLUGIN_PATH . '/includes/gb-settings.php');
include(GBC_PLUGIN_PATH . '/includes/gb-orders.php');

function gbcart_menu() {
	add_menu_page('GBCart', 'GBCart', 'manage_options', __FILE__, 'gbcart_dashboard_page', GBC_PLUGIN_URL . '/images/icon-16.png');

	add_submenu_page(__FILE__, 'GBCart Settings', 'GBCart Settings', 'manage_options', 'gbcart_admin_page', 'gbcart_admin_page'); 
	add_submenu_page(__FILE__, 'GBCart Orders', 'GBCart Orders', 'manage_options', 'gbcart_orders_page', 'gbcart_orders_page'); 
}

function gbc_enqueue_scripts($hook_suffix) {
	wp_register_style('gbc-ui-style', plugins_url('css/easyui.css', __FILE__));
	wp_enqueue_style('gbc-ui-style');
	wp_register_style('gbc-icon-style', plugins_url('css/icon.css', __FILE__));
	wp_enqueue_style('gbc-icon-style');

	wp_enqueue_script('gbc-scripts', plugins_url('js/jquery.easyui.min.js', __FILE__), array('jquery'), false, true);
}


add_action('admin_menu', 'gbcart_menu'); // settings menu
add_action('wp_print_styles', 'gbc_styles'); // frontend styles
add_action('admin_enqueue_scripts', 'gbc_enqueue_scripts'); // backend scripts and styles
add_action('wp_head', 'gbc_js'); // frontend inline javascript

add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

// plugin localization
load_plugin_textdomain('gbcart', false, dirname(plugin_basename(__FILE__)) . '/languages/');

function gbcart_admin_activate() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'gb_cart';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
//		$wpdb->query(""); // query should be inside
		$sql = "CREATE TABLE " . $table_name . " (
			`cartId` int(11) NOT NULL AUTO_INCREMENT,
			`sessionId` text,
			`itemId` int(11) DEFAULT NULL,
			`qty` int(11) DEFAULT NULL,
			UNIQUE KEY `cartId` (`cartId`)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	$table_name = $wpdb->prefix . 'gb_items';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
//		$wpdb->query(""); // query should be inside
		$sql = "CREATE TABLE " . $table_name . " (
			`itemId` int(11) NOT NULL AUTO_INCREMENT,
			`itemName` text,
			`itemDesc` text,
			`itemPrice` decimal(65,2) DEFAULT NULL,
			`itemDiscount` int(11) NOT NULL DEFAULT '0',
			`itemCategory` text,
			UNIQUE KEY `id` (`itemId`)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	$table_name = $wpdb->prefix . 'gb_orders';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
//		$wpdb->query(""); // query should be inside
		$sql = "CREATE TABLE " . $table_name . " (
			`orderID` int(11) NOT NULL AUTO_INCREMENT,
			`orderName` text COLLATE latin1_general_ci NOT NULL,
			`orderLastName` text COLLATE latin1_general_ci NOT NULL,
			`orderCompany` text COLLATE latin1_general_ci NOT NULL,
			`orderLocation` text COLLATE latin1_general_ci NOT NULL,
			`orderEmail` text COLLATE latin1_general_ci NOT NULL,
			`orderPhone` text COLLATE latin1_general_ci NOT NULL,
			`orderAddress1` text COLLATE latin1_general_ci NOT NULL,
			`orderAddress2` text COLLATE latin1_general_ci NOT NULL,
			`orderComments` text COLLATE latin1_general_ci NOT NULL,
			`orderCart` text COLLATE latin1_general_ci NOT NULL,
			`orderDate` datetime NOT NULL,
			UNIQUE KEY `orderID` (`orderID`)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	add_option('gbcart_notification_email', '');
	add_option('gbcart_currency', 'EUR');
	add_option('gbcart_styling', 'table');
	add_option('gbc_rc_public', '');
	add_option('gbc_rc_private', '');
	add_option('gbc_page_id', '');
}
register_activation_hook(__FILE__, 'gbcart_admin_activate');

function gbc_js() {
	$display = '
	<script>
	function updateArchive(id) {
		jQuery.ajax({
			type: "POST",
			url: "' . GBC_PLUGIN_URL . '/includes/gb-order.php",
			data: { "gbID": id },
			success: function(data){
				alert("' . __('Item added successfully!', 'gbcart') . '");
			},
			error: function(data){ 
				alert("' . __('This item already exists!', 'gbcart') . '");
			},
		});
	}
	function deleteArchive(id) {
		jQuery.ajax({
			type: "POST",
			url: "' . GBC_PLUGIN_URL . '/includes/gb-remove.php",
			data: { "gbID": id },
			success: function(data){
				jQuery(".gbRow" + id).fadeOut("fast");
			},
			error: function(data){ 
				alert("' . __('Unable to remove item!', 'gbcart') . '");
			},
		});
	}
	</script>';
	echo $display;
}

// main cart list function
function gb_cart_list($atts) {
	extract(shortcode_atts(array(
		'text' => '',
		'category' => '',
	), $atts));

	global $wpdb;
	$id_session = session_id();

	if(!(isset($_GET['pagenum'])))
		$pagenum = 1;
	else
		$pagenum = mysql_real_escape_string($_GET['pagenum']);

	if(!empty($category))
		$data = mysql_query("SELECT * FROM " . $wpdb->prefix . "gb_items WHERE itemCategory = '$category'");
	else
		$data = mysql_query("SELECT * FROM " . $wpdb->prefix . "gb_items");
	$rows = mysql_num_rows($data); 
	$page_rows = 20; 
	$last = ceil($rows/$page_rows); 

	if($pagenum < 1) 
		$pagenum = 1; 
	elseif($pagenum > $last) 
		$pagenum = $last; 

	$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

	if(!empty($category))
		$query = "SELECT * FROM " . $wpdb->prefix . "gb_items WHERE itemCategory = '$category' $max";
	else
		$query = "SELECT * FROM " . $wpdb->prefix . "gb_items $max";
	$result = mysql_query($query);

	$display = '';

	$pageURL = get_permalink();
	$cartResult = mysql_query("SELECT * FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "'");
	$cartRows = mysql_num_rows($cartResult); 

	$display .= '<table class="gb-products zebra bordered">';
	$display .= '<thead><tr><th>' . __('Item Name', 'gbcart') . '</th><th>' . __('Item Description', 'gbcart') . '</th><th>' . __('Item Price', 'gbcart') . '</th><th></th></tr></thead><tbody>';

	while($row = mysql_fetch_array($result)) {
		$display .= '<tr>';
			$display .= '
			<td>' . $row['itemName'] . '</td>
			<td>' . $row['itemDesc'] . '</td>
			<td>' . get_option('gbcart_currency') . $row['itemPrice'] . '</td>
			<td><a href="#" class="gb-button" onclick="updateArchive(' . $row['itemId'] . '); return false;">' . __('Add to cart', 'gbcart') . '</a></td>';
		$display .= '</tr>';
	}
	$display .= '</tbody></table>';

	$display .= '<p><small>' . __('Page', 'gbcart') . ' <b>' . $pagenum . '</b> ' . __('of', 'gbcart') . ' <b>' . $last . '</b></small></p>';

	$display .= '<p>';
		$pages = new Paginator;
		$pages->items_total = $rows;
		$pages->mid_range = 10;
		$pages->current_page = $pagenum;
		$pages->default_ipp = $page_rows;
		$pages->url_next = $pageURL . '?pagenum=';
		$pages->paginate();
		$display .= $pages->display_pages();
	$display .= '</p>';

	return $display;
}

// main search function
function gb_search_list($atts) {
	extract(shortcode_atts(array(
		'text' => '',
	), $atts));

	global $wpdb;
	$id_session = session_id();

	if(!(isset($_GET['pagenum'])))
		$pagenum = 1;
	else
		$pagenum = mysql_real_escape_string($_GET['pagenum']);

	$display = '';
	$pageURL = get_permalink();

	if(isset($_POST['isSearch'])) {
		$type = $_POST['type'];

		$data = mysql_query("SELECT * FROM " . $wpdb->prefix . "gb_items WHERE itemName LIKE '%$type%' OR itemDesc LIKE '%$type%'");
		$rows = mysql_num_rows($data); 
		$page_rows = 20; 
		$last = ceil($rows/$page_rows); 

		if($pagenum < 1) 
			$pagenum = 1; 
		elseif($pagenum > $last) 
			$pagenum = $last; 

		$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

		$searchResult = mysql_query("SELECT * FROM " . $wpdb->prefix . "gb_items WHERE itemName LIKE '%$type%' OR itemDesc LIKE '%$type%' $max");

		$display .= __('<h2>Search Results</h2>', 'gbcart');

		$numprops = mysql_num_rows($searchResult);
		if($numprops == 0) {
			$display .= '<p class="error">' . __('No results found!', 'gbcart') . '</p>';
		}
		else {
			$display .= '<table class="gb-products zebra bordered">';
			$display .= '<thead><tr><th>' . __('Item Name', 'gbcart') . '</th><th>' . __('Item Description', 'gbcart') . '</th><th>' . __('Item Price', 'gbcart') . '</th><th></th></tr></thead><tbody>';

			while($rowSearch = mysql_fetch_array($searchResult)) {
				$display .= '<tr>';
					$display .= '
					<td>' . $rowSearch['itemName'] . '</td>
					<td>' . $rowSearch['itemDesc'] . '</td>
					<td>' . get_option('gbcart_currency') . $rowSearch['itemPrice'] . '</td>
					<td><a href="#" class="gb-button" onclick="updateArchive(' . $rowSearch['itemId'] . '); return false;">' . __('Add to cart', 'gbcart') . '</a></td>';
				$display .= '</tr>';
			}
			$display .= '</tbody></table>';

			$display .= '<p><small>' . __('Page', 'gbcart') . ' <b>' . $pagenum . '</b> ' . __('of', 'gbcart') . ' <b>' . $last . '</b></small></p>';

			$display .= '<p>';
				$pages = new Paginator;
				$pages->items_total = $rows;
				$pages->mid_range = 10;
				$pages->current_page = $pagenum;
				$pages->default_ipp = $page_rows;
				$pages->url_next = $pageURL . '?pagenum=';
				$pages->paginate();
				$display .= $pages->display_pages();
			$display .= '</p>';
		}
	}

	$gbc_search_page = get_option('gbc_page_id');
	$gbc_search_action = get_permalink($gbc_search_page);
	$display .= '
	<form method="post" action="' . $gbc_search_action . '">
		<div style="padding: 20px 0;">
			<input type="search" name="type" size="64" placeholder="' . __('Search Item...', 'gbcart') . '"> 
			<input type="submit" name="isSearch" value="' . __('Search', 'gbcart') . '">
		</div>
	</form>';

	return $display;
}


add_shortcode('gbcart', 'gb_cart_list');
add_shortcode('gbsearch', 'gb_search_list');
add_shortcode('gbcheckout', 'ShowCart');

function AddProduct($itemId) {
	global $wpdb;
	$id_session = session_id();

	$result = mysql_query("SELECT COUNT(*) FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "' AND itemId = $itemId");
	$row = mysql_fetch_row($result);
	$numRows = $row[0];

	if($numRows == 0)
		mysql_query("INSERT INTO " . $wpdb->prefix . "gb_cart(sessionId, itemId, qty) VALUES ('" . $id_session . "', $itemId, 1)");
	else
		UpdateProduct($itemId);
}
function UpdateProduct($itemId, $qty) {
	global $wpdb;
	$id_session = session_id();
	mysql_query("UPDATE " . $wpdb->prefix . "gb_cart SET qty = qty + 1 WHERE sessionId = '" . $id_session . "' AND itemId = $itemId");
}
function ShowCart() {
	global $wpdb;
	$id_session = session_id();
	$totalCost = 0;
	$display = '';

	$sql = "SELECT *
			FROM " . $wpdb->prefix . "gb_cart
			INNER JOIN " . $wpdb->prefix . "gb_items
			ON " . $wpdb->prefix . "gb_cart.itemId = " . $wpdb->prefix . "gb_items.itemId
			WHERE " . $wpdb->prefix . "gb_cart.sessionId = '" . $id_session . "'";

	if($result = mysql_query($sql)) {
		$display .= '<table class="gb-products zebra bordered">';
		$display .= '<thead><tr><th>' . __('Item Name', 'gbcart') . '</th><th>' . __('Item Description', 'gbcart') . '</th><th>' . __('Item Price', 'gbcart') . '</th><th></th></tr></thead><tbody>';
		while($row = mysql_fetch_array($result)) {
			$display .= '<tr class="gbRow' . $row['itemId'] . '">';
				$display .= '
				<td>' . $row['itemName'] . '</td>
				<td>' . $row['itemDesc'] . '</td>
				<td>' . get_option('gbcart_currency') . $row['itemPrice'] . ' (' . $row['qty'] . ')</td>
				<td><a href="#" class="gb-button" onclick="deleteArchive(' . $row['itemId'] . '); return false;" title="' . __('Remove this item', 'gbcart') . '">X</a></td>';
			$display .= '</tr>';
			$totalCost += $row['qty'] * $row['itemPrice'];
		}
		$display .= '</table>';
	}
	else {
		$display = mysql_error();
	}
	$display .= '<table class="gb-products"><tr><td class="gb-right"><b>' . __('Total:', 'gbcart') . '</b> ' . get_option('gbcart_currency') . number_format($totalCost, 2, '.', ',') . '</td></tr></table>';

	if(isset($_POST['isSubmit'])) {
		$gbform = $display;
		$message = '<p>' . $_POST['billing_first_name'] . ' ' . $_POST['billing_last_name'] . ' (' . $_POST['billing_company'] . ')</p>';
		$message .= '<p>' . $_POST['billing_address_1'] . ', ' . $_POST['billing_address_2'] . ', ' . $_POST['billing_city'] . '</p>';
		$message .= '<p>' . $_POST['billing_email'] . ' | ' . $_POST['billing_phone'] . '</p>';
		$message .= '<p>' . $_POST['billing_notes'] . '</p>';
		$message .= $gbform;

		// begin // add order to database
		$cart_contents = strip_tags($display, '<table><tr><td>');
		$cart_contents = preg_replace('#<table class="gb-products">(.*?)</table>#', '', $cart_contents);
		$cart_contents = str_replace('Item NameItem DescriptionItem Price', '', $cart_contents);
		$cart_contents = str_replace(' class="gb-products zebra bordered"', '', $cart_contents);
		$cart_contents = str_replace('<tr></tr>', '', $cart_contents);
		$cart_contents = str_replace('<td>X</td>', '', $cart_contents);
		$orderDate = date('Y-m-d H:i:s');

		if(get_option('gbc_rc_public') != '' && get_option('gbc_rc_private')) {
			// Get a key from https://www.google.com/recaptcha/admin/create
			$publickey = get_option('gbc_rc_public');
			$privatekey = get_option('gbc_rc_private');
			$resp = null;

			if($_POST['recaptcha_response_field']) {
				require_once(GBC_PLUGIN_PATH . '/recaptchalib.php');
				$resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
				if($resp->is_valid) {
					mysql_query("INSERT INTO " . $wpdb->prefix . "gb_orders (orderID, orderName, orderLastName, orderCompany, orderLocation, orderEmail, orderPhone, orderAddress1, orderAddress2, orderComments, orderCart, orderDate) VALUES (NULL, '" . $_POST['billing_first_name'] . "', '" . $_POST['billing_last_name'] . "', '" . $_POST['billing_company'] . "', '" . $_POST['billing_city'] . "', '" . $_POST['billing_email'] . "', '" . $_POST['billing_phone'] . "', '" . $_POST['billing_address_1'] . "', '" . $_POST['billing_address_2'] . "', '" . $_POST['billing_notes'] . "', '" . $cart_contents . "', '" . $orderDate . "')");
					mysql_query("DELETE FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "'");
					wp_mail(get_option('gbcart_notification_email'), __('New Order!', 'gbcart'), $message);
					$display .= '<div class="gbh-success">' . __('Order sent successfully!', 'gbcart') . '</div>';
				}
				else {
					$display .= '<div class="gbh-success">' . __('Incorrect verification code!', 'gbcart') . '</div>';
				}
			}
		}
		else {
			mysql_query("INSERT INTO " . $wpdb->prefix . "gb_orders (orderID, orderName, orderLastName, orderCompany, orderLocation, orderEmail, orderPhone, orderAddress1, orderAddress2, orderComments, orderCart, orderDate) VALUES (NULL, '" . $_POST['billing_first_name'] . "', '" . $_POST['billing_last_name'] . "', '" . $_POST['billing_company'] . "', '" . $_POST['billing_city'] . "', '" . $_POST['billing_email'] . "', '" . $_POST['billing_phone'] . "', '" . $_POST['billing_address_1'] . "', '" . $_POST['billing_address_2'] . "', '" . $_POST['billing_notes'] . "', '" . $cart_contents . "', '" . $orderDate . "')");
			mysql_query("DELETE FROM " . $wpdb->prefix . "gb_cart WHERE sessionId = '" . $id_session . "'");
			wp_mail(get_option('gbcart_notification_email'), __('New Order!', 'gbcart'), $message);
			$display .= '<div class="gbh-success">' . __('Order sent successfully!', 'gbcart') . '</div>';
		}
	}

	$display .= '
	<h3>' . __('Send Order', 'gbcart') . '</h3>

	<form method="post">
		<p>
			<input type="text" class="input-text gbh" name="billing_first_name" id="billing_first_name" placeholder="' . __('Name', 'gbcart') . ' *" required>
			<input type="text" class="input-text gbh" name="billing_last_name" id="billing_last_name" placeholder="' . __('Last Name', 'gbcart') . ' *" required>
		</p>
		<p>
			<input type="text" class="input-text gbh" name="billing_company" id="billing_company" placeholder="' . __('Company', 'gbcart') . '">
			<input type="text" class="input-text gbh" name="billing_city" id="billing_city" placeholder="' . __('Location', 'gbcart') . ' *" required>
		</p>
		<p>
			<input type="email" class="input-text gbh" name="billing_email" id="billing_email" placeholder="' . __('email@domain.com', 'gbcart') . ' *" required>
			<input type="text" class="input-text gbh" name="billing_phone" id="billing_phone" placeholder="' . __('Phone', 'gbcart') . '">
		</p>
		<p>
			<input type="text" class="input-text gbh" name="billing_address_1" id="billing_address_1" placeholder="' . __('Address', 'gbcart') . '">
			<input type="text" class="input-text gbh" name="billing_address_2" id="billing_address_1" placeholder="' . __('Address (more)', 'gbcart') . '">
		</p>
		<p>
			<textarea class="large-text gbl" name="billing_notes" id="billing_notes" placeholder="' . __('Comments', 'gbcart') . '" rows="4"></textarea>
		</p>';

		if(get_option('gbc_rc_public') != '' && get_option('gbc_rc_private')) {
			if(!function_exists('_recaptcha_qsencode'))
				require_once(GBC_PLUGIN_PATH . '/recaptchalib.php');
			$publickey = get_option('gbc_rc_public');
			$display .= recaptcha_get_html($publickey);
		}

		$display .= '
		<p><input type="submit" name="isSubmit" value="' . __('Send Order', 'gbcart') . '"></p>
	</form>';

	return $display;
}
?>
