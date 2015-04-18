<?php
/*
Plugin Name: WordPress Placeholder
Plugin URI: http://getbutterfly.com/wordpress-plugins/wordpress-placeholder-plugin/
Description: WordPress Placeholder is a quick and simple function for inserting image placeholders in your design or code. Add the shortcode in your post or page (or straight into your template) and get a customized placeholder.
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/
Version: 1.1

WordPress Placeholder Plugin
Copyright (C) 2012, 2013 Ciprian Popescu

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

//
define('PH_PLUGIN_URL', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
define('PH_PLUGIN_PATH', WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)));
define('PH_VERSION', '1.1');
//

// plugin localization
$plugin_dir = basename(dirname(__FILE__)); 
load_plugin_textdomain('ph', false, $plugin_dir.'/languages'); 

// Default options
add_option('ph_width', 150);
add_option('ph_height', 150);
add_option('ph_background', '#cccccc');
add_option('ph_alignment', 'none');
add_option('ph_text', 'SAMPLE');
add_option('ph_class', 'placeholder');
add_option('ph_size', 12);
add_option('ph_shape', 'rectangle');
// TO BE ADDED

// Displays options menu
function ph_add_option_page() {
	add_menu_page('Placeholder', 'Placeholder', 'manage_options', __FILE__, 'placeholder_options_page', PH_PLUGIN_URL.'/images/favicon.png');
	add_submenu_page(__FILE__, 'Help &amp; Tips', 'Help &amp; Tips', 'manage_options', 'ph_help', 'ph_help_page'); 
}

// Add stylesheet to head
function ph_head() {
	echo '<link rel="stylesheet" href="'.PH_PLUGIN_URL.'/css/placeholder.css" type="text/css">';
}
add_action('wp_head', 'ph_head');
//

add_shortcode('_p', 'placeholder'); // shortcode, function

// Helper functions
include('functions.php');
//

function placeholder($atts) {
	extract(shortcode_atts(array(
		'width' => get_option('ph_width'),
		'height' => get_option('ph_height'),
		'color' => get_option('ph_background'),
		'align' => get_option('ph_alignment'),
		'text' => get_option('ph_text'),
		'class' => get_option('ph_class'),
		'size' => get_option('ph_size'),
		'img' => PH_PLUGIN_URL . '/css/images/noise.png',
		'link' => '',
	), $atts));

	if(get_option('ph_shape') == 'rectangle')
		$ph_shape = '';
	if(get_option('ph_shape') == 'round')
		$ph_shape = 'ph_round';
	$c = calculateTextColor('#'.$color);

	if($link == '')
		return '<div class="c '.$ph_shape.' '.$class.'" style="color: '.$c.'; width: '.$width.'px; height: '.$height.'px; background: '.$color.' url('.$img.') repeat; line-height: '.$height.'px; float: '.$align.'; font-size: '.$size.'px"><span>'.$text.'</span></div>';
	else
		return '<div class="c '.$ph_shape.' '.$class.'" style="color: '.$c.'; width: '.$width.'px; height: '.$height.'px; background: '.$color.' url('.$img.') repeat; line-height: '.$height.'px; float: '.$align.'; font-size: '.$size.'px; cursor: pointer;" onclick="location.href=\''.$link.'\'"><span>'.$text.'</span></div>';
}
//

function ph_help_page() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Placeholder Help</h2>
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>Welcome</h3>
				<div class="inside">
					<p>The Placeholder plugin is a quick and simple function for inserting image placeholders in your design or code. Add the shortcode in your post or page (or straight into your template) and get a customized placeholder.</p>
					<p>An image placeholder is a dummy image designed to draw attention to the need for an actual image.
					<p>When designing WordPress templates and layouts, images to be used usually doesn't exist at first as it is the layout that matters the most. However, the sizes for the images are usually preset and inserting some image placeholders help visualize the layout better.</p>

					<h4>Shortcodes</h4>
					<p><code>[_p width="150" height="150" color="#cccccc" align="none" text="SAMPLE IMAGE" size="12" class="myimage"]</code></p>
					<p>
						The <code>width</code> and <code>height</code> parameters are mandatory. All the other parameters are optional, as they have fallback values.<br>
						The <code>color</code> parameter requires full HEX color code (no shorthand values, such as F00 or CCC, are allowed).<br>
						The <code>align</code> parameter accepts three values: <code>none</code> (default), <code>left</code> or <code>right</code>.<br>
						The <code>text</code> parameter sets the placeholder text (default: SAMPLE).<br>
						The <code>class</code> parameter is used when styling the image yourself in a separate stylesheet (such as style.css). Use it when adding borders, padding or margin to your images.<br>
						The <code>size</code> parameter sets the placeholder text size (default is 12).<br>
						The <code>img</code> parameter sets the placeholder background image. Use it to place specially crafted banners or images. The image will tile, so you can use various patterns.<br>
						The <code>link</code> parameter sets the placeholder link (optional).<br>
					</p>

					<p>The text colour is automatically calculated from the background color, and displays as either black or white.</p>

					<h4>Template Tags</h4>
					<p>Use the following PHP code if you want to add an image placeholder directly into your template:</p>
					<p><code>&lt;?php echo do_shortcode('[_p width="100" height="100" color="#cc0000" align="left"]'); ?&gt;</code></p>
					<p>This is, basically, an embedded shortcode. Feel free to add or remove any parameters from the shortcode.</p>

					<h4>Bonus Shortcodes</h4>
					<p>Use <code>[_t]</code> and <code>[_t2x]</code> shortcodes to generate text.</p>

					<hr>
					<p>For more information and updates, visit the <a href="http://getbutterfly.com/" rel="external">official web site</a></p>
				</div>
			</div>
		</div>
	</div>
	<?php
}

add_action('init', 'ilc_farbtastic_script');
function ilc_farbtastic_script() {
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
}

function placeholder_options_page() {
	if(isset($_POST['info_update'])) {
		update_option('ph_width', (string)$_POST['ph_width']);
		update_option('ph_height', (string)$_POST['ph_height']);
		update_option('ph_background', (string)$_POST['ph_background']);
		update_option('ph_alignment', (string)$_POST['ph_alignment']);
		update_option('ph_text', (string)$_POST['ph_text']);
		update_option('ph_class', (string)$_POST['ph_class']);
		update_option('ph_size', (string)$_POST['ph_size']);
		update_option('ph_shape', (string)$_POST['ph_shape']);

		echo '<div id="message" class="updated"><p>Options updated successfully!</p></div>';
	}
	?>
	<script>
	jQuery(document).ready(function() {
		jQuery('#ilctabscolorpicker').hide();
		jQuery('#ilctabscolorpicker').farbtastic("#ph_background");
		jQuery("#ph_background").click(function(){jQuery('#ilctabscolorpicker').slideToggle()});
	});
	</script>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Placeholder Settings</h2>

		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>Plugin Information</h3>
				<div class="inside">
					<p>The Placeholder plugin is a quick and simple function for inserting image placeholders in your design or code. Add the shortcode in your post or page (or straight into your template) and get a customized placeholder. See the <b>Help &amp; Tips</b> page for more information.</p>
					<p><small>You are using <b>Placeholder</b> version <strong><?php echo PH_VERSION;?></strong></small></p>
				</div>
			</div>
		</div>

		<form method="post">
			<input type="hidden" name="info_update" id="info_update" value="true">

			<table class="widefat">
				<tr><td colspan="2"><h4>Plugin Default Options</h4></td></tr>
				<tr>
					<th>
						Default image placeholder dimensions
						<br><em>(width x height)</em>
					</th>
					<td>
						<input name="ph_width" type="number" min="0" value="<?php echo get_option('ph_width');?>" max="9999"><label> x </label>
						<input name="ph_height" type="number" min="0" value="<?php echo get_option('ph_height');?>" max="9999"><label> px</label>
					</td>
				</tr>
				<tr>
					<th>
						Default image placeholder shape
						<br><em>(rectangle or round)</em>
					</th>
					<td>
						<select name="ph_shape" class="regular-text">
							<option value="rectangle"<?php if(get_option('ph_shape') == 'rectangle') echo ' selected="selected"';?>>Rectangle (default)</option>
							<option value="round"<?php if(get_option('ph_shape') == 'round') echo ' selected="selected"';?>>Round</option>
						</select> 
						<br /><small>Use the same width and height to generate circles</small>
					</td>
				</tr>
				<tr>
					<th>
						Default background color
						<br><em>(usually light grey)</em>
					</th>
					<td>
						<input id="ph_background"name="ph_background" size="7" type="text" value="<?php echo get_option('ph_background');?>" class="code">
						<div id="ilctabscolorpicker"></div>
					</td>
				</tr>
				<tr>
					<th>
						Default image placeholder alignment
						<br><em>(image can float to left, right or none)</em>
					</th>
					<td>
						<select name="ph_alignment" class="regular-text">
							<option value="none"<?php if(get_option('ph_alignment') == 'none') echo ' selected="selected"';?>>None (default)</option>
							<option value="left"<?php if(get_option('ph_alignment') == 'left') echo ' selected="selected"';?>>Left</option>
							<option value="right"<?php if(get_option('ph_alignment') == 'right') echo ' selected="selected"';?>>Right</option>
						</select> 
						<br /><small>Use the editor's alignment tool to center align it</small>
					</td>
				</tr>
				<tr>
					<th>
						Default image text
						<br><em>("SAMPLE", "IMAGE", "200 x 200")</em>
					</th>
					<td>
						<input name="ph_text" type="text" size="65" value="<?php echo get_option('ph_text');?>" class="regular-text">
						<br /><small>This text should describe the image role, such as a banner ad, or a filler, or a featured image</small>
					</td>
				</tr>
				<tr>
					<th>Default image text size</th>
					<td>
						<input name="ph_size" type="number" min="1" value="<?php echo get_option('ph_size');?>" max="9999">
					</td>
				</tr>
				<tr>
					<th>CSS class name</th>
					<td>
						<input name="ph_class" type="text" size="65" value="<?php echo get_option('ph_class');?>" class="regular-text">
						<br /><small>Use this class in your own stylesheet to add further styling - see sample code below</small>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<textarea name="ph_sample_css" class="regular-text code" cols="80" rows="12">
/*
 * This is sample code.
 * It should be used as a starting point for your own style.
 * It should be used according to your own design.
 */
.placeholder {
	margin: 4px;
	padding: 2px;
	border: 1px solid #CCCCCC;
	box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
}
						</textarea>
					</td>
				</tr>
			</table>

			<p>
				<input type="submit" name="info_update" class="button-primary" value="Update options" />
			</p>
		</form>

		<p>For more information and updates, visit the <a href="http://getbutterfly.com/" rel="external">official web site</a></p>

	</div>
<?php
}

add_action('admin_menu', 'ph_add_option_page');

// Javascript TinyMCE button
add_action('init', 'add_button');

add_shortcode('_t', 'textholder'); // shortcode, function
add_shortcode('_t2x', 'textholder2x');
?>
