<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<div class="lobo-tabs clearfix">

	<div class="contents clearfix">

<?php if ( $order ) : ?>

		<?php if ( in_array( $order->status, array( 'failed' ) ) ) : ?>

			<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'lobo' ); ?></p>

			<p><?php
				if ( is_user_logged_in() )
					_e( 'Please attempt your purchase again or go to your account page.', 'lobo' );
				else
					_e( 'Please attempt your purchase again.', 'lobo' );
			?></p>

			<p>
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'lobo' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'lobo' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<h2 class="wcp-title"><?php _e( 'Thank you', 'lobo' ); ?></h2>
			<p class="wcp-subtitle"><?php _e( 'Your order has been received.', 'lobo' ); ?></p>

			<ul class="order_details" style="margin-top: 20px">
				<li class="order">
					<?php _e( 'Order:', 'lobo' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>
				<li class="date">
					<?php _e( 'Date:', 'lobo' ); ?>
					<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
				</li>
				<li class="total">
					<?php _e( 'Total:', 'lobo' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>
				<?php if ( $order->payment_method_title ) : ?>
				<li class="method">
					<?php _e( 'Payment method:', 'lobo' ); ?>
					<strong><?php echo $order->payment_method_title; ?></strong>
				</li>
				<?php endif; ?>
			</ul>
			<div class="clear"></div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

	<?php else : ?>

		<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'lobo' ), null ); ?></p>

	<?php endif; ?>

</div>

</div>