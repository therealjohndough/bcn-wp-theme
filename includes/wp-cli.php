<?php
/**
 * WP-CLI commands for BCN Theme
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

namespace BCN\Theme;

if (!defined('ABSPATH')) {
    exit;
}

// Only load WP-CLI commands if WP-CLI is available
if (!defined('WP_CLI') || !WP_CLI) {
    return;
}

/**
 * Seed membership levels via WP-CLI
 *
 * @param array $args Command arguments
 * @param array $assoc_args Command options
 */
function cli_seed_levels($args, $assoc_args) {
    $levels = array(
        'premier-member' => __('Premier Member', 'bcn-wp-theme'),
        'pro-member' => __('Pro Member', 'bcn-wp-theme'),
        'community-partner' => __('Community Partner', 'bcn-wp-theme'),
    );

    $created = 0;
    $skipped = 0;

    foreach ($levels as $slug => $label) {
        if (term_exists($slug, 'bcn_membership_level')) {
            $skipped++;
            WP_CLI::log("Skipped: {$label} (already exists)");
        } else {
            $result = wp_insert_term($label, 'bcn_membership_level', array('slug' => $slug));
            if (is_wp_error($result)) {
                WP_CLI::error("Failed to create {$label}: " . $result->get_error_message());
            } else {
                $created++;
                WP_CLI::log("Created: {$label}");
            }
        }
    }

    WP_CLI::success("Membership levels seeded: {$created} created, {$skipped} skipped");
}

/**
 * Import members from CSV
 *
 * @param array $args Command arguments
 * @param array $assoc_args Command options
 */
function cli_import_members($args, $assoc_args) {
    $file = $args[0] ?? '';
    
    if (empty($file) || !file_exists($file)) {
        WP_CLI::error('Please provide a valid CSV file path');
    }

    $dry_run = isset($assoc_args['dry-run']);
    $update_existing = isset($assoc_args['update-existing']);

    if ($dry_run) {
        WP_CLI::log('DRY RUN MODE - No changes will be made');
    }

    $handle = fopen($file, 'r');
    if (!$handle) {
        WP_CLI::error('Could not open CSV file');
    }

    $headers = fgetcsv($handle);
    $required_headers = array('name', 'email', 'level');
    
    foreach ($required_headers as $required) {
        if (!in_array($required, $headers, true)) {
            WP_CLI::error("Missing required column: {$required}");
        }
    }

    $imported = 0;
    $updated = 0;
    $skipped = 0;
    $errors = 0;

    while (($data = fgetcsv($handle)) !== false) {
        $row = array_combine($headers, $data);
        
        // Validate required fields
        if (empty($row['name']) || empty($row['email']) || empty($row['level'])) {
            WP_CLI::warning("Skipping row with missing required data: " . implode(', ', $row));
            $skipped++;
            continue;
        }

        // Check if member already exists
        $existing = get_posts(array(
            'post_type' => 'bcn_member',
            'meta_query' => array(
                array(
                    'key' => 'bcn_member_email',
                    'value' => sanitize_email($row['email']),
                ),
            ),
            'posts_per_page' => 1,
        ));

        if (!empty($existing) && !$update_existing) {
            WP_CLI::log("Skipping existing member: {$row['name']}");
            $skipped++;
            continue;
        }

        if ($dry_run) {
            WP_CLI::log("Would " . (!empty($existing) ? 'update' : 'create') . " member: {$row['name']}");
            continue;
        }

        $post_data = array(
            'post_type' => 'bcn_member',
            'post_title' => sanitize_text_field($row['name']),
            'post_content' => sanitize_textarea_field($row['description'] ?? ''),
            'post_status' => 'publish',
        );

        if (!empty($existing)) {
            $post_data['ID'] = $existing[0]->ID;
            $result = wp_update_post($post_data);
        } else {
            $result = wp_insert_post($post_data);
        }

        if (is_wp_error($result)) {
            WP_CLI::warning("Failed to " . (!empty($existing) ? 'update' : 'create') . " member {$row['name']}: " . $result->get_error_message());
            $errors++;
            continue;
        }

        $post_id = is_numeric($result) ? $result : $result->ID;

        // Update meta fields
        $meta_fields = array(
            'bcn_member_email' => 'email',
            'bcn_member_website' => 'website',
            'bcn_member_phone' => 'phone',
            'bcn_member_address' => 'address',
            'bcn_member_instagram' => 'instagram',
            'bcn_member_facebook' => 'facebook',
            'bcn_member_twitter' => 'twitter',
            'bcn_member_linkedin' => 'linkedin',
            'bcn_member_youtube' => 'youtube',
        );

        foreach ($meta_fields as $meta_key => $csv_key) {
            if (!empty($row[$csv_key])) {
                $value = sanitize_text_field($row[$csv_key]);
                if ('bcn_member_email' === $meta_key) {
                    $value = sanitize_email($value);
                } elseif ('bcn_member_website' === $meta_key || strpos($meta_key, 'bcn_member_') === 0 && in_array(str_replace('bcn_member_', '', $meta_key), array('instagram', 'facebook', 'twitter', 'linkedin', 'youtube'))) {
                    $value = esc_url_raw($value);
                }
                update_post_meta($post_id, $meta_key, $value);
            }
        }

        // Set membership level
        $level_slug = sanitize_key($row['level']);
        if (term_exists($level_slug, 'bcn_membership_level')) {
            wp_set_object_terms($post_id, $level_slug, 'bcn_membership_level', false);
        }

        // Set featured status
        if (!empty($row['featured']) && in_array(strtolower($row['featured']), array('1', 'true', 'yes', 'on'), true)) {
            update_post_meta($post_id, 'bcn_member_featured', true);
        }

        if (!empty($existing)) {
            $updated++;
        } else {
            $imported++;
        }
    }

    fclose($handle);

    WP_CLI::success("Import completed: {$imported} imported, {$updated} updated, {$skipped} skipped, {$errors} errors");
}

/**
 * Export members to CSV
 *
 * @param array $args Command arguments
 * @param array $assoc_args Command options
 */
function cli_export_members($args, $assoc_args) {
    $file = $args[0] ?? 'members-export.csv';
    $level = $assoc_args['level'] ?? '';
    $featured_only = isset($assoc_args['featured-only']);

    $query_args = array(
        'post_type' => 'bcn_member',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    if ($level) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'bcn_membership_level',
                'field' => 'slug',
                'terms' => $level,
            ),
        );
    }

    if ($featured_only) {
        $query_args['meta_query'] = array(
            array(
                'key' => 'bcn_member_featured',
                'value' => true,
                'compare' => '=',
            ),
        );
    }

    $members = get_posts($query_args);

    if (empty($members)) {
        WP_CLI::warning('No members found matching criteria');
        return;
    }

    $handle = fopen($file, 'w');
    if (!$handle) {
        WP_CLI::error('Could not create export file');
    }

    $headers = array(
        'name',
        'email',
        'website',
        'phone',
        'address',
        'level',
        'featured',
        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'description',
    );

    fputcsv($handle, $headers);

    foreach ($members as $member) {
        $terms = wp_get_post_terms($member->ID, 'bcn_membership_level');
        $level_name = !empty($terms) && !is_wp_error($terms) ? $terms[0]->slug : '';

        $row = array(
            $member->post_title,
            get_post_meta($member->ID, 'bcn_member_email', true),
            get_post_meta($member->ID, 'bcn_member_website', true),
            get_post_meta($member->ID, 'bcn_member_phone', true),
            get_post_meta($member->ID, 'bcn_member_address', true),
            $level_name,
            get_post_meta($member->ID, 'bcn_member_featured', true) ? 'yes' : 'no',
            get_post_meta($member->ID, 'bcn_member_instagram', true),
            get_post_meta($member->ID, 'bcn_member_facebook', true),
            get_post_meta($member->ID, 'bcn_member_twitter', true),
            get_post_meta($member->ID, 'bcn_member_linkedin', true),
            get_post_meta($member->ID, 'bcn_member_youtube', true),
            $member->post_content,
        );

        fputcsv($handle, $row);
    }

    fclose($handle);

    WP_CLI::success("Exported " . count($members) . " members to {$file}");
}

// Register WP-CLI commands
WP_CLI::add_command('bcn seed-levels', __NAMESPACE__ . '\\cli_seed_levels', array(
    'shortdesc' => 'Seed membership level terms',
    'synopsis' => array(),
));

WP_CLI::add_command('bcn import-members', __NAMESPACE__ . '\\cli_import_members', array(
    'shortdesc' => 'Import members from CSV file',
    'synopsis' => array(
        array(
            'type' => 'positional',
            'name' => 'file',
            'description' => 'Path to CSV file',
            'optional' => false,
        ),
        array(
            'type' => 'flag',
            'name' => 'dry-run',
            'description' => 'Preview changes without making them',
        ),
        array(
            'type' => 'flag',
            'name' => 'update-existing',
            'description' => 'Update existing members instead of skipping',
        ),
    ),
));

WP_CLI::add_command('bcn export-members', __NAMESPACE__ . '\\cli_export_members', array(
    'shortdesc' => 'Export members to CSV file',
    'synopsis' => array(
        array(
            'type' => 'positional',
            'name' => 'file',
            'description' => 'Output file path',
            'optional' => true,
            'default' => 'members-export.csv',
        ),
        array(
            'type' => 'assoc',
            'name' => 'level',
            'description' => 'Filter by membership level slug',
            'optional' => true,
        ),
        array(
            'type' => 'flag',
            'name' => 'featured-only',
            'description' => 'Export only featured members',
        ),
    ),
));