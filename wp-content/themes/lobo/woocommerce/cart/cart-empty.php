<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<div class="lobo-tabs at-top-2 clearfix">

	<div class="contents clearfix">

		<p class="cart-empty"><?php _e( 'Your cart is currently empty.', 'lobo' ) ?></p>

		<?php do_action( 'woocommerce_cart_is_empty' ); ?>

		<p style="text-align:center"><a class="button wc-backward wc-button" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php _e( 'Return To Shop', 'lobo' ) ?></a></p>
	
	</div>

</div>