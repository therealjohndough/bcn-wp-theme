<?php
/**
 * Buffalo Cannabis Network Theme Functions
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function bcn_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true);

    // Add custom image sizes
    add_image_size('bcn-featured', 800, 450, true);
    add_image_size('bcn-thumbnail', 400, 300, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bcn-wp-theme'),
        'footer'  => __('Footer Menu', 'bcn-wp-theme'),
        'community' => __('Community Menu', 'bcn-wp-theme'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for align wide
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'bcn_theme_setup');

/**
 * Force theme setup on activation
 */
function bcn_force_theme_setup() {
    // Force post type and taxonomy registration
    bcn_register_post_types();
    bcn_register_taxonomies();
    
    // Import ACF field groups
    if (function_exists('bcn_import_acf_field_groups')) {
        bcn_import_acf_field_groups();
    }
    
    // Create default membership levels
    if (function_exists('bcn_create_default_membership_levels')) {
        bcn_create_default_membership_levels();
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('init', 'bcn_force_theme_setup', 20);

/**
 * Admin notice for theme setup
 */
function bcn_admin_setup_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if ACF is active
    if (!function_exists('acf_get_setting')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>BCN Theme:</strong> Advanced Custom Fields Pro is required. <a href="' . admin_url('plugin-install.php?s=advanced+custom+fields+pro&tab=search&type=term') . '">Install ACF Pro</a></p>';
        echo '</div>';
        return;
    }
    
    // Check if member post type exists
    if (!post_type_exists('bcn_member')) {
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p><strong>BCN Theme:</strong> Member post type not found. ';
        echo '<a href="' . admin_url('themes.php') . '">Reactivate the theme</a> or ';
        echo '<a href="' . admin_url('admin.php?action=bcn_force_setup') . '" class="button button-primary">Force Setup Now</a>';
        echo '</p></div>';
        return;
    }
    
    // Check if ACF field groups are imported
    $member_fields = acf_get_field_group('group_bcn_member_details');
    if (!$member_fields) {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p><strong>BCN Theme:</strong> <a href="' . admin_url('edit.php?post_type=acf-field-group&page=acf-tools&tab=import') . '">Import ACF field groups</a> for full functionality.</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'bcn_admin_setup_notice');

/**
 * Add admin action to force setup
 */
function bcn_add_admin_actions() {
    if (current_user_can('manage_options')) {
        add_action('admin_action_bcn_force_setup', 'bcn_handle_force_setup');
    }
}
add_action('admin_init', 'bcn_add_admin_actions');

function bcn_handle_force_setup() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    // Force register post types and taxonomies
    bcn_register_post_types();
    bcn_register_taxonomies();
    
    // Import ACF field groups
    if (function_exists('bcn_import_acf_field_groups')) {
        bcn_import_acf_field_groups();
    }
    
    // Create default membership levels
    if (function_exists('bcn_create_default_membership_levels')) {
        bcn_create_default_membership_levels();
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Redirect back with success message
    wp_redirect(admin_url('edit.php?post_type=bcn_member&bcn_setup=success'));
    exit;
}

/**
 * Show setup success message
 */
function bcn_show_setup_success() {
    if (isset($_GET['bcn_setup']) && $_GET['bcn_setup'] === 'success') {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>BCN Theme:</strong> Setup completed successfully! Post types and taxonomies have been registered.</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'bcn_show_setup_success');

/**
 * Set the content width in pixels
 */
function bcn_content_width() {
    $GLOBALS['content_width'] = apply_filters('bcn_content_width', 1200);
}
add_action('after_setup_theme', 'bcn_content_width', 0);

/**
 * Register widget areas
 */
function bcn_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'bcn-wp-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'bcn-wp-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'bcn-wp-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'bcn-wp-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Community Widget Area', 'bcn-wp-theme'),
        'id'            => 'community-1',
        'description'   => __('Add widgets here for community features.', 'bcn-wp-theme'),
        'before_widget' => '<div id="%1$s" class="community-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'bcn_widgets_init');

/**
 * Enqueue scripts and styles
 */
function bcn_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('bcn-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue custom scripts
    wp_enqueue_script('bcn-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true);
    wp_enqueue_script('bcn-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Enqueue enhanced member cards assets
    if (is_post_type_archive('bcn_member') || is_singular('bcn_member')) {
        wp_enqueue_style('bcn-member-cards-enhanced', get_template_directory_uri() . '/assets/css/member-cards-enhanced.css', array(), '1.0.0');
        wp_enqueue_style('bcn-member-archive-enhanced', get_template_directory_uri() . '/assets/css/member-archive-enhanced.css', array('bcn-member-cards-enhanced'), '1.0.0');
        wp_enqueue_script('bcn-member-archive-enhanced', get_template_directory_uri() . '/assets/js/member-archive-enhanced.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('bcn-member-cards-enhanced', get_template_directory_uri() . '/assets/js/member-cards-enhanced.js', array('jquery'), '1.0.0', true);
    }

    // Add inline script for smooth scroll
    wp_add_inline_script('bcn-main', 'var bcnTheme = ' . json_encode(array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bcn-nonce'),
    )), 'before');

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bcn_scripts');

// Load BCN pattern styles
add_action('wp_enqueue_scripts', function() {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('bcn-patterns', get_template_directory_uri() . '/assets/css/patterns.css', [], $version);
});

/**
 * Custom template tags for this theme
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require get_template_directory() . '/includes/template-functions.php';

/**
 * Customizer additions
 */
require get_template_directory() . '/includes/customizer.php';

// Load pattern registrations
require_once get_template_directory() . '/includes/patterns.php';

/**
 * Member directory features
 */
require get_template_directory() . '/includes/member-directory.php';

/**
 * Custom post types and taxonomies
 */
require get_template_directory() . '/includes/post-types.php';

/**
 * Community features
 */
require get_template_directory() . '/includes/community-features.php';

/**
 * Member experience features
 */
require get_template_directory() . '/includes/member-experience.php';

/**
 * Add custom body classes
 */
function bcn_body_classes($classes) {
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }

    // Add class for single posts
    if (is_singular()) {
        $classes[] = 'singular';
    }

    return $classes;
}
add_filter('body_class', 'bcn_body_classes');

/**
 * Add excerpt length filter
 */
function bcn_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'bcn_excerpt_length');

/**
 * Add excerpt more filter
 */
function bcn_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'bcn_excerpt_more');

/**
 * Enqueue scripts and styles
 */
function bcn_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style('bcn-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    
    // Member archive styles
    if (is_post_type_archive('bcn_member') || is_page_template('page-members.php')) {
        wp_enqueue_style('bcn-member-archive', get_template_directory_uri() . '/assets/css/member-archive.css', array('bcn-style'), wp_get_theme()->get('Version'));
        wp_enqueue_style('bcn-member-logo-marquee', get_template_directory_uri() . '/assets/css/member-logo-marquee.css', array('bcn-style'), wp_get_theme()->get('Version'));
        wp_enqueue_script('bcn-member-archive', get_template_directory_uri() . '/assets/js/member-archive.js', array('jquery'), wp_get_theme()->get('Version'), true);
    }
    
    // Member registration styles
    if (is_page() && has_shortcode(get_post()->post_content, 'member_registration_form')) {
        wp_enqueue_style('bcn-member-registration', get_template_directory_uri() . '/assets/css/member-registration.css', array('bcn-style'), wp_get_theme()->get('Version'));
    }
    
    // Marquee styles for any page with marquee shortcodes
    if (is_page() && (has_shortcode(get_post()->post_content, 'premier_member_marquee') || 
                     has_shortcode(get_post()->post_content, 'pro_member_marquee') || 
                     has_shortcode(get_post()->post_content, 'member_marquees'))) {
        wp_enqueue_style('bcn-member-logo-marquee', get_template_directory_uri() . '/assets/css/member-logo-marquee.css', array('bcn-style'), wp_get_theme()->get('Version'));
    }
    
    // Enhanced member cards
    if (is_singular('bcn_member') || is_post_type_archive('bcn_member')) {
        wp_enqueue_style('bcn-member-cards-enhanced', get_template_directory_uri() . '/assets/css/member-cards-enhanced.css', array('bcn-style'), wp_get_theme()->get('Version'));
        wp_enqueue_script('bcn-member-cards-enhanced', get_template_directory_uri() . '/assets/js/member-cards-enhanced.js', array('jquery'), wp_get_theme()->get('Version'), true);
    }
    
    // Admin scripts
    if (is_admin()) {
        wp_enqueue_script('bcn-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), wp_get_theme()->get('Version'), true);
        wp_localize_script('bcn-admin', 'bcn_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bcn_admin_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'bcn_enqueue_scripts');

/**
 * Include additional functionality
 */
require_once get_template_directory() . '/includes/post-types.php';
require_once get_template_directory() . '/includes/acf-import.php';
require_once get_template_directory() . '/includes/member-directory.php';
require_once get_template_directory() . '/includes/member-experience.php';
require_once get_template_directory() . '/includes/member-registration.php';
require_once get_template_directory() . '/includes/member-marquee-shortcodes.php';
