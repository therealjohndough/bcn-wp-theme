<?php
/**
 * Title: Hero Section with CTA
 * Slug: bcn/hero-section
 * Categories: bcn-hero
 * Description: Large hero banner with heading, description, and CTA buttons
 */
?>

<!-- wp:cover {"overlayColor":"secondary","minHeight":500,"isDark":false,"style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"2rem","right":"2rem"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-cover is-light" style="padding-top:6rem;padding-right:2rem;padding-bottom:6rem;padding-left:2rem;min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container">
    
    <!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"400","lineHeight":"1.1"},"spacing":{"margin":{"bottom":"1rem"}}},"textColor":"base"} -->
    <h1 class="wp-block-heading has-text-align-center has-base-color has-text-color" style="margin-bottom:1rem;font-size:3.5rem;font-weight:400;line-height:1.1">Your Hero Headline Here</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"bottom":"2.5rem"}}},"textColor":"base"} -->
    <p class="has-text-align-center has-base-color has-text-color" style="margin-bottom:2.5rem;font-size:1.25rem">A compelling description that explains your value proposition and encourages action.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1rem"}}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"4px"}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button" style="border-radius:4px">Primary Action</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"backgroundColor":"base","textColor":"secondary","style":{"border":{"radius":"4px"}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-secondary-color has-base-background-color has-text-color has-background wp-element-button" style="border-radius:4px">Learn More</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</div></div>
<!-- /wp:cover -->