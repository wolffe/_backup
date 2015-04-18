<?php
if(isset($_GET['delete'])) {
    if($_GET['delete'] == 0) {
        ?>
        <div class="updated"><p>Topic deleted.</p></div>
        <?php
    }
    else if($_GET['delete'] == 1) {
        ?>
        <div class="updated"><p>Topic not deleted.</p></div>
        <?php
    }
}

if(isset($_GET['add'])) {
    if($_GET['add'] == 1) {
        ?>
        <div class="updated"><p>Topic added.</p></div>
        <?php
    }
    else if($_GET['add'] == 0) {
        ?>
        <div class="updated"><p>Topic not added.</p></div>
        <?php
    }
}

if(isset($_GET['edit'])) {
    if($_GET['edit'] == 1) {
        ?>
        <div class="updated"><p>Topic modified.</p></div>
        <?php
    }
    else if($_GET['edit'] == 0) {
        ?>
        <div class="update"><p>Topic not modified.</p></div>
        <?php
    }
}

if(isset($_GET['action'])) {
    if($_GET['action'] == 'edit' || $_GET['action'] == 'add') {
        if($_GET['action'] == 'edit') {
            $post = get_post( $_GET['id'], OBJECT );
            $post_icon = get_post_meta($_GET['id'], 'forum_post_icon', true);
            $thread_message = get_post_meta($_GET['id'], 'thread_message', true);
        }
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/thread.php');
	}
    else if($_GET['action'] == 'delete') {
        $urlAfterDelete = curPageURL();
        require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/forms/delete.php');
    }
}
else {
    require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/actions/index_forum_threads.php');
}
?>
