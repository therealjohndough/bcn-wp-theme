<?php
/**
 * Title: Members Showcase
 * Slug: bcn/members-showcase
 * Categories: bcn-team
 * Description: Display premier and professional members with logos
 */

// Get members
$premier_members = new WP_Query( array(
    'post_type' => 'bcn_member',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'member_tier',
            'field' => 'slug',
            'terms' => 'premier-member',
        ),
    ),
    'orderby' => 'menu_order title',
    'order' => 'ASC'
) );

$professional_members = new WP_Query( array(
    'post_type' => 'bcn_member',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'member_tier',
            'field' => 'slug',
            'terms' => 'professional-member',
        ),
    ),
    'orderby' => 'menu_order title',
    'order' => 'ASC'
) );

?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"2rem","right":"2rem"}}},"backgroundColor":"background-subtle","layout":{"type":"constrained","contentSize":"1400px"}} -->
<div class="wp-block-group has-background-subtle-background-color has-background" style="padding-top:5rem;padding-right:2rem;padding-bottom:5rem;padding-left:2rem">

    <!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"3rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"1rem"}}},"textColor":"text-primary"} -->
    <h2 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-bottom:1rem;font-size:3rem;font-weight:600">We Are Stronger, Together</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"4rem"}}},"textColor":"text-secondary"} -->
    <p class="has-text-align-center has-text-secondary-color has-text-color" style="margin-bottom:4rem;font-size:1.125rem">Meet our valued members powering Buffalo's cannabis industry</p>
    <!-- /wp:paragraph -->

    <?php if ( $premier_members->have_posts() ) : ?>
    
    <!-- Premier Members Section -->
    <!-- wp:heading {"level":3,"textAlign":"center","style":{"typography":{"fontSize":"2rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"2rem"}}},"textColor":"text-primary"} -->
    <h3 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-bottom:2rem;font-size:2rem;font-weight:600">Premier Members</h3>
    <!-- /wp:heading -->

    <!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"radius":"12px"}},"backgroundColor":"base","className":"bcn-premier-slider-container shadow-md","layout":{"type":"constrained"}} -->
    <div class="wp-block-group bcn-premier-slider-container shadow-md has-base-background-color has-background" style="border-radius:12px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
        
        <!-- wp:html -->
        <div class="bcn-premier-slider">
            <?php 
            while ( $premier_members->have_posts() ) : 
                $premier_members->the_post();
                $website = get_post_meta( get_the_ID(), 'member_website_url', true );
                $company = get_post_meta( get_the_ID(), 'member_company_name', true );
                ?>
                <div class="bcn-premier-logo">
                    <?php if ( $website ) : ?>
                        <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                            <?php else : ?>
                                <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                        <?php else : ?>
                            <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            
            <!-- Duplicate for smooth infinite scroll -->
            <?php 
            $premier_members->rewind_posts();
            while ( $premier_members->have_posts() ) : 
                $premier_members->the_post();
                $website = get_post_meta( get_the_ID(), 'member_website_url', true );
                $company = get_post_meta( get_the_ID(), 'member_company_name', true );
                ?>
                <div class="bcn-premier-logo">
                    <?php if ( $website ) : ?>
                        <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                            <?php else : ?>
                                <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                        <?php else : ?>
                            <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <!-- /wp:html -->
        
    </div>
    <!-- /wp:group -->
    
    <?php endif; ?>

    <?php if ( $professional_members->have_posts() ) : ?>
    
    <!-- Professional Members Section -->
    <!-- wp:heading {"level":3,"textAlign":"center","style":{"typography":{"fontSize":"2rem","fontWeight":"600"},"spacing":{"margin":{"top":"4rem","bottom":"2rem"}}},"textColor":"text-primary"} -->
    <h3 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-top:4rem;margin-bottom:2rem;font-size:2rem;font-weight:600">Professional Members</h3>
    <!-- /wp:heading -->

    <!-- wp:html -->
    <div class="bcn-member-grid">
        <?php 
        while ( $professional_members->have_posts() ) : 
            $professional_members->the_post();
            $website = get_post_meta( get_the_ID(), 'member_website_url', true );
            $company = get_post_meta( get_the_ID(), 'member_company_name', true );
            ?>
            <div class="bcn-member-card">
                <?php if ( $website ) : ?>
                    <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener nofollow" class="bcn-member-card-link">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                        <?php else : ?>
                            <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php else : ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( $company ) ) ); ?>
                    <?php else : ?>
                        <span class="bcn-member-name"><?php echo esc_html( $company ? $company : get_the_title() ); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <!-- /wp:html -->
    
    <?php endif; ?>

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"4rem"}}}} -->
    <div class="wp-block-buttons" style="margin-top:4rem">
        <!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"4px"}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button" href="/members" style="border-radius:4px">View Full Member Directory</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</div>
<!-- /wp:group -->

