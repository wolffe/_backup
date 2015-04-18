<div class="postbox">
    <h3>Cinnamon Dashboard (Help and general usage)</h3>
    <div class="inside">
        <p>Thank you for using Cinnamon Forums, a WordPress forum plugin with a light footprint, responsive structure and user accessibility.</p>
        <p>
            <small>You are using Cinnamon Forums plugin version <strong><?php echo CINNAMON_VERSION; ?></strong> | Dependencies: <a href="http://fontawesome.io/" rel="external">Font Awesome</a> 4.3.0</small>
        </p>

        <h4>Installation and shortcodes</h4>
        <p>When you first install the plugin, a new empty page - <b>Forums</b> - is created with the shortcode tag <code>[display-forum]</code> inside. Feel free to add a custom template to this page.</p>
        <p>If you want to use a different page for the forums, just place the <code>[display-forum]</code> shortcode in the desired page.</p>
    </div>

    <div class="inside">
        <?php
        if(isset($_POST['isCinnamonSubmit'])) {
            update_option('cinnamon_forum_ui', $_POST['cinnamon_forum_ui']);
            update_option('cinnamon_forum_slug', $_POST['cinnamon_forum_slug']);

			update_option('cinnamon_use_pure', $_POST['cinnamon_use_pure']);
            update_option('cinnamon_use_normalize', $_POST['cinnamon_use_normalize']);

            update_option('cinnamon_text_colour', $_POST['cinnamon_text_colour']);
            update_option('cinnamon_background_colour', $_POST['cinnamon_background_colour']);

            echo '<div class="updated"><p>Settings updated successfully!</p></div>';
        }
        ?>
        <form method="post" action="">
			<h2>General Settings</h2>
            <p>
                <input type="text" name="cinnamon_forum_slug" id="cinnamon_forum_slug" class="regular-text" value="<?php echo get_option('cinnamon_forum_slug'); ?>" placeholder="forum"> <label for="cinnamon_forum_slug">Forum slug</label>
                <br><small>Forum rewrite slug (default is <b>forum</b>). Resave your permalinks after changing this value.</small>
                <br><small>Use the forum slug conversion tool if you can't find your old threads and forums.</small>
            </p>
            <p>
                <select name="cinnamon_use_pure" id="cinnamon_use_pure">
                    <option value="0" <?php if(get_option('cinnamon_use_pure') == 0) echo 'selected'; ?>>Do not use Pure CSS</option>
                    <option value="1" <?php if(get_option('cinnamon_use_pure') == 1) echo 'selected'; ?>>Use Pure CSS</option>
                </select> <label for="cinnamon_use_pure">Use Pure CSS library</label>
                <br><small>Use Pure CSS library for buttons and forms</small>
            </p>
            <p>
                <select name="cinnamon_use_normalize" id="cinnamon_use_normalize">
                    <option value="0" <?php if(get_option('cinnamon_use_normalize') == 0) echo 'selected'; ?>>Do not use normalize.css</option>
                    <option value="1" <?php if(get_option('cinnamon_use_normalize') == 1) echo 'selected'; ?>>Use normalize.css</option>
                </select> <label for="cinnamon_use_normalize">Use normalize.css library</label>
                <br><small>Use normalize.css (3.0.2) library (optional)</small>
            </p>
            <p>
				<label for="cinnamon_forum_ui">Display custom UI for Cinnamon boards</label> 
                <select name="cinnamon_forum_ui" id="cinnamon_forum_ui">
                    <option value="<?php echo get_option('cinnamon_forum_ui'); ?>"><?php echo get_option('cinnamon_forum_ui'); ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <br><small>This option will display a custom taxonomy UI for the boards (for debug purposes)</small>
            </p>

			<h2>Colour Settings</h2>
            <p>
                <label for="cinnamon_text_colour">Text colour (accent)</label>
                <br><input type="text" name="cinnamon_text_colour" class="cinnamon_colorPicker" data-default-color="#000000" value="<?php echo get_option('cinnamon_text_colour'); ?>">
                <br><small>This is the text accent colour for certain text elements, titles and sections. Try to match your site's theme.</small>
            </p>
            <p>
                <label for="cinnamon_background_colour">Background colour</label>
                <br><input type="text" name="cinnamon_background_colour" class="cinnamon_colorPicker" data-default-color="#666666" value="<?php echo get_option('cinnamon_background_colour'); ?>">
                <br><small>This is the background colour of certain containers, stripes and boxes. Try to match your site's theme.</small>
            </p>
            <p>
                <input type="submit" name="isCinnamonSubmit" value="Save Changes" class="button-primary">
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
