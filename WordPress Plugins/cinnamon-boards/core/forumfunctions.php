<?php
function rs_count_user_posts($userid, $post_type = 'post') {
	if(empty($userid))
		return false;

	$args = array(
		'post_type' => $post_type,
		'author' => $userid
	);

	$the_query = new WP_Query($args);
	$user_post_count = $the_query->found_posts;

	return $user_post_count;
}

function insert_thread($post) {
	if(!empty($post)) {
		$title = str_replace(' ', '', $post['post_title']);

		$title = $post['post_title'];
		$title = strip_tags($title);
		$title = str_replace('&nbsp;', '', $title);
		$title = str_replace(' ', '', $title);

		$text = $post['thread_message'];
		$text = strip_tags($text);
		$text = str_replace('&nbsp;', '', $text);
		$text = str_replace(' ', '', $text);

		if(!empty($title)) {
			if(!empty($text)) {
				$parentPost = get_the_ID();

				$post['post_parent'] = $parentPost;

				$thread = new forum;
				$thread->addThread($post);

				unset($post);
				unset($_POST);
				unset($thread);

				wp_redirect($_SERVER['REQUEST_URI']);
			}
		}
	}
}

function insert_response($post) {
	if(!empty($post)) {
		$text = $post['thread_message'];
		$text = strip_tags($_POST['thread_message']);
		$text = str_replace('&nbsp;', '', $text);
		$text = str_replace(' ', '', $text);

		if($text != '') {
			$parentPost = get_the_ID();

			$post['post_parent'] = $parentPost;

			$thread = new forum;
			$thread->addResponse($post);

			unset($post);
			unset($_POST);
			unset($thread);

			wp_update_post(array('ID' => get_the_ID()));

			wp_redirect($_SERVER['REQUEST_URI']);
		}
	}
}

function edit_response($post) {
	if(!empty($post)) {
		$text = $post['thread_message'];
		$text = strip_tags($_POST['thread_message']);
		$text = str_replace('&nbsp;', '', $text);
		$text = str_replace(' ', '', $text);

		if($text != '') {
			unset($post['response']);

			$thread = new forum;
			$thread->updateResponse($post);

			unset($post);
			unset($_POST);
			unset($thread);

			wp_update_post(array('ID' => get_the_ID()));

			wp_redirect($_SERVER['REQUEST_URI']);
		}
	}
}

function delete_response($id, $url) {
	$user = wp_get_current_user();
	$userRole = $user->roles[0];
	if(!empty($userRole)) {
		if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
			$thread = new forum;
			$thread->deleteResponse($id);
			unset($thread);
			wp_redirect($url);
		}
	}
}

function iftitle_forum($post) {
	if(!empty($post)) {
		if(isset($post['title'])) {
			$title = str_replace(' ', '', $post['title']);

			if(!empty($title)) {
				insert_forum_post($post);
			}
			else {
				return $posterror = 1;
			}
		}
		else {
			return $posterror = 1;
		}
	}
}

function get_admin_forum($get) {
    if(!empty($get)) {
        $count = count($get);

        if($count == 2) { 
            if($get['action']) {
                $user = $user->ID;
                $idthread = $get['thread'];
                $post_icon = $get['action'];

				$user = wp_get_current_user();
				$userRole = $user->roles[0];
				if(!empty($userRole)) {
					if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
						if(get_post_meta(get_the_ID(), 'forum_post_icon', true) != 'lock') {
							$thread = new forum;
							$thread->changeIcon($idthread, $post_icon);
							unset($thread);
						}
					}
				}
			}

			if($get['delete'] == 1) {
				$user = wp_get_current_user();
				$userRole = $user->roles[0];
				if(!empty($userRole)) {
					if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
						if(get_post_meta(get_the_ID(), 'forum_post_icon', true) != 'lock') {
							$idthread = $get['thread'];
							$thread = new forum;
							$thread->deleteThread($idthread);
							unset($thread);
						}
					}
				}
			}
		}
	}
}

function curPageURL() {
    $pageURL = 'http';

    if($_SERVER['HTTPS'] == 'on') {
        $pageURL .= 's';
    }
    $pageURL .= "://";

    if($_SERVER['SERVER_PORT'] != '80') {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
?>
