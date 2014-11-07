<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div>

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

	<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					?>
					<li>

						<a href="<?php echo get_permalink( $product_id ); ?>">

							<?php

								$img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'medium' );
								$img_obj = aq_resize($img_url[0], '77', '77', true, false);

								$image = '<img src="' . $img_obj[0] . '" width="' . $img_obj[1] . '" height="' . $img_obj[2] . '" alt="" />';

								echo $image;

							?>

							<span class="p-name"><?php echo $product_name; ?></span>

							<span class="p-price"><?php echo __( 'Price: ', 'lobo' ) . $product_price; ?></span>
							<span class="p-quantity"><?php echo __( 'Quantity: ', 'lobo' ) . $cart_item['quantity']; ?></span>

						</a>

						<?php echo WC()->cart->get_item_data( $cart_item ); ?>

					</li>
					<?php
				}
			}
		?>

	</ul><!-- end product list -->

	<p class="total"><strong><?php _e( 'Subtotal', 'lobo' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons clearfix">
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button view wc-forward"><?php _e( 'View Cart', 'lobo' ); ?></a>
		<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout wc-forward"><?php _e( 'Checkout', 'lobo' ); ?></a>
	</p>

<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>