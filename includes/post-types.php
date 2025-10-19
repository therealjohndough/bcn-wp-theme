<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

/**
 * Register Custom Post Types
 */
function bcn_register_post_types() {
    // Register Community Event Post Type
    register_post_type(
        'bcn_event',
        array(
            'labels'              => array(
                'name'               => _x('Events', 'Post Type General Name', 'bcn-wp-theme'),
                'singular_name'      => _x('Event', 'Post Type Singular Name', 'bcn-wp-theme'),
                'menu_name'          => __('Events', 'bcn-wp-theme'),
                'name_admin_bar'     => __('Event', 'bcn-wp-theme'),
                'add_new_item'       => __('Add New Event', 'bcn-wp-theme'),
                'edit_item'          => __('Edit Event', 'bcn-wp-theme'),
                'view_item'          => __('View Event', 'bcn-wp-theme'),
                'all_items'          => __('All Events', 'bcn-wp-theme'),
                'search_items'       => __('Search Events', 'bcn-wp-theme'),
                'not_found'          => __('No events found.', 'bcn-wp-theme'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => 'events'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-calendar-alt',
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest'        => true,
        )
    );

    // Note: The `bcn_member` post type is registered in `includes/member-directory.php`
    // to keep member functionality encapsulated. Avoid double registration here.
}
add_action('init', 'bcn_register_post_types');

/**
 * Register Custom Taxonomies
 */
function bcn_register_taxonomies() {
    // Register Event Category Taxonomy
    register_taxonomy(
        'event_category',
        'bcn_event',
        array(
            'labels'            => array(
                'name'          => _x('Event Categories', 'taxonomy general name', 'bcn-wp-theme'),
                'singular_name' => _x('Event Category', 'taxonomy singular name', 'bcn-wp-theme'),
                'search_items'  => __('Search Event Categories', 'bcn-wp-theme'),
                'all_items'     => __('All Event Categories', 'bcn-wp-theme'),
                'edit_item'     => __('Edit Event Category', 'bcn-wp-theme'),
                'update_item'   => __('Update Event Category', 'bcn-wp-theme'),
                'add_new_item'  => __('Add New Event Category', 'bcn-wp-theme'),
                'new_item_name' => __('New Event Category Name', 'bcn-wp-theme'),
                'menu_name'     => __('Event Categories', 'bcn-wp-theme'),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'event-category'),
            'show_in_rest'      => true,
        )
    );
}
add_action('init', 'bcn_register_taxonomies');
