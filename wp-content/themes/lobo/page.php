<?php
/**
 * The Template for displaying all pages.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php if ( function_exists( 'is_woocommerce' ) ) {
			lobo_output_woo_header();
		} ?>

		<section class="content-module post-wrapper clearfix">

            <div class="the-post">

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry four-fifth last' ); ?>>

					<div class="post-body">

						<h2><?php the_title(); ?></h2>

						<div class="post-excerpt">

						<?php 

							the_content();
							wp_link_pages( array(
								'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'lobo' ) . '</span>'
								)
							);

						?>

						</div>

					</div>

				</article>

			</div>

		</section>

	<?php endwhile; ?>

<?php get_footer(); ?>