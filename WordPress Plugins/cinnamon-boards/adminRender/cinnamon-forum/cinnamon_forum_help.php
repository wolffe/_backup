<div class="postbox">
    <h3>Cinnamon Help Topics</h3>

	<div class="inside">
		<h2>I. How to create/rename your forums page</h2>
		<p>Upon initial activation, Cinnamon Boards creates a <b>Forums</b> page. In order to create a new page or rename the default one use the <code>[display-forum]</code> shortcode.</p>
		<p>The forums page can have any name (e.g. Boards, Discussion, Community) except <b>Forum</b>.</p>

		<h2>II. How to restrict search bots from crawling the root section of your forums</h2>
		<p>Add the following code to your <code>robots.txt</code> file:</p>
		<p>
			<code>User-agent: *</code><br>
			<code>Disallow: /<?php echo get_option('cinnamon_forum_slug'); ?>/$</code><br>
			<code>Disallow: /<?php echo get_option('cinnamon_forum_slug'); ?>$</code>
		</p>
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
