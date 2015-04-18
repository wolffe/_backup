<?php 
add_action('admin_menu', 'cinnamon_thread_message');

function cinnamon_thread_message() {
    add_meta_box('post_info', 'Post Information', 'cinnamon_thread_info', 'cinnamon_thread', 'side', 'high');
}

function cinnamon_thread_info() {
    global $post;
    ?>
    <div>
        <p>
            <label for="thread_message"><?php _e('Message', 'cinnamon'); ?></label><br>
            <textarea name="thread_message" id="thread_message" style="width: 100%;" rows="8"><?php echo get_post_meta($post->ID, 'thread_message', true); ?></textarea>
        </p>
    </div>
	<?php
}

add_action('save_post', 'thread_message_save');

function thread_message_save($postID) {
    global $post;

    if($_POST['thread_message']) {
        update_post_meta($postID, 'thread_message', $_POST['thread_message']);
    }
}
?>
