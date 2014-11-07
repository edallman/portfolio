<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
array_push( $classes, 'prtfl-item ifpt' );
?>
<li <?php post_class( $classes ); ?> href="<?php the_permalink(); ?>">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<?php

		if ( has_post_thumbnail() ) {

			$thumb = get_post_thumbnail_id();
			$old_img = wp_get_attachment_image_src( $thumb, 'full' );

		} else {
			$old_img = Array( get_template_directory_uri() . '/img/blank-pfolio.gif', 480, 480 );
		}

		global $loop_type;

		if ( isset( $loop_type ) && $loop_type == 'related' ) {
			$tw = 1;
			$th = 1;
		} else {
			$tw = max( floor( $old_img[1] / 480 ), 1 );
			$th = max( floor( $old_img[2] / 480 ), 1 );
		}

		$img = aq_resize( $old_img[0], $tw * 480, $th * 480, true );

		do_action( 'woocommerce_before_shop_loop_item_title' );
	?>

	<img src="<?php echo $img; ?>" width="<?php echo $tw * 480; ?>" height="<?php echo $th * 480; ?>" alt="<?php the_title(); ?>" />

	<div class="item-hover">
		<div class="item-meta">
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			<h2 class="item-title"><?php the_title(); ?></h2>
			<h5 class="item-cat"><?php lobo_categories( $post->ID, 'product_cat' ); ?></h5>
			<a class="view_button button" href="<?php echo get_permalink(); ?>"><?php _e( 'View', 'lobo' ); ?></a>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
	</div>


</li>