<?php
/**
 * Single Member Profile - Material Design 3
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<?php bcn_breadcrumbs(); ?>

<main id="primary" class="site-main">

    <?php while ( have_posts() ) : the_post();
        $company_name = get_post_meta( get_the_ID(), 'member_company_name', true );
        $website = get_post_meta( get_the_ID(), 'member_website_url', true );
        $industry = get_post_meta( get_the_ID(), 'member_industry', true );
        $contact_name = get_post_meta( get_the_ID(), 'member_contact_name', true );
        $contact_email = get_post_meta( get_the_ID(), 'member_contact_email', true );
        $phone = get_post_meta( get_the_ID(), 'member_phone', true );
        $join_date = get_post_meta( get_the_ID(), 'member_join_date', true );
        
        $tier_terms = get_the_terms( get_the_ID(), 'member_tier' );
        $tier_name = $tier_terms && !is_wp_error($tier_terms) ? $tier_terms[0]->name : '';
        $tier_slug = $tier_terms && !is_wp_error($tier_terms) ? $tier_terms[0]->slug : '';
    ?>

        <!-- Material 3 Member Header -->
        <section style="background: var(--md-sys-color-primary-container); padding: var(--md-spacing-20) var(--md-spacing-4); text-align: center;">
            <div class="md-container-narrow">
                
                <!-- Member Logo -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="max-width: 300px; margin: 0 auto var(--md-spacing-6); background: var(--md-sys-color-surface); padding: var(--md-spacing-8); border-radius: var(--md-shape-corner-large); box-shadow: var(--md-elevation-2);">
                        <?php the_post_thumbnail( 'medium', array( 'style' => 'max-width: 100%; height: auto;' ) ); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Tier Badge -->
                <?php if ( $tier_name ) : ?>
                    <div style="margin-bottom: var(--md-spacing-3);">
                        <span class="bcn-member-tier-badge <?php echo sanitize_html_class( $tier_slug ); ?>" style="display: inline-block; padding: var(--md-spacing-2) var(--md-spacing-4); border-radius: var(--md-shape-corner-full); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--md-elevation-1);">
                            <?php echo esc_html( $tier_name ); ?>
                        </span>
                    </div>
                <?php endif; ?>
                
                <h1 style="color: var(--md-sys-color-on-primary-container); margin-bottom: var(--md-spacing-3); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">
                    <?php echo esc_html( $company_name ?: get_the_title() ); ?>
                </h1>
                
                <?php if ( $industry ) : ?>
                    <p style="font-size: 18px; color: var(--md-sys-color-on-primary-container); opacity: 0.75; margin-bottom: var(--md-spacing-6);">
                        <?php echo esc_html( $industry ); ?>
                    </p>
                <?php endif; ?>
                
                <?php if ( $website ) : ?>
                    <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow" class="wp-element-button" style="background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); padding: var(--md-spacing-3) var(--md-spacing-6); border-radius: var(--md-shape-corner-full); display: inline-flex; align-items: center; gap: var(--md-spacing-2); font-weight: 600; box-shadow: var(--md-elevation-2);">
                        <i class="icon-external-link icon-sm"></i> Visit Website <i class="icon-arrow-right icon-sm"></i>
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <!-- Member Content -->
        <section style="padding: var(--md-spacing-16) var(--md-spacing-4);">
            <div class="md-container-narrow">
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

        <!-- Contact Information Card - Material 3 -->
        <?php if ( $contact_name || $contact_email || $phone ) : ?>
            <section style="padding: 0 var(--md-spacing-4) var(--md-spacing-16);">
                <div class="md-container-narrow">
                    <div class="bcn-card-hover" style="background: var(--md-sys-color-secondary-container); padding: var(--md-spacing-8); border-radius: var(--md-shape-corner-large);">
                        <h3 style="color: var(--md-sys-color-on-secondary-container); margin-bottom: var(--md-spacing-6);">Contact Information</h3>
                        
                        <div style="display: grid; gap: var(--md-spacing-4);">
                            <?php if ( $contact_name ) : ?>
                                <div style="color: var(--md-sys-color-on-secondary-container);">
                                    <strong style="display: block; font-size: 13px; opacity: 0.75; margin-bottom: 4px;">Contact Person</strong>
                                    <span><?php echo esc_html( $contact_name ); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $contact_email ) : ?>
                                <div>
                                    <strong style="display: block; font-size: 13px; opacity: 0.75; margin-bottom: 4px; color: var(--md-sys-color-on-secondary-container);">Email</strong>
                                    <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" style="color: var(--md-sys-color-primary); font-weight: 500;">
                                        <?php echo esc_html( $contact_email ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $phone ) : ?>
                                <div>
                                    <strong style="display: block; font-size: 13px; opacity: 0.75; margin-bottom: 4px; color: var(--md-sys-color-on-secondary-container);">Phone</strong>
                                    <a href="tel:<?php echo esc_attr( str_replace( array('-', ' ', '(', ')'), '', $phone ) ); ?>" style="color: var(--md-sys-color-primary); font-weight: 500;">
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $join_date ) : ?>
                                <div style="color: var(--md-sys-color-on-secondary-container);">
                                    <strong style="display: block; font-size: 13px; opacity: 0.75; margin-bottom: 4px;">Member Since</strong>
                                    <span><?php echo date_i18n( 'F Y', strtotime( $join_date ) ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Member Featured In (Photos/Posts) -->
        <?php
        $member_slug = get_post_field( 'post_name', get_the_ID() );
        $featured_posts = new WP_Query( array(
            'post_type' => array( 'post', 'bcn_event' ),
            'posts_per_page' => 12,
            'tax_query' => array(
                array(
                    'taxonomy' => 'featured_member',
                    'field'    => 'slug',
                    'terms'    => $member_slug,
                ),
            ),
        ) );
        
        if ( $featured_posts->have_posts() ) : ?>
        <section style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-20) var(--md-spacing-4);">
            <div class="md-container">
                <h2 style="text-align: center; margin-bottom: var(--md-spacing-12);">Featured In</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--md-spacing-6);">
                    <?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
                        <article class="bcn-card-hover">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div style="position: relative; overflow: hidden; background: var(--md-sys-color-surface-variant); border-radius: var(--md-shape-corner-large) var(--md-shape-corner-large) 0 0;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div style="padding: var(--md-spacing-6);">
                                <h3 style="margin-bottom: var(--md-spacing-3); font-size: 18px;">
                                    <a href="<?php the_permalink(); ?>" style="color: var(--md-sys-color-on-surface);">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p style="font-size: 13px; color: var(--md-sys-color-on-surface-variant);">
                                    <?php echo get_the_date(); ?>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- CTA -->
        <section style="padding: 0 var(--md-spacing-4) var(--md-spacing-16);">
            <div class="md-container-narrow">
                <div class="bcn-card-hover" style="background: linear-gradient(135deg, var(--md-sys-color-tertiary), var(--md-sys-color-secondary)); padding: var(--md-spacing-12); border-radius: var(--md-shape-corner-extra-large); text-align: center; color: white;">
                    <h2 style="color: white; margin-bottom: var(--md-spacing-4);">Want to Join Our Network?</h2>
                    <p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">Get listed in our member directory</p>
                    
                    <div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
                        <a href="/membership" class="wp-element-button" style="background: white; color: var(--md-sys-color-tertiary); padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600;">View Membership Options</a>
                        <a href="/members" class="wp-element-button" style="background: rgba(255,255,255,0.2); color: white; padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600; border: 2px solid white;">View All Members</a>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>

