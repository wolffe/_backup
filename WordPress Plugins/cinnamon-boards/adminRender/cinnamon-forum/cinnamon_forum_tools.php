<div class="postbox">
    <h3>Cinnamon Tools</h3>

	<div class="inside">
        <?php
        if(isset($_POST['isCinnamonToolsSubmit'])) {
			global $wpdb;

			$cinnamon_forum_slug_old = $_POST['cinnamon_forum_slug_old'];
			$cinnamon_forum_slug_new = $_POST['cinnamon_forum_slug_new'];

			$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_type = '%s' WHERE post_type = '%s'", $cinnamon_forum_slug_new, $cinnamon_forum_slug_old));

            echo '<div class="updated"><p>Operation executed successfully!</p></div>';
        }
        ?>
        <form method="post" action="">
			<h2>Forum slug conversion</h2>
            <p>
                <input type="text" name="cinnamon_forum_slug_old" id="cinnamon_forum_slug_old" class="regular-text" placeholder="Old forum slug"> <label for="cinnamon_forum_slug_old">Old forum slug</label>
				<br>
                <input type="text" name="cinnamon_forum_slug_new" id="cinnamon_forum_slug_new" class="regular-text" placeholder="New forum slug" value="<?php echo get_option('cinnamon_forum_slug'); ?>"> <label for="cinnamon_forum_slug_new">New/current forum slug</label>
                <br><small>Use this tool to update your old forums, categories and topics.</small>
            </p>
			<p>
                <input type="submit" name="isCinnamonToolsSubmit" value="Convert" class="button-secondary">
            </p>
        </form>
    </div>
</div>

<div class="postbox">
    <h3>Forum Statistics</h3>
    <div class="inside">
        <p>
            Total members: <strong><?php $result = count_users(); echo $result['total_users']; ?></strong><br>
            Total categories, forums and topics: <strong><?php $result = wp_count_posts( 'forum' ); echo $result->publish; ?></strong>
        </p>

        <h4>Help and support</h4>
        <p>Check the <a href="http://getbutterfly.com/wordpress-plugins/cinnamon-forum/" rel="external">official web site</a> for news, updates and general help.</p>
    </div>
</div>
