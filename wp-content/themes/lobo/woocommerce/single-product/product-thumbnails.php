<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="thumbnails"><div><?php

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_title = esc_attr( get_the_title( $attachment_id ) );

			$img_url = wp_get_attachment_image_src( $attachment_id, 'full' );
			$img_obj = aq_resize($img_url[0], '114', '114', true, false);

			echo '<a href="' . $img_url[0] . '" class="fancybox fancybox-thumb" data-fancybox-group="product-gallery-' . $post->ID . '"><img src="' . $img_obj[0] . '" width="' . $img_obj[1] . '" height="' . $img_obj[2] . '" alt="' . $image_title . '" /></a>';

			$loop++;
		}

	?></div></div>
	<?php
}