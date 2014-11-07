<?php
/**
 * Template Name: Blog
 */
get_header(); ?>

	<?php while ( have_posts() ) : the_post(); 

    	if ( post_password_required() ) :
    		echo get_the_password_form();
    	else :
    		
    	?>

        <section class="content-module clearfix">

            <aside class="sidebar"></aside>

            <section class="posts-stream" data-cols="<?php echo get_option( 'lobo_blog_cols', '3' ); ?>">

	        <?php

				$paged_string = is_home() || is_front_page() ? 'page' : 'paged';
				$paged = get_query_var( $paged_string ) ? get_query_var( $paged_string ) : 1;

				$args = array(
					'paged' => $paged, 
					'post_type' => 'post'
				);
				$all_posts = new WP_Query( $args );

				global $post_i;
				$post_i = 0;

				while ( $all_posts->have_posts() ) : $all_posts->the_post();

					get_template_part( 'content' );

				endwhile; 

			?>

			</section>

			<?php lobo_pagination( $all_posts ); ?>

		</section>

	<?php endif;

	endwhile; ?>

<?php get_footer(); ?>