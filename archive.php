<?php
/**
 * Archive Template - Material Design 3
 * For blog posts, categories, tags, and author archives
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Material 3 Archive Hero -->
    <section class="bcn-archive-hero">
        <div class="md-container">
            <div class="bcn-archive-hero-badge">
                <?php 
                if ( is_category() ) {
                    echo 'Category';
                } elseif ( is_tag() ) {
                    echo 'Tag';
                } elseif ( is_author() ) {
                    echo 'Author';
                } else {
                    echo 'News';
                }
                ?>
            </div>
            <h1 class="bcn-archive-hero-title">
                <?php 
                if ( is_category() ) {
                    single_cat_title();
                } elseif ( is_tag() ) {
                    single_tag_title();
                } elseif ( is_author() ) {
                    the_author();
                } else {
                    echo 'News & Updates';
                }
                ?>
            </h1>
            <?php if ( get_the_archive_description() ) : ?>
                <p class="bcn-archive-hero-description">
                    <?php the_archive_description(); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <?php bcn_breadcrumbs(); ?>

    <!-- Material 3 Card Grid -->
    <section class="bcn-archive-content">
        <div class="md-container">
            
            <?php if ( have_posts() ) : ?>

                <div class="bcn-posts-grid">
                    
                    <?php while ( have_posts() ) : the_post(); ?>

                        <article class="bcn-post-card">
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="bcn-post-card-image-wrapper">
                                    <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                                        <?php 
                                        the_post_thumbnail( 'medium_large', array( 
                                            'class' => 'bcn-post-card-image',
                                            'loading' => 'lazy',
                                            'alt' => esc_attr( get_the_title() )
                                        ) ); 
                                        ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="bcn-post-card-image-placeholder">
                                    <span class="icon-calendar icon-lg"></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="bcn-post-card-content">
                                
                                <?php 
                                $categories = get_the_category();
                                if ( $categories ) : ?>
                                    <div class="bcn-post-card-categories">
                                        <?php foreach ( $categories as $category ) : ?>
                                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="bcn-post-category-tag">
                                                <?php echo esc_html( $category->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3 class="bcn-post-card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <div class="bcn-post-card-meta">
                                    <span class="bcn-post-card-date">
                                        <i class="icon-calendar icon-sm"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <?php if ( get_the_author() ) : ?>
                                        <span class="bcn-post-card-author">
                                            <i class="icon-user icon-sm"></i>
                                            <?php the_author(); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ( get_the_excerpt() ) : ?>
                                    <p class="bcn-post-card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="bcn-post-card-button">
                                    Read Article <i class="icon-arrow-right icon-sm"></i>
                                </a>
                            </div>
                            
                        </article>

                    <?php endwhile; ?>
                    
                </div>

                <!-- Material 3 Pagination -->
                <div class="bcn-pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ) );
                    ?>
                </div>

            <?php else : ?>

                <div class="bcn-archive-empty">
                    <p>No posts found.</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
?>
