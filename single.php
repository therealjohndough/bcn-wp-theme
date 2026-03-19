<?php
/**
 * Single Post/Blog Template - Material Design 3
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<?php bcn_breadcrumbs(); ?>

<main id="primary" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Material 3 Post Header -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div style="position: relative; height: 500px; overflow: hidden; background: var(--md-sys-color-surface-variant);">
                    <?php the_post_thumbnail( 'full', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
                    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.85) 100%);"></div>
                    
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: var(--md-spacing-12) var(--md-spacing-4);">
                        <div class="md-container-narrow">
                            <?php the_category( ', ' ); ?>
                            <h1 style="color: white; margin: var(--md-spacing-3) 0 var(--md-spacing-4); text-shadow: 0 2px 8px rgba(0,0,0,0.3); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">
                                <?php the_title(); ?>
                            </h1>
                            <div style="display: flex; gap: var(--md-spacing-6); align-items: center; flex-wrap: wrap; color: rgba(255,255,255,0.87); font-size: 14px;">
                                <span style="display: inline-flex; align-items: center; gap: var(--md-spacing-2);"><i class="icon-calendar icon-sm" style="color: rgba(255,255,255,0.87);"></i> <?php echo get_the_date(); ?></span>
                                <span style="display: inline-flex; align-items: center; gap: var(--md-spacing-2);"><i class="icon-edit icon-sm" style="color: rgba(255,255,255,0.87);"></i> <?php the_author(); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div style="background: var(--md-sys-color-primary-container); padding: var(--md-spacing-16) var(--md-spacing-4); text-align: center;">
                    <div class="md-container-narrow">
                        <?php the_category( ', ' ); ?>
                        <h1 style="color: var(--md-sys-color-on-primary-container); margin: var(--md-spacing-3) 0 var(--md-spacing-4); font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif; line-height: 1.1; letter-spacing: 0.01em; font-stretch: 125%;">
                            <?php the_title(); ?>
                        </h1>
                        <div style="display: flex; gap: var(--md-spacing-6); justify-content: center; align-items: center; flex-wrap: wrap; color: var(--md-sys-color-on-primary-container); opacity: 0.75; font-size: 14px;">
                            <span style="display: inline-flex; align-items: center; gap: var(--md-spacing-2);"><i class="icon-calendar icon-sm"></i> <?php echo get_the_date(); ?></span>
                            <span style="display: inline-flex; align-items: center; gap: var(--md-spacing-2);"><i class="icon-edit icon-sm"></i> <?php the_author(); ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Post Content - Material 3 Spacing -->
            <div class="entry-content md-container-narrow" style="padding-top: var(--md-spacing-16); padding-bottom: var(--md-spacing-12);">
                <?php the_content(); ?>
            </div>

            <!-- Material 3 Tags -->
            <?php if ( has_tag() ) : ?>
                <div class="md-container-narrow" style="padding: 0 var(--md-spacing-4) var(--md-spacing-8);">
                    <div style="background: var(--md-sys-color-surface-variant); padding: var(--md-spacing-6); border-radius: var(--md-shape-corner-large);">
                        <strong style="display: block; margin-bottom: var(--md-spacing-3); color: var(--md-sys-color-on-surface);">Topics:</strong>
                        <div style="display: flex; gap: var(--md-spacing-2); flex-wrap: wrap;">
                            <?php 
                            $tags = get_the_tags();
                            foreach ( $tags as $tag ) :
                            ?>
                                <a href="<?php echo get_tag_link( $tag->term_id ); ?>" style="background: var(--md-sys-color-primary); color: var(--md-sys-color-on-primary); padding: var(--md-spacing-2) var(--md-spacing-4); border-radius: var(--md-shape-corner-small); font-size: 13px; font-weight: 500; box-shadow: var(--md-elevation-1); transition: all 200ms;">
                                    <?php echo $tag->name; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Material 3 Share Section -->
            <div style="background: var(--md-sys-color-surface); padding: var(--md-spacing-12) var(--md-spacing-4); border-top: 1px solid var(--md-sys-color-outline-variant);">
                <div class="md-container-narrow" style="text-align: center;">
                    <h3 style="margin-bottom: var(--md-spacing-6); color: var(--md-sys-color-on-surface);">Share This Article</h3>
                    <div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="md-elevation-2" style="background: var(--md-sys-color-secondary); color: white; width: 48px; height: 48px; border-radius: var(--md-shape-corner-full); display: flex; align-items: center; justify-content: center; transition: all 200ms;">
                            <i class="icon-facebook icon-md"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" class="md-elevation-2" style="background: var(--md-sys-color-primary); color: white; width: 48px; height: 48px; border-radius: var(--md-shape-corner-full); display: flex; align-items: center; justify-content: center; transition: all 200ms;">
                            <i class="icon-twitter icon-md"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" class="md-elevation-2" style="background: var(--md-sys-color-tertiary); color: white; width: 48px; height: 48px; border-radius: var(--md-shape-corner-full); display: flex; align-items: center; justify-content: center; transition: all 200ms;">
                            <i class="icon-linkedin icon-md"></i>
                        </a>
                    </div>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
