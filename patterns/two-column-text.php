<?php
/**
 * Title: Two Column Text Layout
 * Slug: bcn/two-column-text
 * Categories: bcn-cards
 * Description: Two column layout for comparing content or listing features
 */
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50"}}}} -->
        <div class="wp-block-column" style="padding-right:var(--wp--preset--spacing--50)">
            <!-- wp:heading {"level":3,"style":{"typography":{"fontWeight":"600"}},"textColor":"black"} -->
            <h3 class="wp-block-heading has-black-color has-text-color" style="font-weight:600">Who We Serve</h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"textColor":"gray"} -->
            <p class="has-gray-color has-text-color">Cannabis dispensary owners, cultivators, medical marijuana professionals, and entrepreneurs across Western New York.</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"textColor":"gray"} -->
            <p class="has-gray-color has-text-color">From startup founders to established operators, we support cannabis business growth through networking and education.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"style":{"spacing":{"padding":{"left":"var:preset|spacing|50"}}}} -->
        <div class="wp-block-column" style="padding-left:var(--wp--preset--spacing--50)">
            <!-- wp:heading {"level":3,"style":{"typography":{"fontWeight":"600"}},"textColor":"black"} -->
            <h3 class="wp-block-heading has-black-color has-text-color" style="font-weight:600">What We Do</h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"textColor":"gray"} -->
            <p class="has-gray-color has-text-color">Monthly networking events, educational workshops, industry speaker series, and advocacy initiatives across Buffalo region.</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"textColor":"gray"} -->
            <p class="has-gray-color has-text-color">Creating opportunities for cannabis professionals to learn, grow, and succeed in this rapidly evolving industry.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->