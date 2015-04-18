<?php
/*
Plugin Name: Cinnamon Boards
Plugin URI: http://getbutterfly.com/wordpress-plugins/cinnamon-forum/
Description: Cinnamon Forum is a WordPress forum plugin with a light footprint, responsive structure and user accessibility. The forum uses custom post types and all information is structured as a forum (categories, forums and topics). It can easily be integrated into any theme without losing any of its functionality.
Version: 3.3
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/
License: GPL3

Cinnamon Forum
Copyright (C) 2012, 2013, 2014, 2015 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
error_reporting(0);

define('CINNAMON_VERSION', '3.3');
define('CINNAMON_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('CINNAMON_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));

// plugin localization
$plugin_dir = basename(dirname(__FILE__)); 
load_plugin_textdomain('cinnamon', false, $plugin_dir . '/languages');

register_activation_hook(__FILE__, 'cinnamon_activate');

add_action('admin_menu', 'cinnamon_construct');



function cinnamon_construct() {
    add_menu_page('Cinnamon Boards', 'Cinnamon Boards', 'activate_plugins', 'cinnamon_forum', 'cinnamon_forum');
    add_submenu_page('cinnamon_forum', 'Cinnamon Categories', 'Categories', 'activate_plugins', 'cinnamon_forum_category', 'cinnamon_forum');
    add_submenu_page('cinnamon_forum', 'Cinnamon Forums', 'Forums', 'activate_plugins', 'cinnamon_forum_forums', 'cinnamon_forum');
    add_submenu_page('cinnamon_forum', 'Cinnamon Topics', 'Topics', 'activate_plugins', 'cinnamon_forum_threads', 'cinnamon_forum');
    add_submenu_page('cinnamon_forum', 'Cinnamon Tools', 'Tools', 'activate_plugins', 'cinnamon_forum_tools', 'cinnamon_forum');
    add_submenu_page('cinnamon_forum', 'Cinnamon Help', 'Help', 'activate_plugins', 'cinnamon_forum_help', 'cinnamon_forum');
}

function cinnamon_forum() {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum.php');
}
function cinnamon_forum_category() {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum-category.php');
}
function cinnamon_forum_forums() {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum-forums.php');
}

$adminCapabilities = array(
    'read' => true,  
    'edit_posts' => true,
    'delete_posts' => true, 
    'create_users' => true,
    'edit_users' => true,
    'list_users' => true,
    'remove_users' => true,
    'promote_users' => true,
    'activate_plugins' => true
);
add_role('forum_administrator', 'Forum Administrator', $adminCapabilities);

$modoCapabilities = array(
    'read' => true,  
    'edit_posts' => true,
    'list_users' => true
);
add_role('forum_moderator', 'Forum Moderator', $modoCapabilities);



// core requires
require_once(CINNAMON_PLUGIN_PATH . '/core/class/cinnamonSettings.class.php');
require_once(CINNAMON_PLUGIN_PATH . '/core/class/cinnamonForum.class.php');

require_once(CINNAMON_PLUGIN_PATH . '/core/forumfunctions.php');

// begin shortcodes
function cinnamon_display_forum($atts, $content = null) {
    global $post;

    require_once(CINNAMON_PLUGIN_PATH . '/template/header.tpl.php');
    require_once(CINNAMON_PLUGIN_PATH . '/template/forum.tpl.php');
    require_once(CINNAMON_PLUGIN_PATH . '/template/footer.tpl.php');
}
function cinnamon_display_threads($atts, $content = null) {
    global $post;

    if(isset($post->post_parent) && !empty($post->post_parent)) {
        require_once(CINNAMON_PLUGIN_PATH . '/template/header.tpl.php');
        require_once(CINNAMON_PLUGIN_PATH . '/template/threads.tpl.php');
        require_once(CINNAMON_PLUGIN_PATH . '/template/footer.tpl.php');
    }
}
function cinnamon_display_thread($atts, $content = null) {
    global $post;

    if(isset($post->post_parent) && !empty($post->post_parent)) {
        require_once(CINNAMON_PLUGIN_PATH . '/template/header.tpl.php');
        require_once(CINNAMON_PLUGIN_PATH . '/template/thread.tpl.php');
        require_once(CINNAMON_PLUGIN_PATH . '/template/footer.tpl.php');
    }
}
function cinnamon_display_thread_response($atts, $content = null) {
    global $post;

    if(isset($post->post_parent) && !empty($post->post_parent)) {
        $parents = get_post_ancestors(get_the_ID());
        $parent = $parents[0];
        echo '<script>window.location = "' . get_permalink($parent) . '"</script>';
    }
}

add_shortcode('display-forum', 'cinnamon_display_forum');
add_shortcode('display-threads', 'cinnamon_display_threads');
add_shortcode('display-thread', 'cinnamon_display_thread');
add_shortcode('display-thread-response', 'cinnamon_display_thread_response');
// end shortcodes

require_once(CINNAMON_PLUGIN_PATH . '/core/types.php');
require_once(CINNAMON_PLUGIN_PATH . '/core/customfields.php');

require_once(CINNAMON_PLUGIN_PATH . '/core/ressources.php');
//

function cinnamon_activate() {
	add_option('cinnamon_forum_slug', 'forum');
	add_option('cinnamon_forum_ui', 'No');
	add_option('cinnamon_use_pure', 1);
	add_option('cinnamon_use_normalize', 0);
	add_option('cinnamon_text_colour', '#ffffff');
	add_option('cinnamon_background_colour', '#dd3333');

    $cinnamon = new cinnamonSettings;
    $cinnamon->cinnamonCreate();
}

add_action('admin_enqueue_scripts', 'cinnamon_enqueue_color_picker');
function cinnamon_enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('cinnamon-color-picker', plugins_url('js/cinnamon-functions.js', __FILE__), array('wp-color-picker'), false, true);
}
?>
