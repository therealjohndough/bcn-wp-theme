<?php
/**
 * Template Name: Contact Page
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
                <div style="display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: var(--md-spacing-2) var(--md-spacing-4); border-radius: var(--md-shape-corner-full); margin-bottom: var(--md-spacing-4); font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Contact Us</div>
                <h1 style="color: white; margin-bottom: var(--md-spacing-4); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">
                    <?php the_title(); ?>
                </h1>
                                <p style="font-size: clamp(1rem, 2vw, 1.25rem); color: rgba(255,255,255,0.95); max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 400;">
                    Connect with Western New York’s premier cannabis community and start building meaningful connections today.
                </p>
            </div>
        </section>


        <?php bcn_breadcrumbs(); ?>

        <section style="padding: var(--md-spacing-20) var(--md-spacing-4);">
            <div class="md-container">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--md-spacing-6); margin-bottom: var(--md-spacing-12);">
                    
                    <div class="bcn-card-hover" style="text-align: center; padding: var(--md-spacing-10);">
                        <div style="width: 80px; height: 80px; background: var(--md-sys-color-secondary-container); border-radius: var(--md-shape-corner-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--md-spacing-6);">
                            <i class="icon-mail icon-2xl" style="color: var(--md-sys-color-secondary);"></i>
                        </div>
                        <h3 style="margin-bottom: var(--md-spacing-3);">Email</h3>
                        <p><a href="mailto:steve@buffalocannabisnetwork.com" style="color: var(--md-sys-color-primary); font-weight: 600; font-size: 18px;">steve@buffalocannabisnetwork.com</a></p>
                    </div>

                    <div class="bcn-card-hover" style="text-align: center; padding: var(--md-spacing-10);">
                        <div style="width: 80px; height: 80px; background: var(--md-sys-color-tertiary-container); border-radius: var(--md-shape-corner-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--md-spacing-6);">
                            <i class="icon-map-pin icon-2xl" style="color: var(--md-sys-color-tertiary);"></i>
                        </div>
                        <h3 style="margin-bottom: var(--md-spacing-3);">Address</h3>
                        <p style="font-size: 16px;">505 Ellicott St.<br>Buffalo, NY 14203<br><span style="font-size: 0.9rem; color: var(--md-sys-color-on-surface-variant);">By appointment only</span></p>
                    </div>

                </div>
            </div>
        </section>

        <section style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-20) var(--md-spacing-4);">
            <div class="md-container-narrow entry-content">
                <?php the_content(); ?>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>

