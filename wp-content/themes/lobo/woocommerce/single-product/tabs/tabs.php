<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="lobo-accordion" data-opened="0">

		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div id="tab-<?php echo $key ?>" class="section clearfix">

				<h3><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></h3>

				<div class="content"><?php call_user_func( $tab['callback'], $key, $tab ) ?></div>

			</div>

		<?php endforeach; ?>
		
	</div>

<?php endif; ?>