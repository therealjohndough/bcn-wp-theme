<?php
/**
 * Event Meta Boxes
 *
 * @package BuffaloCannabisNetwork
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Event Meta Boxes
 */
function bcn_add_event_meta_boxes() {
    add_meta_box(
        'bcn_event_details',
        'Event Details',
        'bcn_event_details_callback',
        'bcn_event',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'bcn_add_event_meta_boxes' );

/**
 * Event Details Meta Box Callback
 */
function bcn_event_details_callback( $post ) {
    wp_nonce_field( 'bcn_event_details_nonce', 'bcn_event_details_nonce' );
    
    $event_date = get_post_meta( $post->ID, 'event_date', true );
    $event_time = get_post_meta( $post->ID, 'event_time', true );
    $event_location = get_post_meta( $post->ID, 'event_location', true );
    $event_registration_link = get_post_meta( $post->ID, 'event_registration_link', true );
    ?>
    
    <style>
        .bcn-meta-box {
            padding: 1rem 0;
        }
        
        .bcn-meta-row {
            margin-bottom: 1.5rem;
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
            transition: border-color 0.2s ease;
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
        
        .bcn-meta-icon {
            margin-right: 0.5rem;
        }
    </style>
    
    <div class="bcn-meta-box">
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">
                <span class="bcn-meta-icon">📅</span>
                Event Date
            </label>
            <input 
                type="date" 
                name="bcn_event_date" 
                id="bcn_event_date" 
                value="<?php echo esc_attr( $event_date ); ?>" 
                class="bcn-meta-input"
            />
            <p class="bcn-meta-description">Select the date when this event will take place</p>
        </div>
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">
                <span class="bcn-meta-icon">⏰</span>
                Event Time
            </label>
            <input 
                type="time" 
                name="bcn_event_time" 
                id="bcn_event_time" 
                value="<?php echo esc_attr( $event_time ); ?>" 
                class="bcn-meta-input"
            />
            <p class="bcn-meta-description">What time does the event start? (e.g., 6:00 PM)</p>
        </div>
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">
                <span class="bcn-meta-icon">📍</span>
                Event Location
            </label>
            <input 
                type="text" 
                name="bcn_event_location" 
                id="bcn_event_location" 
                value="<?php echo esc_attr( $event_location ); ?>" 
                class="bcn-meta-input"
                placeholder="505 Ellicott St, Buffalo, NY 14203"
            />
            <p class="bcn-meta-description">Enter the full address or venue name</p>
        </div>
        
        <div class="bcn-meta-row">
            <label class="bcn-meta-label">
                <span class="bcn-meta-icon">🔗</span>
                Registration Link (Optional)
            </label>
            <input 
                type="url" 
                name="bcn_event_registration_link" 
                id="bcn_event_registration_link" 
                value="<?php echo esc_attr( $event_registration_link ); ?>" 
                class="bcn-meta-input"
                placeholder="https://example.com/register"
            />
            <p class="bcn-meta-description">Link to event registration or ticket purchase page</p>
        </div>
        
    </div>
    
    <?php
}

/**
 * Save Event Meta Box Data
 */
function bcn_save_event_meta( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['bcn_event_details_nonce'] ) || ! wp_verify_nonce( $_POST['bcn_event_details_nonce'], 'bcn_event_details_nonce' ) ) {
        return;
    }
    
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save event date
    if ( isset( $_POST['bcn_event_date'] ) ) {
        update_post_meta( $post_id, 'event_date', sanitize_text_field( $_POST['bcn_event_date'] ) );
    }
    
    // Save event time
    if ( isset( $_POST['bcn_event_time'] ) ) {
        update_post_meta( $post_id, 'event_time', sanitize_text_field( $_POST['bcn_event_time'] ) );
    }
    
    // Save event location
    if ( isset( $_POST['bcn_event_location'] ) ) {
        update_post_meta( $post_id, 'event_location', sanitize_text_field( $_POST['bcn_event_location'] ) );
    }
    
    // Save registration link
    if ( isset( $_POST['bcn_event_registration_link'] ) ) {
        update_post_meta( $post_id, 'event_registration_link', esc_url_raw( $_POST['bcn_event_registration_link'] ) );
    }
}
add_action( 'save_post_bcn_event', 'bcn_save_event_meta' );

/**
 * Add Event Columns to Admin List
 */
function bcn_event_admin_columns( $columns ) {
    $new_columns = array();
    
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        
        if ( $key === 'title' ) {
            $new_columns['event_date'] = 'Event Date';
            $new_columns['event_location'] = 'Location';
        }
    }
    
    return $new_columns;
}
add_filter( 'manage_bcn_event_posts_columns', 'bcn_event_admin_columns' );

/**
 * Populate Event Columns
 */
function bcn_event_admin_column_content( $column, $post_id ) {
    if ( $column === 'event_date' ) {
        $event_date = get_post_meta( $post_id, 'event_date', true );
        if ( $event_date ) {
            echo date_i18n( 'M j, Y', strtotime( $event_date ) );
        } else {
            echo '<span style="color: #999;">—</span>';
        }
    }
    
    if ( $column === 'event_location' ) {
        $event_location = get_post_meta( $post_id, 'event_location', true );
        if ( $event_location ) {
            echo esc_html( $event_location );
        } else {
            echo '<span style="color: #999;">—</span>';
        }
    }
}
add_action( 'manage_bcn_event_posts_custom_column', 'bcn_event_admin_column_content', 10, 2 );

/**
 * Make Event Columns Sortable
 */
function bcn_event_sortable_columns( $columns ) {
    $columns['event_date'] = 'event_date';
    return $columns;
}
add_filter( 'manage_edit-bcn_event_sortable_columns', 'bcn_event_sortable_columns' );

