<?php
/**
 * Manual Theme Setup Script
 * Run this once to set up the theme properly
 */

// Load WordPress
require_once('../../../wp-load.php');

if (!current_user_can('manage_options')) {
    die('You must be logged in as an administrator to run this script.');
}

echo "<h1>BCN Theme Setup</h1>";

// 1. Flush rewrite rules
echo "<h2>1. Flushing rewrite rules...</h2>";
flush_rewrite_rules();
echo "✅ Rewrite rules flushed<br>";

// 2. Import ACF field groups
echo "<h2>2. Importing ACF field groups...</h2>";
if (function_exists('bcn_import_acf_field_groups')) {
    bcn_import_acf_field_groups();
    echo "✅ ACF field groups imported<br>";
} else {
    echo "❌ ACF import function not found<br>";
}

// 3. Create default membership levels
echo "<h2>3. Creating membership levels...</h2>";
if (function_exists('bcn_create_default_membership_levels')) {
    bcn_create_default_membership_levels();
    echo "✅ Membership levels created<br>";
} else {
    echo "❌ Membership level function not found<br>";
}

// 4. Check if post types are registered
echo "<h2>4. Checking post types...</h2>";
$post_types = get_post_types(array('public' => true), 'names');
if (in_array('bcn_member', $post_types)) {
    echo "✅ bcn_member post type is registered<br>";
} else {
    echo "❌ bcn_member post type not found<br>";
}

// 5. Check if taxonomies are registered
echo "<h2>5. Checking taxonomies...</h2>";
$taxonomies = get_taxonomies(array('public' => true), 'names');
if (in_array('bcn_membership_level', $taxonomies)) {
    echo "✅ bcn_membership_level taxonomy is registered<br>";
} else {
    echo "❌ bcn_membership_level taxonomy not found<br>";
}

// 6. Test member archive URL
echo "<h2>6. Testing member archive...</h2>";
$member_archive_url = get_post_type_archive_link('bcn_member');
if ($member_archive_url) {
    echo "✅ Member archive URL: <a href='$member_archive_url' target='_blank'>$member_archive_url</a><br>";
} else {
    echo "❌ Member archive URL not found<br>";
}

// 7. Check ACF field groups
echo "<h2>7. Checking ACF field groups...</h2>";
if (function_exists('acf_get_field_group')) {
    $member_fields = acf_get_field_group('group_bcn_member_details');
    if ($member_fields) {
        echo "✅ ACF field groups are imported<br>";
    } else {
        echo "❌ ACF field groups not found - you may need to import manually<br>";
    }
} else {
    echo "❌ ACF Pro not active<br>";
}

echo "<h2>Setup Complete!</h2>";
echo "<p><a href='" . admin_url() . "'>Go to WordPress Admin</a></p>";
echo "<p><a href='" . get_post_type_archive_link('bcn_member') . "'>View Member Archive</a></p>";
?>