<?php
/*
Plugin Name: Cinnamon Users
Plugin URI: http://getbutterfly.com/wordpress-plugins/cinnamon-users/
Description: <strong>Cinnamon Users</strong> allows you to create slick looking user profiles for multi-author WordPress sites. <strong>Cinnamon Users</strong> features lots of settings and options and allows for unique looking author portfolio pages.
Version: 2.6
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Copyright 2014, 2015 Ciprian Popescu (email: getbutterfly@gmail.com)

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

phpMyAdmin is licensed under the terms of the GNU General Public License
version 3, as published by the Free Software Foundation.
*/

//
define('CINNAMON_PROFILES_VERSION', '2.6');
define('CINNAMON_PROFILES_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('CINNAMON_PROFILES_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));

add_image_size('cinnamon-mini', 48, 48, true);

// plugin localization
$plugin_dir = basename(dirname(__FILE__)); 
load_plugin_textdomain('cinnamon', false, $plugin_dir . '/languages');
//

// modules
include(CINNAMON_PROFILES_PATH . '/modules/mod-awards.php');
include(CINNAMON_PROFILES_PATH . '/modules/mod-user-following.php');
//

// classes
if(get_option('cinnamon_mod_login') == 1)
    include(CINNAMON_PROFILES_PATH . '/classes/class-frontend.php');
//

// activate and check for security key
function cinnamon_profiles_activate() {
    add_option('cinnamon_post_type', 'post');
    add_option('cinnamon_author_slug', 'author'); // try 'profile'
    add_option('cinnamon_profile_title', 'Cinnamon Profile');
    add_option('cinnamon_label_index', 'View all');
    add_option('cinnamon_label_portfolio', 'My Hub');
    add_option('cinnamon_label_about', 'About/Biography');
    add_option('cinnamon_label_hub', 'My Hub');
    add_option('cinnamon_text_colour', '#666666');
    add_option('cinnamon_background_colour', '#ffffff');
    add_option('cinnamon_hide', '');
    add_option('cinnamon_image_size', 150);

    add_option('cinnamon_show_online', 1);
    add_option('cinnamon_show_uploads', 0);
    add_option('cinnamon_show_awards', 0);
    add_option('cinnamon_show_posts', 1);
    add_option('cinnamon_show_comments', 1);
    add_option('cinnamon_show_map', 0);
    add_option('cinnamon_show_followers', 0);
    add_option('cinnamon_show_following', 0);
    add_option('cinnamon_card_hover', 'Clickety click');

    add_option('cinnamon_hide_admin', 0);

    add_option('cinnamon_edit_page', '');

    add_option('cinnamon_mod_login', 0);
    add_option('cinnamon_mod_hub', 0);

    // clean up old versions
    delete_option('cinnamon_colour');
    delete_option('cinnamon_colour_step');
    delete_option('cinnamon_hover_colour');
    delete_option('act_settings');
    delete_option('cinnamon_awards_more');
    delete_option('cinnamon_mod_activity');
    delete_metadata('user', 0, 'hub_gender', '', true);

    wp_clear_scheduled_hook('act_cron_daily');
}
function cinnamon_profiles_deactivate() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'cinnamon_profiles_activate');
register_deactivation_hook(__FILE__, 'cinnamon_profiles_deactivate');
// end activation

// show admin bar only for admins
if(get_option('cinnamon_hide_admin') == 1) {
    add_action('after_setup_theme', 'cinnamon_remove_admin_bar');
    function cinnamon_remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }
}
//

function add_option_page_cinnamon_profiles() {
    $tax = get_taxonomy('award');

	add_menu_page('Cinnamon Users', 'Cinnamon Users', 'manage_options', 'cinnamon', 'option_page_cinnamon_profiles', 'dashicons-groups');
}

function option_page_cinnamon_profiles() {
    ?>
    <div class="wrap">
        <h2>Cinnamon Users</h2>
        <div id="poststuff" class="ui-sortable meta-box-sortables">
            <div class="postbox">
                <h3>About Cinnamon Users <small>(<a href="http://getbutterfly.com/wordpress-plugins/cinnamon-users/" rel="external">official web site</a>)</small></h3>
                <div class="inside">
                    <p>
                        <small>You are using <b>Cinnamon Users</b> plugin version <strong><?php echo CINNAMON_PROFILES_VERSION; ?></strong>.</small><br>
                        <small>Dependencies: <a href="http://fontawesome.io/" rel="external">Font Awesome</a> 4.1.0.</small>
                    </p>

                    <form method="post">
                        <?php
                        if(isset($_POST['cinnamon_submit'])) {
                            update_option('cinnamon_post_type', $_POST['cinnamon_post_type']);
                            update_option('cinnamon_author_slug', $_POST['cinnamon_author_slug']);
                            update_option('cinnamon_profile_title', $_POST['cinnamon_profile_title']);
                            update_option('cinnamon_label_index', $_POST['cinnamon_label_index']);
                            update_option('cinnamon_label_portfolio', $_POST['cinnamon_label_portfolio']);
                            update_option('cinnamon_label_about', $_POST['cinnamon_label_about']);
                            update_option('cinnamon_label_hub', $_POST['cinnamon_label_hub']);
                            update_option('cinnamon_text_colour', $_POST['cinnamon_text_colour']);
                            update_option('cinnamon_background_colour', $_POST['cinnamon_background_colour']);
                            update_option('cinnamon_hide', $_POST['cinnamon_hide']);
                            update_option('cinnamon_image_size', $_POST['cinnamon_image_size']);
                            update_option('cinnamon_card_hover', $_POST['cinnamon_card_hover']);

                            update_option('cinnamon_show_online', $_POST['cinnamon_show_online']);
                            update_option('cinnamon_show_uploads', $_POST['cinnamon_show_uploads']);
                            update_option('cinnamon_show_awards', $_POST['cinnamon_show_awards']);
                            update_option('cinnamon_show_posts', $_POST['cinnamon_show_posts']);
                            update_option('cinnamon_show_comments', $_POST['cinnamon_show_comments']);
                            update_option('cinnamon_show_map', $_POST['cinnamon_show_map']);
                            update_option('cinnamon_show_followers', $_POST['cinnamon_show_followers']);
                            update_option('cinnamon_show_following', $_POST['cinnamon_show_following']);

                            update_option('cinnamon_hide_admin', $_POST['cinnamon_hide_admin']);

                            update_option('cinnamon_edit_page', $_POST['cinnamon_edit_page']);

                            update_option('cinnamon_mod_login', $_POST['cinnamon_mod_login']);
                            update_option('cinnamon_mod_hub', $_POST['cinnamon_mod_hub']);

                            echo '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
                        }
                        ?>

                        <hr>
                        <h2>Plugin Options</h2>
                        <p>
                            <input type="text" name="cinnamon_post_type" id="cinnamon_post_type" value="<?php echo get_option('cinnamon_post_type'); ?>" class="text"> <label for="cinnamon_post_type">Post type to count (default is <b>post</b> - use <b>post</b>, <b>page</b> or custom post types)</label>
                        </p>
                        <p>
                            <input type="text" name="cinnamon_author_slug" id="cinnamon_author_slug" value="<?php echo get_option('cinnamon_author_slug'); ?>" class="text"> <label for="cinnamon_author_slug">Author profile slug (default is <b>author</b> - use <b>author</b>, <b>profile</b> or <b>hub</b>)</label>
                        </p>
                        <p>
                            <input type="text" name="cinnamon_profile_title" id="cinnamon_profile_title" value="<?php echo get_option('cinnamon_profile_title'); ?>" class="text"> <label for="cinnamon_profile_title">Profile section title (try <b>Extended Profile</b> or <b>Extra Profile Information</b>)</label>
                        </p>
                        <p>
                            <input type="text" name="cinnamon_card_hover" id="cinnamon_card_hover" value="<?php echo get_option('cinnamon_card_hover'); ?>" class="text"> <label for="cinnamon_card_hover">Author card hover label (try <b>Click to view</b>)</label>
                        </p>
                        <p>
                            <input type="url" name="cinnamon_edit_page" id="cinnamon_edit_page" value="<?php echo get_option('cinnamon_edit_page'); ?>" class="regular-text" placeholder="http://"> <label for="cinnamon_edit_page">Author profile edit page URL</label>
                            <br><small>Create a new page and add the <code>[cinnamon-profile-edit]</code> shortcode. This shortcode will display all user fields.</small>
                        </p>
                        <p>
                            <a href="<?php echo admin_url('edit-tags.php?taxonomy=award'); ?>" class="button button-secondary">Add/Edit Awards</a>
                            <br><small>Create a new page and add the <code>[cinnamon-awards]</code> shortcode. This shortcode will list all available awards and their description.</small>
                        </p>

                        <hr>
                        <h2>Modules</h2>
                        <p>
                            <select name="cinnamon_mod_login" id="cinnamon_mod_login">
                                <option value="1"<?php if(get_option('cinnamon_mod_login') == 1) echo ' selected'; ?>>Enable frontend login/registration module</option>
                                <option value="0"<?php if(get_option('cinnamon_mod_login') == 0) echo ' selected'; ?>>Disable frontend login/registration module</option>
                            </select> <label for="cinnamon_mod_login">Enable a tabbed login/registration/password reset box</label>
                            <br><small>Use the <code>[cinnamon-login]</code> shortcode to place the box anywhere on the site.</small>
                        </p>
                        <p>
                            <select name="cinnamon_mod_hub" id="cinnamon_mod_hub">
                                <option value="1"<?php if(get_option('cinnamon_mod_hub') == 1) echo ' selected'; ?>>Enable hub</option>
                                <option value="0"<?php if(get_option('cinnamon_mod_hub') == 0) echo ' selected'; ?>>Disable hub</option>
                            </select> <label for="cinnamon_mod_hub">Enable a subdomain address for users (e.g. jack.yourdomain.com)</label>
                            <br><small>Use with caution. See below.</small>
                        </p>

                        <?php if(get_option('cinnamon_mod_hub') == 0) echo '<div style="opacity: 0.5;">'; ?>
                        <hr>
                        <h2>Hub Options <sup>(experimental, developers only)</sup></h2>
                        <p>
                            <input type="text" name="cinnamon_label_index" id="cinnamon_label_index" value="<?php echo get_option('cinnamon_label_index'); ?>" class="text"> <label for="cinnamon_label_index">Hub index icon label (try <b>View all</b> or <b>Back to index view</b>)</label>
                        </p>
                        <p>
                            <input type="text" name="cinnamon_label_hub" id="cinnamon_label_hub" value="<?php echo get_option('cinnamon_label_hub'); ?>" class="text"> <label for="cinnamon_label_hub">Hub view button label (try <b>View Portfolio</b>)</label>
                        </p>
                        <p>
                            <input type="number" min="90" max="320" name="cinnamon_image_size" id="cinnamon_image_size" value="<?php echo get_option('cinnamon_image_size'); ?>"> <label for="cinnamon_image_size">Profile image size</label>
                            <br><small>Default is <b>150</b>px. Leave blank for default WordPress size.</small>
                        </p>
                        <p>
                            <label>Hub tabs</label><br>
                            <input type="text" name="cinnamon_label_portfolio" id="cinnamon_label_portfolio" value="<?php echo get_option('cinnamon_label_portfolio'); ?>" class="text" placeholder="My Portfolio (tab title)"> <small>Try <b>My Portfolio</b> or <b>My Images</b></small><br>
                            <input type="text" name="cinnamon_label_about" id="cinnamon_label_about" value="<?php echo get_option('cinnamon_label_about'); ?>" class="text" placeholder="About (tab title)"> <small>Try <b>About</b></small>
                        </p>
                        <p>
							<label for="cinnamon_text_colour">Hub text colour</label>
							<br><input type="text" name="cinnamon_text_colour" class="cinnamon_colorPicker" data-default-color="#666666" value="<?php echo get_option('cinnamon_text_colour'); ?>">
						</p>
                        <p>
							<label for="cinnamon_background_colour">Hub background colour</label>
							<br><input type="text" name="cinnamon_background_colour" class="cinnamon_colorPicker" data-default-color="#ffffff" value="<?php echo get_option('cinnamon_background_colour'); ?>">
						</p>
                        <p>
                            <input type="text" name="cinnamon_hide" id="cinnamon_hide" value="<?php echo get_option('cinnamon_hide'); ?>" class="regular-text"> <label for="cinnamon_hide">CSS selectors to hide when viewing the hub</label>
                            <br><small>Try <b>header, nav, footer</b> or <b>.sidebar</b> or <b>#main-menu</b>.</small>
                            <br><small>If your hub page flashes for a brief moment, consider moving the selectors in your <code>style.css</code> file (e.g. <code>header, nav, footer, .sidebar, #main-menu { display: none; }</code>.</small>
                        </p>
                        <?php if(get_option('cinnamon_mod_hub') == 0) echo '</div>'; ?>

                        <hr>
                        <p>
                            <select name="cinnamon_show_uploads" id="cinnamon_show_uploads">
                                <option value="1"<?php if(get_option('cinnamon_show_uploads') == 1) echo ' selected'; ?>>Show latest ImagePress uploads</option>
                                <option value="0"<?php if(get_option('cinnamon_show_uploads') == 0) echo ' selected'; ?>>Hide latest ImagePress uploads</option>
                            </select> <label for="cinnamon_show_uploads">You need <b>ImagePress</b> plugin to use this option</label>
                        </p>
                        <p>
                            <select name="cinnamon_show_online" id="cinnamon_show_online">
                                <option value="1"<?php if(get_option('cinnamon_show_online') == 1) echo ' selected'; ?>>Show online and join details</option>
                                <option value="0"<?php if(get_option('cinnamon_show_online') == 0) echo ' selected'; ?>>Hide online and join details</option>
                            </select> 
                            <select name="cinnamon_show_posts" id="cinnamon_show_posts">
                                <option value="1"<?php if(get_option('cinnamon_show_posts') == 1) echo ' selected'; ?>>Show latest posts</option>
                                <option value="0"<?php if(get_option('cinnamon_show_posts') == 0) echo ' selected'; ?>>Hide latest posts</option>
                            </select> 
                            <select name="cinnamon_show_awards" id="cinnamon_show_awards">
                                <option value="1"<?php if(get_option('cinnamon_show_awards') == 1) echo ' selected'; ?>>Show awards</option>
                                <option value="0"<?php if(get_option('cinnamon_show_awards') == 0) echo ' selected'; ?>>Hide awards</option>
                            </select>
                        </p>
                        <p>
                            <select name="cinnamon_show_comments" id="cinnamon_show_comments">
                                <option value="1"<?php if(get_option('cinnamon_show_comments') == 1) echo ' selected'; ?>>Show latest comments and replies</option>
                                <option value="0"<?php if(get_option('cinnamon_show_comments') == 0) echo ' selected'; ?>>Hide latest comments and replies</option>
                            </select> 
                            <select name="cinnamon_show_map" id="cinnamon_show_map">
                                <option value="1"<?php if(get_option('cinnamon_show_map') == 1) echo ' selected'; ?>>Show map</option>
                                <option value="0"<?php if(get_option('cinnamon_show_map') == 0) echo ' selected'; ?>>Hide map</option>
                            </select>
                        </p>
                        <p>
                            <select name="cinnamon_hide_admin" id="cinnamon_hide_admin">
                                <option value="1"<?php if(get_option('cinnamon_hide_admin') == 1) echo ' selected'; ?>>Hide admin bar for non-admin users</option>
                                <option value="0"<?php if(get_option('cinnamon_hide_admin') == 0) echo ' selected'; ?>>Show admin bar for non-admin users</option>
                            </select>
                        </p>
                        <p>
                            <select name="cinnamon_show_followers" id="cinnamon_show_followers">
                                <option value="1"<?php if(get_option('cinnamon_show_followers') == 1) echo ' selected'; ?>>Show followers</option>
                                <option value="0"<?php if(get_option('cinnamon_show_followers') == 0) echo ' selected'; ?>>Hide followers</option>
                            </select> 
                            <select name="cinnamon_show_following" id="cinnamon_show_following">
                                <option value="1"<?php if(get_option('cinnamon_show_following') == 1) echo ' selected'; ?>>Show following</option>
                                <option value="0"<?php if(get_option('cinnamon_show_following') == 0) echo ' selected'; ?>>Hide following</option>
                            </select> <label>Followers behaviour</label>
                        </p>

                        <p>
                            <input name="cinnamon_submit" type="submit" class="button-primary" value="Save Changes">
                        </p>
                    </form>

                    <h2>Usage</h2>
                    <p>In order to view the Cinnamon profile, you need to create (or edit) the <code>author.php</code> file in your theme folder (<code>wp-content/themes/your-theme/author.php</code>) and add the following code:</p>
                    
                    <p><textarea class="large-text code" rows="4">
&lt;?php
// Cinnamon shortcode
echo do_shortcode('[cinnamon-profile]');
?&gt;
                    </textarea></p>
                    <p>
                        If you want to show the profile on a custom page, such as <b>My Profile</b> or <b>View My Portfolio</b>, use the <code>[cinnamon-profile]</code> shortcode.<br>
                        If you want to show a certain user profile on a page, use the <code>[cinnamon-profile author=17]</code> shortcode, where <b>17</b> is the user ID.
                    </p>
                    <p>In order to view the Cinnamon portfolio, you need to create (or edit) the <code>author.php</code> file in your theme folder (<code>wp-content/themes/your-theme/author.php</code>) and add the following code:</p>
                    <p><textarea class="large-text code" rows="12">
&lt;?php
// check for external portfolio
// use this shortcode if page call is made from subdomain (e.g. username.domain.ext)
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parseUrl = parse_url($url);
$ext_detect = trim($parseUrl['path']);
if($ext_detect == '/') {
    echo do_shortcode('[cinnamon-profile-blank]');
}
?&gt;
                    </textarea><br><small>Note: you might want to add an <code>if/else</code> loop in order to show both profiles on the same <code>author.php</code> template.</small></p>
                    <p>In order for the above to work, you need to edit your .htaccess file and add these lines at the end:</p>
                    <p><textarea class="large-text code" rows="6">
# BEGIN Cinnamon Author Rewrite
RewriteCond %{HTTP_HOST} !^www\.domain.com
RewriteCond %{HTTP_HOST} ([^.]+)\.domain.com
RewriteRule ^(.*)$ ?author_name=%1
# END Cinnamon Author Rewrite
                    </textarea></p>
                    <p>Requirements for portfolio subdomains (jack.domain.com) include active permalinks, wildcard subdomain support (contact your hosting server for more information) and FTP access to your template files.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function cinnamon_enqueue_color_picker($hook_suffix) {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('cinnamon_color_picker', plugins_url('js/cinnamon-functions.js', __FILE__), array('wp-color-picker'), false, true);
}
function cinnamon_profiles_default() {
    wp_enqueue_style('cinnamon-profiles', CINNAMON_PROFILES_URL . '/css/cinnamon-profiles.css');
    wp_enqueue_style('fa', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');

    wp_enqueue_script('jpages', CINNAMON_PROFILES_URL . '/js/jpages.min.js', array('jquery'));
    wp_enqueue_script('cinnamon', CINNAMON_PROFILES_URL . '/js/cinnamon.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'cinnamon_profiles_default');
add_action('admin_enqueue_scripts', 'cinnamon_enqueue_color_picker');
add_action('admin_menu', 'add_option_page_cinnamon_profiles');

/* CINNAMON ACTIONS */
add_action('init', 'update_cinnamon_action_time');
add_action('init', 'cinnamon_author_base');
add_action('wp_login', 'cinnamon_last_login');

add_action('show_user_profile', 'cinnamon_profile_fields', 1);
add_action('edit_user_profile', 'cinnamon_profile_fields', 1);

add_action('personal_options_update', 'save_cinnamon_profile_fields');
add_action('edit_user_profile_update', 'save_cinnamon_profile_fields');

/* CINNAMON SHORTCODES */
add_shortcode('cinnamon-card', 'cinnamon_card');
add_shortcode('cinnamon-profile', 'cinnamon_profile');
add_shortcode('cinnamon-profile-blank', 'cinnamon_profile_blank');
add_shortcode('cinnamon-profile-edit', 'cinnamon_profile_edit');
add_shortcode('cinnamon-awards', 'cinnamon_awards');
/* CINNAMON FILTERS */
add_filter('get_avatar', 'hub_gravatar_filter', 10, 5);
add_filter('user_contactmethods', 'cinnamon_extra_contact_info');

/* CINNAMON CHECKS */
$user_ID = get_current_user_id();
update_user_meta($user_ID, 'cinnamon_action_time', current_time('mysql'));

/* CINNAMON FUNCTIONS */
function cinnamon_count_user_posts_by_type($userid, $post_type = 'post') {
	global $wpdb;

    $cinnamon_post_type = get_option('cinnamon_post_type');

    $where = get_posts_by_author_sql($cinnamon_post_type, true, $userid);
	$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts $where");

  	return apply_filters('get_usernumposts', $count, $userid);
}

function cinnamon_get_level_by_id($hid) {
    if($hid == 0) return __('Subscriber', 'cinnamon');
    if($hid == 1) return __('Contributor', 'cinnamon');
    if($hid == 2) return __('Author', 'cinnamon');
    if($hid == 3) return __('Editor', 'cinnamon');
    if($hid == 4) return __('Editor', 'cinnamon');
    if($hid == 5) return __('Editor', 'cinnamon');
    if($hid == 6) return __('Editor', 'cinnamon');
    if($hid == 7) return __('Editor', 'cinnamon');
    if($hid == 8) return __('Administrator', 'cinnamon');
    if($hid == 9) return __('Administrator', 'cinnamon');
    if($hid == 10) return __('Administrator', 'cinnamon');
}

function cinnamon_last_login($login) {
    $user = get_user_by('login', $login);
    update_user_meta($user->ID, 'cinnamon_action_time', current_time('mysql'));
}

function get_cinnamon_login($user_id) {
  $last_login = get_user_meta($user_id, 'cinnamon_action_time', true);
  $date_format = get_option('date_format') . ' ' . get_option('time_format');
  $the_last_login = mysql2date($date_format, $last_login, false);
  return $the_last_login;
}

function update_cinnamon_action_time() {
    $user = wp_get_current_user();
    update_user_meta($user->ID, 'cinnamon_action_time', current_time('mysql'));
}

function cinnamon_PostViews($id) {
    $axCount = get_user_meta($id, 'ax_post_views', true);
    if($axCount == '')
        $axcount = 0;

    $axCount++;
    update_user_meta($id, 'ax_post_views', $axCount);

    return $axCount;
}

function cinnamon_author_base() {
    global $wp_rewrite;

    $cinnamon_author_slug = get_option('cinnamon_author_slug');
    $author_slug = $cinnamon_author_slug; // change slug name
    $wp_rewrite->author_base = $author_slug;
}

function cinnamon_get_related_author_posts($author) {
    global $post;

    $cinnamon_post_type = get_option('cinnamon_post_type');
    $authors_posts = get_posts(array(
        'author' => $author,
        'posts_per_page' => 9,
        'post_type' => $cinnamon_post_type
    ));

    $output = '';
    if($authors_posts) {
        $output .= '
        <div class="cinnamon-grid"><ul>';
            foreach($authors_posts as $authors_post) {
                $output .= '<li><a href="' . get_permalink($authors_post->ID) . '">' . get_the_post_thumbnail($authors_post->ID, 'thumbnail') . '</a></li>';
            }
        $output .= '</ul></div>';
    }

    return $output;
}

function cinnamon_extra_contact_info($contactmethods) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);

    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['googleplus'] = 'Google+';
    $contactmethods['behance'] = 'Behance';

    return $contactmethods;
}

function cinnamon_get_portfolio_posts($author, $count) {
    global $post;

    $cinnamon_post_type = get_option('cinnamon_post_type');
    $authors_posts = get_posts(array(
        'author' => $author,
        'post_type' => $cinnamon_post_type,
        'posts_per_page' => $count,
        'meta_key' => 'imagepress_sticky',
        'meta_value' => 1,
    ));

    $output = '';
    if($authors_posts) {
        $output .= '<div id="cinnamon-index"><a href="#"><i class="fa fa-th-large"></i> ' . get_option('cinnamon_label_index') . '</a></div>
        <div id="cinnamon-feature"></div>
        <div class="cinnamon-grid-blank">';
            foreach($authors_posts as $authors_post) {
                $post_thumbnail_id = get_post_thumbnail_id($authors_post->ID);
                $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
                $output .= '<a href="#" rel="' . $post_thumbnail_url . '">' . get_the_post_thumbnail($authors_post->ID, 'thumbnail') . '</a>';
            }
        $output .= '</div>';
    }

    return $output;
}



function user_query_count_post_type($args) {
    $args->query_from = str_replace("post_type = 'post' AND", "post_type IN ('" . get_option('cinnamon_post_type') . "') AND ", $args->query_from);
}
function alter_user_search($qry) {
    global $wpdb;
    $key = $qry->get('meta_key');
    if(isset($key)) {
        //$qry->query_orderby = preg_replace('/ORDER BY (.*) (ASC|DESC)/',"ORDER BY {$wpdb->usermeta}.meta_value ".$qry->get('order') ,$qry->query_orderby);
        $qry->query_orderby = preg_replace('/ORDER BY (.*) (ASC|DESC)/',"ORDER BY CAST({$wpdb->usermeta}.meta_value AS UNSIGNED) ".$qry->get('order') ,$qry->query_orderby);
    }
}


/* CINNAMON CARD SHORTCODE */
function cinnamon_card($atts, $content = null) {
	extract(shortcode_atts(array(
        'author' => '',
        'count' => 99999,
        'perpage' => 99999,
        'sort' => 0
    ), $atts));

    global $post;

    $cinnamon_post_type = get_option('cinnamon_post_type');

    if(empty($author))
        $author = get_current_user_id();

    $display = '';
    $display .= '<script>
    jQuery(document).ready(function(){
        jQuery(".cardholder").jPages({
            containerID : "cinnamon-cards",
            perPage: ' . $perpage . ',
            first: "' . __('First', 'imagepress') . '",
            last: "' . __('Last', 'imagepress') . '",
            next: "' . __('Next', 'imagepress') . '",
            previous: "' . __('Previous', 'imagepress') . '",
            callback: function(pages, items){
                jQuery("#legend3").html("Page " + pages.current + " of " + pages.count);
                jQuery("#legend4").html("Showing " + items.range.start + " - " + items.range.end + " of " + items.count);
            }
        });
    })
    </script>';
    if($sort == 0) {
        $display .= '<form method="post">
            <p><select name="cinnamon_sort" id="cinnamon_sort">
                <option value="0">Sort...</option>
                <option value="1">Sort by most popular</option>
                <option value="2">Sort alphabetically</option>
                <option value="3">Sort by uploads</option>
            </select></p>
        </form>';

        add_action('pre_user_query', 'user_query_count_post_type', 1);
        if(isset($_POST['cinnamon_sort'])) {
            if($_POST['cinnamon_sort'] == 1) {
                add_action('pre_user_query', 'alter_user_search');
                $hub_users = get_users(array('number' => $count, 'order' => 'DESC', 'orderby' => 'meta_value', 'meta_key' => 'ax_post_views'));
            }
            if($_POST['cinnamon_sort'] == 2)
                $hub_users = get_users(array('number' => $count, 'order' => 'ASC', 'orderby' => 'title'));
            if($_POST['cinnamon_sort'] == 3)
                $hub_users = get_users(array('number' => $count, 'order' => 'DESC', 'orderby' => 'post_count'));
        }
        else {
            $hub_users = get_users(array('number' => $count, 'order' => 'DESC', 'orderby' => 'post_count'));
        }
        remove_action('pre_user_query', 'user_query_count_post_type');
    }
    else {
        if($sort == 1) {
            add_action('pre_user_query', 'alter_user_search');
            $hub_users = get_users(array('number' => $count, 'order' => 'DESC', 'orderby' => 'meta_value', 'meta_key' => 'ax_post_views'));
        }
        if($sort == 2)
            $hub_users = get_users(array('number' => $count, 'order' => 'ASC', 'orderby' => 'title'));
        if($sort == 3)
            $hub_users = get_users(array('number' => $count, 'order' => 'DESC', 'orderby' => 'post_count'));
    }

    $display .= '<div class="cardholder imagepress-paginator"></div><p><small><span id="legend3"></span> | <span id="legend4"></span></small><p><div id="cinnamon-cards">';

    foreach($hub_users as $user) {
        $author = $user->ID;
        $hub_user_info = get_userdata($author);

        if($hub_user_info->first_name != '' && get_the_author_meta('hub_location', $author) != '') {
            $display .= '<div class="cinnamon-card"><div class="cinnamon-backflip"><a href="' . get_author_posts_url($author) . '"><i class="fa fa-user"></i> ' . get_option('cinnamon_card_hover') . '</a></div><div class="cinnamon-card-inner">';
                $display .= '<div class="avatar-holder">' . get_avatar($author, 90) . '</div>';

                if(get_the_author_meta('user_title', $author) == 'Verified')
                    $verified = ' <span class="hint hint--right" data-hint="' . get_option('cms_verified_profile') . '"><i class="fa fa-check-circle-o"></i></span>';
                else
                    $verified = '';
                $display .= '<h3>' . $hub_user_info->first_name . ' ' . $hub_user_info->last_name . $verified . '</h3>';
                $display .= '<div class="location-holder"><small>' . get_the_author_meta('hub_location', $author) . '</small></div>';

                $display .= '<div style="line-height: 1;"><small><i class="fa fa-user"></i> ' . pwuf_get_follower_count($author) . ' | <i class="fa fa-file-image-o"></i> ' . cinnamon_count_user_posts_by_type($author, $cinnamon_post_type) . ' | <i class="fa fa-eye"></i> ' . cinnamon_PostViews($author) . '</small></div>';
                $display .= '<div style="clear: both;"></div>';

                $authors_posts = get_posts(array(
                    'author' => $author,
                    'posts_per_page' => 3,
                    'post_type' => $cinnamon_post_type
                ));
                if($authors_posts) {
                    $display .= '<div class="mosaicflow">';
                        foreach($authors_posts as $authors_post) {
                            $display .= '<div><a href="' . get_permalink($authors_post->ID) . '">' . get_the_post_thumbnail($authors_post->ID, 'imagepress_pt_sm') . '</a></div>';
                        }
                    $display .= '</div>';
                }
            $display .= '</div></div>';
        }
    }
    $display .= '</div>';
    $display .= '<div style="clear: both;"></div>';

    return $display;
}

/* CINNAMON PROFILE (BLANK) SHORTCODE */
function cinnamon_profile_blank($atts, $content = null) {
	extract(shortcode_atts(array('author' => ''), $atts));

    $author = get_user_by('slug', get_query_var('author_name'));
    $author = $author->ID;

    $author_rewrite = get_user_by('slug', get_query_var('author_name'));
    $author_rewrite = $author_rewrite->user_login;

    if(empty($author))
        $author = get_current_user_id();

    $hub_user_info = get_userdata($author);
    $cinnamon_post_type = get_option('cinnamon_post_type');

    $hub_googleplus = ''; $hub_facebook = ''; $hub_twitter = ''; $hub_behance = '';
    if($hub_user_info->googleplus != '')
        $hub_googleplus = '<a href="' . $hub_user_info->googleplus . '" target="_blank"><i class="fa fa-google-plus-square"></i></a>';
    if($hub_user_info->facebook != '')
        $hub_facebook = '<a href="' . $hub_user_info->facebook . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
    if($hub_user_info->twitter != '')
        $hub_twitter = '<a href="https://twitter.com/' . $hub_user_info->twitter . '" target="_blank"><i class="fa fa-twitter-square"></i></a>';
    if($hub_user_info->behance != '')
        $hub_behance = '<a href="https://www.behance.net/' . $hub_user_info->behance . '" target="_blank"><i class="fa fa-behance-square"></i></a>';

    $hub_email = '<a href="mailto:' . get_the_author_meta('email', $author) . '" target="_blank"><i class="fa fa-envelope-square"></i></a>';

    $display = '<style scoped>html, body { background-color: ' . get_option('cinnamon_background_colour') . '; color: ' . get_option('cinnamon_text_colour') . '; } a:hover { color: ' . get_option('cinnamon_text_colour') . '; }</style><script>jQuery(document).ready(function(){ jQuery("' . get_option('cinnamon_hide') . '").hide(); });</script>';
    $display .= '<div class="cornholio">';
        $display .= '<div class="c-main">' . $hub_user_info->first_name . ' ' . $hub_user_info->last_name . '</div>';
        $display .= '<div class="c-description"> ' . get_the_author_meta('hub_field', $author) . ' // ' . get_the_author_meta('hub_location', $author) . '</div>';
        $display .= '<div class="c-social">' . $hub_facebook . ' ' . $hub_twitter . ' ' . $hub_googleplus . ' ' . $hub_behance . ' ' . $hub_email;
        if($hub_user_info->user_url != '')
            $display .= ' <a href="' . $hub_user_info->user_url . '" rel="external" target="_blank"><i class="fa fa-link"></i></a>';
        $display .= '</div>';

        $display .= '<ul id="tab">
            <li><a href="#" class="c-index">' . get_option('cinnamon_label_portfolio') . '</a></li>
            <li><a href="#">' . get_option('cinnamon_label_about') . '</a></li>
        </ul>
        <div class="clear"></div>
        <div class="tab_icerik">';
            $display .= cinnamon_get_portfolio_posts($author, 18);
        $display .= '</div>
        <div class="tab_icerik">';
            $display .= make_clickable(wpautop($hub_user_info->description));
        $display .= '</div>';

        $display .= '<hr><div class="c-footer">&copy; ' . $hub_user_info->first_name . ' ' . $hub_user_info->last_name . ' ' . date('Y') . '</div>';
        $display .= '<div class="c-footer">Portfolio provided by ' . get_option('cinnamon_profile_title') . '</div>';
    $display .= '</div>';

    return $display;
}

/* CINNAMON PROFILE SHORTCODE */
function cinnamon_profile($atts, $content = null) {
	extract(shortcode_atts(array('author' => ''), $atts));

    $author = get_user_by('slug', get_query_var('author_name'));
    $author = $author->ID;

    $author_rewrite = get_user_by('slug', get_query_var('author_name'));
    $author_rewrite = $author_rewrite->user_login;

    $cinnamon_post_type = get_option('cinnamon_post_type');

    if(empty($author))
        $author = get_current_user_id();

    $hub_user_info = get_userdata($author);

    $display = '';

    $hub_googleplus = ''; $hub_facebook = ''; $hub_twitter = ''; $hub_behance = '';
    if($hub_user_info->googleplus != '')
        $hub_googleplus = ' <a href="' . $hub_user_info->googleplus . '" target="_blank"><i class="fa fa-google-plus-square"></i></a>';
    if($hub_user_info->facebook != '')
        $hub_facebook = ' <a href="' . $hub_user_info->facebook . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
    if($hub_user_info->twitter != '')
        $hub_twitter = ' <a href="https://twitter.com/' . $hub_user_info->twitter . '" target="_blank"><i class="fa fa-twitter-square"></i></a>';
    if($hub_user_info->behance != '')
        $hub_behance = ' <a href="https://www.behance.net/' . $hub_user_info->behance . '" target="_blank"><i class="fa fa-behance-square"></i></a>';

    $hca = get_the_author_meta('hub_custom_cover', $author);
    $hca = wp_get_attachment_url($hca);
    if(!isset($hca) || empty($hca))
        $hca = CINNAMON_PROFILES_URL . '/img/coverimage.png';
        
    $display .= '<div class="profile-hub-container">';
        $display .= '<div class="cinnamon-progress" style="width: 34%;">Profile completeness</div>';
        $display .= '<div class="cinnamon-cover" style="background: url(' . $hca . ') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">';
            $logged_in_user = wp_get_current_user();
            if(is_user_logged_in() && $author_rewrite == $logged_in_user->user_login)
                $display .= '<a href="' . get_option('cinnamon_edit_page') . '" class="overlay" title="' . __('Edit profile', 'cinnamon') . '"><i class="fa fa-pencil-square-o"></i></a>';

            // Cinnamon Stats
            $display .= '<div class="cinnamon-stats">';
                $display .= '<div class="cinnamon-meta"><b>' . pwuf_get_follower_count($author) . '</b> ' . __('followers', 'cinnamon') . '</div>';
                $display .= '<div class="cinnamon-meta"><b>' . cinnamon_PostViews($author) . '</b> ' . __('profile views', 'cinnamon') . '</div>';
                $display .= '<div class="cinnamon-meta"><b>' . cinnamon_count_user_posts_by_type($author, $cinnamon_post_type) . '</b> ' . __('uploads', 'cinnamon') . '</div>';
                // get custom URL
                $hubprotocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
                $hubdomain = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
                $hubuser = get_user_by('id', $author);
                $hubuser = sanitize_title($hubuser->user_login);

                if(get_option('cinnamon_mod_hub') == 1)
                    $display .= '<div class="cinnamon-meta"><a href="' . $hubprotocol . $hubuser . '.' . $hubdomain . '"><i class="fa fa-cog"></i> ' . get_option('cinnamon_label_hub') . '</a></div>';

                $display .= '<div class="cinnamon-meta">';
                    if(get_the_author_meta('hub_status', $author) == 1)
                        $display .= ' <a href="mailto:' . get_the_author_meta('email', $author) . '"><i class="fa fa-envelope"></i></a>';
                    $display .=  $hub_facebook . $hub_twitter . $hub_googleplus . $hub_behance;
                    if($hub_user_info->user_url != '')
                        $display .= ' <a href="' . $hub_user_info->user_url . '" rel="external" target="_blank"><i class="fa fa-link"></i></a>';
                $display .= '</div>';
            $display .= '</div>';
        $display .= '</div>';

        $hub_url = $hub_user_info->user_url;
        $hub_field = get_the_author_meta('hub_field', $author);
        $hub_software = get_the_author_meta('hub_software', $author);
        $hub_employer = get_the_author_meta('hub_employer', $author);

        $display .= '<div class="ph-level">
            <div class="cinnamon-avatar">' . get_avatar($author, 120) . '';
            if(is_user_logged_in() && $author_rewrite != $logged_in_user->user_login)
                $display .= '<br><span>' . do_shortcode('[follow_links follow_id="' . $author . '"]') . '</span>';
            $display .= '</div>';

            if(get_the_author_meta('user_title', $author) == 'Verified')
                $verified = ' <span class="hint hint--right" data-hint="' . get_option('cms_verified_profile') . '"><i class="fa fa-check-circle-o"></i></span>';
            else
                $verified = '';

                $display .= '<div class="cinnamon-field">';
                    if(!empty($hub_field))
                        $display .= '<p><i class="fa fa-briefcase"></i> ' . get_the_author_meta('hub_field', $author) . '</p>';
                    if(get_the_author_meta('hub_status', $author) == 1)
                        $display .= '<p><i class="fa fa-flag"></i> <b>' . __('Available for hire', 'cinnamon') . '</b></p>';
                $display .= '</div>';


            $display .= '<div class="ph-nametag">' . $hub_user_info->first_name . ' ' . $hub_user_info->last_name . $verified . '</div>
            <br>
            <div class="ph-locationtag"><i class="fa fa-map-marker"></i> ' . get_the_author_meta('hub_location', $author) . '</div>';
        $display .= '</div>';



        if(get_option('cinnamon_show_awards') == 1) {
            $display .= '<div class="ph-level">';
                $award_terms = wp_get_object_terms($author, 'award');
                if(!empty($award_terms)) {
                    if(!is_wp_error($award_terms)) {
                        foreach($award_terms as $term) {
                            // get custom FontAwesome
                            $t_ID = $term->term_id;
                            $term_data = get_option("taxonomy_$t_ID");

                            $display .= '<span class="cinnamon-award-list-item" title="' . $term->description . '">';
                            if(isset($term_data['img']))
                                $display .= '<i class="fa ' . $term_data['img'] . '"></i> ';
                            else
                                $display .= '<i class="fa fa-trophy"></i> ';

                            $display .= $term->name . '</span>';
                        }
                    }
                }
            $display .= '</div>';
        }

        $display .= '<div class="ph-level">';
            $display .= '<hr>';
            // TABS //
            $display .= '
            <div class="tab">
                <ul class="tabs">';
                    if(get_option('cinnamon_show_uploads') == 1) {
                        $display .= '<li><a href="#"><i class="fa fa-picture-o"></i> ' . __('My Uploads', 'cinnamon') . '</a></li>';
                    }

                    $display .= '<li><a href="#"><i class="fa fa-file-text-o"></i> ' . __('About', 'cinnamon') . '</a></li>';

                    if(get_option('cinnamon_show_posts') == 1) {
                        $display .= '<li><a href="#"><i class="fa fa-tags"></i> ' . __('Articles', 'cinnamon') . '</a></li>';
                    }
                    if(get_option('cinnamon_show_comments') == 1) {
                        $display .= '<li><a href="#"><i class="fa fa-comments"></i> ' . __('Comments and Replies', 'cinnamon') . '</a></li>';
                    }
                    if(get_option('cinnamon_show_following') == 1) {
                        $display .= '<li><a href="#"><i class="fa fa-users"></i> ' . __('Following', 'cinnamon') . '</a></li>';
                    }
                    if(get_option('cinnamon_show_followers') == 1) {
                        $display .= '<li><a href="#"><i class="fa fa-users"></i> ' . __('Followers', 'cinnamon') . '</a></li>';
                    }
                $display .= '</ul>';
                $display .= '<div class="tab_content">';
                    if(get_option('cinnamon_show_uploads') == 1) {
                        if(get_option('cinnamon_image_size') != '')
                            $display .= '<div class="tabs_item">' . do_shortcode('[imagepress-show user="' . $author . '" sort="no" width="' . get_option('cinnamon_image_size') . '" height="' . get_option('cinnamon_image_size') . '"]') . '</div>';
                        else
                            $display .= '<div class="tabs_item">' . do_shortcode('[imagepress-show user="' . $author . '" sort="no"]') . '</div>';
                    }

                    $display .= '<div class="tabs_item">';
                        $display .= make_clickable(wpautop($hub_user_info->description));
                        if(!empty($hub_software))
                            $display .= '<p><b>' . __('Preferred Software', 'cinnamon') . ':</b> ' . $hub_software . '</p>';
                        if(!empty($hub_employer))
                            $display .= '<p><b>' . __('Employer', 'cinnamon') . ':</b> ' . $hub_employer . '</p>';
                        if(get_option('cinnamon_show_map') == 1 && get_the_author_meta('hub_location', $author) != '') {
                            $display .= '<p><img src="http://maps.googleapis.com/maps/api/staticmap?center=' . get_the_author_meta('hub_location', $author) . '&zoom=11&size=1280x150&maptype=terrain&sensor=false"></p>';
                        }
                        if(get_option('cinnamon_show_online') == 1)
                            $display .= '<p><i class="fa fa-clock-o"></i> ' . __('Last (seen) online on', 'cinnamon') . ' ' . get_cinnamon_login($author) . ' (' . human_time_diff(strtotime(get_cinnamon_login($author))) . ' ' . __('ago', 'cinnamon') . ')<br><small>' . __('Joined on', 'cinnamon') . ' ' . $hub_user_info->user_registered . '</small></p>';
                    $display .= '</div>';

                    if(get_option('cinnamon_show_posts') == 1) {
                        $display .= '<div class="tabs_item">';
                            $args = array(
                                'author' => $author,
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 10
                            );
                            $my_query = null;
                            $my_query = new WP_Query($args);
                            if($my_query->have_posts()) {
                                while($my_query->have_posts()) : $my_query->the_post();
                                    $display .= '<p><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
                                endwhile;
                            }
                            wp_reset_query();
                        $display .= '</div>';
                    }
                    if(get_option('cinnamon_show_comments') == 1) {
                        $display .= '<div class="tabs_item">';
                            $args = array(
                                'user_id' => $author,
                                'status' => 'approve',
                                'number' => 10
                            );
                            $comments = get_comments($args);
                            foreach($comments as $comment) :
                                $display .= '<p><time><small>' . $comment->comment_date . '</small></time><br><a href="' . get_permalink($comment->comment_post_ID) . '">' . $comment->comment_content . '</a></p>';
                            endforeach;
                        $display .= '</div>';
                    }
                    if(get_option('cinnamon_show_following') == 1) {
                        $display .= '<div class="tabs_item">';
                            $arr = pwuf_get_following($author);
                            if($arr) {
                                foreach($arr as $value) {
                                    $user = get_user_by('id', $value);
                                    $display .= '<a href="' . get_author_posts_url($value) . '">' . get_avatar($value, 90) . '</a> ';
                                }
                                unset($value);
                            }

                            $author_rewrite = get_user_by('slug', get_query_var('author_name'));
                            $author_rewrite = $author_rewrite->user_login;
                            $logged_in_user = wp_get_current_user();
                            if(is_user_logged_in() && $author_rewrite == $logged_in_user->user_login)
                                $display .= '<p>' . do_shortcode('[following_posts]') . '</p>';
                        $display .= '</div>';
                    }
                    if(get_option('cinnamon_show_followers') == 1) {
                        $display .= '<div class="tabs_item">';
                            $arr = pwuf_get_followers($author);
                            if($arr) {
                                foreach($arr as $value) {
                                    $user = get_user_by('id', $value);
                                    $display .= '<a href="' . get_author_posts_url($value) . '">' . get_avatar($value, 90) . '</a> ';
                                }
                                unset($value);
                            }
                        $display .= '</div>';
                    }
                $display .= '</div>
            </div>';
        $display .= '</div>';
    $display .= '</div>';

    return $display;
}

function cinnamon_profile_edit($atts, $content = null) {
	extract(shortcode_atts(array('author' => ''), $atts));

    global $wpdb, $current_user, $wp_roles;
    get_currentuserinfo();

    $error = array();    

    if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {
        if(!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
            if($_POST['pass1'] == $_POST['pass2'])
                wp_update_user(array('ID' => $current_user->ID, 'user_pass' => esc_attr($_POST['pass1'])));
            else
                $error[] = __('The passwords you entered do not match. Your password was not updated.', 'cinnamon');
        }

        if(!empty($_POST['url']))
            wp_update_user(array('ID' => $current_user->ID, 'user_url' => esc_url($_POST['url'])));
        if(!empty($_POST['email'])) {
            if(!is_email(esc_attr($_POST['email'])))
                $error[] = __('The email you entered is not valid. Please try again.', 'cinnamon');
            elseif(email_exists(esc_attr($_POST['email'])) != $current_user->id)
                $error[] = __('This email is already used by another user. Try a different one.', 'cinnamon');
            else {
                wp_update_user(array('ID' => $current_user->ID, 'user_email' => esc_attr($_POST['email'])));
            }
        }

        if(!empty($_POST['first-name']))
            update_user_meta($current_user->ID, 'first_name', esc_attr($_POST['first-name']));
        if(!empty($_POST['last-name']))
            update_user_meta($current_user->ID, 'last_name', esc_attr($_POST['last-name']));

        if(!empty($_POST['nickname'])) {
            update_user_meta($current_user->ID, 'nickname', esc_attr($_POST['nickname']));
            $wpdb->update($wpdb->users, array('display_name' => $_POST['nickname']), array('ID' => $current_user->ID), null, null);
        }

        if(!empty($_POST['description']))
            update_user_meta( $current_user->ID, 'description', esc_attr($_POST['description']));

        if(!empty($_POST['facebook']))
            update_user_meta($current_user->ID, 'facebook', esc_attr($_POST['facebook']));
        if(!empty($_POST['twitter']))
            update_user_meta($current_user->ID, 'twitter', esc_attr($_POST['twitter']));
        if(!empty($_POST['googleplus']))
            update_user_meta($current_user->ID, 'googleplus', esc_attr($_POST['googleplus']));
        if(!empty($_POST['behance']))
            update_user_meta($current_user->ID, 'behance', esc_attr($_POST['behance']));

        // avatar and cover upload
        if(!function_exists('wp_generate_attachment_metadata')) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
        if($_FILES) {
            foreach($_FILES as $file => $array) {
                if(!empty($_FILES[$file]['name'])) {
                    $file_id = media_handle_upload($file, 0);
                    if($file_id > 0) {
                        update_user_meta($current_user->ID, $file, $file_id);
                    }
                }
            }   
        }
        //

        if(count($error) == 0) {
            do_action('edit_user_profile_update', $current_user->ID);
            echo '<p class="message noir-success">' . __('Profile updated successfully!', 'cinnamon') . '</p>';
        }
    }
    ?>
    <div id="post-<?php the_ID(); ?>">
        <div class="entry-content entry cinnamon">
            <?php if(!is_user_logged_in()) : ?>
                    <p class="warning"><?php _e('You must be logged in to edit your profile.', 'cinnamon'); ?></p>
            <?php else : ?>
                <?php if(count($error) > 0) echo '<p class="error">' . implode('<br>', $error) . '</p>'; ?>
                <form method="post" id="adduser" action="<?php the_permalink(); ?>" enctype="multipart/form-data">
                    <table class="form-table">
                        <tr>
                            <th><label for="first-name"><?php _e('First Name', 'cinnamon'); ?></label></th>
                            <td><input name="first-name" type="text" id="first-name" value="<?php the_author_meta('first_name', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="last-name"><?php _e('Last Name', 'cinnamon'); ?></label></th>
                            <td><input name="last-name" type="text" id="last-name" value="<?php the_author_meta('last_name', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="nickname"><?php _e('Nickname', 'cinnamon'); ?></label></th>
                            <td><input name="nickname" type="text" id="nickname" value="<?php the_author_meta('nickname', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="email"><?php _e('E-mail *', 'cinnamon'); ?></label></th>
                            <td><input name="email" type="text" id="email" value="<?php the_author_meta('user_email', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="url"><?php _e('Website', 'cinnamon'); ?></label></th>
                            <td><input name="url" type="text" id="url" value="<?php the_author_meta('user_url', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="pass1"><?php _e('Password *', 'cinnamon'); ?></label></th>
                            <td><input name="pass1" type="password" id="pass1"></td>
                        </tr>
                        <tr>
                            <th><label for="pass2"><?php _e('Repeat Password *', 'cinnamon'); ?></label></th>
                            <td><input name="pass2" type="password" id="pass2"></td>
                        </tr>
                        <tr>
                            <th><label for="description"><?php _e('Biographical Information', 'cinnamon'); ?></label></th>
                            <td><textarea name="description" id="description" rows="4" style="width: 100%;"><?php the_author_meta('description', $current_user->ID); ?></textarea></td>
                        </tr>

                        <tr>
                            <th><label for="facebook"><i class="fa fa-facebook-square"></i> <?php _e('Facebook Profile URL', 'cinnamon'); ?></label></th>
                            <td><input name="facebook" type="url" id="facebook" value="<?php the_author_meta('facebook', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="twitter"><i class="fa fa-twitter-square"></i> <?php _e('Twitter Username', 'cinnamon'); ?></label></th>
                            <td><input name="twitter" type="text" id="twitter" value="<?php the_author_meta('twitter', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="googleplus"><i class="fa fa-google-plus-square"></i> <?php _e('Google+ Profile URL', 'cinnamon'); ?></label></th>
                            <td><input name="googleplus" type="url" id="googleplus" value="<?php the_author_meta('googleplus', $current_user->ID); ?>"></td>
                        </tr>
                        <tr>
                            <th><label for="behance"><i class="fa fa-behance-square"></i> <?php _e('Behance Username', 'cinnamon'); ?></label></th>
                            <td><input name="behance" type="text" id="behance" value="<?php the_author_meta('behance', $current_user->ID); ?>"></td>
                        </tr>
                    </table>
                    <?php do_action('edit_user_profile', $current_user); ?>
                    <hr>
                    <table class="form-table">
                        <tr>
                            <th></th>
                            <td>
                                <input name="updateuser" type="submit" class="button" id="updateuser" value="<?php _e('Update', 'cinnamon'); ?>">
                                <?php wp_nonce_field('update-user'); ?>
                                <input name="action" type="hidden" id="action" value="update-user">
                                <i class="fa fa-share-square"></i> <a href="<?php echo get_author_posts_url($current_user->ID); ?>"><?php _e('View and share your profile', 'cinnamon'); ?></a>
                            </td>
                        </tr>
                    </table>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/* CINNAMON CUSTOM PROFILE FIELDS */
function cinnamon_profile_fields($user) {
    $cinnamon_profile_title = get_option('cinnamon_profile_title');
    ?>
    <a name="cinnamon"></a>
    <div class="cinnamon-user-profile">
        <h3><?php echo $cinnamon_profile_title; ?></h3>
        <p><small><?php _e('Do not forget to set your Facebook, Twitter and Google+ accounts. Also, add a concise description (biographical info).', 'cinnamon'); ?></small></p>
        <table class="form-table">
            <tr>
                <th><label for="hub_location"><?php _e('Location', 'cinnamon'); ?></label></th>
                <td>
                    <input type="text" name="hub_location" id="hub_location" value="<?php echo esc_attr(get_the_author_meta('hub_location', $user->ID)); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="hub_employer"><?php _e('Employer', 'cinnamon'); ?></label></th>
                <td>
                    <input type="text" name="hub_employer" id="hub_employer" value="<?php echo esc_attr(get_the_author_meta('hub_employer', $user->ID)); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="hub_field"><?php _e('Occupational Field', 'cinnamon'); ?></label></th>
                <td>
                    <input type="text" name="hub_field" id="hub_field" value="<?php echo esc_attr(get_the_author_meta('hub_field', $user->ID)); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="hub_status"><?php _e('Status', 'cinnamon'); ?></label></th>
                <td>
                    <select name="hub_status" id="hub_status">
                        <option value="1"<?php if(get_the_author_meta('hub_status', $user->ID) == 1) echo ' selected'; ?>><?php _e('Available for hire', 'cinnamon'); ?></option>
                        <option value="0"<?php if(get_the_author_meta('hub_status', $user->ID) == 0) echo ' selected'; ?>><?php _e('Not available for hire', 'cinnamon'); ?></option>
                    </select>
                    <br><small><?php _e('Being available for hire will show an additional email icon on your profile, emails will be sent to the email address you have registered with the site.', 'cinnamon'); ?></small>
                </td>
            </tr>
            <tr>
                <th><label for="hub_software"><?php _e('Preferred Software', 'cinnamon'); ?></label></th>
                <td>
                    <input type="text" name="hub_software" id="hub_software" value="<?php echo esc_attr(get_the_author_meta('hub_software', $user->ID)); ?>" class="regular-text">
                    <br><small><?php _e('Preferred Software (e.g. Adobe Photoshop, Adobe Illustrator, Adobe InDesign, etc.)', 'cinnamon'); ?></small>
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>

            <?php if(current_user_can('manage_options')) { ?>
            <tr>
                <th><label for="user_title"><?php _e('Status', 'cinnamon'); ?></label></th>
                <td>
                    <select name="user_title" id="user_title">
                        <option selected><?php echo esc_attr(get_user_meta($user->ID, 'user_title', true)); ?></option>
                        <option>Verified</option>
                        <option>Regular</option>
                    </select>
                    <span class="description"><?php _e('Select user verification status', 'cinnamon'); ?></span>
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
            <?php } ?>

            <?php if(!is_admin()) { ?>
                <tr>
                    <th><?php _e('Cover/Avatar Preview', 'cinnamon'); ?></th>
                    <td>
                        <?php
                        $hcc = get_the_author_meta('hub_custom_cover', $user->ID);
                        $hca = get_the_author_meta('hub_custom_avatar', $user->ID);
                        $hcc = wp_get_attachment_url($hcc);
                        $hca = wp_get_attachment_url($hca);
                        ?>
                        <div class="cinnamon-cover-preview" style="background: url('<?php echo $hcc; ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"><img src="<?php echo $hca; ?>" alt=""></div>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th><label for="hub_custom_cover"><?php _e('Profile Cover Image', 'cinnamon'); ?></label></th>
                <td>
                    <input type="file" name="hub_custom_cover" id="hub_custom_cover" value="<?php echo get_the_author_meta('hub_custom_cover', $user->ID); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th><label for="hub_custom_avatar"><?php _e('Profile Avatar Image', 'cinnamon'); ?></label></th>
                <td>
                    <input type="file" name="hub_custom_avatar" id="hub_custom_avatar" value="<?php echo get_the_author_meta('hub_custom_avatar', $user->ID); ?>" class="regular-text">
                    <br><small><?php _e('Recommended cover size is 1080x300.', 'cinnamon'); ?></small>
                    <br><small><?php _e('Recommended avatar size is 240x240. If there is no custom avatar, your Gravatar will be used.', 'cinnamon'); ?></small>
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
        </table>
    </div>
<?php }

function save_cinnamon_profile_fields($user_id) {
	if(!current_user_can('edit_user', $user_id))
		return false;

	update_user_meta($user_id, 'hub_location', $_POST['hub_location']);
	update_user_meta($user_id, 'hub_employer', $_POST['hub_employer']);
	update_user_meta($user_id, 'hub_field', $_POST['hub_field']);
    update_user_meta($user_id, 'hub_status', $_POST['hub_status']);
    update_user_meta($user_id, 'hub_software', $_POST['hub_software']);

    if(current_user_can('manage_options', $user_id))
        update_user_meta($user_id, 'user_title', $_POST['user_title']);

    // awards
    if(current_user_can('manage_options', $user_id)) {
        $tax = get_taxonomy('award');
        $term = $_POST['award'];
        wp_set_object_terms($user_id, $term, 'award', false);
        clean_object_term_cache($user_id, 'award');
    }
}

function hub_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
    $custom_avatar = get_the_author_meta('hub_custom_avatar', $id_or_email);
    $custom_avatar = wp_get_attachment_url($custom_avatar);

    if($custom_avatar)
        $return = '<img src="' . $custom_avatar . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" class="avatar">';
    elseif($avatar)
        $return = $avatar;
    else
        $return = '<img src="' . $default . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" class="avatar">';

    return $return;
}

function cinnamon_awards() {
    $args = array(
        'hide_empty' => false,
        'pad_counts' => true
    );
    $terms = get_terms('award', $args);

    if(!empty($terms) && !is_wp_error($terms)) {
        foreach($terms as $term) {
            // get custom FontAwesome
            $t_ID = $term->term_id;
            $term_data = get_option("taxonomy_$t_ID");

            echo '<p><span class="cinnamon-award-list-item" title="' . $term->description . '">';
                if(isset($term_data['img']))
                    echo '<i class="fa ' . $term_data['img'] . '"></i> ';
                else
                    echo '<i class="fa fa-trophy"></i> ';
                echo $term->name . '</span> <span>' . $term->description . '<br><small>(' . $term->count . ' author(s) received this award)</small></span>';
            echo '</p>';
        }
    }
}

// verified user?
function user_title_field($user) {
    if(current_user_can('manage_options')) { ?>
        <h3><?php _e('User Verification', 'cinnamon'); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="user_title"><?php _e('Status', 'cinnamon'); ?></label></th>
                <td>
                    <select name="user_title" id="user_title">
                        <option selected><?php echo esc_attr(get_user_meta($user->ID, 'user_title', true)); ?></option>
                        <option>Verified</option>
                        <option>Regular</option>
                    </select>
                    <span class="description"><?php _e('Select user verification status', 'cinnamon'); ?></span>
                </td>
            </tr>
        </table>
<?php }
}
?>
