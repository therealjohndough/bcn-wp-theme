<?php
// Simple test to check theme status
echo "Theme Directory: " . get_template_directory() . "\n";
echo "Active Theme: " . get_option('stylesheet') . "\n";
echo "Template: " . get_option('template') . "\n";

// Check if post types exist
$post_types = get_post_types(array('public' => true), 'names');
echo "Post Types: " . implode(', ', $post_types) . "\n";

// Check if bcn_member exists
if (post_type_exists('bcn_member')) {
    echo "✅ bcn_member post type exists\n";
} else {
    echo "❌ bcn_member post type NOT found\n";
}

// Check if taxonomies exist
$taxonomies = get_taxonomies(array('public' => true), 'names');
echo "Taxonomies: " . implode(', ', $taxonomies) . "\n";

if (taxonomy_exists('bcn_membership_level')) {
    echo "✅ bcn_membership_level taxonomy exists\n";
} else {
    echo "❌ bcn_membership_level taxonomy NOT found\n";
}

// Check if functions are loaded
if (function_exists('bcn_register_post_types')) {
    echo "✅ bcn_register_post_types function exists\n";
} else {
    echo "❌ bcn_register_post_types function NOT found\n";
}

// Try to register manually
if (function_exists('bcn_register_post_types')) {
    echo "Attempting to register post types...\n";
    bcn_register_post_types();
    echo "Post types registered\n";
    
    flush_rewrite_rules();
    echo "Rewrite rules flushed\n";
}
?>