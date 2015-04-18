<div class="post" style="padding: 8px;">
    <div class="large-12 columns post">
        <h4 class="forumTitle"><?php _e('Edit', 'cinnamon'); ?></h4>

        <div class="contentthread">
            <form method="post" class="pure-form">
                <p>
                    <label for="thread_message"><?php _e('Message', 'cinnamon'); ?></label><br>
                    <!--<textarea name="thread_message" id="thread_message" style="width: 100%;" rows="8"><?php echo get_post_meta($_POST['ID'], 'thread_message', true); ?></textarea>-->
                    <?php
                    $settings = array(
                        'media_buttons' => false,
                        'teeny' => true,
                        'quicktags' => false,
                    );
                    wp_editor(get_post_meta($_POST['ID'], 'thread_message', true), 'thread_message', $settings);
                    ?>
                </p>
                <p>
					<input type="hidden" name="response" value="1">
					<input type="hidden" name="ID" value="<?php echo $_POST['ID']; ?>">
					<input type="hidden" name="post_author" value="<?php echo $_POST['post_author']; ?>">
					<input type="hidden" name="post_icon" value="<?php echo get_post_meta($_POST['ID'], 'forum_post_icon', true); ?>">
					<input type="submit" value="<?php _e('Submit', 'cinnamon'); ?>" class="pure-button">
                </p>
            </form>
        </div>
    </div>
</div>
