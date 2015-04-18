<?php
insert_thread($_POST);
get_admin_forum($_GET);
$user = wp_get_current_user();
$forumIndexID = get_option('forum_page_id');
$forumIndex = get_permalink($forumIndexID);
?>

<p><a href="<?php echo $forumIndex; ?>"><?php _e('Back to all forums', 'cinnamon'); ?></a></p>

<div class="forumHead"><?php the_title(); ?></div>

<div class="forum">
    <?php 
    $forumID = get_the_ID();
    if(isset($_GET['pageForum'])) {
        $paged = $_GET['pageForum'];
    }
    else {
        $paged = 1;
    }

    $args = array(
        'posts_per_page' => 15,
        'post_type' => get_option('cinnamon_forum_slug'),
        'post_parent' => $forumID,
        'orderby' => 'meta_value_num modified',
        'meta_key' => 'forum_post_priority',
        'paged' => $paged
    );
    $loop = new WP_Query($args);
    while($loop->have_posts()) : $loop->the_post();
        $icon = get_post_meta(get_the_ID(), 'forum_post_icon', true);

        if($icon == 'lock')
            $icon = '<i class="fa fa-fw fa-lock"></i>';
        if($icon == 'default')
            $icon = '<i class="fa fa-fw fa-comments"></i>';
        if($icon == 'toread')
            $icon = '<i class="fa fa-fw fa-exclamation-circle"></i>';
        if($icon == 'postit')
            $icon = '<i class="fa fa-fw fa-bolt"></i>';
        ?>
        <div class="post">
            <div class="large-8 columns">
                <h5 class="forumTitle"><?php echo $icon; ?> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><small>
                    <?php _e('Posted by', 'cinnamon'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'cinnamon'); ?> <?php echo get_the_date(); ?><br>
                    <?php 
                    $userRole = $user->roles[0];
                    if(!empty($userRole)) {
                        if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
                            if(get_post_meta(get_the_ID(), 'forum_post_icon', true) != 'lock') {
                                ?>
                                <a href="?action=lock&thread=<?php echo get_the_ID(); ?>"><?php _e('Lock topic', 'cinnamon'); ?></a> | 
                                <a href="?action=postit&thread=<?php echo get_the_ID(); ?>"><?php _e('Stick topic', 'cinnamon'); ?></a> | 
                                <a href="?action=toread&thread=<?php echo get_the_ID(); ?>"><?php _e('Prioritize topic', 'cinnamon'); ?></a> | 
                                <a href="?action=default&thread=<?php echo get_the_ID(); ?>"><?php _e('Make default', 'cinnamon'); ?></a> | 
                                <a href="?delete=1&thread=<?php echo get_the_ID(); ?>"><?php _e('Trash', 'cinnamon'); ?></a>
                                <?php
                            }
                            else {
                                ?>
                                <a href="?action=postit&thread=<?php echo get_the_ID(); ?>"><?php _e('Stick topic', 'cinnamon'); ?></a> | 
                                <a href="?action=toread&thread=<?php echo get_the_ID(); ?>"><?php _e('Prioritize topic', 'cinnamon'); ?></a> | 
                                <a href="?action=default&thread=<?php echo get_the_ID(); ?>"><?php _e('Make default', 'cinnamon'); ?></a> | 
                                <a href="?delete=1&thread=<?php echo get_the_ID(); ?>"><?php _e('Trash', 'cinnamon'); ?></a>
                                <?php
                            }
                        }
                    }
                    ?>
                </small></p>
            </div>

            <div class="large-4 columns"><small>
                <?php 
                $forumID = get_the_ID();
                $count = array('post_per_page' => 1, 'post_type' => get_option('cinnamon_forum_slug'), 'post_parent' => get_the_ID());
                $countAll = new WP_Query($count);
                $counts = $countAll->found_posts;
                ?>
                <?php echo $counts; ?> <?php _e('replies', 'cinnamon'); ?>
                <br>
                <?php 
                $argsC = array('post_per_page' => 1, 'post_type' => get_option('cinnamon_forum_slug'), 'post_parent' => get_the_ID());
                $argsCount = new WP_Query($argsC);
                if($argsCount->found_posts != 0) {
                    $pp = 0;
                    while($argsCount->have_posts()) : $argsCount->the_post();
                        if($pp>0) {}
                        else {
                            ?>
                            <span title="<?php _e('Latest reply', 'cinnamon'); ?>"><i class="fa fa-comments-o"></i> <?php the_date(); ?></span>
                            <br>
                            <i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
                            <?php
                            $pp++;
                        }
                    endwhile; 
                }
                else {
                    ?>
                    <span title="<?php _e('Latest reply', 'cinnamon'); ?>"><i class="fa fa-comments-o"></i> <?php echo get_the_date(); ?></span>
                    <br>
                    <i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
                    <?php
                }
                ?>
            </small></div>
        </div>
    <?php endwhile; ?>
    <br>

    <?php 
    $npage = 0;
    while($loop->max_num_pages > $npage) {
        $npage++;
        $nurl = '?pageForum=' . $npage;

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

    if($_GET['pageForum'] == $npage) {}
    else {
        $currentpage = $_GET['pageForum'];
        $nextpage = $currentpage + 1;
        $surl = '?pageForum=' . $nextpage;
        echo '<a href="' . $surl . '" class="page-numbers"> ' . __('Next', 'cinnamon') . '</a> ';
    }
    ?>
</div>
<br>

<?php 
if($user->ID == 0) {}
else {
    require_once(CINNAMON_PLUGIN_PATH . '/template/formthreads.php');	
}
?>
