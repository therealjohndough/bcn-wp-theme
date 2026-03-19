    <!-- Footer -->
    <footer id="colophon" class="site-footer" style="background: #000; color: #fff; padding: 3rem 2rem 1.5rem; font-family: 'Roboto Flex', sans-serif;">
        <div class="footer-container" style="max-width: 1400px; margin: 0 auto;">
            
            <div class="footer-columns" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 2rem; padding: 0 var(--md-spacing-4);">
                
                <!-- Column 1: Contact Info -->
                <div class="footer-column">
                    <h4 style="color: #7CB342; font-size: 1.125rem; margin-bottom: 1rem; font-weight: 600;">Buffalo Cannabis Network</h4>
                    <p style="margin: 0.5rem 0; color: #fff;">
                        <?php 
                        $address = get_field('contact_address', 'option') ?: '505 Ellicott St';
                        $city = get_field('contact_city', 'option') ?: 'Buffalo';
                        $state = get_field('contact_state', 'option') ?: 'NY';
                        $zip = get_field('contact_zip', 'option') ?: '14203';
                        echo esc_html( $address ); ?><br>
                        <?php echo esc_html( "$city, $state $zip" ); ?><br>
                        <span style="font-size: 0.9rem; color: #999;">By appointment only</span>
                    </p>
                    <p style="margin: 0.5rem 0; color: #fff;">
                        Email: <a href="mailto:steve@buffalocannabisnetwork.com" style="color: #7CB342; text-decoration: none;">
                            steve@buffalocannabisnetwork.com
                        </a>
                    </p>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div class="footer-column">
                    <h4 style="color: #7CB342; font-size: 1.125rem; margin-bottom: 1rem; font-weight: 600;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 0.75rem;"><a href="/" style="color: #fff; text-decoration: none;">Home</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="/about" style="color: #fff; text-decoration: none;">About</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="/membership" style="color: #fff; text-decoration: none;">Membership</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="https://luma.com/BCNetwork?k=c"<style="color: #fff; text-decoration: none;">Events</a></li>
                    </ul>
                </div>
                
                <!-- Column 3: Resources -->
                <div class="footer-column">
                    <h4 style="color: #7CB342; font-size: 1.125rem; margin-bottom: 1rem; font-weight: 600;">Resources</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 0.75rem;"><a href="/members" style="color: #fff; text-decoration: none;">Member Directory</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="https://luma.com/BCNetwork?k=c"< style="color: #fff; text-decoration: none;">Event Calendar</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="/contact" style="color: #fff; text-decoration: none;">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Column 4: Connect -->
                <div class="footer-column">
                    <h4 style="color: #7CB342; font-size: 1.125rem; margin-bottom: 1rem; font-weight: 600;">Connect</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 0.75rem;"><a href="/contact" style="color: #fff; text-decoration: none;">Contact Us</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="https://www.facebook.com/buffalocannabisnetwork" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">Facebook</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="https://www.linkedin.com/company/buffalo-cannabis-network" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">LinkedIn</a></li>
                        <li style="margin-bottom: 0.75rem;"><a href="https://www.instagram.com/buffalocannabisnetwork" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">Instagram</a></li>
                    </ul>
                </div>
                
            </div>
            
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">
            
            <p style="text-align: center; color: #757575; font-size: 0.875rem; margin: 0;">
                © <?php echo date('Y'); ?> Buffalo Cannabis Network. Elevating Buffalo's cannabis standards together.
                <?php if ( function_exists( 'the_privacy_policy_link' ) ) {
                    echo ' | ';
                    the_privacy_policy_link();
                } ?>
            </p>
            
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

