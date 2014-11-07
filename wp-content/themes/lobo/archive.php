<?php
/**
 * The template for displaying archives.
 */
get_header(); ?>

    <section class="content-module clearfix">

        <aside class="sidebar"></aside>

        <section class="posts-stream" data-cols="<?php echo get_option( 'lobo_blog_cols', '3' ); ?>">

        	<?php 

				global $post_i;
				$post_i = 0;

				while ( have_posts() ) : the_post();

					get_template_part( 'content' );

				endwhile;

				lobo_pagination( null ); 

			?>

		</section>

	</section>
	
<?php get_footer(); ?>