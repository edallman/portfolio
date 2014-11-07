<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php global $loop_type; $cols = $loop_type == 'related' ? 'cols-3' : get_option( 'lobo_shop_cols', 'cols-2' ); ?>
<ul class="content-module portfolio clearfix type-masonry" data-cols="<?php echo $cols; ?>">