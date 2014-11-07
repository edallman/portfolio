<?php
/**
 * The template for displaying search results.
 */
get_header(); ?>

    <section class="content-module clearfix">

        <aside class="sidebar"></aside>

        <section class="posts-stream" data-cols="<?php echo get_option( 'lobo_blog_cols', '3' ); ?>">

			<?php if ( have_posts() ) : 

				global $post_i;
				$post_i = 0;

				while ( have_posts() ) : the_post();

					get_template_part( 'content' );

				endwhile;

				lobo_pagination( null );

			else : ?>

				<div class="post-item even" style="width:100%; height: 320px">
					<div class="inner-post">
						<div class="post-title">
							<?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'lobo' ); ?>
						</div>
					</div>
					<span class="post-overlay"></span>
				</div>

			<?php endif; ?>

		</section>

	</section>
	
<?php get_footer(); ?>