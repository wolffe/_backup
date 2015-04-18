<table class="wp-list-table widefat posts">
    <thead>
        <tr>
            <th class="check-column"></th>
            <th>Title</th>
            <th>Position/Order</th>
            <th>Child Forums</th>
            <th>Date</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th class="check-column"></th>
            <th>Title</th>
            <th>Position/Order</th>
            <th>Child Forums</th>
            <th>Date</th>
        </tr>
    </tfoot>
    <tbody id="the-list">
        <?php 
        $tabletr = 0;
        $forumUrl = get_option('forum_page_id'); 
        $forumUrl = get_permalink($forumUrl);
        if(isset($_GET['pageForum'])) {
            $paged = $_GET['pageForum'];
        }
        else {
            $paged = 1;
        }
        $args = array(
            'posts_per_page' => -1,
            'post_type' => get_option('cinnamon_forum_slug'),
            'orderby' => 'menu_order',
			'order' => 'ASC',
            'post_parent' => 0,
            'paged' => $paged
        );

        $loop = new WP_Query($args);
        while($loop->have_posts()) : $loop->the_post();
            $tabletr++;
            $tabletrfd = $tabletr%2;
            if($tabletrfd == 0) {
                $table = true;
            }
            ?>
            <tr class="type-post status-publish format-standard hentry category-uncategorized alternate iedit author-self" <?php if($table) { ?> style="background-color:#f6f6f6" <?php } ?>>
                <th class="check-column"></th>
                <td class="post-title page-title column-title">
                    <a href="" class="rowtitle"><strong><a href="?page=cinnamon_forum_category&action=edit&id=<?php echo get_the_ID(); ?>"><?php the_title(); ?></a></strong></a>
                    <div class="row-actions">
                        <span class="edit"><a href="?page=cinnamon_forum_category&action=edit&id=<?php echo get_the_ID(); ?>">Edit</a> | </span>
                        <span class="trash"><a href="?page=cinnamon_forum_category&action=delete&id=<?php echo get_the_ID(); ?>" class="submitdelete">Trash</a> | </span>
                        <span class="view"><a href="<?php echo $forumUrl ?>" target="_blank">View</a></span>
                        <span class=""></span>
                    </div>
                </td>
                <td class="post-title page-title column-title">
                    <?php global $post; echo $post->menu_order; ?>
                </td>
                <td class="post-title page-title column-title">
                    <?php 
                    $count = array('post_per_page' => -1, 'post_type' => 'forum', 'post_parent' => get_the_ID());
                    $countAll = new WP_Query($count);
                    $counts = $countAll->found_posts;
                    ?>
                    <?php echo $counts; ?>
                </td>
                <td class="post-title page-title column-title">
                    <?php echo get_the_date(); ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<br>

<?php 
$npage = 0;
while($loop->max_num_pages>$npage) {
    $npage++;
    $nurl = "?page=cinnamon_forum_category&pageForum=" . $npage;

    if($_GET['pageForum'] == $npage) {
        echo '<span class="page-numbers current">' . $npage . '</span> ';
    }
    else if(!isset($_GET['pageForum']) && $npage == 1) {
        echo '<span class="page-numbers current">' . $npage . '</span> ';
    }
    else {
        echo '<a href="' . $nurl . '" class="page-numbers">' . $npage . '</a> ';
    }
}

if($_GET['pageForum'] == $npage) {
}
else {
    $currentpage = $_GET['pageForum'];
    $nextpage = $currentpage + 1;
    $surl = "?page=cinnamon_forum_category&pageForum=" . $nextpage;
    echo '<a href="' . $surl . '" class="page-numbers"> Next</a> ';
}
?>

<p><a href="?page=cinnamon_forum_category&action=add" class="button-primary">Add New Category</a></p>
