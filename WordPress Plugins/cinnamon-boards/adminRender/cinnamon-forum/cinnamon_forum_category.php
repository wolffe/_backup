<?php 
if(isset($_GET['delete'])) {
    if($_GET['delete'] == 0) {
        ?>
        <div class="updated"><p>Category deleted.</p></div>
        <?php
    }
    else if($_GET['delete'] == 1) {
        ?>
        <div class="updated"><p>Category not deleted.</p></div>
        <?php
    }
}

if(isset($_GET['add'])) {
    if($_GET['add'] == 0) {
        ?>
        <div class="updated"><p>Category added.</p></div>
        <?php
    }
    else if($_GET['add'] == 1) {
        ?>
        <div class="updated"><p>Category not added.</p></div>
        <?php
    }
}

if(isset($_GET['edit'])) {
    if($_GET['edit'] == 1) {
        ?>
        <div class="updated"><p>Category modified.</p></div>
        <?php
    }
    else if($_GET['edit'] == 0) {
        ?>
        <div class="updated"><p>Category not modified.</p></div>
        <?php
    }
}

if(isset($_GET['action'])) {
    if($_GET['action'] == 'edit' || $_GET['action'] == 'add') {
        if($_GET['action'] == 'edit') {
            $post = get_post( $_GET['id'], OBJECT );
            $menu_order = $post->menu_order;
            $post_title = $post->post_title;
            $post_excerpt = $post->post_excerpt;
            $post_status = $post->post_status;
        }
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/category.php');
    }
    else if($_GET['action'] == 'delete') {
        $urlAfterDelete = curPageURL();
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/delete.php');
    }
}
else {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/index_forum_category.php');
}
?>
