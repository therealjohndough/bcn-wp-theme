<?php
/**
 * Import Initial BCN Members
 * 
 * Run once to populate member directory with existing members from HTML
 * 
 * Usage: Access via WordPress admin URL:
 * /wp-admin/admin.php?page=bcn-import-members
 * 
 * Or run via WP-CLI:
 * wp eval-file wp-content/themes/buffalo-cannabis-network/scripts/import-initial-members.php
 */

// Ensure WordPress is loaded
if ( ! defined( 'ABSPATH' ) ) {
    // Try to load WordPress
    require_once dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/wp-load.php';
}

function bcn_import_initial_members() {
    
    // Get tier IDs
    $premier_tier = get_term_by( 'name', 'Premier Member', 'member_tier' );
    $professional_tier = get_term_by( 'name', 'Professional Member', 'member_tier' );
    
    if ( ! $premier_tier ) {
        $premier_tier = wp_insert_term( 'Premier Member', 'member_tier' );
        $premier_tier = get_term( $premier_tier['term_id'], 'member_tier' );
    }
    
    if ( ! $professional_tier ) {
        $professional_tier = wp_insert_term( 'Professional Member', 'member_tier' );
        $professional_tier = get_term( $professional_tier['term_id'], 'member_tier' );
    }
    
    $premier_members = array(
        array(
            'company_name' => 'DRS Testing',
            'logo_url' => '/wp-content/uploads/2025/06/DRS-LOGOAsset-1.png',
            'industry' => 'Cannabis Testing Laboratory',
            'website' => '', // Add actual website
        ),
        array(
            'company_name' => 'Staff Buffalo',
            'logo_url' => '/wp-content/uploads/2025/06/Staff-HRBuffalo-Logo-Transparent-1.png',
            'industry' => 'Human Resources & Staffing',
            'website' => '',
        ),
        array(
            'company_name' => 'ICH Processors',
            'logo_url' => '/wp-content/uploads/2025/09/ICH-Full-Green.png',
            'industry' => 'Cannabis Processing',
            'website' => '',
        ),
        array(
            'company_name' => 'SUNY Niagara',
            'logo_url' => '/wp-content/uploads/2025/07/SUNY-Niagara-Logo_OnLight_DetailSwash_CMYK1-300x113-1.png',
            'industry' => 'Cannabis Education & Training',
            'website' => 'https://www.sunyniagara.edu',
        ),
        array(
            'company_name' => 'Weed Ross',
            'logo_url' => '/wp-content/uploads/2025/06/Color-Logo-Transparent.png',
            'industry' => 'Cannabis Insurance & Risk Management',
            'website' => '',
        ),
        array(
            'company_name' => 'CBK',
            'logo_url' => '/wp-content/uploads/2025/06/CBK-Asset-2@2x.png',
            'industry' => 'Cannabis Business Consulting',
            'website' => '',
        ),
        array(
            'company_name' => 'Case Study Labs',
            'logo_url' => '/wp-content/uploads/2025/06/CASE-STUDY-LABS-SocialAsset-16@2x.png',
            'industry' => 'Digital Marketing & Branding',
            'website' => 'https://casestudylabs.com',
        ),
    );
    
    $professional_members = array(
        array(
            'company_name' => 'PAX',
            'logo_url' => '/wp-content/uploads/2025/09/PAX-Logo-Black-scaled.png',
            'industry' => 'Cannabis Technology & Devices',
            'website' => 'https://www.pax.com',
        ),
        array(
            'company_name' => 'Hurwitz Fine',
            'logo_url' => '/wp-content/uploads/2025/06/HF_Primary_Full-Color-scaled.png',
            'industry' => 'Cannabis Legal Services',
            'website' => '',
        ),
        array(
            'company_name' => 'House of Sacci',
            'logo_url' => '/wp-content/uploads/2025/06/HOUSE-OF-SACCI.png',
            'industry' => 'Cannabis Brand & Products',
            'website' => '',
        ),
        array(
            'company_name' => 'Withum',
            'logo_url' => '/wp-content/uploads/2025/09/RGB-Withum-ATA-Logo-scaled.jpg',
            'industry' => 'Cannabis Accounting & Tax',
            'website' => 'https://www.withum.com',
        ),
        array(
            'company_name' => 'Amplified',
            'logo_url' => '/wp-content/uploads/2025/06/AmplifiedLogo-002.png',
            'industry' => 'Cannabis Marketing',
            'website' => '',
        ),
        array(
            'company_name' => 'Bootstrap Buffalo',
            'logo_url' => '', // Text only
            'industry' => 'Business Development & Networking',
            'website' => '',
        ),
        array(
            'company_name' => 'Skyworld',
            'logo_url' => '/wp-content/uploads/2025/06/couAsset-3.png',
            'industry' => 'Cannabis Retail',
            'website' => '',
        ),
        array(
            'company_name' => 'AmeriCU Credit Union',
            'logo_url' => '/wp-content/uploads/2025/09/AmeriCU_2022_Color-scaled.jpg',
            'industry' => 'Financial Services',
            'website' => 'https://www.americu.org',
        ),
    );
    
    $imported_count = 0;
    
    // Import Premier Members
    foreach ( $premier_members as $index => $member ) {
        $post_id = bcn_create_member( $member, $premier_tier->term_id, $index );
        if ( $post_id ) {
            $imported_count++;
            echo "✅ Imported Premier: {$member['company_name']} (ID: $post_id)<br>";
        }
    }
    
    // Import Professional Members
    foreach ( $professional_members as $index => $member ) {
        $post_id = bcn_create_member( $member, $professional_tier->term_id, $index );
        if ( $post_id ) {
            $imported_count++;
            echo "✅ Imported Professional: {$member['company_name']} (ID: $post_id)<br>";
        }
    }
    
    echo "<br><strong>🎉 Successfully imported $imported_count members!</strong><br>";
    echo "<br>👉 <a href='" . admin_url( 'edit.php?post_type=bcn_member' ) . "'>View Members</a> | ";
    echo "<a href='" . home_url( '/members' ) . "'>View Directory</a>";
}

function bcn_create_member( $data, $tier_id, $menu_order ) {
    // Check if member already exists
    $existing = get_page_by_title( $data['company_name'], OBJECT, 'bcn_member' );
    if ( $existing ) {
        return false; // Skip if already exists
    }
    
    $post_data = array(
        'post_title'    => $data['company_name'],
        'post_type'     => 'bcn_member',
        'post_status'   => 'publish',
        'post_excerpt'  => 'Member of Buffalo Cannabis Network',
        'menu_order'    => $menu_order,
    );
    
    $post_id = wp_insert_post( $post_data );
    
    if ( is_wp_error( $post_id ) ) {
        return false;
    }
    
    // Set tier
    wp_set_object_terms( $post_id, $tier_id, 'member_tier' );
    
    // Add meta
    update_post_meta( $post_id, 'member_company_name', $data['company_name'] );
    update_post_meta( $post_id, 'member_industry', $data['industry'] );
    update_post_meta( $post_id, 'member_join_date', date( 'Y-m-d' ) );
    
    if ( ! empty( $data['website'] ) ) {
        update_post_meta( $post_id, 'member_website_url', $data['website'] );
    }
    
    // Attach logo if exists
    if ( ! empty( $data['logo_url'] ) ) {
        $logo_path = ABSPATH . ltrim( $data['logo_url'], '/' );
        
        if ( file_exists( $logo_path ) ) {
            // Get attachment ID from URL
            $attachment_id = attachment_url_to_postid( home_url( $data['logo_url'] ) );
            
            if ( $attachment_id ) {
                set_post_thumbnail( $post_id, $attachment_id );
            }
        }
    }
    
    return $post_id;
}

// Add admin page for import
function bcn_add_import_page() {
    add_submenu_page(
        'edit.php?post_type=bcn_member',
        'Import Members',
        'Import Initial Members',
        'manage_options',
        'bcn-import-members',
        'bcn_import_members_page'
    );
}
add_action( 'admin_menu', 'bcn_add_import_page' );

function bcn_import_members_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    echo '<div class="wrap">';
    echo '<h1>Import Initial BCN Members</h1>';
    echo '<p>This will import the Premier and Professional members from your existing HTML.</p>';
    
    if ( isset( $_GET['do_import'] ) && $_GET['do_import'] === 'yes' ) {
        echo '<div style="background: #fff; padding: 2rem; border-left: 4px solid #7CB342; margin: 2rem 0;">';
        bcn_import_initial_members();
        echo '</div>';
    } else {
        echo '<p><a href="?post_type=bcn_member&page=bcn-import-members&do_import=yes" class="button button-primary button-large">Run Import Now</a></p>';
        echo '<p><strong>Note:</strong> This will not create duplicates if members already exist.</p>';
    }
    
    echo '</div>';
}

// If running via WP-CLI
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    bcn_import_initial_members();
}

