<?php
/**
 * Title: Event Photo Gallery
 * Slug: bcn/event-gallery
 * Categories: bcn-events
 * Description: Interactive photo gallery with lightbox for event images
 */
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem","left":"2rem","right":"2rem"}}},"backgroundColor":"background-subtle","layout":{"type":"constrained","contentSize":"1400px"}} -->
<div class="wp-block-group has-background-subtle-background-color has-background" style="padding-top:4rem;padding-right:2rem;padding-bottom:4rem;padding-left:2rem">

    <!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"3rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"1rem"}}},"textColor":"text-primary"} -->
    <h2 class="wp-block-heading has-text-align-center has-text-primary-color has-text-color" style="margin-bottom:1rem;font-size:3rem;font-weight:600">Event Photos</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"bottom":"3rem"}}},"textColor":"text-secondary"} -->
    <p class="has-text-align-center has-text-secondary-color has-text-color" style="margin-bottom:3rem;font-size:1.25rem">Highlights from our cannabis industry events in Buffalo</p>
    <!-- /wp:paragraph -->

    <!-- wp:gallery {"columns":3,"linkTo":"none","sizeSlug":"large","className":"bcn-event-gallery"} -->
    <figure class="wp-block-gallery has-nested-images columns-3 is-cropped bcn-event-gallery">
        <!-- Add your gallery images here via WordPress editor -->
    </figure>
    <!-- /wp:gallery -->

</div>
<!-- /wp:group -->

