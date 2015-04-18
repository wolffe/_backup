<?php
if(!empty($_POST)) {
    if(!empty($_POST['action'])) {
        $post = $_POST;
        $action = $post['action'];

        if($action == 'edit') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $forumUpdate = new forum;
                $forumUpdate->updateForum($post);

                $post_title = $post['post_title'];
                $menu_order = $post['menu_order'];
                $post_status = $post['post_status'];
                $post_excerpt = $post['post_excerpt'];
                $post_parent = $post['post_parent'];

                unset($post);
                unset($_POST);
                unset($categoryUpdate);
            }
            echo '<div class="updated"><p>Forum changed.</p></div>';
        }
        else if($action == 'add') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $forumAdd = new forum;
                $forumAdd->addForum($post);

                unset($post);
                unset($_POST);
                unset($categoryAdd);
            }
        }
    }
}

if($_GET['action'] == 'edit') {
    ?>
    <div class="postbox">
        <h3>Edit Forum</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" value="<?php echo $post_title; ?>" placeholder="Forum Title" class="regular-text"> <label for="post_title">Forum Title</label></p>
                <p><input type="number" name="menu_order" id="menu_order" min="0" max="9999" value="<?php echo $menu_order; ?>"> <label for="menu_order">Forum Position/Order</label></p>
                <p>
                    <select name="post_status" id="post_status">
                        <option value="publish" <?php if($post_status == 'publish') echo 'selected'; ?>>Published</option>
                        <option value="publish" <?php if($post_status == 'private') echo 'selected'; ?>>Private</option>
                        <option value="pending" <?php if($post_status == 'pending') echo 'selected'; ?>>Pending</option>
                    </select> <label for="post_status">Initial Forum Status</label>
                </p>
                <p>
                    <select name="post_parent" id="post_parent">
                        <?php
                        $args = array( 
                            'posts_per_page' => -1,
                            'post_type' => get_option('cinnamon_forum_slug'),
                            'orderby' => 'menu_order',
							'order' => 'ASC',
                            'post_parent' => 0
                        );
                        $loop = new WP_Query($args);
                        while($loop->have_posts()) : $loop->the_post();
                            ?>
                            <option value="<?php echo get_the_ID(); ?>" <?php if($post_parent == get_the_ID()) echo 'selected'; ?>><?php the_title(); ?></option>
                        <?php endwhile; ?>
                    </select> <label for="post_parent">Forum Parent</label>
                </p>
                <p><input type="text" name="post_excerpt" id="post_excerpt" placeholder="Forum Description" class="regular-text" value="<?php echo $post_excerpt; ?>"> <label for="post_excerpt">Message</label></p>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="ID" value="<?php echo $_GET['id']; ?>">
                <input type="submit" class="button-primary" value="Save Changes">
            </form>
        </div>
    </div>
    <?php
}
else if($_GET['action'] == 'add' && !isset($move)) {
    ?>
    <div class="postbox">
        <h3>Add New Forum</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" placeholder="Forum Title" class="regular-text"> <label for="post_title">Forum Title</label></p>
                <p><input type="number" name="menu_order" id="menu_order" min="0" max="9999" placeholder="0"> <label for="menu_order">Forum Position/Order</label></p>
                <p>
                    <select name="post_status" id="post_status">
                        <option value="publish" selected>Published</option>
                        <option value="private">Private</option>
                        <option value="pending">Pending</option>
                    </select> <label for="post_status">Initial Forum Status</label>
                </p>
                <p>
                    <select name="post_parent" id="post_parent">
                        <?php 
                        $args = array( 
                            'posts_per_page' => -1,
                            'post_type' => get_option('cinnamon_forum_slug'),
                            'orderby' => 'menu_order',
							'order' => 'ASC',
                            'post_parent' => 0
                        );
                        $loop = new WP_Query($args);
                        while($loop->have_posts()) : $loop->the_post();
                            ?>
                            <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                        <?php endwhile; ?>
                    </select> <label for="post_parent">Forum Parent</label>
                </p>
                <p><input type="text" name="post_excerpt" id="post_excerpt" placeholder="Forum Description" class="regular-text"> <label for="post_excerpt">Forum Description</label></p>
                <input type="hidden" name="action" value="add">
                <input type="submit" class="button-primary" value="Add New">
            </form>
        </div>
    </div>
    <?php 
}
?>
