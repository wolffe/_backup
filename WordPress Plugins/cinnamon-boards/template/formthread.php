<div class="post" style="padding: 8px;">
	<div class="large-12 columns post">
		<h4 class="forumTitle"><?php _e('Reply', 'cinnamon'); ?></h4>
		<div class="contentthread">
			<form method="post" class="pure-form">
				<p>
					<label for="thread_message"><?php _e('Message', 'cinnamon'); ?></label><br>
					<?php
					$settings = array('media_buttons' => false, 'teeny' => true, 'quicktags' => false);
					wp_editor('', 'thread_message', $settings);
					?>
				</p>
				<p><input type="submit" value="<?php _e('Reply', 'cinnamon'); ?>" class="pure-button"></p>
			</form>
		</div>
	</div>
</div>
