<?php $user = wp_get_current_user(); ?>

<div class="post" style="padding: 8px;">
	<div class="large-12 columns post">
        <h4 class="forumTitle"><?php _e('New topic', 'cinnamon'); ?></h4>

        <div class="contentthread">
            <form method="post" class="pure-form">
                <p>
                    <input type="text" name="post_title" id="post_title" placeholder="<?php _e('Topic title', 'cinnamon'); ?>" required> <label for="post_title"><?php _e('Topic title', 'cinnamon'); ?></label>
                </p>
                <?php
                $userRole = $user->roles[0];
                if(!empty($userRole)) {
                    if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
                        if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
                            ?>
                            <p>
                                <label for="post_icon"><?php _e('Topic type', 'cinnamon'); ?></label>
                                <select name="post_icon" id="post_icon">
                                    <option value="default" selected><?php _e('Default', 'cinnamon'); ?></option>
                                    <option value="postit"><?php _e('Sticky', 'cinnamon'); ?></option>
                                    <option value="lock"><?php _e('Locked', 'cinnamon'); ?></option>
                                    <option value="toread"><?php _e('Prioritized', 'cinnamon'); ?></option>
                                </select>
                            </p>
                            <?php
                        }
                    }
                }
                ?>
                <p>
                    <label for="thread_message"><?php _e('Message', 'cinnamon'); ?></label><br>
                    <!--<textarea name="thread_message" style="width: 100%;" rows="8" id="thread_message" required></textarea>-->
                    <?php
                    $settings = array(
                        'media_buttons' => false,
                        'teeny' => true,
                        'quicktags' => false,
                    );
                    wp_editor('', 'thread_message', $settings);
                    ?>
                </p>
                <p><input type="submit" value="<?php _e('Submit', 'cinnamon'); ?>" class="pure-button"></p>
            </form>
        </div>
    </div>
</div>
