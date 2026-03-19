<?php
/**
 * Buffalo Cannabis Network Theme Functions - Enhanced Version
 *
 * @package BuffaloCannabisNetwork
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// =============================================================================
// THEME SETUP
// =============================================================================

/**
 * Theme Setup
 */
function bcn_theme_setup() {
    // Block editor support
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-line-height' );
    add_theme_support( 'custom-units' );
    add_theme_support( 'custom-spacing' );
    add_theme_support( 'appearance-tools' );
    add_theme_support( 'link-color' );
    
    // Core WordPress features
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    
    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
        'navigation-widgets'
    ) );
    
    // Add theme support for selective refresh of widgets
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Custom Logo Support with size controls
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'bcn_theme_setup' );

// =============================================================================
// CUSTOMIZER - COLOR CONTROLS
// =============================================================================

/**
 * Add color customizer options
 */
function bcn_customize_register( $wp_customize ) {
    
    // Add Colors Section
    $wp_customize->add_section( 'bcn_colors', array(
        'title'    => __( 'Brand Colors', 'buffalo-cannabis-network' ),
        'priority' => 30,
    ) );
    
    // Primary Color (Green)
    $wp_customize->add_setting( 'bcn_primary_color', array(
        'default'           => '#7CB342',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bcn_primary_color', array(
        'label'    => __( 'Primary Color (Green)', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_colors',
        'settings' => 'bcn_primary_color',
    ) ) );
    
    // Secondary Color (Blue)
    $wp_customize->add_setting( 'bcn_secondary_color', array(
        'default'           => '#4A90E2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bcn_secondary_color', array(
        'label'    => __( 'Secondary Color (Blue)', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_colors',
        'settings' => 'bcn_secondary_color',
    ) ) );
    
    // Tertiary Color (Purple)
    $wp_customize->add_setting( 'bcn_tertiary_color', array(
        'default'           => '#9C27B0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bcn_tertiary_color', array(
        'label'    => __( 'Tertiary Color (Purple)', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_colors',
        'settings' => 'bcn_tertiary_color',
    ) ) );
    
    // Accent Color (Yellow)
    $wp_customize->add_setting( 'bcn_accent_color', array(
        'default'           => '#FFC107',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bcn_accent_color', array(
        'label'    => __( 'Accent Color (Yellow)', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_colors',
        'settings' => 'bcn_accent_color',
    ) ) );
    
    // =============================================================================
    // HOMEPAGE CONTENT SECTION
    // =============================================================================
    
    // Add Homepage Content Section
    $wp_customize->add_section( 'bcn_homepage_content', array(
        'title'    => __( 'Homepage Content', 'buffalo-cannabis-network' ),
        'priority' => 35,
        'description' => __( 'Edit the homepage hero section and key content areas.', 'buffalo-cannabis-network' ),
    ) );
    
    // Hero Title
    $wp_customize->add_setting( 'bcn_hero_title', array(
        'default'           => 'Building Buffalo\'s Cannabis Future, Together',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_title', array(
        'label'    => __( 'Hero Title', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
        'description' => __( 'Main headline in the hero section', 'buffalo-cannabis-network' ),
    ) );
    
    // Hero Tagline
    $wp_customize->add_setting( 'bcn_hero_tagline', array(
        'default'           => 'Connect. Support. Elevate.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_tagline', array(
        'label'    => __( 'Hero Tagline', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
        'description' => __( 'Short tagline under the main heading', 'buffalo-cannabis-network' ),
    ) );
    
    // Hero Description
    $wp_customize->add_setting( 'bcn_hero_description', array(
        'default'           => 'Western New York\'s premier network fostering a thriving, collaborative, and responsible cannabis industry',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_description', array(
        'label'    => __( 'Hero Description', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'textarea',
        'description' => __( 'Description text below the tagline', 'buffalo-cannabis-network' ),
    ) );
    
    // Hero Button 1 Text
    $wp_customize->add_setting( 'bcn_hero_button1_text', array(
        'default'           => 'Join the Network',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_button1_text', array(
        'label'    => __( 'Primary Button Text', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
    ) );
    
    // Hero Button 1 Link
    $wp_customize->add_setting( 'bcn_hero_button1_link', array(
        'default'           => '/membership',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_button1_link', array(
        'label'    => __( 'Primary Button Link', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'url',
        'description' => __( 'URL for the primary button (e.g., /membership or full URL)', 'buffalo-cannabis-network' ),
    ) );
    
    // Hero Button 2 Text
    $wp_customize->add_setting( 'bcn_hero_button2_text', array(
        'default'           => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_button2_text', array(
        'label'    => __( 'Secondary Button Text', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
    ) );
    
    // Hero Button 2 Link
    $wp_customize->add_setting( 'bcn_hero_button2_link', array(
        'default'           => '/about',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_hero_button2_link', array(
        'label'    => __( 'Secondary Button Link', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'url',
        'description' => __( 'URL for the secondary button (e.g., /about or full URL)', 'buffalo-cannabis-network' ),
    ) );
    
    // Mission Text
    $wp_customize->add_setting( 'bcn_mission_text', array(
        'default'           => 'Buffalo Cannabis Network is more than networking—it\'s a community where authentic relationships drive industry success. We\'re building sustainable, lasting connections that elevate professional standards and create opportunities for every stakeholder in WNY\'s cannabis ecosystem.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_mission_text', array(
        'label'    => __( 'Mission Text', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'textarea',
        'description' => __( 'Mission statement text below the mission heading', 'buffalo-cannabis-network' ),
    ) );
    
    // Members Heading
    $wp_customize->add_setting( 'bcn_members_heading', array(
        'default'           => 'We Are Stronger, Together',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_members_heading', array(
        'label'    => __( 'Members Section Heading', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
    ) );
    
    // Members Subheading
    $wp_customize->add_setting( 'bcn_members_subheading', array(
        'default'           => 'Meet our valued members powering Buffalo\'s cannabis industry',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_members_subheading', array(
        'label'    => __( 'Members Section Subheading', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
    ) );
    
    // CTA Heading
    $wp_customize->add_setting( 'bcn_cta_heading', array(
        'default'           => 'Ready to Join?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_cta_heading', array(
        'label'    => __( 'CTA Section Heading', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'text',
    ) );
    
    // CTA Text
    $wp_customize->add_setting( 'bcn_cta_text', array(
        'default'           => 'Become part of Western New York\'s premier cannabis community and start building meaningful connections today.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'bcn_cta_text', array(
        'label'    => __( 'CTA Section Text', 'buffalo-cannabis-network' ),
        'section'  => 'bcn_homepage_content',
        'type'     => 'textarea',
    ) );
}
add_action( 'customize_register', 'bcn_customize_register' );

/**
 * Output custom colors as CSS variables
 */
function bcn_customizer_css() {
    $primary   = get_theme_mod( 'bcn_primary_color', '#7CB342' );
    $secondary = get_theme_mod( 'bcn_secondary_color', '#4A90E2' );
    $tertiary  = get_theme_mod( 'bcn_tertiary_color', '#9C27B0' );
    $accent    = get_theme_mod( 'bcn_accent_color', '#FFC107' );
    ?>
    <style type="text/css">
        :root {
            --md-sys-color-primary: <?php echo esc_attr( $primary ); ?>;
            --md-sys-color-secondary: <?php echo esc_attr( $secondary ); ?>;
            --md-sys-color-tertiary: <?php echo esc_attr( $tertiary ); ?>;
            --md-sys-color-accent: <?php echo esc_attr( $accent ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'bcn_customizer_css' );

// =============================================================================
// ENQUEUE STYLES & SCRIPTS
// =============================================================================

/**
 * Enqueue theme assets
 */
function bcn_enqueue_assets() {
    // Google Fonts - Roboto Flex + Roboto Condensed + Roboto Black
    wp_enqueue_style(
        'bcn-google-fonts',
        'https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100..1000&family=Roboto+Condensed:wght@300;400;700;900&family=Roboto:wght@300;400;500;700;900&display=swap', 
        array(),
        null
    );
    
    // Lucide Icons JavaScript Library (SVG icons)
    wp_enqueue_script(
        'lucide-icons',
        'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js',
        array(),
        '0.294.0',
        true
    );
    
    // Icon System CSS
    wp_enqueue_style(
        'bcn-icon-system',
        get_template_directory_uri() . '/assets/css/icon-system.css',
        array(),
        wp_get_theme()->get( 'Version' )
    );
    
    // Theme stylesheet - with cache busting
    $style_version = file_exists( get_stylesheet_directory() . '/style.css' ) 
        ? filemtime( get_stylesheet_directory() . '/style.css' ) 
        : wp_get_theme()->get( 'Version' );
    
    wp_enqueue_style( 
        'bcn-style', 
        get_stylesheet_uri(), 
        array( 'bcn-google-fonts', 'bcn-icon-system' ), 
        $style_version
    );
    
    // Icon initialization script
    wp_enqueue_script(
        'bcn-icons',
        get_template_directory_uri() . '/assets/js/icons.js',
        array( 'lucide-icons' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
    
    // Custom theme scripts
    if ( file_exists( get_template_directory() . '/assets/js/theme.js' ) ) {
        wp_enqueue_script(
            'bcn-theme-js',
            get_template_directory_uri() . '/assets/js/theme.js',
            array( 'bcn-icons' ),
            wp_get_theme()->get( 'Version' ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'bcn_enqueue_assets' );

/**
 * Enqueue block editor assets
 */
function bcn_enqueue_editor_assets() {
    // Load fonts in editor
    wp_enqueue_style( 
        'bcn-editor-fonts', 
        'https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100..1000&display=swap', 
        array(), 
        null 
    );
    
    // Lucide Icons in editor
    wp_enqueue_script(
        'lucide-icons-editor',
        'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js',
        array(),
        '0.294.0',
        true
    );
    
    // Icon System CSS in editor
    wp_enqueue_style(
        'bcn-icon-system-editor',
        get_template_directory_uri() . '/assets/css/icon-system.css',
        array(),
        wp_get_theme()->get( 'Version' )
    );
    
    // Icon initialization in editor
    wp_enqueue_script(
        'bcn-icons-editor',
        get_template_directory_uri() . '/assets/js/icons.js',
        array( 'lucide-icons-editor' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
    
    // Custom editor styles
    if ( file_exists( get_template_directory() . '/assets/css/editor-style.css' ) ) {
        wp_enqueue_style(
            'bcn-editor-style',
            get_template_directory_uri() . '/assets/css/editor-style.css',
            array(),
            wp_get_theme()->get( 'Version' )
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'bcn_enqueue_editor_assets' );

/**
 * Preload critical resources
 */
function bcn_preload_resources() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://unpkg.com">' . "\n";
}
add_action( 'wp_head', 'bcn_preload_resources', 1 );

// =============================================================================
// CUSTOM POST TYPES & TAXONOMIES
// =============================================================================

/**
 * Register Custom Post Type: Events
 * NOTE: Now managed via ACF Extended - see acf-post-type-bcn_event.json
 * Keeping this commented out as fallback if ACF Extended is disabled
 */
/*
function bcn_register_events_post_type() {
    $labels = array(
        'name'                  => _x( 'Events', 'Post Type General Name', 'buffalo-cannabis-network' ),
        'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'buffalo-cannabis-network' ),
        'menu_name'             => __( 'Events', 'buffalo-cannabis-network' ),
        'name_admin_bar'        => __( 'Event', 'buffalo-cannabis-network' ),
        'all_items'             => __( 'All Events', 'buffalo-cannabis-network' ),
        'add_new_item'          => __( 'Add New Event', 'buffalo-cannabis-network' ),
        'add_new'               => __( 'Add New', 'buffalo-cannabis-network' ),
        'new_item'              => __( 'New Event', 'buffalo-cannabis-network' ),
        'edit_item'             => __( 'Edit Event', 'buffalo-cannabis-network' ),
        'update_item'           => __( 'Update Event', 'buffalo-cannabis-network' ),
        'view_item'             => __( 'View Event', 'buffalo-cannabis-network' ),
        'view_items'            => __( 'View Events', 'buffalo-cannabis-network' ),
        'search_items'          => __( 'Search Events', 'buffalo-cannabis-network' ),
        'not_found'             => __( 'No events found', 'buffalo-cannabis-network' ),
        'not_found_in_trash'    => __( 'No events found in Trash', 'buffalo-cannabis-network' ),
        'featured_image'        => __( 'Event Image', 'buffalo-cannabis-network' ),
        'set_featured_image'    => __( 'Set event image', 'buffalo-cannabis-network' ),
        'remove_featured_image' => __( 'Remove event image', 'buffalo-cannabis-network' ),
        'use_featured_image'    => __( 'Use as event image', 'buffalo-cannabis-network' ),
    );

    $args = array(
        'label'                 => __( 'Event', 'buffalo-cannabis-network' ),
        'description'           => __( 'Buffalo Cannabis Network Events', 'buffalo-cannabis-network' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'rest_base'             => 'events',
        'rewrite'               => array( 'slug' => 'events', 'with_front' => false ),
    );

    register_post_type( 'bcn_event', $args );
}
add_action( 'init', 'bcn_register_events_post_type' );
*/

/**
 * Register Members Post Type
 * NOTE: Now managed via ACF Extended - see acf-post-type-bcn_member.json
 * UNCOMMENTED: Keeping active until ACF Extended is fully synced to preserve existing members
 */
function bcn_register_members_post_type() {
    $labels = array(
        'name'                  => _x( 'Members', 'Post Type General Name', 'buffalo-cannabis-network' ),
        'singular_name'         => _x( 'Member', 'Post Type Singular Name', 'buffalo-cannabis-network' ),
        'menu_name'             => __( 'BCN Members', 'buffalo-cannabis-network' ),
        'name_admin_bar'        => __( 'Member', 'buffalo-cannabis-network' ),
        'all_items'             => __( 'All Members', 'buffalo-cannabis-network' ),
        'add_new_item'          => __( 'Add New Member', 'buffalo-cannabis-network' ),
        'add_new'               => __( 'Add New', 'buffalo-cannabis-network' ),
        'new_item'              => __( 'New Member', 'buffalo-cannabis-network' ),
        'edit_item'             => __( 'Edit Member', 'buffalo-cannabis-network' ),
        'update_item'           => __( 'Update Member', 'buffalo-cannabis-network' ),
        'view_item'             => __( 'View Member', 'buffalo-cannabis-network' ),
        'search_items'          => __( 'Search Members', 'buffalo-cannabis-network' ),
        'not_found'             => __( 'No members found', 'buffalo-cannabis-network' ),
        'featured_image'        => __( 'Company Logo', 'buffalo-cannabis-network' ),
        'set_featured_image'    => __( 'Set company logo', 'buffalo-cannabis-network' ),
    );

    $args = array(
        'label'                 => __( 'Member', 'buffalo-cannabis-network' ),
        'description'           => __( 'BCN Members Directory', 'buffalo-cannabis-network' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'rest_base'             => 'members',
        'rewrite'               => array( 'slug' => 'members', 'with_front' => false ),
    );

    register_post_type( 'bcn_member', $args );
}
add_action( 'init', 'bcn_register_members_post_type' );

/**
 * Register Member Tier Taxonomy
 * NOTE: Now managed via ACF Extended - see acf-taxonomy-member_tier.json
 * UNCOMMENTED: Keeping active until ACF Extended is fully synced to preserve existing data
 */
function bcn_register_member_tier_taxonomy() {
    $labels = array(
        'name'              => _x( 'Membership Tiers', 'taxonomy general name', 'buffalo-cannabis-network' ),
        'singular_name'     => _x( 'Membership Tier', 'taxonomy singular name', 'buffalo-cannabis-network' ),
        'menu_name'         => __( 'Membership Tiers', 'buffalo-cannabis-network' ),
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'membership-tier' ),
    );

    register_taxonomy( 'member_tier', array( 'bcn_member' ), $args );
}
add_action( 'init', 'bcn_register_member_tier_taxonomy' );

/**
 * Add Default Member Tiers
 */
function bcn_add_default_member_tiers() {
    if ( get_option( 'bcn_default_member_tiers_added' ) ) {
        return;
    }

    $tiers = array(
        'Premier Member' => 'Premier tier members - $695/year',
        'Professional Member' => 'Professional tier members - $250/year',
        'Student Member' => 'Student tier members - $49/year'
    );

    foreach ( $tiers as $name => $description ) {
        if ( ! term_exists( $name, 'member_tier' ) ) {
            wp_insert_term( $name, 'member_tier', array( 'description' => $description ) );
        }
    }

    update_option( 'bcn_default_member_tiers_added', true );
}
add_action( 'after_switch_theme', 'bcn_add_default_member_tiers' );

/**
 * Add Custom Columns to Members List
 */
function bcn_member_admin_columns( $columns ) {
    $new_columns = array();
    
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        
        if ( $key === 'title' ) {
            $new_columns['logo'] = 'Logo';
            $new_columns['company'] = 'Company';
            $new_columns['tier'] = 'Tier';
            $new_columns['website'] = 'Website';
        }
    }
    
    return $new_columns;
}
add_filter( 'manage_bcn_member_posts_columns', 'bcn_member_admin_columns' );

/**
 * Populate Custom Columns
 */
function bcn_member_admin_column_content( $column, $post_id ) {
    if ( $column === 'logo' ) {
        if ( has_post_thumbnail( $post_id ) ) {
            echo get_the_post_thumbnail( $post_id, array( 60, 60 ), array( 'style' => 'border-radius: 4px;' ) );
        } else {
            echo '—';
        }
    }
    
    if ( $column === 'company' ) {
        $company = get_post_meta( $post_id, 'member_company_name', true );
        echo $company ? esc_html( $company ) : '—';
    }
    
    if ( $column === 'tier' ) {
        $terms = get_the_terms( $post_id, 'member_tier' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            echo esc_html( $terms[0]->name );
        } else {
            echo '—';
        }
    }
    
    if ( $column === 'website' ) {
        $website = get_post_meta( $post_id, 'member_website_url', true );
        if ( $website ) {
            echo '<a href="' . esc_url( $website ) . '" target="_blank">🔗 Visit</a>';
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_bcn_member_posts_custom_column', 'bcn_member_admin_column_content', 10, 2 );

/**
 * Register Event Taxonomy: Event Type
 * NOTE: Now managed via ACF Extended - see acf-taxonomy-event_type.json
 * Keeping this commented out as fallback if ACF Extended is disabled
 */
/*
function bcn_register_event_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Event Types', 'Taxonomy General Name', 'buffalo-cannabis-network' ),
        'singular_name'              => _x( 'Event Type', 'Taxonomy Singular Name', 'buffalo-cannabis-network' ),
        'menu_name'                  => __( 'Event Types', 'buffalo-cannabis-network' ),
        'all_items'                  => __( 'All Event Types', 'buffalo-cannabis-network' ),
        'parent_item'                => __( 'Parent Event Type', 'buffalo-cannabis-network' ),
        'parent_item_colon'          => __( 'Parent Event Type:', 'buffalo-cannabis-network' ),
        'new_item_name'              => __( 'New Event Type Name', 'buffalo-cannabis-network' ),
        'add_new_item'               => __( 'Add New Event Type', 'buffalo-cannabis-network' ),
        'edit_item'                  => __( 'Edit Event Type', 'buffalo-cannabis-network' ),
        'update_item'                => __( 'Update Event Type', 'buffalo-cannabis-network' ),
        'view_item'                  => __( 'View Event Type', 'buffalo-cannabis-network' ),
        'separate_items_with_commas' => __( 'Separate event types with commas', 'buffalo-cannabis-network' ),
        'add_or_remove_items'        => __( 'Add or remove event types', 'buffalo-cannabis-network' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'buffalo-cannabis-network' ),
        'popular_items'              => __( 'Popular Event Types', 'buffalo-cannabis-network' ),
        'search_items'               => __( 'Search Event Types', 'buffalo-cannabis-network' ),
        'not_found'                  => __( 'No event types found', 'buffalo-cannabis-network' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rest_base'                  => 'event-types',
        'rewrite'                    => array( 'slug' => 'event-type', 'with_front' => false ),
    );

    register_taxonomy( 'event_type', array( 'bcn_event' ), $args );
}
add_action( 'init', 'bcn_register_event_taxonomy' );
*/

/**
 * Add default event types on theme activation
 * NOTE: This still runs even though taxonomy is managed by ACF Extended
 */
function bcn_add_default_event_types() {
    if ( get_option( 'bcn_default_event_types_added' ) ) {
        return;
    }

    $default_types = array(
        'Networking' => 'Professional networking events and mixers',
        'Workshop' => 'Educational workshops and training sessions',
        'Speaker Series' => 'Industry expert presentations and panels',
        'Showcase' => 'Product showcases and exhibitions',
        'Happy Hour' => 'Casual social gatherings',
        'NY-OCM' => 'Official events from New York State Office of Cannabis Management, including Cannabis Control Board meetings and other regulatory events'
    );

    foreach ( $default_types as $name => $description ) {
        if ( ! term_exists( $name, 'event_type' ) ) {
            wp_insert_term( $name, 'event_type', array( 'description' => $description ) );
        }
    }

    update_option( 'bcn_default_event_types_added', true );
}
add_action( 'after_switch_theme', 'bcn_add_default_event_types' );

// =============================================================================
// BLOCK PATTERNS & STYLES
// =============================================================================

/**
 * Register Block Pattern Categories
 */
function bcn_register_block_pattern_categories() {
    $categories = array(
        'bcn-hero'       => array( 'label' => __( 'BCN Hero Sections', 'buffalo-cannabis-network' ) ),
        'bcn-cards'      => array( 'label' => __( 'BCN Card Layouts', 'buffalo-cannabis-network' ) ),
        'bcn-membership' => array( 'label' => __( 'BCN Membership', 'buffalo-cannabis-network' ) ),
        'bcn-team'       => array( 'label' => __( 'BCN Team & People', 'buffalo-cannabis-network' ) ),
        'bcn-cta'        => array( 'label' => __( 'BCN Call to Action', 'buffalo-cannabis-network' ) ),
        'bcn-events'     => array( 'label' => __( 'BCN Events', 'buffalo-cannabis-network' ) ),
    );

    foreach ( $categories as $name => $properties ) {
        register_block_pattern_category( $name, $properties );
    }
}
add_action( 'init', 'bcn_register_block_pattern_categories' );

/**
 * Register custom block styles
 */
function bcn_register_block_styles() {
    // Button styles
    register_block_style( 'core/button', array(
        'name'  => 'bcn-primary',
        'label' => __( 'BCN Primary', 'buffalo-cannabis-network' ),
    ) );

    register_block_style( 'core/button', array(
        'name'  => 'bcn-secondary',
        'label' => __( 'BCN Secondary', 'buffalo-cannabis-network' ),
    ) );

    register_block_style( 'core/button', array(
        'name'  => 'bcn-outline',
        'label' => __( 'BCN Outline', 'buffalo-cannabis-network' ),
    ) );

    // Group/container styles
    register_block_style( 'core/group', array(
        'name'  => 'bcn-card',
        'label' => __( 'BCN Card', 'buffalo-cannabis-network' ),
    ) );

    register_block_style( 'core/group', array(
        'name'  => 'bcn-card-hover',
        'label' => __( 'BCN Card with Hover', 'buffalo-cannabis-network' ),
    ) );

    // Column styles
    register_block_style( 'core/columns', array(
        'name'  => 'bcn-equal-height',
        'label' => __( 'Equal Height Columns', 'buffalo-cannabis-network' ),
    ) );
}
add_action( 'init', 'bcn_register_block_styles' );

// =============================================================================
// IMAGE SIZES
// =============================================================================

/**
 * Add custom image sizes
 */
function bcn_custom_image_sizes() {
    add_image_size( 'bcn-event-card', 380, 220, true );
    add_image_size( 'bcn-article-card', 350, 220, true );
    add_image_size( 'bcn-team-avatar', 300, 300, true );
    add_image_size( 'bcn-hero', 1400, 600, true );
    add_image_size( 'bcn-thumbnail', 150, 150, true );
    add_image_size( 'bcn-medium', 600, 400, true );
}
add_action( 'after_setup_theme', 'bcn_custom_image_sizes' );

/**
 * Add custom image sizes to media library
 */
function bcn_custom_image_sizes_names( $sizes ) {
    return array_merge( $sizes, array(
        'bcn-event-card'   => __( 'Event Card', 'buffalo-cannabis-network' ),
        'bcn-article-card' => __( 'Article Card', 'buffalo-cannabis-network' ),
        'bcn-team-avatar'  => __( 'Team Avatar', 'buffalo-cannabis-network' ),
        'bcn-hero'         => __( 'Hero Image', 'buffalo-cannabis-network' ),
    ) );
}
add_filter( 'image_size_names_choose', 'bcn_custom_image_sizes_names' );

// =============================================================================
// NAVIGATION & MENUS
// =============================================================================

/**
 * Register navigation menus
 */
function bcn_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'buffalo-cannabis-network' ),
        'footer'  => __( 'Footer Menu', 'buffalo-cannabis-network' ),
        'social'  => __( 'Social Links', 'buffalo-cannabis-network' ),
    ) );
}
add_action( 'init', 'bcn_register_menus' );

/**
 * Default Menu Fallback
 */
function bcn_default_menu() {
    echo '<ul class="primary-menu">';
    echo '<li><a href="' . home_url() . '">Home</a></li>';
    echo '<li><a href="' . home_url('/about') . '">About</a></li>';
    echo '<li><a href="' . home_url('/events') . '">Events</a></li>';
    echo '<li><a href="' . home_url('/membership') . '">Membership</a></li>';
    echo '<li><a href="' . home_url('/members') . '">Members</a></li>';
    echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
    echo '</ul>';
}

// =============================================================================
// QUERY CUSTOMIZATIONS
// =============================================================================

/**
 * Add custom query vars
 */
function bcn_custom_query_vars( $vars ) {
    $vars[] = 'event_type';
    $vars[] = 'event_date';
    return $vars;
}
add_filter( 'query_vars', 'bcn_custom_query_vars' );

/**
 * Modify main query for events archive
 */
function bcn_modify_events_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'bcn_event' ) ) {
        // Order by event date meta field
        $query->set( 'meta_key', 'event_date' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'ASC' );
        
        // Only show future events by default
        $query->set( 'meta_query', array(
            array(
                'key'     => 'event_date',
                'value'   => date( 'Y-m-d' ),
                'compare' => '>=',
                'type'    => 'DATE'
            )
        ) );
    }
}
add_action( 'pre_get_posts', 'bcn_modify_events_query' );

/**
 * Customize excerpt length
 */
function bcn_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'bcn_excerpt_length' );

/**
 * Customize excerpt more string
 */
function bcn_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'bcn_excerpt_more' );

// =============================================================================
// PERFORMANCE OPTIMIZATIONS
// =============================================================================

/**
 * Disable WordPress emojis
 */
function bcn_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'bcn_disable_emojis' );

/**
 * Disable embeds (optional - remove if you need embeds)
 */
function bcn_disable_embeds() {
    wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'bcn_disable_embeds' );

/**
 * Add async/defer to scripts (FIXED - excludes editor scripts)
 */
function bcn_defer_scripts( $tag, $handle ) {
    // Don't defer on admin pages or critical scripts
    if ( is_admin() ) {
        return $tag;
    }
    
    // List of scripts that should NOT be deferred
    $exclude_handles = array(
        'jquery',
        'jquery-core',
        'jquery-migrate',
        'wp-polyfill',
        'wp-hooks',
        'wp-i18n',
        'lodash',
        'react',
        'react-dom',
    );
    
    if ( in_array( $handle, $exclude_handles ) ) {
        return $tag;
    }
    
    // Defer non-critical scripts
    return str_replace( ' src', ' defer src', $tag );
}
add_filter( 'script_loader_tag', 'bcn_defer_scripts', 10, 2 );

/**
 * Remove query strings from static resources
 */
function bcn_remove_query_strings( $src ) {
    if ( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'bcn_remove_query_strings', 10, 1 );
add_filter( 'script_loader_src', 'bcn_remove_query_strings', 10, 1 );

// =============================================================================
// SECURITY ENHANCEMENTS
// =============================================================================

/**
 * Add security headers
 */
function bcn_security_headers() {
    if ( ! is_admin() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'X-XSS-Protection: 1; mode=block' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    }
}
add_action( 'send_headers', 'bcn_security_headers' );

/**
 * Remove WordPress version from head and feeds
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Cleanup wp_head
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

/**
 * Allow SVG uploads (with sanitization)
 */
function bcn_allow_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'bcn_allow_svg_upload' );

/**
 * Sanitize uploaded SVG files
 */
function bcn_sanitize_svg( $file ) {
    if ( isset( $file['type'] ) && $file['type'] === 'image/svg+xml' ) {
        if ( file_exists( $file['tmp_name'] ) ) {
            $file_contents = file_get_contents( $file['tmp_name'] );
            
            // Remove potentially dangerous elements
            $file_contents = preg_replace( '/<script\b[^>]*>(.*?)<\/script>/is', '', $file_contents );
            $file_contents = preg_replace( '/on\w+\s*=\s*"[^"]*"/i', '', $file_contents );
            $file_contents = preg_replace( '/on\w+\s*=\s*\'[^\']*\'/i', '', $file_contents );
            
            file_put_contents( $file['tmp_name'], $file_contents );
        }
    }
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'bcn_sanitize_svg' );

// =============================================================================
// ADMIN CUSTOMIZATIONS
// =============================================================================

/**
 * Customize admin footer text
 */
function bcn_admin_footer_text() {
    echo '<span id="footer-thankyou">Built with <span style="color: #7CB342;">♥</span> for Buffalo Cannabis Network</span>';
}
add_filter( 'admin_footer_text', 'bcn_admin_footer_text' );

/**
 * Add custom admin CSS
 */
function bcn_admin_styles() {
    echo '<style>
        #wpadminbar { background-color: #7CB342 !important; }
        .bcn_event .dashicons-calendar-alt { color: #7CB342; }
    </style>';
}
add_action( 'admin_head', 'bcn_admin_styles' );

/**
 * Add helpful links to admin bar
 */
function bcn_admin_bar_links( $admin_bar ) {
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }

    $admin_bar->add_menu( array(
        'id'    => 'bcn-resources',
        'title' => 'BCN Resources',
        'href'  => '#',
        'meta'  => array(
            'title' => __( 'Buffalo Cannabis Network Resources', 'buffalo-cannabis-network' ),
        ),
    ) );

    $admin_bar->add_menu( array(
        'parent' => 'bcn-resources',
        'id'     => 'bcn-docs',
        'title'  => 'Theme Documentation',
        'href'   => admin_url( 'themes.php' ),
    ) );
}
add_action( 'admin_bar_menu', 'bcn_admin_bar_links', 100 );

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Get formatted event date
 */
function bcn_get_event_date( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $event_date = get_post_meta( $post_id, 'event_date', true );
    
    if ( $event_date ) {
        return date_i18n( get_option( 'date_format' ), strtotime( $event_date ) );
    }
    
    return '';
}

/**
 * Get event time
 */
function bcn_get_event_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    return get_post_meta( $post_id, 'event_time', true );
}

/**
 * Format event time from 24-hour to 12-hour format
 */
function bcn_format_event_time( $time ) {
    if ( empty( $time ) ) {
        return '';
    }
    
    // If already in 12-hour format (contains AM/PM), return as is
    if ( stripos( $time, 'am' ) !== false || stripos( $time, 'pm' ) !== false ) {
        return $time;
    }
    
    // Try to parse 24-hour format (HH:MM or HH:MM:SS)
    $time_parts = explode( ':', trim( $time ) );
    if ( count( $time_parts ) >= 2 ) {
        $hour = intval( $time_parts[0] );
        $minute = intval( $time_parts[1] );
        
        // Validate hour and minute
        if ( $hour >= 0 && $hour <= 23 && $minute >= 0 && $minute <= 59 ) {
            $period = 'AM';
            if ( $hour == 0 ) {
                $hour = 12;
            } elseif ( $hour == 12 ) {
                $period = 'PM';
            } elseif ( $hour > 12 ) {
                $hour = $hour - 12;
                $period = 'PM';
            }
            
            return sprintf( '%d:%02d %s', $hour, $minute, $period );
        }
    }
    
    // If parsing fails, return original
    return $time;
}

/**
 * Get event location
 */
function bcn_get_event_location( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    return get_post_meta( $post_id, 'event_location', true );
}

/**
 * Check if event is past
 */
function bcn_is_past_event( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $event_date = get_post_meta( $post_id, 'event_date', true );
    
    if ( $event_date ) {
        return strtotime( $event_date ) < strtotime( 'today' );
    }
    
    return false;
}

/**
 * Get upcoming events
 */
function bcn_get_upcoming_events( $limit = 5 ) {
    $args = array(
        'post_type'      => 'bcn_event',
        'posts_per_page' => $limit,
        'meta_key'       => 'event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => 'event_date',
                'value'   => date( 'Y-m-d' ),
                'compare' => '>=',
                'type'    => 'DATE'
            )
        )
    );
    
    return new WP_Query( $args );
}

/**
 * Display event meta information
 */
function bcn_event_meta( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $date = bcn_get_event_date( $post_id );
    $time = bcn_get_event_time( $post_id );
    $location = bcn_get_event_location( $post_id );
    
    $output = '<div class="event-meta">';
    
    if ( $date ) {
        $output .= '<span class="event-date"><i class="lucide lucide-calendar"></i> ' . esc_html( $date ) . '</span>';
    }
    
    if ( $time ) {
        $output .= '<span class="event-time"><i class="lucide lucide-clock"></i> ' . esc_html( $time ) . '</span>';
    }
    
    if ( $location ) {
        $output .= '<span class="event-location"><i class="lucide lucide-map-pin"></i> ' . esc_html( $location ) . '</span>';
    }
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Get social share links
 */
function bcn_get_social_share_links() {
    $url = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );
    
    $links = array(
        'facebook'  => "https://www.facebook.com/sharer/sharer.php?u={$url}",
        'twitter'   => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
        'linkedin'  => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}",
        'email'     => "mailto:?subject={$title}&body={$url}",
    );
    
    return $links;
}

// =============================================================================
// SCHEMA MARKUP FOR SEO
// =============================================================================

/**
 * Add Organization Schema Markup (Enhanced)
 */
function bcn_organization_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Buffalo Cannabis Network',
        'alternateName' => 'BCN',
        'url' => home_url(),
        'logo' => get_template_directory_uri() . '/screenshot.png',
        'description' => 'Western New York\'s premier professional network for cannabis industry professionals, entrepreneurs, and advocates. Connect, support, and elevate Buffalo\'s cannabis community.',
        'foundingDate' => '2022',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '505 Ellicott St',
            'addressLocality' => 'Buffalo',
            'addressRegion' => 'NY',
            'postalCode' => '14203',
            'addressCountry' => 'US'
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'email' => 'steve@buffalocannabisnetwork.com',
            'areaServed' => array( 'US-NY', 'Buffalo', 'Western New York' ),
            'availableLanguage' => 'English'
        ),
        'sameAs' => array(
            'https://www.facebook.com/buffalocannabisnetwork',
            'https://www.linkedin.com/company/buffalo-cannabis-network',
            'https://www.instagram.com/buffalocannabisnetwork'
        ),
        'memberOf' => array(
            '@type' => 'Organization',
            'name' => 'Cannabis Industry Professional Network'
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Add LocalBusiness Schema for Contact/About Pages
 */
function bcn_localbusiness_schema() {
    if ( ! is_page( array( 'contact', 'about' ) ) && ! is_front_page() ) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Buffalo Cannabis Network',
        'image' => get_template_directory_uri() . '/screenshot.png',
        'description' => 'Professional networking organization for cannabis industry professionals in Western New York.',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '505 Ellicott St',
            'addressLocality' => 'Buffalo',
            'addressRegion' => 'NY',
            'postalCode' => '14203',
            'addressCountry' => 'US'
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '42.886447',
            'longitude' => '-78.878369'
        ),
        'telephone' => '',
        'email' => 'steve@buffalocannabisnetwork.com',
        'url' => home_url(),
        'priceRange' => '$$',
        'openingHoursSpecification' => array(
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
            'opens' => '09:00',
            'closes' => '17:00'
        ),
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Buffalo'
        ),
        'sameAs' => array(
            'https://www.facebook.com/buffalocannabisnetwork',
            'https://www.linkedin.com/company/buffalo-cannabis-network',
            'https://www.instagram.com/buffalocannabisnetwork'
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

add_action( 'wp_head', 'bcn_organization_schema' );
add_action( 'wp_head', 'bcn_localbusiness_schema' );

/**
 * Add FAQ Schema Markup for Membership Page
 */
function bcn_membership_faq_schema() {
    if ( ! is_page( 'membership' ) ) {
        return;
    }
    
    $faqs = array(
        array(
            'question' => 'What\'s included in each membership tier?',
            'answer' => 'Each tier builds on the previous one. Student membership ($49/year) includes all networking events, educational workshops, career development resources, industry newsletter, and welcome swag bag. Professional ($250/year) adds priority event registration, member directory listing, exclusive market reports, and quarterly member meetups. Premier ($695/year) includes everything plus 2 company representatives, speaking opportunities, brand exposure features, and partnership opportunities.'
        ),
        array(
            'question' => 'Can I upgrade my membership tier?',
            'answer' => 'Yes! You can upgrade your membership at any time. Simply pay the difference between your current tier and the new tier, and we\'ll prorate it based on your remaining membership period.'
        ),
        array(
            'question' => 'Do you offer refunds?',
            'answer' => 'We offer a 30-day money-back guarantee. If you\'re not satisfied with your membership within the first 30 days, contact us for a full refund. After 30 days, memberships are non-refundable.'
        ),
        array(
            'question' => 'How do I cancel my membership?',
            'answer' => 'BCN memberships are annual and will not auto-renew unless you choose to renew. Simply don\'t renew at the end of your membership period.'
        ),
        array(
            'question' => 'Are Student memberships only for enrolled students?',
            'answer' => 'Yes, Student membership is exclusively for currently enrolled students (college, university, or vocational programs). You\'ll need to provide proof of enrollment.'
        ),
        array(
            'question' => 'What types of events does BCN host?',
            'answer' => 'BCN hosts monthly networking mixers, educational workshops on licensing and compliance, industry speaker series, product showcases and brand expos, happy hours, and special events like our annual Dispensary Showcase.'
        ),
        array(
            'question' => 'Can businesses purchase multiple memberships?',
            'answer' => 'Absolutely! Professional membership includes 2 company representatives. Premier membership includes even more benefits for businesses. Contact us about corporate membership packages.'
        ),
        array(
            'question' => 'How do I access member-only resources?',
            'answer' => 'Once you join, you\'ll receive login credentials to access our member portal where you can find industry reports, educational materials, the member directory, and event calendar.'
        ),
        array(
            'question' => 'Is BCN affiliated with any government agencies?',
            'answer' => 'No, BCN is an independent professional networking organization. We are not affiliated with the NYS Office of Cannabis Management or any government agency.'
        ),
        array(
            'question' => 'What payment methods do you accept?',
            'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express, Discover) as well as PayPal. Invoicing is available for businesses requiring NET-30 terms (Premier memberships only).'
        )
    );
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array()
    );
    
    foreach ( $faqs as $faq ) {
        $schema['mainEntity'][] = array(
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $faq['answer']
            )
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bcn_membership_faq_schema' );

/**
 * Add Event Schema Markup for Events (Enhanced)
 */
function bcn_event_schema() {
    if ( ! is_singular( 'bcn_event' ) ) {
        return;
    }
    
    $post_id = get_the_ID();
    $event_date = get_post_meta( $post_id, 'event_date', true );
    $event_time = get_post_meta( $post_id, 'event_time', true );
    $event_location = get_post_meta( $post_id, 'event_location', true );
    $registration_link = get_post_meta( $post_id, 'event_registration_link', true );
    
    if ( ! $event_date ) {
        return;
    }
    
    // Format date/time properly
    $start_date = $event_date;
    if ( $event_time ) {
        $start_date .= 'T' . $event_time;
        if ( ! strpos( $event_time, '+' ) && ! strpos( $event_time, 'Z' ) ) {
            $start_date .= '-05:00'; // EST timezone
        }
    } else {
        $start_date .= 'T00:00:00-05:00';
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( get_the_content(), 30 ),
        'startDate' => $start_date,
        'eventStatus' => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location' => array(
            '@type' => 'Place',
            'name' => $event_location ? $event_location : 'Buffalo, NY',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Buffalo',
                'addressRegion' => 'NY',
                'addressCountry' => 'US'
            )
        ),
        'organizer' => array(
            '@type' => 'Organization',
            'name' => 'Buffalo Cannabis Network',
            'url' => home_url(),
            'email' => 'steve@buffalocannabisnetwork.com'
        ),
        'offers' => array(
            '@type' => 'Offer',
            'url' => $registration_link ? $registration_link : get_permalink(),
            'price' => '0',
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
            'validFrom' => get_the_date( 'c' )
        )
    );
    
    if ( has_post_thumbnail( $post_id ) ) {
        $schema['image'] = get_the_post_thumbnail_url( $post_id, 'full' );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Add Article Schema for Blog Posts
 */
function bcn_article_schema() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }
    
    global $post;
    $author = get_the_author_meta( 'display_name', $post->post_author );
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( get_the_content(), 30 ),
        'image' => has_post_thumbnail() ? get_the_post_thumbnail_url( $post->ID, 'full' ) : get_template_directory_uri() . '/screenshot.png',
        'datePublished' => get_the_date( 'c' ),
        'dateModified' => get_the_modified_date( 'c' ),
        'author' => array(
            '@type' => 'Person',
            'name' => $author
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'Buffalo Cannabis Network',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/screenshot.png'
            )
        ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => get_permalink()
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

add_action( 'wp_head', 'bcn_event_schema' );
add_action( 'wp_head', 'bcn_article_schema' );

/**
 * Breadcrumb Navigation Function
 */
function bcn_breadcrumbs() {
    if ( is_front_page() ) {
        return;
    }
    
    $separator = '<span style="margin: 0 8px; color: var(--md-sys-color-outline);">/</span>';
    $home_text = 'Home';
    
    echo '<nav class="bcn-breadcrumbs" style="padding: var(--md-spacing-4) var(--md-spacing-4); background: var(--md-sys-color-surface-variant); font-size: 14px; color: var(--md-sys-color-on-surface-variant);" aria-label="Breadcrumb">';
    echo '<div class="md-container" style="display: flex; align-items: center; flex-wrap: wrap; gap: 4px;">';
    
    // Home
    echo '<a href="' . esc_url( home_url() ) . '" style="color: var(--md-sys-color-primary); text-decoration: none;">' . esc_html( $home_text ) . '</a>';
    
    if ( is_category() || is_single() || is_page() ) {
        echo $separator;
        
        if ( is_page() ) {
            echo '<span style="color: var(--md-sys-color-on-surface);">' . get_the_title() . '</span>';
        } elseif ( is_single() ) {
            $categories = get_the_category();
            if ( $categories ) {
                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" style="color: var(--md-sys-color-primary); text-decoration: none;">' . esc_html( $categories[0]->name ) . '</a>';
                echo $separator;
            }
            echo '<span style="color: var(--md-sys-color-on-surface);">' . get_the_title() . '</span>';
        } elseif ( is_category() ) {
            echo '<span style="color: var(--md-sys-color-on-surface);">' . single_cat_title( '', false ) . '</span>';
        }
    } elseif ( is_post_type_archive() ) {
        echo $separator;
        $post_type = get_post_type_object( get_query_var( 'post_type' ) );
        echo '<span style="color: var(--md-sys-color-on-surface);">' . esc_html( $post_type->labels->name ) . '</span>';
    } elseif ( is_archive() ) {
        echo $separator;
        echo '<span style="color: var(--md-sys-color-on-surface);">Archive</span>';
    } elseif ( is_search() ) {
        echo $separator;
        echo '<span style="color: var(--md-sys-color-on-surface);">Search Results</span>';
    } elseif ( is_404() ) {
        echo $separator;
        echo '<span style="color: var(--md-sys-color-on-surface);">404 - Page Not Found</span>';
    }
    
    echo '</div>';
    echo '</nav>';
}

/**
 * Add Breadcrumb Schema
 */
function bcn_breadcrumb_schema() {
    if ( is_front_page() ) {
        return;
    }
    
    $items = array();
    $position = 1;
    
    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url()
    );
    
    if ( is_page() ) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif ( is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $categories[0]->name,
                'item' => get_category_link( $categories[0]->term_id )
            );
        }
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif ( is_post_type_archive() ) {
        $post_type = get_post_type_object( get_query_var( 'post_type' ) );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $post_type->labels->name,
            'item' => get_post_type_archive_link( get_query_var( 'post_type' ) )
        );
    }
    
    if ( ! empty( $items ) ) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
    }
}

add_action( 'wp_head', 'bcn_breadcrumb_schema' );

// =============================================================================
// INCLUDE CUSTOM ADMIN FILES
// =============================================================================

// Load custom admin dashboard
if ( is_admin() ) {
    require_once get_template_directory() . '/includes/admin-dashboard.php';
    // Removed event-meta-boxes.php - using ACF "Event Details" field group instead
    // require_once get_template_directory() . '/includes/event-meta-boxes.php';
}

// Load members directory system
// Removed members-post-type.php - using ACF field groups instead
// require_once get_template_directory() . '/includes/members-post-type.php';

// Load member import tool (admin only)
if ( is_admin() ) {
    require_once get_template_directory() . '/scripts/import-initial-members.php';
}

// =============================================================================
// SEO META TAGS & OPTIMIZATION
// =============================================================================

/**
 * Add SEO Meta Tags
 */
function bcn_add_seo_meta_tags() {
    global $post;
    
    // Get site info
    $site_name = get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description' );
    
    // Default meta
    $title = $site_name;
    $description = $site_description;
    $keywords = 'Buffalo cannabis network, Western New York cannabis, NY cannabis networking, Buffalo cannabis events, cannabis industry Buffalo, New York cannabis community';
    $image = get_template_directory_uri() . '/screenshot.png';
    $url = home_url();
    
    // Page specific meta
    if ( is_singular() ) {
        $title = get_the_title() . ' | ' . $site_name;
        $description = get_the_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 30 );
        $url = get_permalink();
        
        if ( has_post_thumbnail() ) {
            $image = get_the_post_thumbnail_url( null, 'full' );
        }
    } elseif ( is_home() || is_front_page() ) {
        $title = $site_name . ' | ' . $site_description;
        $description = 'Join Western New York\'s premier cannabis professional network. Connect, learn, and grow with Buffalo\'s leading cannabis industry community.';
    } elseif ( is_page( 'about' ) || is_page( 'about-buffalo-cannabis-network' ) ) {
        $title = 'About Buffalo Cannabis Network | Western NY Cannabis Community | ' . $site_name;
        $description = 'Buffalo Cannabis Network is Western New York\'s premier professional association for cannabis businesses and industry professionals since 2022. Learn about our mission, board of directors, and community impact.';
        $keywords .= ', about BCN, cannabis association, Buffalo cannabis organization, Western NY cannabis network';
    } elseif ( is_page( 'membership' ) ) {
        $title = 'Join Buffalo Cannabis Network | Membership Plans $49-$695 | ' . $site_name;
        $description = 'Join Buffalo Cannabis Network: Student ($49/year), Professional ($250/year), and Premier ($695/year) memberships. Access networking events, educational workshops, member directory, and exclusive resources.';
        $keywords .= ', cannabis membership, join BCN, Buffalo cannabis member, NY cannabis networking membership';
    } elseif ( is_page( 'events' ) || is_post_type_archive( 'bcn_event' ) ) {
        $title = 'Buffalo Cannabis Events | Networking & Workshops | ' . $site_name;
        $description = 'Discover upcoming cannabis networking events, workshops, and showcases in Buffalo and Western New York. Join BCN for exclusive access to industry events and educational programming.';
        $keywords .= ', Buffalo cannabis events, NY cannabis networking, cannabis workshops Buffalo, Western NY cannabis events';
    } elseif ( is_page( 'contact' ) || is_page( 'contact-buffalo-cannabis-network' ) ) {
        $title = 'Contact Buffalo Cannabis Network | Buffalo, NY | ' . $site_name;
        $description = 'Contact Buffalo Cannabis Network at 505 Ellicott St, Buffalo, NY 14203. Email steve@buffalocannabisnetwork.com for membership questions, partnership inquiries, or event information. By appointment only.';
        $keywords .= ', contact BCN, Buffalo cannabis contact, cannabis network Buffalo NY';
    } elseif ( is_post_type_archive( 'bcn_member' ) || is_page( 'members' ) ) {
        $title = 'Member Directory | Buffalo Cannabis Network Members | ' . $site_name;
        $description = 'Browse Buffalo Cannabis Network\'s member directory. Discover premier and professional cannabis businesses, operators, and industry leaders in Western New York.';
        $keywords .= ', Buffalo cannabis members, cannabis business directory, NY cannabis companies';
    }
    
    // Clean description
    $description = wp_strip_all_tags( $description );
    $description = str_replace( array( "\r", "\n" ), '', $description );
    $description = substr( $description, 0, 160 );
    ?>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo esc_attr( $description ); ?>">
    <meta name="keywords" content="<?php echo esc_attr( $keywords ); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo esc_url( $url ); ?>">
    <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
    <meta property="og:image" content="<?php echo esc_url( $image ); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url( $url ); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
    <meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
    
    <!-- Additional SEO -->
    <link rel="canonical" href="<?php echo esc_url( $url ); ?>">
    <meta name="author" content="Buffalo Cannabis Network">
    <meta name="geo.region" content="US-NY">
    <meta name="geo.placename" content="Buffalo">
    <meta name="geo.position" content="42.886447;-78.878369">
    <meta name="ICBM" content="42.886447, -78.878369">
    
    <!-- Additional Open Graph -->
    <?php if ( is_singular( 'post' ) ) : ?>
        <meta property="article:published_time" content="<?php echo get_the_date( 'c' ); ?>">
        <meta property="article:modified_time" content="<?php echo get_the_modified_date( 'c' ); ?>">
        <meta property="article:author" content="<?php echo esc_attr( get_the_author() ); ?>">
        <?php
        $categories = get_the_category();
        foreach ( $categories as $category ) {
            echo '<meta property="article:section" content="' . esc_attr( $category->name ) . '">' . "\n";
        }
        $tags = get_the_tags();
        if ( $tags ) {
            foreach ( $tags as $tag ) {
                echo '<meta property="article:tag" content="' . esc_attr( $tag->name ) . '">' . "\n";
            }
        }
        ?>
    <?php endif; ?>
    
    <?php
}
add_action( 'wp_head', 'bcn_add_seo_meta_tags', 1 );

/**
 * Add robots.txt handling
 */
function bcn_robots_txt_handler( $output, $public ) {
    if ( ! $public ) {
        return $output;
    }
    
    $robots_file = get_template_directory() . '/robots.txt';
    if ( file_exists( $robots_file ) ) {
        $file_content = file_get_contents( $robots_file );
        // Add sitemap reference if not already present
        if ( strpos( $file_content, 'Sitemap:' ) === false ) {
            $file_content .= "\nSitemap: " . home_url( '/?bcn_sitemap=1' ) . "\n";
        }
        return $file_content;
    }
    
    // If no robots.txt file, add sitemap to default output
    $output .= "\nSitemap: " . home_url( '/?bcn_sitemap=1' ) . "\n";
    return $output;
}
add_filter( 'robots_txt', 'bcn_robots_txt_handler', 10, 2 );

/**
 * Generate Simple XML Sitemap
 */
function bcn_generate_sitemap() {
    if ( ! isset( $_GET['bcn_sitemap'] ) ) {
        return;
    }
    
    header( 'Content-Type: application/xml; charset=utf-8' );
    
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Homepage
    echo '<url>';
    echo '<loc>' . home_url() . '</loc>';
    echo '<lastmod>' . date( 'Y-m-d' ) . '</lastmod>';
    echo '<changefreq>daily</changefreq>';
    echo '<priority>1.0</priority>';
    echo '</url>';
    
    // Pages
    $pages = get_pages( array( 'post_status' => 'publish' ) );
    foreach ( $pages as $page ) {
        echo '<url>';
        echo '<loc>' . get_permalink( $page->ID ) . '</loc>';
        echo '<lastmod>' . date( 'Y-m-d', strtotime( $page->post_modified ) ) . '</lastmod>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
    
    // Posts
    $posts = get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
    foreach ( $posts as $post ) {
        echo '<url>';
        echo '<loc>' . get_permalink( $post->ID ) . '</loc>';
        echo '<lastmod>' . date( 'Y-m-d', strtotime( $post->post_modified ) ) . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.6</priority>';
        echo '</url>';
    }
    
    // Events
    $events = get_posts( array( 'post_type' => 'bcn_event', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
    foreach ( $events as $event ) {
        echo '<url>';
        echo '<loc>' . get_permalink( $event->ID ) . '</loc>';
        echo '<lastmod>' . date( 'Y-m-d', strtotime( $event->post_modified ) ) . '</lastmod>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }
    
    echo '</urlset>';
    exit;
}
add_action( 'template_redirect', 'bcn_generate_sitemap' );


/**
 * Add Local Business Schema to Footer (Legacy - use bcn_localbusiness_schema instead)
 * This function is kept for backward compatibility but should not be used
 */
function bcn_local_business_schema_legacy() {
    if ( ! is_front_page() ) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Buffalo Cannabis Network',
        'image' => get_template_directory_uri() . '/screenshot.png',
        'telephone' => '',
        'email' => 'info@buffalocannabisnetwork.com',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '505 Ellicott St',
            'addressLocality' => 'Buffalo',
            'addressRegion' => 'NY',
            'postalCode' => '14203',
            'addressCountry' => 'US'
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '42.886447',
            'longitude' => '-78.878369'
        ),
        'url' => home_url(),
        'priceRange' => '$49-$695',
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Buffalo',
            'containedIn' => 'Western New York'
        ),
        'openingHoursSpecification' => array(
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
            'opens' => '09:00',
            'closes' => '17:00'
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
// Removed - duplicate of bcn_localbusiness_schema which is already in wp_head

/**
 * Add Member Organization Schema
 */
function bcn_member_schema() {
    if ( ! is_singular( 'bcn_member' ) ) {
        return;
    }
    
    $post_id = get_the_ID();
    $company_name = get_post_meta( $post_id, 'member_company_name', true );
    $website = get_post_meta( $post_id, 'member_website_url', true );
    $phone = get_post_meta( $post_id, 'member_phone', true );
    $email = get_post_meta( $post_id, 'member_contact_email', true );
    
    if ( ! $company_name ) {
        $company_name = get_the_title();
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $company_name,
        'description' => get_the_excerpt(),
        'url' => $website ? $website : get_permalink(),
        'image' => get_the_post_thumbnail_url( $post_id, 'full' ),
        'memberOf' => array(
            '@type' => 'Organization',
            'name' => 'Buffalo Cannabis Network'
        )
    );
    
    if ( $phone ) {
        $schema['telephone'] = $phone;
    }
    
    if ( $email ) {
        $schema['email'] = $email;
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bcn_member_schema' );

// =============================================================================
// PERFORMANCE OPTIMIZATIONS
// =============================================================================

/**
 * Add native lazy loading to images
 */
function bcn_add_lazy_loading( $attr ) {
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'bcn_add_lazy_loading' );

/**
 * Enable WebP Support
 */
function bcn_enable_webp_upload( $mimes ) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter( 'mime_types', 'bcn_enable_webp_upload' );

/**
 * Display WebP Images in Media Library
 */
function bcn_webp_display( $result, $path ) {
    if ( $result === false ) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );
        
        if ( empty( $info ) ) {
            $result = false;
        } elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
            $result = false;
        } else {
            $result = true;
        }
    }
    
    return $result;
}
add_filter( 'file_is_displayable_image', 'bcn_webp_display', 10, 2 );

/**
 * Remove unnecessary scripts and styles
 */
function bcn_remove_unnecessary_assets() {
    // Don't remove block library or global styles - needed for block editor content
    // These styles are required for pages using the block editor (like About page)
    
    // Remove classic theme styles only
    wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'bcn_remove_unnecessary_assets', 100 );

/**
 * Optimize WordPress Heartbeat API
 */
function bcn_optimize_heartbeat( $settings ) {
    $settings['interval'] = 60; // 60 seconds instead of 15
    return $settings;
}
add_filter( 'heartbeat_settings', 'bcn_optimize_heartbeat' );

/**
 * Limit Post Revisions
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
    define( 'WP_POST_REVISIONS', 3 );
}

/**
 * Increase Autosave Interval
 */
if ( ! defined( 'AUTOSAVE_INTERVAL' ) ) {
    define( 'AUTOSAVE_INTERVAL', 300 ); // 5 minutes
}

/**
 * Add DNS Prefetch for External Resources
 */
function bcn_dns_prefetch() {
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//unpkg.com">' . "\n";
}
add_action( 'wp_head', 'bcn_dns_prefetch', 0 );

/**
 * Defer CSS Loading for Non-Critical Styles
 */
function bcn_defer_css( $html, $handle ) {
    if ( is_admin() ) {
        return $html;
    }
    
    // Don't defer critical styles
    $critical_handles = array( 'bcn-style', 'bcn-google-fonts' );
    
    if ( in_array( $handle, $critical_handles ) ) {
        return $html;
    }
    
    // Defer non-critical CSS
    $html = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $html );
    
    return $html;
}
// Commented out to prevent issues - uncomment if needed
// add_filter( 'style_loader_tag', 'bcn_defer_css', 10, 2 );

/**
 * Optimize Database on Theme Activation
 */
function bcn_optimize_database() {
    global $wpdb;
    
    // Clean up post revisions
    $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type = 'revision'" );
    
    // Clean up trashed posts
    $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_status = 'trash'" );
    
    // Clean up orphaned post meta
    $wpdb->query( "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL" );
    
    // Optimize tables
    $wpdb->query( "OPTIMIZE TABLE $wpdb->posts" );
    $wpdb->query( "OPTIMIZE TABLE $wpdb->postmeta" );
    $wpdb->query( "OPTIMIZE TABLE $wpdb->options" );
}
// Run on theme activation
add_action( 'after_switch_theme', 'bcn_optimize_database' );

/**
 * Add Browser Caching Headers
 */
function bcn_add_cache_headers() {
    if ( ! is_admin() && ! is_user_logged_in() ) {
        header( 'Cache-Control: public, max-age=31536000' );
        header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 31536000 ) . ' GMT' );
    }
}
// Commented out - let SiteGround handle caching
// add_action( 'send_headers', 'bcn_add_cache_headers' );

/**
 * Minify HTML Output (Simple Version)
 */
function bcn_minify_html( $buffer ) {
    if ( is_admin() || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
        return $buffer;
    }
    
    // Remove HTML comments (except IE conditionals)
    $buffer = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $buffer );
    
    // Remove whitespace
    $buffer = preg_replace( '/\s+/', ' ', $buffer );
    
    return $buffer;
}

// Commented out - can cause issues with some scripts
// function bcn_buffer_start() { ob_start( 'bcn_minify_html' ); }
// function bcn_buffer_end() { if ( ob_get_length() ) ob_end_flush(); }
// add_action( 'wp_loaded', 'bcn_buffer_start' );
// add_action( 'shutdown', 'bcn_buffer_end' );

/**
 * Cleanup WordPress Head
 */
function bcn_cleanup_head() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'wp_resource_hints', 2 );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
add_action( 'init', 'bcn_cleanup_head' );

// =============================================================================
// SHORTCODES FOR DYNAMIC CONTENT
// =============================================================================

/**
 * Members Showcase Shortcode (Auto-updates from database)
 * 
 * Usage: Add Shortcode block in editor, then type: [bcn_members]
 * This will automatically display all members from the database
 */
function bcn_members_showcase_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'tier' => 'all', // all, premier, professional, student
    ), $atts );
    
    ob_start();
    
    // Premier Members
    if ( $atts['tier'] === 'all' || $atts['tier'] === 'premier' ) {
        $premier_members = new WP_Query( array(
            'post_type' => 'bcn_member',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'member_tier',
                    'field' => 'slug',
                    'terms' => 'premier-member',
                    'operator' => 'IN',
                ),
            ),
            'orderby' => 'menu_order title',
            'order' => 'ASC'
        ) );
        
        if ( $premier_members->have_posts() ) :
        ?>
        <div class="bcn-members-tier-section" style="margin-bottom: 3rem;">
            <h3 style="text-align: center; font-size: 2rem; margin-bottom: 2rem; font-family: 'Roboto Flex', sans-serif;">Premier Members</h3>
            
            <div class="bcn-premier-slider-container">
                <div class="bcn-premier-slider">
                    <?php 
                    $count = 0;
                    while ( $premier_members->have_posts() ) : 
                        $premier_members->the_post();
                        $count++;
                        $website = get_post_meta( get_the_ID(), 'member_website_url', true );
                        $company = get_post_meta( get_the_ID(), 'member_company_name', true );
                        ?>
                        <div class="bcn-premier-logo">
                            <?php if ( $website ) : ?>
                                <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                                    <?php else : ?>
                                        <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                                <?php else : ?>
                                    <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                    
                    <!-- Duplicate for smooth scroll -->
                    <?php 
                    $premier_members->rewind_posts();
                    while ( $premier_members->have_posts() ) : 
                        $premier_members->the_post();
                        $website = get_post_meta( get_the_ID(), 'member_website_url', true );
                        $company = get_post_meta( get_the_ID(), 'member_company_name', true );
                        ?>
                        <div class="bcn-premier-logo">
                            <?php if ( $website ) : ?>
                                <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                                    <?php else : ?>
                                        <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                                <?php else : ?>
                                    <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        
        <?php 
        endif;
        wp_reset_postdata();
    }
    
    // Member Directory Info Section (replaces Professional Members)
    ?>
    
    <div class="bcn-member-directory-info" style="margin-top: var(--md-spacing-16); background: linear-gradient(135deg, var(--md-sys-color-primary-container), var(--md-sys-color-secondary-container)); border-radius: var(--md-shape-corner-extra-large); text-align: center; box-shadow: var(--md-elevation-2);">
        <div class="md-container-narrow">
            <h3 style="font-size: 2rem; font-weight: 700; margin-bottom: var(--md-spacing-8); color: var(--md-sys-color-on-surface);">
                Explore Our Complete Member Directory
            </h3>
            <p style="font-size: 1.125rem; line-height: 1.8; color: var(--md-sys-color-on-surface-variant); margin-bottom: var(--md-spacing-12); max-width: 700px; margin-left: auto; margin-right: auto; padding: 0 var(--md-spacing-4);">
                Discover all of Buffalo's premier cannabis businesses, from testing labs and dispensaries to consultants and service providers. Our directory includes detailed profiles, contact information, and direct links to member websites.
            </p>
            <a href="<?php echo esc_url( home_url( '/members' ) ); ?>" class="bcn-button-secondary" style="display: inline-flex; align-items: center; gap: var(--md-spacing-4);">
                <span>View Full Member Directory</span>
                <i class="icon-arrow-right icon-md"></i>
            </a>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}
add_shortcode( 'bcn_members', 'bcn_members_showcase_shortcode' );

/**
 * Member Directory Shortcode (Alias for bcn_members)
 * 
 * Usage: [bcn_member_directory tier="all"]
 * This is an alias for [bcn_members] for backwards compatibility
 */
function bcn_member_directory_shortcode( $atts ) {
    // Just call the same function
    return bcn_members_showcase_shortcode( $atts );
}
add_shortcode( 'bcn_member_directory', 'bcn_member_directory_shortcode' );

// =============================================================================
// ACF PRO SETUP
// =============================================================================

/**
 * Add ACF Options Page for Site Settings
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    
    acf_add_options_page( array(
        'page_title'    => 'BCN Site Settings',
        'menu_title'    => 'BCN Settings',
        'menu_slug'     => 'bcn-settings',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-admin-generic',
        'redirect'      => false,
        'position'      => 3
    ) );
    
    acf_add_options_sub_page( array(
        'page_title'    => 'Contact Information',
        'menu_title'    => 'Contact Info',
        'parent_slug'   => 'bcn-settings',
    ) );
    
    acf_add_options_sub_page( array(
        'page_title'    => 'Social Media Links',
        'menu_title'    => 'Social Media',
        'parent_slug'   => 'bcn-settings',
    ) );
}

/**
 * Enable ACF JSON Save/Load
 */
add_filter( 'acf/settings/save_json', function() {
    return get_stylesheet_directory() . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function( $paths ) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
} );

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        null
    );

    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'bcn-community-slider',
        get_template_directory_uri() . '/assets/js/community-slider.js',
        ['swiper'],
        '1.0.0',
        true
    );
});
