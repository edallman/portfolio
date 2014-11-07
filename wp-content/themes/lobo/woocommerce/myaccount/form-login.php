<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="lobo-tabs clearfix">

	<ul class="titles clearfix">
		<li><?php _e( 'Login', 'lobo' ); ?></li>
		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?><li><?php _e( 'Register', 'lobo' ); ?></li><?php endif; ?>
	</ul>

	<div class="contents">

		<div id="customer_login">

			<h2 class="wcp-title"><?php _e( 'Login', 'lobo' ); ?></h2>
			<h4 class="wcp-subtitle"><?php _e( 'Your login details', 'lobo' ); ?></h2>

			<form method="post" class="login p-form">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="form-row form-row-wide">
					<label for="username"><?php _e( 'Username or email address', 'lobo' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>
				<p class="form-row form-row-wide">
					<label for="password"><?php _e( 'Password', 'lobo' ); ?> <span class="required">*</span></label>
					<input class="input-text" type="password" name="password" id="password" />
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row" style="text-align:center">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'lobo' ); ?>" /> 
					<label for="rememberme" class="inline" style="display: block; text-align: center;">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'lobo' ); ?>
					</label>
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'lobo' ); ?></a>
				</p>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>

		</div>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

		<div id="customer_register">

			<h2 class="wcp-title"><?php _e( 'Register', 'lobo' ); ?></h2>
			<h4 class="wcp-subtitle"><?php _e( 'Create an account', 'lobo' ); ?></h2>

			<form method="post" class="register p-form">

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

					<p class="form-row form-row-wide">
						<label for="reg_username"><?php _e( 'Username', 'lobo' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>

				<?php endif; ?>

				<p class="form-row form-row-wide">
					<label for="reg_email"><?php _e( 'Email address', 'lobo' ); ?> <span class="required">*</span></label>
					<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
		
					<p class="form-row form-row-wide">
						<label for="reg_password"><?php _e( 'Password', 'lobo' ); ?> <span class="required">*</span></label>
						<input type="password" class="input-text" name="password" id="reg_password" />
					</p>

				<?php endif; ?>

				<!-- Spam Trap -->
				<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'lobo' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

				<?php do_action( 'woocommerce_register_form' ); ?>
				<?php do_action( 'register_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-register', 'register' ); ?>
					<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'lobo' ); ?>" />
				</p>

				<?php do_action( 'woocommerce_register_form_end' ); ?>

			</form>

		</div>

		<?php endif; ?>

	</div>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
