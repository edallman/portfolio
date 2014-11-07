<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'lobo' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	<div class="lobo-tabs clearfix">

		<ul class="titles clearfix">

			<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
				<li><?php _e( 'Billing Address', 'lobo' ); ?></li>
				<li><?php _e( 'Shipping Address', 'lobo' ); ?></li>
			<?php endif; ?>

			<?php if ( WC()->cart->coupons_enabled() ) : ?>
				<li><?php _e( 'Apply Coupon', 'lobo' ); ?></li>
			<?php endif; ?>

			<li><?php _e( 'Review Order', 'lobo' ); ?></li>

		</ul>

		<div class="contents">

			<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

				<?php //do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div id="checkout_billing">

					<h3 class="wcp-title"><?php _e( 'Billing Address', 'lobo' ); ?>
					<h4 class="wcp-subtitle"><?php _e( 'Fill in your details', 'lobo' ); ?></h4>
					<div class="p-form clearfix"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>

				</div>

				<div id="checkout_shipping">

					<h3 class="wcp-title"><?php _e( 'Shipping Address', 'lobo' ); ?>
					<h4 class="wcp-subtitle"><?php _e( 'Fill in your details', 'lobo' ); ?></h4>
					<div class="p-form clearfix"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>

				</div>

				<?php //do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

			<?php if ( WC()->cart->coupons_enabled() ) : ?>

				<div id="checkout_coupon">
					<h3 class="wcp-title"><?php _e( 'Coupon Code', 'lobo' ); ?></h3>
					<h4 class="wcp-subtitle"><?php _e( 'Forgot about your discount?', 'lobo' ); ?></h4>
				</div>
			<?php endif; ?>

			<div id="checkout_order">

				<h3 class="wcp-title"><?php _e( 'Review your order', 'lobo' ); ?></h3>
				<?php $size = sizeof( WC()->cart->get_cart() ); ?>
				<h4 class="wcp-subtitle"><?php echo sprintf( _n( '1 item in your cart', '%s items in your cart', $size, 'lobo' ), $size ); ?></h4>
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>

			</div>

		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>