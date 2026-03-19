<?php
/**
 * Template Name: Membership Page
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

        <section style="
  background:
    linear-gradient(135deg, rgba(0,0,0,0.55), rgba(0,0,0,0.25)),
    url('https://buffalocannabisnetwork.com/wp-content/uploads/2025/12/AdobeStock_1553720518-scaled.webp');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  padding: var(--md-spacing-20) var(--md-spacing-4);
  text-align: center;
  position: relative;
  overflow: hidden;
">

            <div style="position: absolute; inset: 0; background: url('data:image/svg+xml,<svg width=&quot;100&quot; height=&quot;100&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;2&quot; fill=&quot;rgba(255,255,255,0.1)&quot;/></svg>'); opacity: 0.3;"></div>
            <div class="md-container-narrow" style="position: relative; z-index: 1;">
                <div style="display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: var(--md-spacing-2) var(--md-spacing-4); border-radius: var(--md-shape-corner-full); margin-bottom: var(--md-spacing-4); font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Membership</div>
                <h1 style="color: white; margin-bottom: var(--md-spacing-4); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">
                    <?php the_title(); ?>
                </h1>
                <p style="font-size: clamp(1rem, 2vw, 1.25rem); color: rgba(255,255,255,0.95); max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 400;">
                    Choose the membership that fits your professional goals
                </p>
            </div>
        </section>

        <?php bcn_breadcrumbs(); ?>

        <section style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-20) var(--md-spacing-4);">
            <div class="md-container">
                <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                    <h2 style="margin-bottom: var(--md-spacing-3);">Join Buffalo's Most Connected Cannabis Community</h2>
                    <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">Choose the membership that fits your professional goals</p>
                </div>
                
                <?php get_template_part( 'template-parts/membership', 'tiers' ); ?>
            </div>
        </section>

        <section style="padding: var(--md-spacing-20) var(--md-spacing-4);">
            <div class="md-container-narrow">
                <div style="text-align: center; margin-bottom: var(--md-spacing-12);">
                    <h2 style="margin-bottom: var(--md-spacing-3);">Frequently Asked Questions</h2>
                    <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">Everything you need to know about BCN membership</p>
                </div>
                
                <?php get_template_part( 'template-parts/faq', 'list' ); ?>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>

