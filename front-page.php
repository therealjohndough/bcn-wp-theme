<?php
/**
 * Front Page Template (PHP Version)
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- HERO SECTION -->
    <section style="
        background:
            linear-gradient(135deg, rgba(0,0,0,0.55), rgba(0,0,0,0.25)),
            url('https://buffalocannabisnetwork.com/wp-content/uploads/2025/12/AdobeStock_1553720518-scaled.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: clamp(500px, 90vh, 800px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--md-spacing-24) var(--md-spacing-4);
        text-align: center;
        position: relative;
        overflow: hidden;
    ">
        <div style="max-width: 900px;">
            <h1 style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; line-height: 1.1; color: white; margin-bottom: var(--md-spacing-6);">
                <?php echo esc_html( get_theme_mod( 'bcn_hero_title', get_field('hero_title') ?: 'Building Buffalo\'s Cannabis Future, Together' ) ); ?>
            </h1>

            <p style="font-size: clamp(1.25rem, 3vw, 1.75rem); font-weight: 600; color: var(--md-sys-color-accent); margin-bottom: var(--md-spacing-4);">
                <?php echo esc_html( get_theme_mod( 'bcn_hero_tagline', get_field('hero_tagline') ?: 'Connect. Support. Elevate.' ) ); ?>
            </p>

            <p style="font-size: clamp(1rem, 2vw, 1.25rem); color: rgba(255,255,255,0.95); margin-bottom: var(--md-spacing-8); max-width: 700px; margin-inline: auto;">
                <?php echo esc_html( get_theme_mod( 'bcn_hero_description', get_field('hero_description') ?: 'Western New York\'s premier network fostering a thriving, collaborative, and responsible cannabis industry' ) ); ?>
            </p>

            <div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo esc_url( get_theme_mod( 'bcn_hero_button1_link', '/membership' ) ); ?>" class="wp-element-button">
                    <?php echo esc_html( get_theme_mod( 'bcn_hero_button1_text', 'Join the Network' ) ); ?>
                </a>
                <a href="<?php echo esc_url( get_theme_mod( 'bcn_hero_button2_link', '/about' ) ); ?>" class="wp-element-button is-style-outline">
                    <?php echo esc_html( get_theme_mod( 'bcn_hero_button2_text', 'Learn More' ) ); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- COMMUNITY SLIDER (REPLACES ILLUSTRATION) -->
    <section style="margin: var(--md-spacing-12) 0;">
        <div class="md-container">

            <?php
            $slides = get_field('community_slider');
            $fallback = content_url('/uploads/2025/09/BUFFALO-CANNABIS-NETWORK-BRAND-SHOWCASE-2025_IMG_7879.jpg');
            ?>

            <?php if ( $slides && is_array($slides) ) : ?>
                <div class="swiper bcn-community-slider" style="border-radius: var(--md-shape-corner-extra-large); overflow: hidden;">
                    <div class="swiper-wrapper">
                        <?php foreach ( $slides as $slide ) :
                            $img = $slide['sizes']['large'] ?? $slide['url'];
                            $alt = $slide['alt'] ?: 'Buffalo Cannabis Network community';
                        ?>
                            <div class="swiper-slide">
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" style="width:100%; display:block;">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            <?php else : ?>
                <img src="<?php echo esc_url($fallback); ?>" alt="Buffalo Cannabis Network community" style="width:100%; display:block;" loading="lazy">
            <?php endif; ?>

        </div>
    </section>
    
    <!-- MISSION SECTION - Material 3 Spacing -->
    <section style="padding: var(--md-spacing-20) var(--md-spacing-4); text-align: center;">
        <div class="md-container-narrow">
            <h2 style="margin-bottom: var(--md-spacing-6); color: var(--md-sys-color-on-surface);">
                The Premier Cannabis Network in <span style="color: var(--md-sys-color-primary);">Western New York</span>
            </h2>
            <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant); line-height: 1.75; max-width: 800px; margin: 0 auto;">
                <?php echo esc_html( get_theme_mod( 'bcn_mission_text', get_field('mission_text') ?: 'Buffalo Cannabis Network is more than networking—it\'s a community where authentic relationships drive industry success. We\'re building sustainable, lasting connections that elevate professional standards and create opportunities for every stakeholder in WNY\'s cannabis ecosystem.' ) ); ?>
            </p>
        </div>
    </section>

    <!-- VALUES SECTION - Material 3 -->
    <section style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-20) var(--md-spacing-4);">
        <div class="md-container">
            <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                <h2 style="margin-bottom: var(--md-spacing-3);">Our Core Values</h2>
                <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">The principles that guide everything we do</p>
            </div>
            
            <?php get_template_part( 'template-parts/values', 'grid' ); ?>
        </div>
    </section>

    <!-- MEMBERS SHOWCASE - Material 3 -->
    <section style="padding: var(--md-spacing-20) var(--md-spacing-4);">
        <div class="md-container">
            <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                <h2 style="margin-bottom: var(--md-spacing-3);">
                    <?php echo esc_html( get_theme_mod( 'bcn_members_heading', get_field('members_heading') ?: 'We Are Stronger, Together' ) ); ?>
                </h2>
                <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">
                    <?php echo esc_html( get_theme_mod( 'bcn_members_subheading', get_field('members_subheading') ?: 'Meet our valued members powering Buffalo\'s cannabis industry' ) ); ?>
                </p>
            </div>
            
            <!-- Dynamic Members Display -->
            <?php echo do_shortcode('[bcn_members]'); ?>
        </div>
    </section>

    <!-- MEMBERSHIP TIERS - Material 3 -->
    <section style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-20) var(--md-spacing-4);">
        <div class="md-container">
            <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                <h2 style="margin-bottom: var(--md-spacing-3);">Join Buffalo's Most Connected Cannabis Community</h2>
                <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">Choose the membership that fits your professional goals</p>
            </div>
            
            <?php get_template_part( 'template-parts/membership', 'tiers' ); ?>
        </div>
    </section>

    <!-- FAQ SECTION - Material 3 -->
    <section style="padding: var(--md-spacing-20) var(--md-spacing-4);">
        <div class="md-container-narrow">
            <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                <h2 style="margin-bottom: var(--md-spacing-3);">Frequently Asked Questions</h2>
                <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">Everything you need to know about BCN membership</p>
            </div>
            
            <?php get_template_part( 'template-parts/faq', 'list' ); ?>
        </div>
    </section>

    <!-- CTA SECTION - Material 3 Elevated Card -->
    <section style="background: var(--md-sys-color-surface); padding: var(--md-spacing-20) var(--md-spacing-4);">
        <div class="md-container-narrow">
            <div class="bcn-card-hover" style="background: linear-gradient(135deg, var(--md-sys-color-tertiary), var(--md-sys-color-secondary)); padding: var(--md-spacing-16); border-radius: var(--md-shape-corner-extra-large); text-align: center; box-shadow: var(--md-elevation-3);">
                <h2 style="color: white; margin-bottom: var(--md-spacing-4); font-size: 2.5rem; font-weight: 500;">
                    <?php echo esc_html( get_theme_mod( 'bcn_cta_heading', get_field('cta_heading') ?: 'Ready to Join?' ) ); ?>
                </h2>
                <p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">
                    <?php echo esc_html( get_theme_mod( 'bcn_cta_text', get_field('cta_text') ?: 'Become part of Western New York\'s premier cannabis community and start building meaningful connections today.' ) ); ?>
                </p>
                
                <div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
                    <a href="/membership" class="wp-element-button" style="background: white; color: var(--md-sys-color-tertiary); padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600; box-shadow: var(--md-elevation-2); transition: transform 0.2s;">
                        Become a Member
                    </a>
                    <a href="/contact" class="wp-element-button" style="background: rgba(255,255,255,0.25); color: white; padding: var(--md-spacing-4) var(--md-spacing-8); border-radius: var(--md-shape-corner-full); font-weight: 600; border: 2px solid rgba(255,255,255,0.5); backdrop-filter: blur(10px); transition: all 0.2s;">
                        Have Questions?
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>

