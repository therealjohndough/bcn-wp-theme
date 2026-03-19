<?php
/**
 * Main Index Template - Blog/News Archive
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Blog Hero -->
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
        <div class="md-container" style="position: relative; z-index: 1;">
            <div style="display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: var(--md-spacing-2) var(--md-spacing-4); border-radius: var(--md-shape-corner-full); margin-bottom: var(--md-spacing-4); font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Blog</div>
            <h1 style="color: white; margin-bottom: var(--md-spacing-3); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">News & Updates</h1>
            <p style="font-size: clamp(1rem, 2vw, 1.25rem); color: rgba(255,255,255,0.95); max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 400;">
                Stay updated with the latest from Buffalo's cannabis industry
            </p>
        </div>
    </section>

    <?php bcn_breadcrumbs(); ?>

    <!-- Blog Grid -->
    <section style="padding: var(--md-spacing-16) var(--md-spacing-4); background: var(--md-sys-color-surface-variant);">
        <div class="md-container">
            
            <?php if ( have_posts() ) : ?>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--md-spacing-6);">
                    
                    <?php while ( have_posts() ) : the_post(); ?>

                        <article class="bcn-card-hover" style="display: flex; flex-direction: column; height: 100%;">
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div style="position: relative; overflow: hidden; background: var(--md-sys-color-surface-variant); border-radius: var(--md-shape-corner-large) var(--md-shape-corner-large) 0 0;">
                                    <a href="<?php the_permalink(); ?>" style="display: block;">
                                        <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
                                    </a>
                                    <div style="position: absolute; top: var(--md-spacing-4); right: var(--md-spacing-4); display: flex; gap: var(--md-spacing-2);">
                                        <?php the_category( ' ' ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div style="padding: var(--md-spacing-8); display: flex; flex-direction: column; flex-grow: 1;">
                                
                                <div style="color: var(--md-sys-color-primary); font-size: 13px; font-weight: 600; margin-bottom: var(--md-spacing-3); display: flex; align-items: center; gap: var(--md-spacing-3);">
                                    <span style="display: inline-flex; align-items: center; gap: var(--md-spacing-1);"><i class="icon-calendar icon-xs"></i> <?php echo get_the_date('M j, Y'); ?></span>
                                    <span style="color: var(--md-sys-color-outline);">•</span>
                                    <span style="color: var(--md-sys-color-secondary); display: inline-flex; align-items: center; gap: var(--md-spacing-1);"><i class="icon-edit icon-xs"></i> <?php the_author(); ?></span>
                                </div>
                                
                                <h3 style="margin-bottom: var(--md-spacing-4); font-size: 22px; line-height: 1.3;">
                                    <a href="<?php the_permalink(); ?>" style="color: var(--md-sys-color-on-surface);">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <p style="color: var(--md-sys-color-on-surface-variant); margin-bottom: var(--md-spacing-6); line-height: 1.7; flex-grow: 1; font-size: 15px;">
                                    <?php echo wp_trim_words( get_the_excerpt(), 22 ); ?>
                                </p>
                                
                                <a href="<?php the_permalink(); ?>" class="wp-element-button" style="background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); padding: var(--md-spacing-3) var(--md-spacing-6); border-radius: var(--md-shape-corner-full); display: inline-flex; align-items: center; gap: var(--md-spacing-2); font-weight: 600; font-size: 14px; align-self: flex-start;">
                                    Read Article <i class="icon-arrow-right icon-xs"></i>
                                </a>
                            </div>
                            
                        </article>

                    <?php endwhile; ?>
                    
                </div>

                <div style="margin-top: var(--md-spacing-12); text-align: center;">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ) );
                    ?>
                </div>

            <?php else : ?>

                <div style="text-align: center; padding: var(--md-spacing-16);">
                    <p style="font-size: 18px; color: var(--md-sys-color-on-surface-variant);">No posts found.</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
?>

