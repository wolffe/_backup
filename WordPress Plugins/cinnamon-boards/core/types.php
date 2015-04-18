<?php
function register_cpt_forum() {
	$labels = array(
		'name'                => _x( 'Forums', 'Post Type General Name', 'cinnamon' ),
		'singular_name'       => _x( 'Forum', 'Post Type Singular Name', 'cinnamon' ),
		'menu_name'           => __( 'Cinnamon Boards', 'cinnamon' ),
		'name_admin_bar'      => __( 'Forum', 'cinnamon' ),
		'parent_item_colon'   => __( 'Parent Forum:', 'cinnamon' ),
		'all_items'           => __( 'All Forums', 'cinnamon' ),
		'add_new_item'        => __( 'Add New Forum', 'cinnamon' ),
		'add_new'             => __( 'Add New', 'cinnamon' ),
		'new_item'            => __( 'New Forum', 'cinnamon' ),
		'edit_item'           => __( 'Edit Forum', 'cinnamon' ),
		'update_item'         => __( 'Update Forum', 'cinnamon' ),
		'view_item'           => __( 'View Forum', 'cinnamon' ),
		'search_items'        => __( 'Search Forum', 'cinnamon' ),
		'not_found'           => __( 'Not found', 'cinnamon' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'cinnamon' ),
	);

	/**
	$rewrite = array(
		'slug'                => get_option('cinnamon_forum_slug'),
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	/**/

	if(get_option('cinnamon_forum_ui') == 'Yes') {
		$show = true;
	}
	if(get_option('cinnamon_forum_ui') == 'No') {
		$show = false;
	}

	$args = array(
		'label' => __(get_option('cinnamon_forum_slug'), 'cinnamon'),
		'description' => __('Hierarchical forum custom post type', 'cinnamon'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'author', 'custom-fields', 'page-attributes'),
		'taxonomies' => array('page-category'),
		'hierarchical' => true,
		'public' => true,
		'show_ui' => $show,
		'show_in_menu' => $show,
		'show_in_nav_menus' => $show,
		'show_in_admin_bar' => false,
		'menu_position' => 20,
		'menu_icon' => 'dashicons-megaphone',
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		//'rewrite' => $rewrite,
		'capability_type' => 'page'
	);

	register_post_type(get_option('cinnamon_forum_slug'), $args);
}

add_action('init', 'register_cpt_forum', 0);
?>
