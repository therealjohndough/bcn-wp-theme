<?php
/**
 * Admin UI improvements for BCN Theme
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

namespace BCN\Theme;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom columns to member list table
 *
 * @param array $columns Existing columns
 * @return array Modified columns
 */
function add_member_list_columns($columns) {
    // Insert after title column
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ('title' === $key) {
            $new_columns['membership_level'] = __('Membership Level', 'bcn-wp-theme');
            $new_columns['featured'] = __('Featured', 'bcn-wp-theme');
            $new_columns['website'] = __('Website', 'bcn-wp-theme');
        }
    }
    return $new_columns;
}
add_filter('manage_bcn_member_posts_columns', __NAMESPACE__ . '\\add_member_list_columns');

/**
 * Populate custom columns
 *
 * @param string $column Column name
 * @param int $post_id Post ID
 */
function populate_member_list_columns($column, $post_id) {
    switch ($column) {
        case 'membership_level':
            $terms = wp_get_post_terms($post_id, 'bcn_membership_level');
            if (!empty($terms) && !is_wp_error($terms)) {
                $term_names = array_map(function($term) {
                    return $term->name;
                }, $terms);
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '<span class="na">—</span>';
            }
            break;

        case 'featured':
            $featured = get_post_meta($post_id, 'bcn_member_featured', true);
            if ($featured) {
                echo '<span class="dashicons dashicons-star-filled" title="' . esc_attr__('Featured Member', 'bcn-wp-theme') . '"></span>';
            } else {
                echo '<span class="dashicons dashicons-star-empty" title="' . esc_attr__('Not Featured', 'bcn-wp-theme') . '"></span>';
            }
            break;

        case 'website':
            $website = get_post_meta($post_id, 'bcn_member_website', true);
            if ($website) {
                echo '<a href="' . esc_url($website) . '" target="_blank" rel="noopener">' . esc_html(parse_url($website, PHP_URL_HOST)) . '</a>';
            } else {
                echo '<span class="na">—</span>';
            }
            break;
    }
}
add_action('manage_bcn_member_posts_custom_column', __NAMESPACE__ . '\\populate_member_list_columns', 10, 2);

/**
 * Make columns sortable
 *
 * @param array $columns Sortable columns
 * @return array Modified columns
 */
function make_member_columns_sortable($columns) {
    $columns['membership_level'] = 'membership_level';
    $columns['featured'] = 'featured';
    return $columns;
}
add_filter('manage_edit-bcn_member_sortable_columns', __NAMESPACE__ . '\\make_member_columns_sortable');

/**
 * Handle custom column sorting
 *
 * @param WP_Query $query Query object
 */
function handle_member_column_sorting($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    switch ($orderby) {
        case 'membership_level':
            $query->set('meta_key', 'bcn_membership_level');
            $query->set('orderby', 'meta_value');
            break;

        case 'featured':
            $query->set('meta_key', 'bcn_member_featured');
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', __NAMESPACE__ . '\\handle_member_column_sorting');

/**
 * Add dropdown filter for membership level
 */
function add_membership_level_filter() {
    global $typenow;

    if ('bcn_member' === $typenow) {
        $taxonomy = 'bcn_membership_level';
        $selected = isset($_GET[$taxonomy]) ? sanitize_key($_GET[$taxonomy]) : '';
        $info_taxonomy = get_taxonomy($taxonomy);

        wp_dropdown_categories(array(
            'show_option_all' => sprintf(__('All %s', 'bcn-wp-theme'), $info_taxonomy->label),
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'selected' => $selected,
            'show_count' => true,
            'hide_empty' => false,
            'value_field' => 'slug',
        ));
    }
}
add_action('restrict_manage_posts', __NAMESPACE__ . '\\add_membership_level_filter');

/**
 * Add featured filter
 */
function add_featured_filter() {
    global $typenow;

    if ('bcn_member' === $typenow) {
        $selected = isset($_GET['featured_filter']) ? sanitize_key($_GET['featured_filter']) : '';
        ?>
        <select name="featured_filter">
            <option value=""><?php esc_html_e('All Members', 'bcn-wp-theme'); ?></option>
            <option value="featured" <?php selected($selected, 'featured'); ?>><?php esc_html_e('Featured Only', 'bcn-wp-theme'); ?></option>
            <option value="not_featured" <?php selected($selected, 'not_featured'); ?>><?php esc_html_e('Not Featured', 'bcn-wp-theme'); ?></option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', __NAMESPACE__ . '\\add_featured_filter');

/**
 * Handle featured filter
 *
 * @param WP_Query $query Query object
 */
function handle_featured_filter($query) {
    global $pagenow;

    if (!is_admin() || 'edit.php' !== $pagenow || !$query->is_main_query()) {
        return;
    }

    $featured_filter = isset($_GET['featured_filter']) ? sanitize_key($_GET['featured_filter']) : '';

    if ('featured' === $featured_filter) {
        $query->set('meta_query', array(
            array(
                'key' => 'bcn_member_featured',
                'value' => true,
                'compare' => '=',
            ),
        ));
    } elseif ('not_featured' === $featured_filter) {
        $query->set('meta_query', array(
            array(
                'key' => 'bcn_member_featured',
                'compare' => 'NOT EXISTS',
            ),
        ));
    }
}
add_action('pre_get_posts', __NAMESPACE__ . '\\handle_featured_filter');

/**
 * Add bulk actions for members
 *
 * @param array $bulk_actions Existing bulk actions
 * @return array Modified bulk actions
 */
function add_member_bulk_actions($bulk_actions) {
    $bulk_actions['mark_featured'] = __('Mark as Featured', 'bcn-wp-theme');
    $bulk_actions['unmark_featured'] = __('Unmark as Featured', 'bcn-wp-theme');
    return $bulk_actions;
}
add_filter('bulk_actions-edit-bcn_member', __NAMESPACE__ . '\\add_member_bulk_actions');

/**
 * Handle bulk actions
 *
 * @param string $redirect_to Redirect URL
 * @param string $doaction Action being performed
 * @param array $post_ids Post IDs
 * @return string Modified redirect URL
 */
function handle_member_bulk_actions($redirect_to, $doaction, $post_ids) {
    if ('mark_featured' === $doaction) {
        foreach ($post_ids as $post_id) {
            update_post_meta($post_id, 'bcn_member_featured', true);
        }
        $redirect_to = add_query_arg('bulk_marked_featured', count($post_ids), $redirect_to);
    } elseif ('unmark_featured' === $doaction) {
        foreach ($post_ids as $post_id) {
            delete_post_meta($post_id, 'bcn_member_featured');
        }
        $redirect_to = add_query_arg('bulk_unmarked_featured', count($post_ids), $redirect_to);
    }

    return $redirect_to;
}
add_filter('handle_bulk_actions-edit-bcn_member', __NAMESPACE__ . '\\handle_member_bulk_actions', 10, 3);

/**
 * Display bulk action notices
 */
function display_bulk_action_notices() {
    if (!empty($_REQUEST['bulk_marked_featured'])) {
        $count = intval($_REQUEST['bulk_marked_featured']);
        printf(
            '<div id="message" class="updated notice is-dismissible"><p>' .
            _n(
                '%s member marked as featured.',
                '%s members marked as featured.',
                $count,
                'bcn-wp-theme'
            ) . '</p></div>',
            $count
        );
    }

    if (!empty($_REQUEST['bulk_unmarked_featured'])) {
        $count = intval($_REQUEST['bulk_unmarked_featured']);
        printf(
            '<div id="message" class="updated notice is-dismissible"><p>' .
            _n(
                '%s member unmarked as featured.',
                '%s members unmarked as featured.',
                $count,
                'bcn-wp-theme'
            ) . '</p></div>',
            $count
        );
    }
}
add_action('admin_notices', __NAMESPACE__ . '\\display_bulk_action_notices');