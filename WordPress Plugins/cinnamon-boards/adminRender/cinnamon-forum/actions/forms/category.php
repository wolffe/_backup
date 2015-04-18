<?php
if(!empty($_POST)) {
    if(!empty($_POST['action'])) {
        $post = $_POST;
        $action = $post['action'];

        if($action == 'edit') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $categoryUpdate = new forum;
                $categoryUpdate->updateForumCategory($post);

                $post_title = $post['post_title'];
                $menu_order = $post['menu_order'];
                $post_status = $post['post_status'];
                $post_excerpt = $post['post_excerpt'];

                unset($post);
                unset($_POST);
                unset($categoryUpdate);
            }
            echo '<div class="updated"><p>Category changed.</p></div>';
        }
        else if($action == 'add') {
            $post_title = str_replace(' ', '', $post['post_title']);
            if(!empty($post_title)) {
                $categoryAdd = new forum;
                $categoryAdd->addForumCategory($post);

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
        <h3>Edit Category</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" placeholder="Category Title" class="regular-text" value="<?php echo $post_title; ?>"> <label for="post_title">Category Title</label></p>
                <p><input type="number" name="menu_order" id="menu_order" min="0" max="9999" placeholder="0" value="<?php echo $menu_order; ?>"> <label for="menu_order">Category Position/Order</label></p>
				<p>
                    <select name="post_status" id="post_status">
                        <option value="publish" <?php if($post_status == 'publish') echo 'selected'; ?>>Published</option>
                        <option value="pending" <?php if($post_status == 'pending') echo 'selected'; ?>>Pending</option>
                    </select> <label for="post_status">Initial Category Status</label>
                </p>
                <p><input type="text" name="post_excerpt" id="post_excerpt" placeholder="Category Description" class="regular-text"> <label for="post_excerpt" value="<?php echo $post_excerpt; ?>">Category Description</label></p>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="ID" value="<?php echo $_GET['id']; ?>">
                <input type="submit" class="button-primary" value="Save Changes">
            </form>
        </div>
    </div>
    <?php 
}
else if($_GET['action'] == 'add') {
    ?>
    <div class="postbox">
        <h3>Add New Category</h3>
        <div class="inside">
            <form method="post">
                <p><input type="text" name="post_title" id="post_title" placeholder="Category Title" class="regular-text"> <label for="post_title">Category Title</label></p>
                <p><input type="number" name="menu_order" id="menu_order" min="0" max="9999" placeholder="0"> <label for="menu_order">Category Position/Order</label></p>
                <p>
                    <select name="post_status" id="post_status">
                        <option value="publish" selected>Published</option>
                        <option value="pending">Pending</option>
                    </select> <label for="post_status">Initial Category Status</label>
                </p>
                <p><input type="text" name="post_excerpt" id="post_excerpt" placeholder="Category Description" class="regular-text"> <label for="post_excerpt">Category Description</label></p>
                <input type="hidden" name="action" value="add">
                <input type="submit" class="button-primary" value="Add New">
            </form>
        </div>
    </div>
    <?php 
}
?>
