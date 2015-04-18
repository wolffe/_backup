<div class="inner-sidebar">
	<div class="postbox">
		<h3><span><?php _e('Plugin Information', 'tycoon'); ?></span></h3>
		<div class="inside">
			<p><?php _e('This plugin allows users to subscribe and receive a newsletter containing the blog latest posts. The newsletter subscription system features a double opt-in system, with email confirmation. Administrators can also activate subscribers.', 'tycoon'); ?></p>
			<ul>
				<li>
					<?php
					// http://make.wordpress.org/core/2012/12/12/php-warning-missing-argument-2-for-wpdb-prepare/
					// %d for integers, %s for strings, %f for floats.
					global $wpdb;
					$members_table = $wpdb->prefix.'tycoon_members';
					$members_count = $wpdb->get_var("SELECT COUNT(*) FROM $members_table;");
					$active_count = $wpdb->get_var("SELECT COUNT(*) FROM $members_table WHERE state = 'active';");
					?>
					&bull; <strong><?php echo $members_count; ?></strong> <?php _e('total users in database', 'tycoon'); ?><br>
					&bull; <strong><?php echo $active_count; ?></strong> <?php _e('active users in database', 'tycoon'); ?>
				</li>
				<li><small><?php _e('You are using', 'tycoon');?> Newsletter Tycoon <strong><?php echo NEWSLETTER_TYCOON_VERSION; ?></strong></small></li>
			</ul>
		</div>
	</div>
	<div class="postbox">
		<h3><span><?php _e('Plugin Note', 'tycoon'); ?></span></h3>
		<div class="inside">
			<p><?php _e('Make sure you are allowing users to subscribe under the general settings.', 'tycoon'); ?></p>
			<p><?php _e('Make sure you are using either the widget <strong>or</strong> the shortcode, not both.', 'tycoon'); ?></p>
		</div>
	</div>
	<div class="postbox">
		<h3><span><?php _e('Plugin Help and Support', 'tycoon'); ?></span></h3>
		<div class="inside">
			<p><?php _e('Use the shortcode to place the subscription form anywhere you want. All shortcode parameters are mandatory (e.g. <code>[newsletter-tycoon title="This is the title" pitch="Subscribe now!" button="Go"]</code>).', 'tycoon'); ?>
			<p><?php _e('For more information and updates, visit the', 'tycoon'); ?> <a href="http://getbutterfly.com/" rel="external"><?php _e('official web site', 'tycoon'); ?></a></p>
		</div>
	</div>
</div>
