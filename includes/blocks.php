<?php
/**
 * Custom blocks for BCN Theme
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

namespace BCN\Theme;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom blocks
 */
function register_blocks() {
    register_block_type('bcn/member-logo-grid', array(
        'api_version' => 2,
        'title' => __('Member Logo Grid', 'bcn-wp-theme'),
        'description' => __('Display a grid of member logos with filtering options.', 'bcn-wp-theme'),
        'category' => 'bcn',
        'icon' => 'groups',
        'keywords' => array('members', 'logos', 'grid', 'directory'),
        'supports' => array(
            'align' => array('wide', 'full'),
            'html' => false,
        ),
        'attributes' => array(
            'level' => array(
                'type' => 'string',
                'default' => '',
            ),
            'limit' => array(
                'type' => 'number',
                'default' => 12,
            ),
            'featured' => array(
                'type' => 'boolean',
                'default' => false,
            ),
            'columns' => array(
                'type' => 'number',
                'default' => 4,
            ),
        ),
        'render_callback' => __NAMESPACE__ . '\\render_member_logo_grid_block',
        'editor_script' => 'bcn-member-logo-grid-block',
        'editor_style' => 'bcn-member-logo-grid-block-editor',
        'style' => 'bcn-member-logo-grid-block',
    ));
}
add_action('init', __NAMESPACE__ . '\\register_blocks');

/**
 * Enqueue block assets
 */
function enqueue_block_assets() {
    // Editor script
    wp_register_script(
        'bcn-member-logo-grid-block',
        get_theme_file_uri('assets/js/blocks/member-logo-grid.js'),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        filemtime(get_theme_file_path('assets/js/blocks/member-logo-grid.js')),
        true
    );

    // Editor styles
    wp_register_style(
        'bcn-member-logo-grid-block-editor',
        get_theme_file_uri('assets/css/blocks/member-logo-grid-editor.css'),
        array('wp-edit-blocks'),
        filemtime(get_theme_file_path('assets/css/blocks/member-logo-grid-editor.css'))
    );

    // Frontend styles
    wp_register_style(
        'bcn-member-logo-grid-block',
        get_theme_file_uri('assets/css/blocks/member-logo-grid.css'),
        array(),
        filemtime(get_theme_file_path('assets/css/blocks/member-logo-grid.css'))
    );
}
add_action('init', __NAMESPACE__ . '\\enqueue_block_assets');

/**
 * Render the member logo grid block
 *
 * @param array $attributes Block attributes
 * @return string Block HTML
 */
function render_member_logo_grid_block($attributes) {
    $level = sanitize_key($attributes['level'] ?? '');
    $limit = absint($attributes['limit'] ?? 12);
    $featured = (bool) ($attributes['featured'] ?? false);
    $columns = min(6, max(2, absint($attributes['columns'] ?? 4)));

    $query_args = array(
        'post_type' => 'bcn_member',
        'posts_per_page' => $limit > 0 ? $limit : -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'no_found_rows' => true,
    );

    $tax_query = array();
    if (!empty($level)) {
        $tax_query[] = array(
            'taxonomy' => 'bcn_membership_level',
            'field' => 'slug',
            'terms' => $level,
        );
    }

    if (!empty($tax_query)) {
        $query_args['tax_query'] = $tax_query;
    }

    if ($featured) {
        $query_args['meta_query'] = array(
            array(
                'key' => 'bcn_member_featured',
                'value' => true,
                'compare' => '=',
            ),
        );
    }

    $query = new \WP_Query($query_args);

    if (!$query->have_posts()) {
        wp_reset_postdata();
        return '<div class="bcn-member-logo-grid bcn-member-logo-grid--empty"><p>' . esc_html__('No members found.', 'bcn-wp-theme') . '</p></div>';
    }

    $column_class = 'columns-' . $columns;
    $output = '<div class="bcn-member-logo-grid ' . esc_attr($column_class) . '">';

    while ($query->have_posts()) {
        $query->the_post();
        $logo_html = get_the_post_thumbnail(get_the_ID(), 'bcn-member-logo', array(
            'class' => 'bcn-member-logo-image',
            'alt' => get_the_title(),
            'loading' => 'lazy',
            'decoding' => 'async',
        ));

        if (empty($logo_html)) {
            $logo_html = '<div class="bcn-member-logo-placeholder">' . esc_html(get_the_title()) . '</div>';
        }

        $output .= '<a class="bcn-member-logo" href="' . esc_url(get_permalink()) . '" aria-label="' . esc_attr(get_the_title()) . '">';
        $output .= $logo_html;
        $output .= '</a>';
    }

    wp_reset_postdata();
    $output .= '</div>';

    return $output;
}

/**
 * Register block category
 *
 * @param array $categories Existing categories
 * @return array Modified categories
 */
function register_block_category($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'bcn',
                'title' => __('BCN Blocks', 'bcn-wp-theme'),
                'icon' => 'groups',
            ),
        )
    );
}
add_filter('block_categories_all', __NAMESPACE__ . '\\register_block_category');