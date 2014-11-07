<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $current_user;

$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'lobo' ) : __( 'Shipping Address', 'lobo' );

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<div class="lobo-tabs clearfix">

	<div class="contents clearfix">

		<?php if ( ! $load_address ) : ?>

			<?php wc_get_template( 'myaccount/my-address.php' ); ?>

		<?php else : ?>

			<h2 class="wcp-title"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h2>
			<p class="wcp-subtitle"><?php _e( 'Change your details', 'lobo' ); ?></p>

			<form method="post" class="p-form">

				<?php foreach ( $address as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

				<?php endforeach; ?>

				<p style="text-align:center">
					<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'lobo' ); ?>" />
					<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
					<input type="hidden" name="action" value="edit_address" />
				</p>

			</form>

		<?php endif; ?>

	</div>

</div>