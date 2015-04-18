<?php
class cinnamonSettings {
	function __construct() {}

	public function cinnamonCreate() {
		global $wpdb;

		$args = array('pagename' => 'forumc', 'post_type' => 'page');
		$query = new WP_Query($args);

		if($query->have_posts()) {
			while($query->have_posts()) : $query->the_post();
				$pageID = get_the_ID();

				$args = array(
					'ID' => $pageID,
					'post_status' => 'publish',
					'post_author' => $current_user->ID,
					'post_content' => '[display-forum]',
					'post_title' => 'Forums',
					'post_name' => 'forums',
					'menu_order' => 2
				);
				wp_update_post($args);

				$option = 'forum_page_id';
				update_option($option, $pageID);
			endwhile;
		}
		else {
			$current_user = wp_get_current_user();

			$args = array(
				'post_title' => 'Forums',
				'post_name' => 'forums',
				'post_content' => '[display-forum]',
				'post_status' => 'publish',
				'post_author' => $current_user->ID,
				'post_type' => 'page',
				'menu_order' => 2
			);

			$page_id = wp_insert_post($args, $wp_error);

			$option = 'forum_page_id';
			update_option($option, $page_id);
		}
	}
}
?>
