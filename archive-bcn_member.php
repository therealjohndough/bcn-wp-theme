<?php
/**
 * Archive template for member directory.
 *
 * @package BCN_WP_Theme
 */

get_header();
?>

<main id="primary" class="site-main member-archive">
    <header class="page-header member-archive__header">
        <h1 class="page-title"><?php esc_html_e('Member Directory', 'bcn-wp-theme'); ?></h1>
        <p class="page-subtitle"><?php esc_html_e('Explore the companies and partners who power our community.', 'bcn-wp-theme'); ?></p>
    </header>

    <section class="member-archive__filters">
        <form method="get" class="member-archive__filter-form">
            <div class="member-archive__filter">
                <label for="membership_level"><?php esc_html_e('Membership Level', 'bcn-wp-theme'); ?></label>
                <select name="membership_level" id="membership_level">
                    <option value=""><?php esc_html_e('All levels', 'bcn-wp-theme'); ?></option>
                    <?php
                    $current_level = isset($_GET['membership_level']) ? sanitize_key(wp_unslash($_GET['membership_level'])) : '';
                    $levels        = get_terms(
                        array(
                            'taxonomy'   => 'bcn_membership_level',
                            'hide_empty' => false,
                        )
                    );

                    foreach ($levels as $level) {
                        printf(
                            '<option value="%1$s" %2$s>%3$s</option>',
                            esc_attr($level->slug),
                            selected($current_level, $level->slug, false),
                            esc_html($level->name)
                        );
                    }
                    ?>
                </select>
            </div>
            <div class="member-archive__filter">
                <label for="member-search"><?php esc_html_e('Search members', 'bcn-wp-theme'); ?></label>
                <input type="search" id="member-search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search by name or keyword', 'bcn-wp-theme'); ?>" />
            </div>
            <div class="member-archive__filter member-archive__filter--checkbox">
                <?php
                $featured_checked = isset($_GET['featured_only']) ? (bool) $_GET['featured_only'] : false;
                ?>
                <label for="featured_only">
                    <input type="checkbox" name="featured_only" id="featured_only" value="1" <?php checked($featured_checked); ?> />
                    <?php esc_html_e('Show featured members only', 'bcn-wp-theme'); ?>
                </label>
            </div>
            <div class="member-archive__actions">
                <button type="submit" class="button button-primary"><?php esc_html_e('Apply filters', 'bcn-wp-theme'); ?></button>
                <a class="button button-secondary" href="<?php echo esc_url(get_post_type_archive_link('bcn_member')); ?>">
                    <?php esc_html_e('Reset', 'bcn-wp-theme'); ?>
                </a>
            </div>
        </form>
    </section>

    <?php if (have_posts()) : ?>
        <div class="member-archive__grid">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'member-card');
            endwhile;
            ?>
        </div>

        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <section class="member-archive__empty">
            <h2><?php esc_html_e('No members found', 'bcn-wp-theme'); ?></h2>
            <p><?php esc_html_e('Try adjusting your filters or search terms.', 'bcn-wp-theme'); ?></p>
        </section>
    <?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
