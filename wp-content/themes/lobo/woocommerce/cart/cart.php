<?php
/**
* Cart Page
*
* @author WooThemes
* @package WooCommerce/Templates
* @version 2.1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

$size = sizeof( WC()->cart->get_cart() );
do_action( 'woocommerce_before_cart' ); ?>

<h1 class="wcp-title"><?php _e( 'Your Cart', 'lobo' ); ?></h1>
<h3 class="wcp-subtitle"><?php echo sprintf( _n( '1 item in your cart', '%s items in your cart', $size, 'lobo' ), $size ); ?></h3>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'lobo' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'lobo' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'lobo' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'lobo' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>

					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<!-- Product Name -->
						<td class="product-name">

							<?php

								$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($_product->id), 'medium');

								$img_obj = aq_resize($img_url[0], '77', '77', true, false);

								$image = '<img src="' . $img_obj[0] . '" width="' . $img_obj[1] . '" height="' . $img_obj[2] . '" alt="" />';

								echo $image;

							?>

							<?php

							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

                   			// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'lobo' ) . '</p>';
							?>

						</td>

						<!-- Product price -->
						<td class="product-price">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php

							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );

							?>
						</td>

						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>


						<!-- Remove from cart link -->
						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'lobo' ) ), $cart_item_key );
							?>
						</td>

					</tr>
					<?php
				}
			}

		do_action( 'woocommerce_cart_contents' );
			?>
			</tbody>
		</table>

		<div class="lobo-tabs">

			<ul class="titles clearfix">
				<li><?php _e( 'Cart Total', 'lobo' ); ?></li>
				<?php if ( WC()->cart->coupons_enabled() ) : ?><li><?php _e( 'Apply Coupon', 'lobo' ); ?></li><?php endif; ?>
				<?php if ( ! ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) ) : ?><li><?php _e( 'Calculate Shipping', 'lobo' ); ?></li><?php endif; ?>
			</ul>

			<div class="contents">

				<div>

					<?php woocommerce_cart_totals(); ?>

					<p style="text-align:center">

		 				<input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout', 'lobo' ); ?>" />
						<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'lobo' ); ?>" />

					</p>

					<?php do_action('woocommerce_proceed_to_checkout'); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					<?php do_action( 'woocommerce_after_cart_table' ); ?>

				</div>

				<?php if ( WC()->cart->coupons_enabled() ) : ?>

					<div class="coupon clearfix">

						<h2 class="wcp-title"><?php _e( 'Coupon Code', 'lobo' ); ?>
						<h3 class="wcp-subtitle"><?php _e( 'Get your discount', 'lobo' ); ?></h3>

						<input name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'lobo' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'lobo' ); ?>" />

						<?php do_action('woocommerce_cart_coupon'); ?>

					</div>

				<?php endif; ?>

				<?php if ( ! ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) ) : ?>

					<div><?php woocommerce_shipping_calculator(); ?></div>

				<?php endif; ?>

			</div>

		</div>

	</form>

<div class="cart-collaterals">

	<?php do_action('woocommerce_cart_collaterals'); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>