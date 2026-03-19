<?php
/**
 * BCN Members Custom Post Type
 *
 * @package BuffaloCannabisNetwork
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Members Post Type
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
 * Add Member Meta Boxes
 */
function bcn_add_member_meta_boxes() {
    add_meta_box(
        'bcn_member_details',
        'Member Details',
        'bcn_member_details_callback',
        'bcn_member',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'bcn_add_member_meta_boxes' );

/**
 * Member Details Meta Box Callback
 */
function bcn_member_details_callback( $post ) {
    wp_nonce_field( 'bcn_member_details_nonce', 'bcn_member_details_nonce' );
    
    $company_name = get_post_meta( $post->ID, 'member_company_name', true );
    $website_url = get_post_meta( $post->ID, 'member_website_url', true );
    $contact_name = get_post_meta( $post->ID, 'member_contact_name', true );
    $contact_email = get_post_meta( $post->ID, 'member_contact_email', true );
    $phone = get_post_meta( $post->ID, 'member_phone', true );
    $industry = get_post_meta( $post->ID, 'member_industry', true );
    $join_date = get_post_meta( $post->ID, 'member_join_date', true );
    $featured_member = get_post_meta( $post->ID, 'member_featured', true );
    ?>
    
    <style>
        .bcn-meta-box {
            padding: 1rem 0;
        }
        .bcn-meta-row {
            margin-bottom: 1.5rem;
        }
        .bcn-meta-row-half {
            display: inline-block;
            width: 48%;
            margin-right: 2%;
            vertical-align: top;
        }
        .bcn-meta-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #000;
            font-size: 14px;
        }
        .bcn-meta-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .bcn-meta-input:focus {
            border-color: #7CB342;
            outline: none;
            box-shadow: 0 0 0 2px rgba(124, 179, 66, 0.1);
        }
        .bcn-meta-description {
            font-size: 12px;
            color: #757575;
            margin-top: 0.25rem;
        }
        .bcn-checkbox-wrapper {
            margin-top: 0.5rem;
        }
        .bcn-checkbox-wrapper label {
            display: inline-block;
            margin-left: 0.5rem;
            font-weight: normal;
        }
    </style>
    
    <div class="bcn-meta-box">
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">Company/Business Name *</label>
            <input 
                type="text" 
                name="bcn_member_company_name" 
                value="<?php echo esc_attr( $company_name ); ?>" 
                class="bcn-meta-input"
                placeholder="e.g., DRS Testing"
                required
            />
            <p class="bcn-meta-description">Official company or business name</p>
        </div>
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">Website URL</label>
            <input 
                type="url" 
                name="bcn_member_website_url" 
                value="<?php echo esc_attr( $website_url ); ?>" 
                class="bcn-meta-input"
                placeholder="https://example.com"
            />
            <p class="bcn-meta-description">Company website for backlink (great for SEO!)</p>
        </div>
        
        <div class="bcn-meta-row-half">
            <label class="bcn-meta-label">Primary Contact Name</label>
            <input 
                type="text" 
                name="bcn_member_contact_name" 
                value="<?php echo esc_attr( $contact_name ); ?>" 
                class="bcn-meta-input"
                placeholder="John Doe"
            />
        </div>
        
        <div class="bcn-meta-row-half">
            <label class="bcn-meta-label">Contact Email</label>
            <input 
                type="email" 
                name="bcn_member_contact_email" 
                value="<?php echo esc_attr( $contact_email ); ?>" 
                class="bcn-meta-input"
                placeholder="contact@example.com"
            />
        </div>
        
        <div class="bcn-meta-row-half">
            <label class="bcn-meta-label">Phone Number</label>
            <input 
                type="tel" 
                name="bcn_member_phone" 
                value="<?php echo esc_attr( $phone ); ?>" 
                class="bcn-meta-input"
                placeholder="(555) 123-4567"
            />
        </div>
        
        <div class="bcn-meta-row-half">
            <label class="bcn-meta-label">Industry/Category</label>
            <input 
                type="text" 
                name="bcn_member_industry" 
                value="<?php echo esc_attr( $industry ); ?>" 
                class="bcn-meta-input"
                placeholder="e.g., Testing Lab, Dispensary, Consulting"
            />
        </div>
        
        <div class="bcn-meta-row-half">
            <label class="bcn-meta-label">Join Date</label>
            <input 
                type="date" 
                name="bcn_member_join_date" 
                value="<?php echo esc_attr( $join_date ); ?>" 
                class="bcn-meta-input"
            />
        </div>
        
        <div class="bcn-meta-row">
            <div class="bcn-checkbox-wrapper">
                <input 
                    type="checkbox" 
                    name="bcn_member_featured" 
                    id="bcn_member_featured"
                    value="1"
                    <?php checked( $featured_member, '1' ); ?>
                />
                <label for="bcn_member_featured">⭐ Featured Member (show prominently on homepage)</label>
            </div>
        </div>
        
        <div class="bcn-meta-row" style="background: #E3F2FD; border-left: 4px solid #2196F3; padding: 1rem; border-radius: 4px; margin-top: 2rem;">
            <strong>💡 Pro Tip:</strong> Upload the company logo as the Featured Image (bottom right sidebar) for best results!
        </div>
        
    </div>
    
    <?php
}

/**
 * Save Member Meta
 */
function bcn_save_member_meta( $post_id ) {
    if ( ! isset( $_POST['bcn_member_details_nonce'] ) || ! wp_verify_nonce( $_POST['bcn_member_details_nonce'], 'bcn_member_details_nonce' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save all meta fields
    $fields = array(
        'member_company_name',
        'member_website_url',
        'member_contact_name',
        'member_contact_email',
        'member_phone',
        'member_industry',
        'member_join_date'
    );
    
    foreach ( $fields as $field ) {
        if ( isset( $_POST['bcn_' . $field] ) ) {
            $value = sanitize_text_field( $_POST['bcn_' . $field] );
            if ( $field === 'member_website_url' ) {
                $value = esc_url_raw( $_POST['bcn_' . $field] );
            }
            update_post_meta( $post_id, $field, $value );
        }
    }
    
    // Featured member checkbox
    $featured = isset( $_POST['bcn_member_featured'] ) ? '1' : '0';
    update_post_meta( $post_id, 'member_featured', $featured );
}
add_action( 'save_post_bcn_member', 'bcn_save_member_meta' );

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

