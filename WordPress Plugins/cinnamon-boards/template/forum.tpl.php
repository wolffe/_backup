<?php
function cinnamon_count_terms($id) {
    $count = array('posts_per_page' => -1, 'post_type' => get_option('cinnamon_forum_slug'), 'post_parent' => $id);
    $countAll = new WP_Query($count);
    $counts = $countAll->found_posts;

    return $counts;
}

$args = array(
    'posts_per_page' => -1,
    'post_type' => get_option('cinnamon_forum_slug'),
    'post_parent' => 0,
	'orderby' => 'menu_order',
	'order' => 'ASC',
);
$loop = new WP_Query($args);
while($loop->have_posts()) : $loop->the_post();
    ?>
    <div class="forumHead"><?php the_title(); ?></div>

    <div class="forum">
        <?php
        $idForum = get_the_ID();
        $forums = array(
            'posts_per_page' => -1,
            'post_type' => get_option('cinnamon_forum_slug'),
            'post_parent' => $idForum,
			'orderby' => 'menu_order',
			'order' => 'ASC',
        );
        $forumLoop = new WP_Query($forums);
        while($forumLoop->have_posts()) : $forumLoop->the_post();
            ?>
            <div class="post">
                <h5 class="forumTitle"><i class="fa fa-fw fa-chevron-right"></i> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> (<?php echo cinnamon_count_terms(get_the_ID()); ?>)</h5>
				<p class="forumDescription"><small><?php echo get_the_excerpt(); ?></small></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="forumSeparation"></div>
<?php endwhile; ?>
