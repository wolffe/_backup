<?php  
if(!empty($_POST)) {
    if(!empty($_POST['response'])) {
        edit_response($_POST);
    }
    else {
        insert_response($_POST);
    }
}

if(isset($_GET['edit'])) {}

$user = wp_get_current_user();
$parents = get_post_ancestors(get_the_ID());
$parent = $parents[0];
$title = get_the_title();
$statut = get_post_meta(get_the_ID(), 'forum_post_icon', true);

if(isset($_GET)) {
    if($_GET['edit'] == true && !empty($_POST)) {
        require_once(CINNAMON_PLUGIN_PATH . '/template/editResponse.tpl.php');
    }
    else {
        ?>
        <p><a href="<?php echo get_permalink($parent); ?>"><?php _e('Back to all topics', 'cinnamon'); ?></a></p>

        <div class="forumHead"><?php the_title(); ?></div>
        <div class="forum">
            <?php if($_GET['pageForum'] < 1) { ?>
                <div class="underhead">[<a href="#<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">#</a>] <?php echo get_the_date(); ?></div>
                <div class="post thread">
                    <div class="large-3 columns author">
                        <b><?php the_author_posts_link(); ?></b>
                        <p><?php echo get_avatar(get_the_author_meta('ID'), 90); ?></p>

                        <?php $author_registered = get_the_author_meta('user_registered'); ?>
                        <small><?php _e('Joined:', 'cinnamon'); ?> <?php echo date(get_option('date_format'), strtotime($author_registered)); ?></small><br>
                        <small><?php _e('Posts:', 'cinnamon'); ?> <?php echo count_user_posts(get_the_author_meta('ID'), get_option('cinnamon_forum_slug')); ?></small>
                    </div>
                    <div class="large-9 columns post">
                        <div class="headtitle">
                            <h5 class="forumTitle"><?php echo $title; ?></h5>
                            <p class="forump"><?php echo get_the_date(); ?></p>
                        </div>
                        <div class="contentthread">
                            <p>
                                <?php echo wpautop(get_post_meta(get_the_ID(), 'thread_message', true)); ?>
                                <?php 
                                if(!empty($user)) {
                                    $userRole = $user->roles[0];
                                    if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
                                        ?>
                                        <br>
                                        <form action="?edit=true" method="post" class="pure-form">
                                            <p>
                                                <input type="hidden" name="ID" value="<?php echo get_the_ID(); ?>">
                                                <input type="hidden" name="post_author" value="<?php echo get_the_author_meta('ID'); ?>">
                                                <input type="submit" value="<?php _e('Edit', 'cinnamon'); ?>" class="pure-button">
                                            </p>
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php 
            }
            ?>

            <?php 
            if(isset($_GET['pageForum'])) {
                $paged = $_GET['pageForum'];
            }
            else {
                $paged = 1;
            }
            $args = array('posts_per_page' => 15, 'post_type' => get_option('cinnamon_forum_slug'), 'post_parent' => get_the_id(), 'orderby' =>'post_date', 'order'=>'ASC', 'paged' => $paged);
            $loop = new WP_Query($args);
            while($loop->have_posts()) : $loop->the_post();
                ?>
                <div class="underhead">[<a href="#<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">#</a>] <?php echo get_the_date(); ?></div>
                <div class="post thread">
                    <div class="large-3 columns author">
                        <b><?php the_author_posts_link(); ?></b>
                        <p><?php echo get_avatar(get_the_author_meta('ID'), 90); ?></p>
                        <?php $author_registered = get_the_author_meta('user_registered'); ?>
                        <small><?php _e('Joined:', 'cinnamon'); ?> <?php echo date(get_option('date_format'), strtotime($author_registered)); ?></small><br>
                        <small><?php _e('Posts:', 'cinnamon'); ?> <?php echo count_user_posts(get_the_author_meta('ID'), get_option('cinnamon_forum_slug')); ?></small>
                    </div>
                    <div class="large-9 columns post">
                        <div class="headtitle">
                            <h5 class="forumTitle"><?php echo $title; ?></h5>
							<p class="forump"><?php echo get_the_date(); ?></p>
                        </div>
                        <div class="contentthread">
                            <p><?php echo get_post_meta(get_the_ID(), 'thread_message', true); ?></p>
                            <?php 
                            if(!empty($user)) {
                                $userRole = $user->roles[0];
                                if($userRole == 'administrator' || $userRole == 'forum_administrator' || $userRole == 'forum_moderator') {
                                    ?>
                                    <br>
                                    <form action="?edit=true" method="post" class="pure-form">
                                        <p>
                                            <input type="hidden" name="ID" value="<?php echo get_the_ID(); ?>">
                                            <input type="hidden" name="post_author" value="<?php echo get_the_author_meta('ID'); ?>">
                                            <input type="submit" value="<?php _e('Edit', 'cinnamon'); ?>" class="pure-button">
                                        </p>
                                    </form>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <br>

            <?php 
            $npage = 0;
            while($loop->max_num_pages>$npage) {
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

            if($user->ID == 0 || $statut == 'lock') {}
            else {
                require_once(CINNAMON_PLUGIN_PATH . '/template/formthread.php');	
            }
        }
    }
    ?>
</div>
