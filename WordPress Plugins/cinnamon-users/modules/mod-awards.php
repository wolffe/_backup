<?php
function my_register_user_taxonomy() {
    register_taxonomy(
        'award',
        'user',
        array(
            'public' => true,
            'labels' => array(
                'name' => __('Awards', 'cinnamon'),
                'singular_name' => __('Award', 'cinnamon'),
                'menu_name' => __('Awards', 'cinnamon'),
                'search_items' => __('Search Awards', 'cinnamon'),
                'popular_items' => __('Popular Awards', 'cinnamon'),
                'all_items' => __('All Awards', 'cinnamon'),
                'edit_item' => __('Edit Award', 'cinnamon'),
                'update_item' => __('Update Award', 'cinnamon'),
                'add_new_item' => __('Add New Award', 'cinnamon'),
                'new_item_name' => __('New Award Name', 'cinnamon'),
                'separate_items_with_commas' => __('Separate awards with commas', 'cinnamon'),
                'add_or_remove_items' => __('Add or remove awards', 'cinnamon'),
                'choose_from_most_used' => __('Choose from the most popular awards', 'cinnamon'),
            ),
            'rewrite' => array(
                'with_front' => true,
                'slug' => get_option('cinnamon_author_slug') . '/award' // Use 'author' (default WP user slug).
            ),
            'capabilities' => array(
                'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
                'edit_terms'   => 'edit_users',
                'delete_terms' => 'edit_users',
                'assign_terms' => 'edit_users',
            ),
            'update_count_callback' => 'my_update_award_count' // Use a custom function to update the count.
        )
    );
}

function my_update_award_count($terms, $taxonomy) {
	global $wpdb;

	foreach((array)$terms as $term) {
		$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term));

		do_action('edit_term_taxonomy', $term, $taxonomy);
		$wpdb->update($wpdb->term_taxonomy, compact('count'), array('term_taxonomy_id' => $term));
		do_action('edited_term_taxonomy', $term, $taxonomy);
	}
}

add_filter('parent_file', 'fix_user_tax_page');
function fix_user_tax_page($parent_file = '') {
    global $pagenow;
	if(!empty($_GET['taxonomy']) && $_GET['taxonomy'] == 'award' && $pagenow == 'edit-tags.php')
        $parent_file = 'users.php';
    return $parent_file;
}

add_action('admin_menu', 'my_add_award_admin_page');
function my_add_award_admin_page() {
    $tax = get_taxonomy('award');
    add_users_page(esc_attr($tax->labels->menu_name), esc_attr($tax->labels->menu_name), $tax->cap->manage_terms, 'edit-tags.php?taxonomy=' . $tax->name);
}

add_filter('manage_edit-award_columns', 'my_manage_award_user_column');
function my_manage_award_user_column($columns) {
    unset($columns['posts']);
	$columns['users'] = __('Users', 'cinnamon');
	return $columns;
}

add_action('manage_award_custom_column', 'my_manage_award_column', 10, 3);
function my_manage_award_column($display, $column, $term_id) {
    if('users' === $column) {
		$term = get_term($term_id, 'award');
		echo $term->count;
	}
}

add_action('show_user_profile', 'my_edit_user_award_section');
add_action('edit_user_profile', 'my_edit_user_award_section');

function my_edit_user_award_section($user) {
	$tax = get_taxonomy('award');
    if(!current_user_can($tax->cap->assign_terms))
		return;

	$terms = get_terms('award', array('hide_empty' => false)); ?>

	<h3><?php _e('Award', 'cinnamon'); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="award"><?php _e('Select Award', 'cinnamon'); ?></label></th>
			<td><?php
            if(!empty($terms)) {
				foreach($terms as $term) { ?>
					<input type="checkbox" name="award[]" id="award-<?php echo esc_attr($term->slug); ?>" value="<?php echo esc_attr($term->slug); ?>" <?php checked(true, is_object_in_term($user->ID, 'award', $term)); ?> /> <label for="award-<?php echo esc_attr($term->slug); ?>"><?php echo $term->name; ?></label><br>
				<?php }
			}
			else {
				_e('There are no awards available.', 'cinnamon');
			}
			?></td>
		</tr>
	</table>
<?php }

function my_award_count_text($count) {
	return sprintf(_n('%s user', '%s users', $count), number_format_i18n($count));
}
add_action('init', 'my_register_user_taxonomy', 0);

function extra_edit_tax_fields($tag) {
    $t_id = $tag->term_id;
    $term_meta = get_option("taxonomy_$t_id"); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_Image_url"><?php _e('Award Icon', 'cinnamon'); ?></label></th>
        <td>
            <input type="text" name="term_meta[img]" id="term_meta[img]" value="<?php echo esc_attr($term_meta['img']) ? esc_attr($term_meta['img']) : ''; ?>">
            <p class="description"><?php _e('Enter the FontAwesome icon name (e.g. fa-trophy)', 'cinnamon'); ?></p>
        </td>
    </tr>
<?php
}
add_action('award_edit_form_fields', 'extra_edit_tax_fields', 10, 2);

function extra_add_tax_fields($tag) {
    $t_id = $tag->term_id;
    $term_meta = get_option("taxonomy_$t_id"); ?>
    <div class="form-field">
        <label for="cat_Image_url"><?php _e('Award Icon', 'cinnamon'); ?></label>
        <input type="text" name="term_meta[img]" id="term_meta[img]" value="<?php echo esc_attr($term_meta['img']) ? esc_attr($term_meta['img']) : ''; ?>">
        <p class="description"><?php _e('Enter the FontAwesome icon name (e.g. fa-trophy)', 'cinnamon'); ?></p>
    </div>
<?php
}
add_action('award_add_form_fields', 'extra_add_tax_fields', 10, 2);

function save_extra_taxonomy_fields($term_id) {
    if(isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach($cat_keys as $key) {
            if(isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option("taxonomy_$t_id", $term_meta);
    }
}
add_action('edited_award', 'save_extra_taxonomy_fields', 10, 2);
add_action('create_award', 'save_extra_taxonomy_fields', 10, 2);
?>
