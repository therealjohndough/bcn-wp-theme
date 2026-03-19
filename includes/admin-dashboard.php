<?php
/**
 * BCN Custom Admin Dashboard
 *
 * @package BuffaloCannabisNetwork
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =============================================================================
// ADD CUSTOM ADMIN DASHBOARD PAGE
// =============================================================================

/**
 * Add BCN Dashboard Menu Item
 */
function bcn_add_dashboard_menu() {
    add_menu_page(
        'BCN Dashboard',
        'BCN Dashboard',
        'edit_posts',
        'bcn-dashboard',
        'bcn_render_dashboard',
        'dashicons-networking',
        2
    );
}
add_action( 'admin_menu', 'bcn_add_dashboard_menu' );

/**
 * Render Custom Dashboard
 */
function bcn_render_dashboard() {
    // Get statistics
    $stats = bcn_get_dashboard_stats();
    ?>
    <div class="wrap bcn-dashboard">
        <h1 class="bcn-dashboard-title">
            <span class="bcn-icon">🌿</span>
            Buffalo Cannabis Network Dashboard
        </h1>
        
        <div class="bcn-dashboard-grid">
            
            <!-- Quick Stats -->
            <div class="bcn-stats-grid">
                
                <div class="bcn-stat-card bcn-stat-primary">
                    <div class="bcn-stat-icon">📅</div>
                    <div class="bcn-stat-content">
                        <div class="bcn-stat-value"><?php echo esc_html( $stats['upcoming_events'] ); ?></div>
                        <div class="bcn-stat-label">Upcoming Events</div>
                    </div>
                </div>
                
                <div class="bcn-stat-card bcn-stat-secondary">
                    <div class="bcn-stat-icon">📝</div>
                    <div class="bcn-stat-content">
                        <div class="bcn-stat-value"><?php echo esc_html( $stats['total_posts'] ); ?></div>
                        <div class="bcn-stat-label">Total Posts</div>
                    </div>
                </div>
                
                <div class="bcn-stat-card bcn-stat-success">
                    <div class="bcn-stat-icon">📄</div>
                    <div class="bcn-stat-content">
                        <div class="bcn-stat-value"><?php echo esc_html( $stats['total_pages'] ); ?></div>
                        <div class="bcn-stat-label">Pages</div>
                    </div>
                </div>
                
                <div class="bcn-stat-card bcn-stat-info">
                    <div class="bcn-stat-icon">🎨</div>
                    <div class="bcn-stat-content">
                        <div class="bcn-stat-value"><?php echo esc_html( $stats['total_events'] ); ?></div>
                        <div class="bcn-stat-label">Total Events</div>
                    </div>
                </div>
                
            </div>
            
            <!-- Upcoming Events Widget -->
            <div class="bcn-widget">
                <h2 class="bcn-widget-title">
                    <span class="bcn-widget-icon">🗓️</span>
                    Upcoming Events
                </h2>
                <div class="bcn-widget-content">
                    <?php bcn_render_upcoming_events_widget(); ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bcn-widget">
                <h2 class="bcn-widget-title">
                    <span class="bcn-widget-icon">⚡</span>
                    Quick Actions
                </h2>
                <div class="bcn-widget-content">
                    <div class="bcn-quick-actions">
                        <a href="<?php echo admin_url( 'post-new.php?post_type=bcn_event' ); ?>" class="bcn-quick-action bcn-action-primary">
                            <span class="bcn-action-icon">➕</span>
                            <span class="bcn-action-text">Add New Event</span>
                        </a>
                        <a href="<?php echo admin_url( 'post-new.php' ); ?>" class="bcn-quick-action bcn-action-secondary">
                            <span class="bcn-action-icon">✍️</span>
                            <span class="bcn-action-text">Write New Post</span>
                        </a>
                        <a href="<?php echo admin_url( 'upload.php' ); ?>" class="bcn-quick-action bcn-action-success">
                            <span class="bcn-action-icon">📸</span>
                            <span class="bcn-action-text">Upload Media</span>
                        </a>
                        <a href="<?php echo home_url(); ?>" target="_blank" class="bcn-quick-action bcn-action-info">
                            <span class="bcn-action-icon">🌐</span>
                            <span class="bcn-action-text">View Site</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Posts -->
            <div class="bcn-widget bcn-widget-full">
                <h2 class="bcn-widget-title">
                    <span class="bcn-widget-icon">📰</span>
                    Recent Posts
                </h2>
                <div class="bcn-widget-content">
                    <?php bcn_render_recent_posts_widget(); ?>
                </div>
            </div>
            
        </div>
        
        <!-- Help Section -->
        <div class="bcn-help-section">
            <h3>Need Help?</h3>
            <p>
                <strong>Contact Support:</strong> steve@buffalocannabisnetwork.com<br>
                <strong>Documentation:</strong> View the theme documentation for detailed guides on managing your site.
            </p>
        </div>
        
    </div>
    
    <style>
        .bcn-dashboard {
            margin: 20px 20px 20px 0;
        }
        
        .bcn-dashboard-title {
            font-size: 2rem;
            font-weight: 600;
            color: #000;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .bcn-dashboard-title .bcn-icon {
            font-size: 2.5rem;
        }
        
        .bcn-dashboard-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        /* Stats Grid */
        .bcn-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .bcn-stat-card {
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        
        .bcn-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }
        
        .bcn-stat-icon {
            font-size: 2.5rem;
            line-height: 1;
        }
        
        .bcn-stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #000;
        }
        
        .bcn-stat-label {
            font-size: 0.875rem;
            color: #757575;
            margin-top: 0.25rem;
        }
        
        .bcn-stat-primary { border-left: 4px solid #7CB342; }
        .bcn-stat-secondary { border-left: 4px solid #4A90E2; }
        .bcn-stat-success { border-left: 4px solid #4CAF50; }
        .bcn-stat-info { border-left: 4px solid #9C27B0; }
        
        /* Widgets */
        .bcn-widget {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .bcn-widget-full {
            grid-column: 1 / -1;
        }
        
        .bcn-widget-title {
            background: linear-gradient(135deg, #7CB342 0%, #8BC34A 100%);
            color: #fff;
            padding: 1rem 1.5rem;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .bcn-widget-icon {
            font-size: 1.5rem;
        }
        
        .bcn-widget-content {
            padding: 1.5rem;
        }
        
        /* Quick Actions */
        .bcn-quick-actions {
            display: grid;
            gap: 1rem;
        }
        
        .bcn-quick-action {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .bcn-quick-action:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .bcn-action-icon {
            font-size: 1.5rem;
        }
        
        .bcn-action-primary { background: #7CB342; }
        .bcn-action-secondary { background: #4A90E2; }
        .bcn-action-success { background: #4CAF50; }
        .bcn-action-info { background: #9C27B0; }
        
        /* Event List */
        .bcn-event-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .bcn-event-item {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .bcn-event-item:last-child {
            border-bottom: none;
        }
        
        .bcn-event-title {
            font-weight: 600;
            color: #000;
            text-decoration: none;
        }
        
        .bcn-event-title:hover {
            color: #7CB342;
        }
        
        .bcn-event-date {
            font-size: 0.875rem;
            color: #757575;
        }
        
        /* Posts Table */
        .bcn-posts-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .bcn-posts-table th {
            text-align: left;
            padding: 0.75rem;
            background: #f5f5f5;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .bcn-posts-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .bcn-posts-table tr:hover {
            background: #f9f9f9;
        }
        
        .bcn-posts-table a {
            color: #000;
            text-decoration: none;
            font-weight: 600;
        }
        
        .bcn-posts-table a:hover {
            color: #7CB342;
        }
        
        .bcn-post-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .bcn-post-status.publish {
            background: #E8F5E9;
            color: #2E7D32;
        }
        
        .bcn-post-status.draft {
            background: #FFF3E0;
            color: #E65100;
        }
        
        /* Help Section */
        .bcn-help-section {
            background: #E3F2FD;
            border-left: 4px solid #2196F3;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        
        .bcn-help-section h3 {
            margin-top: 0;
            color: #1976D2;
        }
    </style>
    <?php
}

/**
 * Get Dashboard Statistics
 */
function bcn_get_dashboard_stats() {
    $upcoming_events = wp_count_posts( 'bcn_event' );
    $posts = wp_count_posts( 'post' );
    $pages = wp_count_posts( 'page' );
    
    return array(
        'upcoming_events' => $upcoming_events->publish ?? 0,
        'total_posts' => $posts->publish ?? 0,
        'total_pages' => $pages->publish ?? 0,
        'total_events' => $upcoming_events->publish + $upcoming_events->draft ?? 0,
    );
}

/**
 * Render Upcoming Events Widget
 */
function bcn_render_upcoming_events_widget() {
    $args = array(
        'post_type' => 'bcn_event',
        'posts_per_page' => 5,
        'meta_key' => 'event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'value' => date( 'Y-m-d' ),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );
    
    $events = new WP_Query( $args );
    
    if ( $events->have_posts() ) {
        echo '<ul class="bcn-event-list">';
        while ( $events->have_posts() ) {
            $events->the_post();
            $event_date = get_post_meta( get_the_ID(), 'event_date', true );
            ?>
            <li class="bcn-event-item">
                <a href="<?php echo esc_url( get_edit_post_link() ); ?>" class="bcn-event-title">
                    <?php the_title(); ?>
                </a>
                <span class="bcn-event-date">
                    <?php echo $event_date ? date_i18n( 'M j, Y', strtotime( $event_date ) ) : 'No date set'; ?>
                </span>
            </li>
            <?php
        }
        echo '</ul>';
    } else {
        echo '<p style="color: #757575;">No upcoming events. <a href="' . admin_url( 'post-new.php?post_type=bcn_event' ) . '">Create one now</a>.</p>';
    }
    
    wp_reset_postdata();
}

/**
 * Render Recent Posts Widget
 */
function bcn_render_recent_posts_widget() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'post_status' => array( 'publish', 'draft' ),
    );
    
    $posts = new WP_Query( $args );
    
    if ( $posts->have_posts() ) {
        ?>
        <table class="bcn-posts-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ( $posts->have_posts() ) {
                    $posts->the_post();
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url( get_edit_post_link() ); ?>">
                                <?php the_title(); ?>
                            </a>
                        </td>
                        <td><?php echo get_the_date( 'M j, Y' ); ?></td>
                        <td>
                            <span class="bcn-post-status <?php echo get_post_status(); ?>">
                                <?php echo ucfirst( get_post_status() ); ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo esc_url( get_edit_post_link() ); ?>">Edit</a> |
                            <a href="<?php echo esc_url( get_permalink() ); ?>" target="_blank">View</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo '<p style="color: #757575;">No posts yet. <a href="' . admin_url( 'post-new.php' ) . '">Write your first post</a>.</p>';
    }
    
    wp_reset_postdata();
}

