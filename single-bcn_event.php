<?php
/**
 * Single Event Template - Material Design 3
 * Template for bcn_event post type
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<?php bcn_breadcrumbs(); ?>

<main id="primary" class="site-main">

    <?php while ( have_posts() ) : the_post(); 
        
        // Get event meta fields
        $event_date = get_post_meta( get_the_ID(), 'event_date', true );
        $event_time = get_post_meta( get_the_ID(), 'event_time', true );
        $event_location = get_post_meta( get_the_ID(), 'event_location', true );
        
        // Get registration link - try ACF first, then fallback to old meta key
        $registration_link = '';
        if ( function_exists( 'get_field' ) ) {
            $registration_link = get_field( 'registration_url', get_the_ID() );
        }
        if ( empty( $registration_link ) ) {
            $registration_link = get_post_meta( get_the_ID(), 'event_registration_link', true );
        }
        
        // Get event image - try ACF event_image first, then featured image
        $event_image_url = '';
        $event_image_alt = get_the_title();
        
        // Method 1: Try ACF event_image field (return format is "array")
        if ( function_exists( 'get_field' ) ) {
            $event_image = get_field( 'event_image', get_the_ID() );
            if ( $event_image ) {
                if ( is_array( $event_image ) && isset( $event_image['url'] ) ) {
                    // ACF returns array with url, alt, sizes, etc.
                    $event_image_url = $event_image['url']; // Use full size for hero
                    $event_image_alt = isset( $event_image['alt'] ) && ! empty( $event_image['alt'] ) ? esc_attr( $event_image['alt'] ) : $event_image_alt;
                } elseif ( is_numeric( $event_image ) ) {
                    // If it's an attachment ID
                    $event_image_url = wp_get_attachment_image_url( $event_image, 'full' );
                    if ( ! $event_image_url ) {
                        $event_image_url = wp_get_attachment_url( $event_image );
                    }
                    $event_image_alt = get_post_meta( $event_image, '_wp_attachment_image_alt', true ) ?: $event_image_alt;
                }
            }
        }
        
        // Method 2: Fallback to featured image if ACF image not found
        if ( empty( $event_image_url ) && has_post_thumbnail( get_the_ID() ) ) {
            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
            $event_image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
            if ( ! $event_image_url ) {
                $event_image_url = wp_get_attachment_url( $thumbnail_id );
            }
            if ( ! $event_image_url ) {
                $event_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            }
            $event_image_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ?: $event_image_alt;
        }
        
        // Get ACF gallery for additional images
        $event_gallery = function_exists( 'get_field' ) ? get_field( 'event_gallery', get_the_ID() ) : array();
    ?>

        <!-- Event Hero Section -->
        <?php if ( $event_image_url ) : ?>
            <div class="bcn-event-hero">
                <img 
                    src="<?php echo esc_url( $event_image_url ); ?>" 
                    alt="<?php echo esc_attr( $event_image_alt ); ?>"
                    class="bcn-event-hero-image"
                    loading="eager"
                />
                <div class="bcn-event-hero-overlay"></div>
                <div class="bcn-event-hero-content">
                    <div class="md-container">
                        <div class="bcn-event-hero-badge">Event</div>
                        <h1 class="bcn-event-hero-title"><?php the_title(); ?></h1>
                        <?php if ( $event_date || $event_time ) : ?>
                            <div class="bcn-event-hero-meta">
                                <?php if ( $event_date ) : ?>
                                    <span class="bcn-event-hero-meta-item">
                                        <i class="icon-calendar icon-sm"></i> 
                                        <?php echo date_i18n( 'F j, Y', strtotime( $event_date ) ); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ( $event_time ) : ?>
                                    <span class="bcn-event-hero-meta-item">
                                        <i class="icon-clock icon-sm"></i> 
                                        <?php echo esc_html( bcn_format_event_time( $event_time ) ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="bcn-event-hero-fallback">
                <div class="md-container">
                    <div class="bcn-event-hero-badge">Event</div>
                    <h1 class="bcn-event-hero-title"><?php the_title(); ?></h1>
                    <?php if ( $event_date || $event_time ) : ?>
                        <div class="bcn-event-hero-meta" style="justify-content: center;">
                            <?php if ( $event_date ) : ?>
                                <span class="bcn-event-hero-meta-item">
                                    <i class="icon-calendar icon-sm"></i> 
                                    <?php echo date_i18n( 'F j, Y', strtotime( $event_date ) ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ( $event_time ) : ?>
                                <span class="bcn-event-hero-meta-item">
                                    <i class="icon-clock icon-sm"></i> 
                                    <?php echo esc_html( bcn_format_event_time( $event_time ) ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Event Content Section -->
        <section class="bcn-event-main-content">
            <div class="md-container">
                <div class="bcn-event-layout">
                    
                    <!-- Sidebar with Event Details -->
                    <aside class="bcn-event-sidebar">
                        <div class="bcn-event-details-card">
                            <h2 class="bcn-event-details-title">Event Details</h2>
                            
                            <div class="bcn-event-details-list">
                                <?php if ( $event_date ) : ?>
                                    <div class="bcn-event-details-item">
                                        <div class="bcn-event-details-icon">
                                            <i class="icon-calendar icon-lg"></i>
                                        </div>
                                        <div class="bcn-event-details-text">
                                            <strong class="bcn-event-details-item-label">Date</strong>
                                            <span class="bcn-event-details-item-value"><?php echo date_i18n( 'F j, Y', strtotime( $event_date ) ); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $event_time ) : ?>
                                    <div class="bcn-event-details-item">
                                        <div class="bcn-event-details-icon">
                                            <i class="icon-clock icon-lg"></i>
                                        </div>
                                        <div class="bcn-event-details-text">
                                            <strong class="bcn-event-details-item-label">Time</strong>
                                            <span class="bcn-event-details-item-value"><?php echo esc_html( bcn_format_event_time( $event_time ) ); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $event_location ) : ?>
                                    <div class="bcn-event-details-item">
                                        <div class="bcn-event-details-icon">
                                            <i class="icon-map-pin icon-lg"></i>
                                        </div>
                                        <div class="bcn-event-details-text">
                                            <strong class="bcn-event-details-item-label">Location</strong>
                                            <span class="bcn-event-details-item-value"><?php echo esc_html( $event_location ); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $registration_link ) : ?>
                                    <div class="bcn-event-register-wrapper">
                                        <a href="<?php echo esc_url( $registration_link ); ?>" target="_blank" rel="noopener noreferrer" class="bcn-event-register-button">
                                            <span>Register for Event</span>
                                            <i class="icon-arrow-right icon-sm"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </aside>
                    
                    <!-- Main Content Area - Uses WordPress Post Content -->
                    <div class="bcn-event-content">
                        <div class="bcn-event-description">
                            <?php 
                            // Check if content exists before outputting
                            $content = get_the_content();
                            if ( ! empty( $content ) ) {
                                // Use WordPress post content (the_content)
                                the_content();
                            } else {
                                // If no content, show a message
                                echo '<p>Event details coming soon. Check back for more information!</p>';
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- Event Gallery Section -->
        <?php if ( ! empty( $event_gallery ) && is_array( $event_gallery ) ) : ?>
        <section class="bcn-event-gallery-section">
            <div class="md-container">
                <h2 class="bcn-event-gallery-title">Event Gallery</h2>
                <div class="bcn-event-gallery-grid">
                    <?php foreach ( $event_gallery as $image ) : 
                        $image_url = '';
                        $image_alt = '';
                        $image_full = '';
                        
                        // Handle different ACF return formats
                        if ( is_array( $image ) ) {
                            $image_url = isset( $image['sizes']['large'] ) ? $image['sizes']['large'] : ( isset( $image['url'] ) ? $image['url'] : '' );
                            $image_full = isset( $image['url'] ) ? $image['url'] : '';
                            $image_alt = isset( $image['alt'] ) ? $image['alt'] : '';
                        } elseif ( is_numeric( $image ) ) {
                            $image_url = wp_get_attachment_image_url( $image, 'large' );
                            $image_full = wp_get_attachment_image_url( $image, 'full' );
                            $image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true );
                        }
                        
                        if ( $image_url ) :
                    ?>
                        <a href="<?php echo esc_url( $image_full ); ?>" class="bcn-event-gallery-item" data-lightbox="event-gallery">
                            <img 
                                src="<?php echo esc_url( $image_url ); ?>" 
                                alt="<?php echo esc_attr( $image_alt ); ?>"
                                loading="lazy"
                            />
                        </a>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Social Share Section -->
        <section class="bcn-event-social-share">
            <div class="md-container">
                <div class="bcn-social-share-content">
                    <h3 class="bcn-social-share-title">Share This Event</h3>
                    <p class="bcn-social-share-subtitle">Help spread the word about this event</p>
                    <div class="bcn-event-social-links">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="bcn-event-social-link facebook" aria-label="Share on Facebook">
                            <i class="icon-facebook icon-md"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" class="bcn-event-social-link twitter" aria-label="Share on Twitter">
                            <i class="icon-twitter icon-md"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="bcn-event-social-link linkedin" aria-label="Share on LinkedIn">
                            <i class="icon-linkedin icon-md"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section style="padding: var(--md-spacing-16) var(--md-spacing-4);">
            <div class="md-container">
                <div class="bcn-card-hover" style="background: linear-gradient(135deg, var(--md-sys-color-tertiary), var(--md-sys-color-secondary)); padding: var(--md-spacing-12); border-radius: var(--md-shape-corner-extra-large); text-align: center; box-shadow: var(--md-elevation-3);">
                    <h2 style="color: white; margin-bottom: var(--md-spacing-4); font-size: 2.5rem; font-weight: 500;">Want More Events Like This?</h2>
                    <p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">Join BCN for exclusive access to all our events</p>
                    
                    <div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
                        <a href="/membership" class="bcn-button-primary">Become a Member</a>
                        <a href="/events" class="bcn-button-secondary">View All Events</a>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
