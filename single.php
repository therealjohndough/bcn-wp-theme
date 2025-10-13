<?php
/**
 * The template for displaying all single posts
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/content', 'single');

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

        // Previous/next post navigation.
        the_post_navigation(
            array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'bcn-wp-theme') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'bcn-wp-theme') . '</span> <span class="nav-title">%title</span>',
            )
        );

    endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
