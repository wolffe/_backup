<?php
class forum {
	public function addForumCategory(array $array) {
		global $wpdb;

		$menu_order = $array['menu_order'];
		$forum_type = 'category';
		$array['post_type'] = get_option('cinnamon_forum_slug');
		$array['comment_status'] = 'closed';

		//unset($array['menu_order']);
		unset($array['action']);

		$page_id = wp_insert_post($array, $wp_error);
		//update_post_meta($page_id, 'menu_order', $menu_order);
		update_post_meta($page_id, 'forum_type', $forum_type);

		unset($array);
	}

	public function updateForumCategory(array $array) {
		global $wpdb;

		$menu_order = $array['menu_order'];
		$array['post_type'] = get_option('cinnamon_forum_slug');

		//unset($array['menu_order']);
		unset($array['action']);

		$page_id = wp_update_post($array);
		//update_post_meta($page_id, 'menu_order', $menu_order);

		unset($array);
	}

	public function addForum(array $array) {
		global $wpdb;

		$menu_order = $array['menu_order'];
		$forum_type = get_option('cinnamon_forum_slug');
		$array['post_type'] = get_option('cinnamon_forum_slug');
		$array['post_content'] = '[display-threads]';
		$array['comment_status'] = 'closed';

		//unset($array['menu_order']);
		unset($array['action']);

		$page_id = wp_insert_post($array, $wp_error);
		//update_post_meta($page_id, 'menu_order', $menu_order);
		update_post_meta($page_id, 'forum_type', $forum_type);

		unset($array);
	}

	public function updateForum(array $array) {
		global $wpdb;

		$menu_order = $array['menu_order'];

		//unset($array['menu_order']);
		unset($array['action']);

		$page_id = wp_update_post($array);
		//update_post_meta($page_id, 'menu_order', $menu_order);

		unset($array);
	}

	public function addThread(array $array) {
		global $wpdb;

		$forum_type = 'thread';
		$user = wp_get_current_user();
		$thread_message = $array['thread_message'];

		if(!isset($array['post_icon'])) {
			$post_icon = 'default';
		}
		else {
			$post_icon = $array['post_icon'];
		}

		$array['post_type'] = get_option('cinnamon_forum_slug');
		$array['post_content'] = '[display-thread]';
		$array['post_status'] = 'publish';
		$array['post_author'] = $user->ID;
		$array['comment_status'] = 'closed';

		unset($array['action']);
		unset($array['thread_message']);
		unset($array['post_icon']);

		if($post_icon == 'postit') {
			$priority = 0;
		}
		else if($post_icon == 'toread') {
			$priority = 1;
		}
		else {
			$priority = 10;
		}

		$page_id = wp_insert_post($array, $wp_error);
		update_post_meta($page_id, 'thread_message', $thread_message);
		update_post_meta($page_id, 'forum_type', $forum_type);
		update_post_meta($page_id, 'forum_post_icon', $post_icon);
		update_post_meta($page_id, 'forum_post_priority', $priority);

		unset($array);
	}

	public function updateThread(array $array) {
		global $wpdb;

		$post_icon = $array['post_icon'];
		$thread_message = $array['thread_message'];

		$array['post_type'] = get_option('cinnamon_forum_slug');

		unset($array['action']);
		unset($array['post_icon']);
		unset($array['thread_message']);

		$page_id = wp_update_post($array);
		update_post_meta($page_id, 'thread_message', $thread_message);
		update_post_meta($page_id, 'forum_post_icon', $post_icon);

		unset($array);
	}

	public function addResponse(array $array) {
		global $wpdb;

		$forum_type = 'response';
		$thread_message = $array['thread_message'];
		$parent = $array['post_parent'];

		$array['post_type'] = get_option('cinnamon_forum_slug');
		$array['post_content'] = '[display-thread-response]';
		$array['post_author'] = $user->ID;
		$array['post_status'] = 'publish';
		$array['comment_status'] = 'closed';

		unset($array['action']);
		unset($array['thread_message']);

		$page_id = wp_insert_post($array, $wp_error);
		$updt1 = update_post_meta($page_id, 'thread_message', $thread_message);
		$updt2 = update_post_meta($page_id, 'forum_type', $forum_type);

		unset($array);
		unset($updt1);
		unset($updt2);
		unset($thread_message);
	}

	public function updateResponse(array $array) {
		global $wpdb;

		$thread_message = $array['thread_message'];
		$post_icon = $array['post_icon'];

		$array['post_type'] = get_option('cinnamon_forum_slug');

		unset($array['thread_message']);
		unset($array['post_icon']);

		$page_id = wp_update_post($array);
		update_post_meta($page_id, 'thread_message', $thread_message);
		update_post_meta($page_id, 'forum_post_icon', $post_icon);

		unset($array);
	}

	public function deleteForumAdmin($idthread) {
		$args = array('post_parent' => $idthread, 'post_type' => get_option('cinnamon_forum_slug'));
		$posts = get_posts($args);

		$array = array(
			'ID' => $idthread,
			'post_type' => get_option('cinnamon_forum_slug')
		);
		wp_delete_post($idthread, true);

		if(is_array($posts) && count($posts) > 0) {
			foreach($posts as $post) {
				$args2 = array('post_parent' => $post->ID, 'post_type' => get_option('cinnamon_forum_slug'));
				$posts2 = get_posts($args2);

				if(is_array($posts2) && count($posts2) > 0) {
					foreach($posts2 as $post2) {
						$args3 = array('post_parent' => $post2->ID, 'post_type' => get_option('cinnamon_forum_slug'));
						$posts3 = get_posts($args3);
						if(is_array($posts3) && count($posts3) > 0) {
							foreach($posts3 as $post3) {
								wp_delete_post($post3->ID, true);
							}
						}

						wp_delete_post($post2->ID, true);
					}
				}
				wp_delete_post($post->ID, true);
			}
		}
	}

	public function changeIcon($idthread, $post_icon) {
		update_post_meta($idthread, 'forum_post_icon', $post_icon);

		if($post_icon == 'postit') {
			update_post_meta($idthread, 'forum_post_priority', 0);
		}
		else if($post_icon == 'toread') {
			update_post_meta($idthread, 'forum_post_priority', 1);
		}
		else {
			update_post_meta($idthread, 'forum_post_priority', 10);
		}
	}

	public function deleteThread($idthread) {
		$array = array(
			'ID' => $idthread,
			'post_status' => 'inherit'
		);

		wp_trash_post($idthread);

		unset($array);

		$args = array( 
			'post_parent' => $idthread,
			'post_type' => get_option('cinnamon_forum_slug')
		);

		$posts = get_posts($args);

		if(is_array($posts) && count($posts) > 0) {
			foreach($posts as $post) {
				wp_trash_post($post->ID);
			}
		}
		unset($array);
	}

	public function deleteResponse($idthread) {
		$array = array(
			'ID' => $idthread,
			'post_status' => 'inherit'
		);

		wp_trash_post($idthread);

		unset($array);
	}
} 
?>
