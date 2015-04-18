            <div class="endforum">
                <div class="small-12 footer"><i class="fa fa-bar-chart-o"></i> <?php _e('Statistics', 'cinnamon'); ?></div>
                <div class="post">
                    <p>
                        <?php _e('Total members:', 'cinnamon'); ?> <?php $result = count_users(); echo $result['total_users']; ?><br>
                        <?php _e('Total posts:', 'cinnamon'); ?> <?php $result = wp_count_posts('forum'); echo $result->publish; ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
