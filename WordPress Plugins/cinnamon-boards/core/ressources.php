<?php
function cinnamon_default() {
    wp_enqueue_style('cinnamon-default', CINNAMON_PLUGIN_URL . '/template/css/forum.css');
    wp_enqueue_style('fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

    if(get_option('cinnamon_use_pure') == 1) {
		// purecss.io // 0.6.0 // load as 'pure'
        wp_enqueue_style('pure', CINNAMON_PLUGIN_URL . '/template/css/pure.css');
	}
    if(get_option('cinnamon_use_normalize') == 1)
        wp_enqueue_style('normalize', CINNAMON_PLUGIN_URL . '/template/css/pure-normalize-min.css');
}
add_action('wp_enqueue_scripts', 'cinnamon_default');

function add_stylesheet_cinnamon() {
    wp_enqueue_style('cinnamon', CINNAMON_PLUGIN_URL . '/core/css/cinnamon.css');
}
add_action('admin_print_styles', 'add_stylesheet_cinnamon');
?>
