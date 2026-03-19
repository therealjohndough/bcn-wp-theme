<?php
/**
 * Member Directory Archive - Material Design 3
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Material 3 Directory Hero -->
    <section class="bcn-archive-hero" style="background: linear-gradient(135deg, var(--md-sys-color-tertiary), var(--md-sys-color-primary));">
        <div class="md-container">
            <div class="bcn-archive-hero-badge">Member Directory</div>
            <h1 class="bcn-archive-hero-title">Our Members</h1>
            <p class="bcn-archive-hero-description">Discover Buffalo's cannabis industry leaders and innovators</p>
        </div>
    </section>

    <?php bcn_breadcrumbs(); ?>

    <!-- Member Directory Grid - Material 3 -->
    <section class="bcn-archive-content">
        <div class="md-container">
            
            <?php
            $members = new WP_Query( array(
                'post_type' => 'bcn_member',
                'posts_per_page' => 24,
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                'orderby' => 'menu_order title',
                'order' => 'ASC',
            ) );
            
            if ( $members->have_posts() ) : ?>

                <div class="bcn-members-directory">
                    
                    <?php while ( $members->have_posts() ) : $members->the_post();
                        $company = get_post_meta( get_the_ID(), 'member_company_name', true );
                        $website = get_post_meta( get_the_ID(), 'member_website_url', true );
                        $industry = get_post_meta( get_the_ID(), 'member_industry', true );
                        
                        $tier_terms = get_the_terms( get_the_ID(), 'member_tier' );
                        $tier_slug = $tier_terms && !is_wp_error($tier_terms) ? $tier_terms[0]->slug : '';
                        $tier_name = $tier_terms && !is_wp_error($tier_terms) ? $tier_terms[0]->name : '';
                    ?>

                        <article class="bcn-member-directory-card">
                            
                            <!-- Logo Container -->
                            <div class="bcn-member-logo-container">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php 
                                    the_post_thumbnail( 'medium', array( 
                                        'alt' => esc_attr( $company ?: get_the_title() ),
                                        'loading' => 'lazy'
                                    ) ); 
                                    ?>
                                <?php else : ?>
                                    <div style="display: flex; align-items: center; justify-content: center; color: var(--md-sys-color-outline);">
                                        <i class="icon-building icon-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Member Info -->
                            <div class="bcn-member-info">
                                <?php if ( $tier_name ) : ?>
                                    <span class="bcn-member-tier-badge <?php echo sanitize_html_class( $tier_slug ); ?>">
                                        <?php echo esc_html( $tier_name ); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <h3 class="bcn-member-name">
                                    <?php echo esc_html( $company ?: get_the_title() ); ?>
                                </h3>
                                
                                <?php if ( $industry ) : ?>
                                    <p class="bcn-member-industry">
                                        <?php echo esc_html( $industry ); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ( get_the_excerpt() ) : ?>
                                    <p class="bcn-member-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="bcn-member-actions">
                                    <?php if ( $website ) : ?>
                                        <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow" class="bcn-member-button-primary">
                                            Visit Website <i class="icon-arrow-right icon-sm"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" class="bcn-member-button-secondary">
                                        View Profile <i class="icon-arrow-right icon-sm"></i>
                                    </a>
                                </div>
                            </div>
                            
                        </article>

                    <?php endwhile; ?>
                    
                </div>

                <!-- Pagination -->
                <div class="bcn-pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <div class="bcn-archive-empty">
                    <p>No members found.</p>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>

        </div>
    </section>

    <!-- CTA -->
    <section style="padding: var(--md-spacing-16) var(--md-spacing-4);">
        <div class="md-container-narrow">
            <div class="bcn-card-hover" style="background: linear-gradient(135deg, var(--md-sys-color-secondary), var(--md-sys-color-primary)); padding: var(--md-spacing-12); border-radius: var(--md-shape-corner-extra-large); text-align: center; color: white;">
                <h2 style="color: white; margin-bottom: var(--md-spacing-4);">Join Our Network</h2>
                <p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">Get listed in our directory with backlinks to your website</p>
                
                <a href="/membership" class="wp-element-button" style="background: white; color: var(--md-sys-color-primary); padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600;">View Membership Options</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

