<?php
if(isset($_GET['delete'])) {
    if($_GET['delete'] == 0) {
        ?>
        <div class="updated"><p>Forum deleted.</p></div>
        <?php
    }
    else if($_GET['delete'] == 1) {
        ?>
        <div class="updated"><p>Forum not deleted.</p></div>
        <?php
    }
}

if(isset($_GET['add'])) {
    if($_GET['add'] == 0) {
        ?>
        <div class="updated"><p>Forum added.</p></div>
        <?php
    }
    else if($_GET['add'] == 1) {
        ?>
        <div class="updated"><p>Forum not added.</p></div>
        <?php
    }
}

if(isset($_GET['edit'])) {
    if($_GET['edit'] == 1) {
        ?>
        <div class="updated"><p>Forum modified.</p></div>
        <?php
    }
    else if($_GET['edit'] == 0) {
        ?>
        <div class="updated"><p>Forum not modified.</p></div>
        <?php
    }
}

if(isset($_GET['action'])) {
    if($_GET['action'] == 'edit' || $_GET['action'] == 'add') {
        if($_GET['action'] == 'edit') {
            $post = get_post($_GET['id'], OBJECT);
            $menu_order = $post->menu_order;
            $post_title = $post->post_title;
            $post_excerpt = $post->post_excerpt;
            $post_status = $post->post_status;
            $post_parent = $post->post_parent;
        }
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/forum.php');
    }
    else if($_GET['action'] == 'delete') {
        $urlAfterDelete = curPageURL();
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/delete.php');
    }
}
else {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/index_forum_forums.php');
}
?>
