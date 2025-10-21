<?php
/**
 * Client Theme Template Functions
 *
 * @package Client_Theme
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function client_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true);

    // Add custom image sizes
    add_image_size('client-featured', 800, 450, true);
    add_image_size('client-thumbnail', 400, 300, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'client-theme'),
        'footer'  => __('Footer Menu', 'client-theme'),
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
add_action('after_setup_theme', 'client_theme_setup');

/**
 * Set the content width in pixels
 */
function client_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('client_theme_content_width', 1200);
}
add_action('after_setup_theme', 'client_theme_content_width', 0);

/**
 * Register widget areas
 */
function client_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'client-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'client-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'client-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'client-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'client_theme_widgets_init');

/**
 * Enqueue scripts and styles
 */
function client_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('client-theme-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue custom scripts
    wp_enqueue_script('client-theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true);
    wp_enqueue_script('client-theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);

    // Add inline script for theme configuration
    wp_add_inline_script('client-theme-main', 'var clientTheme = ' . json_encode(array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('client-theme-nonce'),
    )), 'before');

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'client_theme_scripts');

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

/**
 * Custom post types and taxonomies
 */
require get_template_directory() . '/includes/post-types.php';

/**
 * Add custom body classes
 */
function client_theme_body_classes($classes) {
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
add_filter('body_class', 'client_theme_body_classes');

/**
 * Add excerpt length filter
 */
function client_theme_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'client_theme_excerpt_length');

/**
 * Add excerpt more filter
 */
function client_theme_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'client_theme_excerpt_more');

/**
 * Customize the login page
 */
function client_theme_login_styles() {
    wp_enqueue_style('client-theme-login', get_template_directory_uri() . '/assets/css/login.css', array(), '1.0.0');
}
add_action('login_enqueue_scripts', 'client_theme_login_styles');

/**
 * Add custom logo to login page
 */
function client_theme_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        echo '<style type="text/css">
            .login h1 a {
                background-image: url(' . esc_url($logo[0]) . ');
                background-size: contain;
                background-repeat: no-repeat;
                width: 200px;
                height: 60px;
            }
        </style>';
    }
}
add_action('login_head', 'client_theme_login_logo');

/**
 * Change login logo URL
 */
function client_theme_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'client_theme_login_logo_url');

/**
 * Change login logo title
 */
function client_theme_login_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'client_theme_login_logo_title');

/**
 * Add theme support for WooCommerce
 */
function client_theme_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'client_theme_woocommerce_support');

/**
 * Remove WooCommerce styles (if using custom styles)
 */
function client_theme_remove_woocommerce_styles() {
    if (class_exists('WooCommerce')) {
        remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));
    }
}
add_action('init', 'client_theme_remove_woocommerce_styles');

/**
 * Add custom CSS to admin
 */
function client_theme_admin_styles() {
    wp_enqueue_style('client-theme-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'client_theme_admin_styles');

/**
 * Add custom fields to user profile
 */
function client_theme_add_user_fields($user) {
    ?>
    <h3><?php _e('Additional Information', 'client-theme'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="phone"><?php _e('Phone Number', 'client-theme'); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'client_theme_add_user_fields');
add_action('edit_user_profile', 'client_theme_add_user_fields');

/**
 * Save custom user fields
 */
function client_theme_save_user_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
}
add_action('personal_options_update', 'client_theme_save_user_fields');
add_action('edit_user_profile_update', 'client_theme_save_user_fields');

/**
 * Add custom post type support for theme
 */
function client_theme_add_cpt_support() {
    $cpt_support = get_theme_support('post-thumbnails');
    $cpt_support = $cpt_support[0];
    $cpt_support[] = 'client_custom_post_type';
    add_theme_support('post-thumbnails', $cpt_support);
}
add_action('init', 'client_theme_add_cpt_support');

/**
 * Customize the search form
 */
function client_theme_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'client-theme') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search...', 'placeholder', 'client-theme') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <input type="submit" class="search-submit" value="' . esc_attr_x('Search', 'submit button', 'client-theme') . '" />
    </form>';
    return $form;
}
add_filter('get_search_form', 'client_theme_search_form');

/**
 * Add custom meta tags
 */
function client_theme_meta_tags() {
    if (is_home() || is_front_page()) {
        echo '<meta name="description" content="' . get_bloginfo('description') . '">' . "\n";
    }
}
add_action('wp_head', 'client_theme_meta_tags');

/**
 * Add custom JavaScript to footer
 */
function client_theme_footer_scripts() {
    ?>
    <script>
        // Add any custom JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Theme initialization code
        });
    </script>
    <?php
}
add_action('wp_footer', 'client_theme_footer_scripts');