<?php
/**
 * Standard Page Template - Material Design 3
 *
 * @package BuffaloCannabisNetwork
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		// HERO SUBTITLE SOURCE OF TRUTH:
		// 1) The SEO Framework meta description
		// 2) Page excerpt fallback
		$hero_subtitle = get_post_meta( get_the_ID(), '_genesis_description', true );

		if ( empty( $hero_subtitle ) && has_excerpt() ) {
			$hero_subtitle = get_the_excerpt();
		}

		if ( ! empty( $hero_subtitle ) ) {
			$hero_subtitle = wp_strip_all_tags( $hero_subtitle );
			$hero_subtitle = trim( $hero_subtitle );

			// Optional: keep it readable in a hero
			$hero_subtitle = wp_html_excerpt( $hero_subtitle, 170, '…' );
		}

		// Global hero background (site-wide)
		$hero_bg_url = 'https://buffalocannabisnetwork.com/wp-content/uploads/2025/12/AdobeStock_1553720518-scaled.webp';
		?>

		<!-- Material 3 Page Hero -->
		<section style="
			background:
				linear-gradient(135deg, rgba(0,0,0,0.55), rgba(0,0,0,0.25)),
				url('<?php echo esc_url( $hero_bg_url ); ?>');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			padding: var(--md-spacing-20) var(--md-spacing-4);
			text-align: center;
			position: relative;
			overflow: hidden;
		">
			<!-- Optional subtle dot texture overlay (keep or delete) -->
			<div style="
				position: absolute;
				inset: 0;
				background: url('data:image/svg+xml,<svg width=&quot;100&quot; height=&quot;100&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;2&quot; fill=&quot;rgba(255,255,255,0.1)&quot;/></svg>');
				opacity: 0.3;
			"></div>

			<div class="md-container-narrow" style="position: relative; z-index: 1;">
				<h1 style="
					color: white;
					margin-bottom: var(--md-spacing-4);
					font-size: clamp(2.5rem, 6vw, 4rem);
					font-weight: 900;
					font-family: 'Roboto', 'Roboto Black', 'Roboto Condensed', sans-serif;
					line-height: 1.1;
					letter-spacing: 0.01em;
					font-stretch: 125%;
				">
					<?php the_title(); ?>
				</h1>

				<?php if ( ! empty( $hero_subtitle ) ) : ?>
					<p style="
						font-size: clamp(1rem, 2vw, 1.25rem);
						color: rgba(255,255,255,0.95);
						max-width: 700px;
						margin: 0 auto;
						line-height: 1.6;
						font-weight: 400;
					">
						<?php echo esc_html( $hero_subtitle ); ?>
					</p>
				<?php endif; ?>
			</div>
		</section>

		<?php
		// Breadcrumbs (if your function exists)
		if ( function_exists( 'bcn_breadcrumbs' ) ) {
			bcn_breadcrumbs();
		}
		?>

		<!-- Page Content -->
		<section style="padding: var(--md-spacing-20) var(--md-spacing-4);">
			<div class="md-container">
				<div class="entry-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'buffalo-cannabis-network' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>
		</section>

		<!-- Material 3 CTA Card -->
		<section style="padding: var(--md-spacing-16) var(--md-spacing-4); background: var(--md-sys-color-surface-variant);">
			<div class="md-container">
				<div class="bcn-card-hover" style="
					background: linear-gradient(135deg, var(--md-sys-color-primary), var(--md-sys-color-secondary));
					padding: var(--md-spacing-12);
					border-radius: var(--md-shape-corner-extra-large);
					text-align: center;
					box-shadow: var(--md-elevation-3);
				">
					<h2 style="color: white; margin-bottom: var(--md-spacing-4); font-size: 2.5rem; font-weight: 500;">
						Ready to Get Involved?
					</h2>
					<p style="font-size: 18px; margin-bottom: var(--md-spacing-8); color: white; line-height: 1.6;">
						Join Buffalo's premier cannabis community
					</p>

					<div style="display: flex; gap: var(--md-spacing-4); justify-content: center; flex-wrap: wrap;">
						<a href="<?php echo esc_url( home_url( '/membership' ) ); ?>" class="bcn-button-primary">
							View Membership
						</a>
						<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="bcn-button-secondary">
							Contact Us
						</a>
					</div>
				</div>
			</div>
		</section>

	<?php endwhile; ?>

</main>

<?php
get_footer();
