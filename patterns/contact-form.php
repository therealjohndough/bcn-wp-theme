<?php
/**
 * Title: Contact Form
 * Slug: bcn/contact-form
 * Categories: bcn-cta
 * Description: Professional contact form with location info
 * Inserter: yes
 */
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"2rem","right":"2rem"}}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-group has-base-background-color has-background" style="padding-top:5rem;padding-right:2rem;padding-bottom:5rem;padding-left:2rem">

    <!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"3rem","left":"3rem"}}}} -->
    <div class="wp-block-columns">
        
        <!-- LEFT COLUMN: Contact Info -->
        <!-- wp:column {"width":"40%"} -->
        <div class="wp-block-column" style="flex-basis:40%">
            
            <!-- wp:heading {"style":{"typography":{"fontSize":"2.5rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"1.5rem"}}},"textColor":"text-primary"} -->
            <h2 class="wp-block-heading has-text-primary-color has-text-color" style="margin-bottom:1.5rem;font-size:2.5rem;font-weight:600">Get in Touch</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"2.5rem"}}},"textColor":"text-secondary"} -->
            <p class="has-text-secondary-color has-text-color" style="margin-bottom:2.5rem;font-size:1.125rem">Have questions about membership, events, or partnerships? We'd love to hear from you.</p>
            <!-- /wp:paragraph -->

            <!-- Contact Details -->
            <!-- wp:group {"style":{"spacing":{"blockGap":"1.5rem","margin":{"bottom":"2.5rem"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group" style="margin-bottom:2.5rem">
                
                <!-- Email -->
                <!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group">
                    <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem"}},"textColor":"primary"} -->
                    <p class="has-primary-color has-text-color" style="font-size:1.5rem">✉️</p>
                    <!-- /wp:paragraph -->
                    
                    <!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
                    <div class="wp-block-group">
                        <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.875rem","fontWeight":"600"}},"textColor":"text-secondary"} -->
                        <p class="has-text-secondary-color has-text-color" style="font-size:0.875rem;font-weight:600">EMAIL</p>
                        <!-- /wp:paragraph -->
                        
                        <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"text-primary"} -->
                        <p class="has-text-primary-color has-text-color" style="font-size:1.125rem"><a href="mailto:steve@buffalocannabisnetwork.com">steve@buffalocannabisnetwork.com</a></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->

                <!-- Address -->
                <!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
                <div class="wp-block-group">
                    <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem"}},"textColor":"primary"} -->
                    <p class="has-primary-color has-text-color" style="font-size:1.5rem">📍</p>
                    <!-- /wp:paragraph -->
                    
                    <!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
                    <div class="wp-block-group">
                        <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.875rem","fontWeight":"600"}},"textColor":"text-secondary"} -->
                        <p class="has-text-secondary-color has-text-color" style="font-size:0.875rem;font-weight:600">ADDRESS</p>
                        <!-- /wp:paragraph -->
                        
                        <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"text-primary"} -->
                        <p class="has-text-primary-color has-text-color" style="font-size:1.125rem">505 Ellicott St<br>Buffalo, NY 14203<br><span style="font-size:0.9rem;opacity:0.8">By appointment only</span></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->

            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:column -->
        
        <!-- RIGHT COLUMN: Contact Form -->
        <!-- wp:column {"width":"60%"} -->
        <div class="wp-block-column" style="flex-basis:60%">
            
            <!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","right":"3rem","bottom":"3rem","left":"3rem"}},"border":{"radius":"12px"}},"backgroundColor":"background-subtle","className":"shadow-md","layout":{"type":"constrained"}} -->
            <div class="wp-block-group shadow-md has-background-subtle-background-color has-background" style="border-radius:12px;padding-top:3rem;padding-right:3rem;padding-bottom:3rem;padding-left:3rem">
                
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.75rem","fontWeight":"600"},"spacing":{"margin":{"bottom":"2rem"}}},"textColor":"text-primary"} -->
                <h3 class="wp-block-heading has-text-primary-color has-text-color" style="margin-bottom:2rem;font-size:1.75rem;font-weight:600">Send us a message</h3>
                <!-- /wp:heading -->

                <!-- Note: This is a placeholder. In production, replace with actual form plugin shortcode -->
                <!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
                <p style="margin-bottom:1.5rem"><strong>Name *</strong></p>
                <!-- /wp:paragraph -->

                <!-- wp:html -->
                <input type="text" class="bcn-form-input" placeholder="Your full name" style="margin-bottom: 1.5rem;" />
                <!-- /wp:html -->

                <!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
                <p style="margin-bottom:1.5rem"><strong>Email *</strong></p>
                <!-- /wp:paragraph -->

                <!-- wp:html -->
                <input type="email" class="bcn-form-input" placeholder="your@email.com" style="margin-bottom: 1.5rem;" />
                <!-- /wp:html -->

                <!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
                <p style="margin-bottom:1.5rem"><strong>Phone</strong></p>
                <!-- /wp:paragraph -->

                <!-- wp:html -->
                <input type="tel" class="bcn-form-input" placeholder="(555) 123-4567" style="margin-bottom: 1.5rem;" />
                <!-- /wp:html -->

                <!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
                <p style="margin-bottom:1.5rem"><strong>Message *</strong></p>
                <!-- /wp:paragraph -->

                <!-- wp:html -->
                <textarea class="bcn-form-input" rows="5" placeholder="Tell us how we can help..." style="margin-bottom: 2rem;"></textarea>
                <!-- /wp:html -->

                <!-- wp:buttons -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"backgroundColor":"primary","textColor":"base","width":100} -->
                    <div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button">Send Message</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->

                <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"top":"1.5rem"}}},"textColor":"text-secondary"} -->
                <p class="has-text-align-center has-text-secondary-color has-text-color" style="margin-top:1.5rem;font-size:0.875rem">Replace this placeholder with your preferred form plugin (WPForms, Contact Form 7, Gravity Forms, etc.)</p>
                <!-- /wp:paragraph -->

            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</div>
<!-- /wp:group -->

