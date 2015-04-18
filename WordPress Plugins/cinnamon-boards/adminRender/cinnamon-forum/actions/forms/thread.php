<?php 
if(!empty($_POST)) {
    if(!empty($_POST['action'])) {
        $post = $_POST;
        $action = $post['action'];

        if($action == 'edit') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $forumUpdate = new forum;
                $forumUpdate->updateThread($post);

                $post_title = $post['post_title'];
                $menu_order = $post['menu_order'];
                $post_status = $post['post_status'];
                $thread_message = $post['thread_message'];
                $post_parent = $post['post_parent'];

                unset($post);
                unset($_POST);
                unset($categoryUpdate);
            }
            echo '<div class="updated"><p>Topic changed.</p></div>';
        }
        else if($action == 'add') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $forumAdd = new forum;
                $forumAdd->addThread($post);

                unset($post);
                unset($_POST);

                echo '<script>window.location="?page=cinnamon_forum_threads&add=1"</script>';
            }
        }
    }
}

if($_GET['action'] == 'edit') {
    ?>
    <div class="postbox">
        <h3>Edit Topic</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" placeholder="Topic Title" value="<?php echo $post->post_title; ?>" class="regular-text"> <label for="post_title">Topic Title</label></p>
                <p>
                    <select name="post_parent" id="post_parent">
                        <?php
                        $parent = get_post_ancestors($_GET['id']);
                        $parent = $parent[0];

                        $args = array(
                            'posts_per_page' => -1,
                            'post_type' => get_option('cinnamon_forum_slug'),
                            'orderby' => 'menu_order',
							'order' => 'ASC',
                            'meta_query' => array(array('key' => 'forum_type', 'value' => 'forum'))
                        );

                        $loop = new WP_Query($args);
                        while($loop->have_posts()) : $loop->the_post();
                            ?>
                            <option value="<?php echo get_the_ID(); ?>" <?php if($parent == get_the_ID()) echo 'selected'; ?>><?php the_title(); ?></option>
                        <?php endwhile; ?>
                    </select> <label for="post_parent">Forum</label>
                </p>
                <p>
                    <select name="post_icon" id="post_icon">
                        <option value="default" <?php if($post_icon == 'default') echo 'selected'; ?>>Default</option>
                        <option value="postit" <?php if($post_icon == 'postit') echo 'selected'; ?>>Sticky</option>
                        <option value="lock" <?php if($post_icon == 'lock') echo 'selected'; ?>>Locked</option>
                        <option value="toread" <?php if($post_icon == 'toread') echo 'selected'; ?>>Important</option>
                    </select> <label for="post_icon">Topic Type</label>
                </p>
                <p>
                    <label for="thread_message">Topic Content</label><br>
                    <textarea name="thread_message" id="thread_message" class="large-text" rows="10"><?php echo $thread_message; ?></textarea>
                </p>
                <input type="hidden" name="action" value="edit">
                <input type="submit" class="button-primary" value="Edit">
            </form>
        </div>
    </div>
    <?php 
}
else if($_GET['action'] == 'add') {
    ?>
    <div class="postbox">
        <h3>Add New Topic</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" placeholder="Topic Title" class="regular-text"> <label for="post_title">Topic Title</label></p>
                <p>
                    <select name="post_parent" id="post_parent">
                        <?php 
                        $args = array(
                            'posts_per_page' => -1,
                            'post_type' => get_option('cinnamon_forum_slug'),
                            'orderby' => 'menu_order',
							'order' => 'ASC',
                            'meta_query' => array(array('key' => 'forum_type', 'value' => 'forum'))
                        );
                        $loop = new WP_Query($args);
                        while($loop->have_posts()) : $loop->the_post();
                            ?>
                            <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                        <?php endwhile; ?>
                    </select> <label for="post_parent">Forum</label>
                </p>
                <p>
                    <select name="post_icon" id="post_icon">
                        <option value="default">Default</option>
                        <option value="postit">Sticky</option>
                        <option value="lock">Locked</option>
                        <option value="toread">Important</option>
                    </select> <label for="post_icon">Topic Type</label>
                </p>
                <p>
                    <label for="thread_message">Topic Content</label><br>
                    <textarea name="thread_message" id="thread_message" class="large-text" rows="10"></textarea>
                </p>
                <input type="hidden" name="action" value="add">
                <input type="submit" class="button-primary" value="Add New">
            </form>
        </div>
	</div>
    <?php 
}
?>
