<?php
/**
 * Title: Members Showcase (Editable)
 * Slug: bcn/members-showcase-static
 * Categories: bcn-team
 * Description: Editable members section - add member logos manually
 * Inserter: yes
 */
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"2rem","right":"2rem"}}},"backgroundColor":"background-subtle","layout":{"type":"constrained","contentSize":"1400px"}} -->
<div class="wp-block-group has-background-subtle-background-color has-background" style="padding-top:5rem;padding-right:2rem;padding-bottom:5rem;padding-left:2rem">

    <!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"3rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"1rem"}}},"textColor":"text-primary"} -->
    <h2 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-bottom:1rem;font-size:3rem;font-weight:600">We Are Stronger, Together</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"4rem"}}},"textColor":"text-secondary"} -->
    <p class="has-text-align-center has-text-secondary-color has-text-color" style="margin-bottom:4rem;font-size:1.125rem">Meet our valued members powering Buffalo's cannabis industry</p>
    <!-- /wp:paragraph -->

    <!-- Premier Members Section -->
    <!-- wp:heading {"level":3,"textAlign":"center","style":{"typography":{"fontSize":"2rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"2rem"}}},"textColor":"text-primary"} -->
    <h3 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-bottom:2rem;font-size:2rem;font-weight:600">Premier Members</h3>
    <!-- /wp:heading -->

    <!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"radius":"12px"}},"backgroundColor":"base","className":"bcn-premier-slider-container shadow-md","layout":{"type":"constrained"}} -->
    <div class="wp-block-group bcn-premier-slider-container shadow-md has-base-background-color has-background" style="border-radius:12px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
        
        <!-- wp:group {"className":"bcn-premier-slider","layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <div class="wp-block-group bcn-premier-slider">
            
            <!-- Add member logos here as Image blocks -->
            <!-- wp:image {"width":"180px","height":"90px","sizeSlug":"medium","className":"bcn-premier-logo-img"} -->
            <figure class="wp-block-image size-medium is-resized bcn-premier-logo-img"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="Member Logo" style="width:180px;height:90px;object-fit:contain"/></figure>
            <!-- /wp:image -->

            <!-- Duplicate this Image block and replace with actual member logos -->
            
        </div>
        <!-- /wp:group -->
        
    </div>
    <!-- /wp:group -->

    <!-- Professional Members Section -->
    <!-- wp:heading {"level":3,"textAlign":"center","style":{"typography":{"fontSize":"2rem","fontWeight":"600"},"spacing":{"margin":{"top":"4rem","bottom":"2rem"}}},"textColor":"text-primary"} -->
    <h3 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-top:4rem;margin-bottom:2rem;font-size:2rem;font-weight:600">Professional Members</h3>
    <!-- /wp:heading -->

    <!-- wp:group {"className":"bcn-member-grid","layout":{"type":"constrained"}} -->
    <div class="wp-block-group bcn-member-grid">
        
        <!-- wp:gallery {"columns":4,"linkTo":"none","sizeSlug":"medium","className":"bcn-professional-members-gallery"} -->
        <figure class="wp-block-gallery has-nested-images columns-4 is-cropped bcn-professional-members-gallery">
            
            <!-- Add member logo images here -->
            <!-- Each image will display in a grid card -->
            
        </figure>
        <!-- /wp:gallery -->
        
    </div>
    <!-- /wp:group -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"4rem"}}}} -->
    <div class="wp-block-buttons" style="margin-top:4rem">
        <!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"4px"}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button" href="/members" style="border-radius:4px">View Full Member Directory</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</div>
<!-- /wp:group -->

