<?php
/**
 * Events Archive - Material Design 3
 * Template Name: Archive for bcn_event post type
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Material 3 Events Hero -->
    <section class="bcn-events-hero">
        <div class="md-container">
            <div class="bcn-events-hero-badge">Events</div>
            <h1>BCN Events</h1>
            <p>Networking, education, and community building in Buffalo's cannabis industry</p>
        </div>
    </section>

    <?php bcn_breadcrumbs(); ?>

    <!-- Events Grid - Material 3 Cards -->
    <section style="padding: var(--md-spacing-20) var(--md-spacing-4); background: var(--md-sys-color-surface-variant);">
        <div class="md-container">
            
            <?php
            // Get filter (upcoming or past)
            $filter = isset($_GET['filter']) ? sanitize_text_field( $_GET['filter'] ) : 'upcoming';
            $today = date('Y-m-d');
            
            // Build query based on filter
            $query_args = array(
                'post_type' => 'bcn_event',
                'posts_per_page' => 24,
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                'meta_key' => 'event_date',
                'orderby' => 'meta_value',
            );
            
            if ($filter === 'past') {
                $query_args['order'] = 'DESC';
                $query_args['meta_query'] = array(
                    array(
                        'key' => 'event_date',
                        'value' => $today,
                        'compare' => '<',
                        'type' => 'DATE'
                    )
                );
            } else {
                $query_args['order'] = 'ASC';
                $query_args['meta_query'] = array(
                    array(
                        'key' => 'event_date',
                        'value' => $today,
                        'compare' => '>=',
                        'type' => 'DATE'
                    )
                );
            }
            
            $events = new WP_Query( $query_args );
            
            // Filter tabs
            ?>
            <div class="bcn-events-filter-tabs">
                <a href="?filter=upcoming" class="bcn-events-filter-tab <?php echo esc_attr( $filter === 'upcoming' ? 'active' : '' ); ?>">
                    Upcoming Events
                </a>
                <a href="?filter=past" class="bcn-events-filter-tab <?php echo esc_attr( $filter === 'past' ? 'active' : '' ); ?>">
                    Past Events
                </a>
            </div>
            
            <?php
            if ( $events->have_posts() ) : ?>

                <div class="bcn-events-grid">
                    
                    <?php while ( $events->have_posts() ) : $events->the_post(); 
                        $event_date = get_post_meta( get_the_ID(), 'event_date', true );
                        $event_location = get_post_meta( get_the_ID(), 'event_location', true );
                        $event_time = get_post_meta( get_the_ID(), 'event_time', true );
                        
                        // Get event image - try ACF event_image first, then featured image
                        $event_image_url = '';
                        $event_image_alt = esc_attr( get_the_title() );
                        
                        // Method 1: Try ACF event_image field (return format is "array")
                        if ( function_exists( 'get_field' ) ) {
                            $event_image = get_field( 'event_image', get_the_ID() );
                            if ( $event_image ) {
                                if ( is_array( $event_image ) && isset( $event_image['url'] ) ) {
                                    // ACF returns array with url, alt, sizes, etc.
                                    $event_image_url = isset( $event_image['sizes']['medium_large'] ) ? $event_image['sizes']['medium_large'] : $event_image['url'];
                                    $event_image_alt = isset( $event_image['alt'] ) && ! empty( $event_image['alt'] ) ? esc_attr( $event_image['alt'] ) : $event_image_alt;
                                } elseif ( is_numeric( $event_image ) ) {
                                    // If it's an attachment ID
                                    $event_image_url = wp_get_attachment_image_url( $event_image, 'medium_large' );
                                    if ( ! $event_image_url ) {
                                        $event_image_url = wp_get_attachment_image_url( $event_image, 'full' );
                                    }
                                    $event_image_alt = get_post_meta( $event_image, '_wp_attachment_image_alt', true ) ?: $event_image_alt;
                                }
                            }
                        }
                        
                        // Method 2: Fallback to featured image if ACF image not found
                        if ( empty( $event_image_url ) && has_post_thumbnail( get_the_ID() ) ) {
                            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                            if ( $thumbnail_id ) {
                                $event_image_url = wp_get_attachment_image_url( $thumbnail_id, 'medium_large' );
                                if ( ! $event_image_url ) {
                                    $event_image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
                                }
                                if ( ! $event_image_url ) {
                                    $event_image_url = wp_get_attachment_url( $thumbnail_id );
                                }
                                $event_image_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ?: $event_image_alt;
                            }
                        }
                    ?>

                        <article class="bcn-event-card">
                            <div class="bcn-event-card-image-wrapper">
                                <?php if ( $event_image_url ) : ?>
                                    <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                                        <img 
                                            src="<?php echo esc_url( $event_image_url ); ?>" 
                                            alt="<?php echo esc_attr( $event_image_alt ); ?>"
                                            class="bcn-event-card-image"
                                            loading="lazy"
                                        />
                                    </a>
                                <?php else : ?>
                                    <div class="bcn-event-card-image-placeholder">
                                        <span class="icon-calendar icon-lg"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="bcn-event-card-content">
                                <h3 class="bcn-event-card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <div class="bcn-event-card-meta">
                                    <?php if ( $event_date ) : ?>
                                        <div class="bcn-event-card-meta-item date">
                                            <i class="icon-calendar icon-sm"></i>
                                            <span><?php echo date_i18n( 'M j, Y', strtotime( $event_date ) ); ?></span>
                                            <?php if ( $event_time ) : ?>
                                                <span> • <?php echo esc_html( bcn_format_event_time( $event_time ) ); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ( $event_location ) : ?>
                                        <div class="bcn-event-card-meta-item location">
                                            <i class="icon-map-pin icon-sm"></i>
                                            <span><?php echo esc_html( wp_trim_words( $event_location, 8 ) ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ( get_the_excerpt() ) : ?>
                                    <p class="bcn-event-card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="bcn-event-card-button">
                                    View Event <i class="icon-arrow-right icon-sm"></i>
                                </a>
                            </div>
                        </article>

                    <?php endwhile; ?>
                    
                </div>

            <?php else : ?>
                <div class="bcn-events-empty">
                    <p>
                        <?php echo $filter === 'past' ? 'No past events found.' : 'No upcoming events. Check back soon!'; ?>
                    </p>
                </div>
            <?php endif; 
            wp_reset_postdata();
            ?>

        </div>
    </section>

    <!-- CTA - Material 3 -->
    <section style="padding: var(--md-spacing-16) var(--md-spacing-4);">
        <div class="md-container-narrow">
            <div class="bcn-card-hover" style="background: linear-gradient(135deg, var(--md-sys-color-secondary), var(--md-sys-color-primary)); padding: var(--md-spacing-12); border-radius: var(--md-shape-corner-extra-large); text-align: center; box-shadow: var(--md-elevation-3);">
                <h2 style="color: white; margin-bottom: var(--md-spacing-4); font-size: 2.5rem; font-weight: 500;">Don't Miss an Event</h2>
                <p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">Become a BCN member for exclusive access to all our events</p>
                
                <a href="/membership" class="wp-element-button" style="background: white; color: var(--md-sys-color-primary); padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600; box-shadow: var(--md-elevation-2);">Become a Member</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

