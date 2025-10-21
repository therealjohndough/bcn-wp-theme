<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php if (have_posts()) : ?>

        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

        <div class="post-list">
            <?php
            // Start the Loop
            while (have_posts()) :
                the_post();
                
                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part('template-parts/content', get_post_type());

            endwhile;
            ?>
        </div>

        <?php
        // Previous/next page navigation
        the_posts_pagination(array(
            'prev_text' => __('Previous', 'bcn-wp-theme'),
            'next_text' => __('Next', 'bcn-wp-theme'),
        ));
        ?>

    <?php else : ?>

        <?php get_template_part('template-parts/content', 'none'); ?>

    <?php endif; ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
