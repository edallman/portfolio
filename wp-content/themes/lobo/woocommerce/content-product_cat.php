<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?> prtfl-item">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<?php

		$thumb = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );

		if ( $thumb != '' ) {
			$old_img = wp_get_attachment_image_src( $thumb, 'full' );
		} else {
			$old_img = Array( get_template_directory_uri() . '/img/blank-pfolio.gif', 480, 480 );
		}

		$tw = max( floor( $old_img[1] / 480 ), 1 );
		$th = max( floor( $old_img[2] / 480 ), 1 );

		$img = aq_resize( $old_img[0], $tw * 480, $th * 480, true );

	?>

	<img src="<?php echo $img; ?>" width="<?php echo $tw * 480; ?>" height="<?php echo $th * 480; ?>" alt="<?php echo $category->name; ?>" />

	<div class="item-hover">
		<div class="item-meta">
			<h2 class="item-title">
				<?php
					echo $category->name; 
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <span>(' . $category->count . ')</span>', $category );
				?>
			</h2>
			<a class="view_button button" href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"><?php _e( 'View', 'lobo' ); ?></a>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>