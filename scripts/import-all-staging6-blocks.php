<?php
/**
 * Import All Block Content from Staging6 XML to Staging10
 * 
 * This script imports all Gutenberg block content for pages
 * from staging6 XML export files into staging10.
 * 
 * Usage: wp eval-file wp-content/themes/buffalo-cannabis-network/scripts/import-all-staging6-blocks.php
 */

// Load WordPress
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php';

if (!current_user_can('manage_options')) {
    die('You must be an administrator to run this script.');
}

// Configuration
$xml_file_path = '/Users/dough/Downloads/2026-BCN-LAUNCH/buffalocannabisnetwork.WordPress.2025-11-20.xml';
$source_domain = 'staging6.buffalocannabisnetwork.com';
$target_domain = 'staging10.buffalocannabisnetwork.com';

echo "=== Importing All Blocks from Staging6 to Staging10 ===\n\n";

// Check if XML file exists
if (!file_exists($xml_file_path)) {
    die("Error: XML file not found at: $xml_file_path\n");
}

echo "Reading XML file: $xml_file_path\n";

// Load and parse XML
libxml_use_internal_errors(true);
$xml = simplexml_load_file($xml_file_path);

if ($xml === false) {
    $errors = libxml_get_errors();
    foreach ($errors as $error) {
        echo "XML Error: " . $error->message . "\n";
    }
    die("Failed to parse XML file.\n");
}

echo "XML file loaded successfully.\n\n";

// Register namespaces
$xml->registerXPathNamespace('content', 'http://purl.org/rss/1.0/modules/content/');
$xml->registerXPathNamespace('wp', 'http://wordpress.org/export/1.2/');

// Extract all pages with blocks from XML
$pages_data = array();

foreach ($xml->channel->item as $item) {
    $post_type = (string)$item->children('wp', true)->post_type;
    
    if ($post_type !== 'page') {
        continue;
    }
    
    $post_name = (string)$item->children('wp', true)->post_name;
    $title = (string)$item->title;
    $content = (string)$item->children('content', true)->encoded;
    
    // Only process pages with block content
    if (!empty(trim($content)) && strpos($content, '<!-- wp:') !== false) {
        $pages_data[$post_name] = array(
            'title' => $title,
            'content' => $content,
            'post_name' => $post_name,
            'post_id' => (string)$item->children('wp', true)->post_id,
        );
        $block_count = substr_count($content, '<!-- wp:');
        echo "Found {$post_name} page: {$title} ({$block_count} blocks, " . strlen($content) . " chars)\n";
    }
}

echo "\nTotal pages with blocks to import: " . count($pages_data) . "\n\n";

// Function to replace URLs in content
function replace_domain_urls($content, $old_domain, $new_domain) {
    // Replace full URLs
    $content = str_replace("https://{$old_domain}", "https://{$new_domain}", $content);
    $content = str_replace("http://{$old_domain}", "http://{$new_domain}", $content);
    
    // Replace in image src attributes
    $content = preg_replace(
        '/(src=["\'])(https?:\/\/)' . preg_quote($old_domain, '/') . '/',
        '$1$2' . $new_domain . '/',
        $content
    );
    
    return $content;
}

// Process each page
$imported = 0;
$skipped = 0;
$errors = 0;

foreach ($pages_data as $post_name => $page_data) {
    echo "=== Processing: {$page_data['title']} ({$post_name}) ===\n";
    
    // Find or create page
    $page = get_page_by_path($post_name);
    if (!$page) {
        $page = get_page_by_title($page_data['title']);
    }
    
    if (!$page) {
        echo "⚠ Page not found. Creating new page...\n";
        $page_id = wp_insert_post(array(
            'post_title' => $page_data['title'],
            'post_name' => $post_name,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
        ));
        
        if (is_wp_error($page_id)) {
            echo "✗ Error creating page: " . $page_id->get_error_message() . "\n";
            $errors++;
            continue;
        }
        
        $page = get_post($page_id);
        echo "✓ Created new page: ID {$page->ID}\n";
    } else {
        echo "✓ Found existing page: ID {$page->ID}\n";
        echo "  Current content length: " . strlen($page->post_content) . " characters\n";
    }
    
    // Prepare new content
    $new_content = $page_data['content'];
    
    // Replace URLs
    $new_content = replace_domain_urls($new_content, $source_domain, $target_domain);
    
    // Update page content
    $update_data = array(
        'ID' => $page->ID,
        'post_content' => $new_content,
    );
    
    $result = wp_update_post($update_data, true);
    
    if (is_wp_error($result)) {
        echo "✗ Error updating page: " . $result->get_error_message() . "\n";
        $errors++;
    } else {
        echo "✓ Page content updated successfully\n";
        echo "  New content length: " . strlen($new_content) . " characters\n";
        $block_count = substr_count($new_content, '<!-- wp:');
        echo "  Block count: {$block_count}\n";
        $imported++;
    }
    
    echo "\n";
}

// Summary
echo "=== Import Summary ===\n";
echo "Pages imported: {$imported}\n";
echo "Pages skipped: {$skipped}\n";
echo "Errors: {$errors}\n\n";

// Flush rewrite rules
flush_rewrite_rules();

echo "=== Import Complete ===\n";
echo "Next steps:\n";
echo "1. Visit staging10.buffalocannabisnetwork.com to verify all pages\n";
echo "2. Check that all blocks render correctly\n";
echo "3. Verify images and links work properly\n";
echo "4. Test responsive design on mobile devices\n";

