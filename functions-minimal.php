<?php
/**
 * Minimal BCN Theme Functions for Testing
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function bcn_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bcn-wp-theme'),
        'footer'  => __('Footer Menu', 'bcn-wp-theme'),
    ));
}
add_action('after_setup_theme', 'bcn_theme_setup');

/**
 * Register Custom Post Types
 */
function bcn_register_post_types() {
    // Register Community Member Post Type
    register_post_type(
        'bcn_member',
        array(
            'labels'              => array(
                'name'               => _x('Members', 'Post Type General Name', 'bcn-wp-theme'),
                'singular_name'      => _x('Member', 'Post Type Singular Name', 'bcn-wp-theme'),
                'menu_name'          => __('Members', 'bcn-wp-theme'),
                'add_new_item'       => __('Add New Member', 'bcn-wp-theme'),
                'edit_item'          => __('Edit Member', 'bcn-wp-theme'),
                'view_item'          => __('View Member', 'bcn-wp-theme'),
                'all_items'          => __('All Members', 'bcn-wp-theme'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => 'members'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-groups',
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'        => true,
        )
    );
}
add_action('init', 'bcn_register_post_types');

/**
 * Register Custom Taxonomies
 */
function bcn_register_taxonomies() {
    // Register Membership Level Taxonomy
    register_taxonomy(
        'bcn_membership_level',
        'bcn_member',
        array(
            'labels'            => array(
                'name'          => _x('Membership Levels', 'taxonomy general name', 'bcn-wp-theme'),
                'singular_name' => _x('Membership Level', 'taxonomy singular name', 'bcn-wp-theme'),
                'menu_name'     => __('Membership Levels', 'bcn-wp-theme'),
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'membership'),
            'show_in_rest'      => true,
        )
    );
}
add_action('init', 'bcn_register_taxonomies');

/**
 * Create default membership levels
 */
function bcn_create_default_membership_levels() {
    $default_levels = array(
        'premier-member' => 'Premier Member',
        'pro-member' => 'Pro Member',
        'basic-member' => 'Basic Member'
    );

    foreach ($default_levels as $slug => $name) {
        if (!term_exists($slug, 'bcn_membership_level')) {
            wp_insert_term($name, 'bcn_membership_level', array('slug' => $slug));
        }
    }
}
add_action('init', 'bcn_create_default_membership_levels', 20);

/**
 * Admin notice for setup
 */
function bcn_admin_setup_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    echo '<div class="notice notice-info is-dismissible">';
    echo '<p><strong>BCN Theme:</strong> Minimal version loaded. Post types should be registered.</p>';
    echo '</div>';
}
add_action('admin_notices', 'bcn_admin_setup_notice');