<?php
/**
 * Template Name: Portfolio
 */
get_header(); ?>

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

    	if ( post_password_required() ) :
    		echo get_the_password_form();
    	else :

		$type = get_post_meta( $post->ID, 'folio_style', true ) != '' ? get_post_meta( $post->ID, 'folio_style', true ) : 'masonry';
		$cols = get_post_meta( $post->ID, 'folio_cols', true ) != '' ? get_post_meta( $post->ID, 'folio_cols', true ) : 'cols-2';

	?>

    <section class="content-module portfolio clearfix type-<?php echo $type; ?>" data-cols="<?php echo $cols; ?>">

		<?php 

		$cats = get_post_meta( $post->ID, 'folio_cats', true );
		$filter = '';

		$infinite = get_post_meta( $post->ID, 'folio_infinite', true );
		$per = get_post_meta( $post->ID, 'folio_per', true );

		if ( $cats != '' && ! empty ( $cats ) ) {
			foreach ( $cats as $cat ) {
				
				$try_filter = get_term_by( 'id', $cat, 'portfolio_category' )->slug . ',';
				if ( $try_filter != ',' ) {
					$filter .= $try_filter;
				}

			}
		}

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

		$args = array(
			'post_type' => 'portfolio',
			'portfolio_category' => $filter,
			'offset' => 0,
			'posts_per_page' => ( $infinite != 'yes-infinite' ? -1 : $per ),
			'paged' => $paged
		);

		$all_posts = new WP_Query( $args ); 

		$page_id = $post->ID;

		while ( $all_posts->have_posts() ) : $all_posts->the_post();

			if ( has_post_thumbnail() ) {

				$thumb = get_post_thumbnail_id();
				$old_img = wp_get_attachment_image_src( $thumb, 'full' );

			} else {
				$old_img = Array( get_template_directory_uri() . '/img/blank-pfolio.gif', 480, 480 );
			}

			$link = get_new_permalink( $page_id, $post->ID, $cats );
			$target = '';

			$c_link = get_post_meta( $post->ID, 'lobo_folio_url_link', true );
			$c_target = get_post_meta( $post->ID, 'lobo_folio_url_target', true );

			if ( $c_link != '' ) {
				$link = $c_link;
				$target = $c_target;
			}

		?>

		<?php if ( $type == 'full' ) :  ?>

			<div class="module image-module <?php lobo_categories( $post->ID, 'portfolio_category', ' ', 'slug' ); ?> ifpt" data-size="4-2" data-bgimage="<?php echo $old_img[0]; ?>">
				<div class="prjct-hvr-title">
					<h2 class="hvr-title"><?php the_title(); ?></h2>
					<h3 class="hvr-subtitle"><?php lobo_categories( $post->ID, 'portfolio_category' ); ?></h3>
				</div>
				<a class="view-item-btn pfl" title="<?php the_title(); ?>" href="<?php echo $link; ?>"<?php echo ( $target != '' ? ' target="' . $target . '"' : '' ); ?>><?php _e( 'View', 'lobo' ); ?><i class="icon-fontawesome-webfont-7"></i></a>
			</div>

		<?php else : 

			$tw = max( floor( $old_img[1] / 480 ), 1 );
			$th = max( floor( $old_img[2] / 480 ), 1 );

			if ( ! strpos( $old_img[0], '.gif' ) ) {
				$img = aq_resize( $old_img[0], $tw * 480, $th * 480, true );
			} else {
				$img = $old_img[0];
			} ?>

			<a class="prtfl-item <?php lobo_categories( $post->ID, 'portfolio_category', ' ', 'slug' ); ?> ifpt pfl" title="<?php the_title(); ?>" href="<?php echo $link; ?>"<?php echo ( $target != '' ? ' target="' . $target . '"' : '' ); ?>>
				<img src="<?php echo $img; ?>" width="<?php echo $tw * 480; ?>" height="<?php echo $th * 480; ?>" alt="<?php the_title(); ?>" />
				<div class="item-hover">
					<div class="item-meta">
						<h2 class="item-title"><?php the_title(); ?></h2>
						<h3 class="item-cat"><?php lobo_categories( $post->ID, 'portfolio_category' ); ?></h3>
						<span class="thumb-extra-info"></span>
					</div>
				</div>
			</a>

		<?php endif; ?>

		<?php endwhile; ?>

	</section>

	<?php if ( $infinite == 'yes-infinite' ) : ?>
		<div id="infinite">
			<i class="fa fa-refresh fa-spin fa-2x"></i>
			<a id="infinite-link" href="<?php lobo_infinite_pagination( $all_posts ); ?>"></a>
			<p><?php _e( 'No More Projects', 'lobo' ); ?></p>
		</div>
	<?php endif; ?>

    <?php endif;
    
    endwhile; 

get_footer(); ?>