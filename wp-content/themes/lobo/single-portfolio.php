<?php
/**
 * The Template for displaying all portfolio projects.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();

    	if ( post_password_required() ) {
    		echo get_the_password_form();
    	} else {
        	lobo_modular_content( $post );
    	}

	endwhile;     

get_footer(); ?>