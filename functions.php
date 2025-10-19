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

    // Add custom image sizes with descriptive names
    add_image_size('bcn-member-logo', 300, 200, true); // For member directory cards
    add_image_size('bcn-member-featured', 600, 400, true); // For featured member displays
    add_image_size('bcn-archive-thumbnail', 400, 300, true); // For archive listings
    add_image_size('bcn-hero-image', 1200, 675, true); // For hero sections
    add_image_size('bcn-card-image', 500, 350, true); // For general card layouts

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

    // Add comprehensive block supports
    add_theme_support('wp-block-styles');
    add_theme_support('custom-line-height');
    add_theme_support('custom-units');
    add_theme_support('custom-spacing');
    add_theme_support('custom-font-size');
    add_theme_support('custom-color');
    add_theme_support('custom-background');
    add_theme_support('custom-logo');
    add_theme_support('custom-header');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'bcn_theme_setup');

/**
 * Add custom query vars for member filtering
 */
function bcn_add_query_vars($qv) {
    $qv[] = 'membership_level';
    $qv[] = 'featured_only';
    return $qv;
}
add_filter('query_vars', 'bcn_add_query_vars');

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
 * Helper function to get asset version based on file modification time
 *
 * @param string $path Asset path relative to theme directory
 * @return array Array with [url, version]
 */
function bcn_asset(string $path): array {
    $file = get_theme_file_path($path);
    return [get_theme_file_uri($path), file_exists($file) ? filemtime($file) : null];
}

/**
 * Enqueue scripts and styles
 */
function bcn_scripts() {
    // Enqueue main stylesheet with versioning
    [$css_url, $css_ver] = bcn_asset('style.css');
    wp_enqueue_style('bcn-style', $css_url, array(), $css_ver);

    // Enqueue custom scripts with proper loading strategy
    [$nav_url, $nav_ver] = bcn_asset('assets/js/navigation.js');
    wp_enqueue_script('bcn-navigation', $nav_url, array(), $nav_ver, true);
    wp_script_add_data('bcn-navigation', 'strategy', 'defer');

    [$main_url, $main_ver] = bcn_asset('assets/js/main.js');
    wp_enqueue_script('bcn-main', $main_url, array('jquery'), $main_ver, true);
    wp_script_add_data('bcn-main', 'strategy', 'defer');
    
    // Enqueue enhanced member cards assets only where needed
    if (is_post_type_archive('bcn_member') || is_singular('bcn_member')) {
        [$cards_css_url, $cards_css_ver] = bcn_asset('assets/css/member-cards-enhanced.css');
        wp_enqueue_style('bcn-member-cards-enhanced', $cards_css_url, array(), $cards_css_ver);
        
        [$archive_css_url, $archive_css_ver] = bcn_asset('assets/css/member-archive-enhanced.css');
        wp_enqueue_style('bcn-member-archive-enhanced', $archive_css_url, array('bcn-member-cards-enhanced'), $archive_css_ver);
        
        [$cards_js_url, $cards_js_ver] = bcn_asset('assets/js/member-cards-enhanced.js');
        wp_enqueue_script('bcn-member-cards-enhanced', $cards_js_url, array('jquery'), $cards_js_ver, true);
        wp_script_add_data('bcn-member-cards-enhanced', 'strategy', 'defer');
    }

    // Add inline script for smooth scroll
    wp_add_inline_script('bcn-main', 'var bcnTheme = ' . wp_json_encode(array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bcn-nonce'),
    )), 'before');

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bcn_scripts');

// Load BCN pattern styles only in editor
add_action('enqueue_block_editor_assets', function() {
    [$patterns_url, $patterns_ver] = bcn_asset('assets/css/patterns.css');
    wp_enqueue_style('bcn-patterns', $patterns_url, [], $patterns_ver);
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
 * REST API endpoints
 */
require get_template_directory() . '/includes/rest-api.php';

/**
 * Custom blocks
 */
require get_template_directory() . '/includes/blocks.php';

/**
 * Admin UI improvements
 */
require get_template_directory() . '/includes/admin-ui.php';

/**
 * WP-CLI commands
 */
require get_template_directory() . '/includes/wp-cli.php';

/**
 * Logging and error handling
 */
require get_template_directory() . '/includes/logging.php';

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
