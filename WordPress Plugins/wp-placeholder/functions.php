<?php
function calculateTextColor($color) {
	$c = str_replace('#', '', $color);
	$rgb[0] = hexdec(substr($c, 0, 2));
	$rgb[1] = hexdec(substr($c, 2, 2));
	$rgb[2] = hexdec(substr($c, 4, 2));
	if($rgb[0] + $rgb[1] + $rgb[2] < 382)
		return '#ffffff';
	else
		return '#000000';	
}

// Generate editor button
function add_button() {
	if(current_user_can('edit_posts') && current_user_can('edit_pages')) {
		add_filter('mce_external_plugins', 'add_plugin');
		add_filter('mce_buttons', 'register_button');
	}
}

function register_button($buttons) {
	array_push($buttons, 'placeholder');
	return $buttons;
}

function add_plugin($plugin_array) {
	$plugin_array['placeholder'] = PH_PLUGIN_URL.'/js/jPlaceholder.js';
	return $plugin_array;
}

// Generate text
function textholder() {
	return '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
}
function textholder2x() {
	return '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>';
}
?>
