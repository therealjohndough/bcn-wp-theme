<?php
/**
 * REST API endpoints for BCN Theme
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

namespace BCN\Theme;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register REST API routes
 */
function register_rest_routes() {
    register_rest_route('bcn/v1', '/members', array(
        'methods'  => 'GET',
        'callback' => __NAMESPACE__ . '\\get_members',
        'permission_callback' => '__return_true',
        'args' => array(
            'level' => array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_key',
                'description' => 'Filter by membership level slug',
            ),
            'featured' => array(
                'type' => 'boolean',
                'default' => false,
                'description' => 'Filter for featured members only',
            ),
            'per_page' => array(
                'type' => 'integer',
                'default' => 10,
                'minimum' => 1,
                'maximum' => 100,
                'description' => 'Number of members per page',
            ),
            'page' => array(
                'type' => 'integer',
                'default' => 1,
                'minimum' => 1,
                'description' => 'Page number',
            ),
        ),
    ));

    register_rest_route('bcn/v1', '/members/(?P<id>\d+)', array(
        'methods'  => 'GET',
        'callback' => __NAMESPACE__ . '\\get_member',
        'permission_callback' => '__return_true',
        'args' => array(
            'id' => array(
                'type' => 'integer',
                'required' => true,
                'description' => 'Member post ID',
            ),
        ),
    ));
}
add_action('rest_api_init', __NAMESPACE__ . '\\register_rest_routes');

/**
 * Get members with filtering
 *
 * @param WP_REST_Request $request REST request object
 * @return WP_REST_Response|WP_Error
 */
function get_members($request) {
    $level = $request->get_param('level');
    $featured = $request->get_param('featured');
    $per_page = $request->get_param('per_page');
    $page = $request->get_param('page');

    $args = array(
        'post_type' => 'bcn_member',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    $meta_query = array();
    $tax_query = array();

    if ($featured) {
        $meta_query[] = array(
            'key' => 'bcn_member_featured',
            'value' => true,
            'compare' => '=',
        );
    }

    if ($level) {
        $tax_query[] = array(
            'taxonomy' => 'bcn_membership_level',
            'field' => 'slug',
            'terms' => $level,
        );
    }

    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new \WP_Query($args);
    $members = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $members[] = format_member_data(get_post());
        }
        wp_reset_postdata();
    }

    $response = new \WP_REST_Response($members);
    $response->header('X-WP-Total', $query->found_posts);
    $response->header('X-WP-TotalPages', $query->max_num_pages);

    return $response;
}

/**
 * Get single member data
 *
 * @param WP_REST_Request $request REST request object
 * @return WP_REST_Response|WP_Error
 */
function get_member($request) {
    $id = $request->get_param('id');
    $post = get_post($id);

    if (!$post || $post->post_type !== 'bcn_member' || $post->post_status !== 'publish') {
        return new \WP_Error('member_not_found', __('Member not found', 'bcn-wp-theme'), array('status' => 404));
    }

    $member_data = format_member_data($post);
    return new \WP_REST_Response($member_data);
}

/**
 * Format member data for API response
 *
 * @param WP_Post $post Member post object
 * @return array Formatted member data
 */
function format_member_data($post) {
    $meta_fields = array(
        'bcn_member_website',
        'bcn_member_email',
        'bcn_member_phone',
        'bcn_member_address',
        'bcn_member_featured',
        'bcn_member_instagram',
        'bcn_member_facebook',
        'bcn_member_twitter',
        'bcn_member_linkedin',
        'bcn_member_youtube',
    );

    $meta_data = array();
    foreach ($meta_fields as $field) {
        $meta_data[str_replace('bcn_member_', '', $field)] = get_post_meta($post->ID, $field, true);
    }

    $membership_levels = wp_get_post_terms($post->ID, 'bcn_membership_level', array('fields' => 'all'));

    return array(
        'id' => $post->ID,
        'title' => $post->post_title,
        'content' => $post->post_content,
        'excerpt' => $post->post_excerpt,
        'slug' => $post->post_name,
        'permalink' => get_permalink($post->ID),
        'featured_image' => get_the_post_thumbnail_url($post->ID, 'bcn-member-logo'),
        'meta' => $meta_data,
        'membership_levels' => $membership_levels,
        'date_created' => $post->post_date,
        'date_modified' => $post->post_modified,
    );
}