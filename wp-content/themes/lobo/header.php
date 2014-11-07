<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7 ie" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>


    <!-- testing svg -->

	<!-- META -->

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php lobo_indexing_meta(); ?>

	<!-- TITLE -->

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<!-- LINKS -->

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if ( get_option( 'lobo_fav' ) != '' ) : ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option( 'lobo_fav' ); ?>" />
	<?php else : ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" />
    <?php endif; ?>

	<!-- WP HEAD -->

	<?php wp_head(); ?>
		
</head>

<?php global $post; 
	$page_hero = krown_hero( $post ); ?>

<body id="body" <?php body_class( get_option( 'lobo_prlx_enable', 'parallax' ) . ' ' . get_option( 'lobo_sticky_enable', 'sticky-head' ) . ' ' . get_option( 'lobo_compact_menu', 'compact-menu' ) . lobo_custom_body_class() . ' ' . get_option( 'lobo_slider_loop', 'sldr-noloop' ) . ' ' . get_option( 'lobo_slider_fade', 'sldr-nofade' ) . ' ' . get_option( 'lobo_sticky_style', 'sticky-default' ) . ' ' . $page_hero[0] . ( function_exists( 'is_woocommerce' ) ? ' is-active-wc' : '' ) . ( get_option( 'lobo_shop_cart', 'enabled') == 'disabled' ? ' push-back-actions' : '' ) ); ?>>

	<!-- Start main wrapper -->
    <div id="main-wrapper">

        <span class="menu-firer"><a href="#"><i class="icon-menu"></i><small><?php _e( 'Menu', 'lobo' ); ?></small></a></span>
        
        <?php if ( function_exists( 'is_woocommerce' ) && ( get_option( 'lobo_shop_cart', 'enabled' ) == 'enabled' || ( get_option( 'lobo_shop_cart', 'enabled' ) == 'disabled' && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) ) ) : ?>

	        <div id="main-cart-holder">

	    		<div id="main-cart">

	        		<?php global $woocommerce; ?>

					<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
						<span><?php echo $woocommerce->cart->cart_contents_count; ?></span>
					</a>

					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>

				</div>

				<span id="main-cart-divider">|</span>

			</div>

		<?php endif; ?>

       	<!-- Start Main Nav -->
        <header id="header">
            <div id="nav-wrapper">

            	<a href="<?php echo home_url(); ?>" title="<?php _e('Home', 'lobo' ); ?>" class="logo" style="width:<?php echo get_option( 'lobo_logo_width', '77' ); ?>px;height:<?php echo get_option( 'lobo_logo_height', '75' ); ?>px">

				<!-- Get logo -->
				<?php 

				$logo = get_option( 'lobo_logo' );
				$logo_x2 = get_option( 'lobo_logo_x2' );

				if ( $logo == '' ) {
					$logo = get_template_directory_uri() . '/img/logo-light.png';
				}
				if ( $logo_x2 == '' ) {
					$logo_x2 = $logo;
				}

				$logo_d = get_option( 'lobo_logo_d' );
				$logo_x2_d = get_option( 'lobo_logo_x2_d' );

				if ( $logo_d == '' ) {
					$logo_d = get_template_directory_uri() . '/img/logo-dark.png';
				}
				if ( $logo_x2_d == '' ) {
					$logo_x2_d = $logo_d;
				}

				?>

	                <img class="logo-light regular-logo" src="<?php echo $logo; ?>" alt="<?php echo bloginfo( 'name' ); ?>">
	                <img class="logo-dark regular-logo" src="<?php echo $logo_d; ?>" alt="<?php echo bloginfo( 'name' ); ?>">
	                <img class="logo-light retina-logo" src="<?php echo $logo_x2; ?>" alt="<?php echo bloginfo( 'name' ); ?>">
	                <img class="logo-dark retina-logo" src="<?php echo $logo_x2_d; ?>" alt="<?php echo bloginfo( 'name' ); ?>">

            	</a>

            	<!-- Complete menu -->
                <nav class="main-d-nav iefix"<?php if ( get_option( 'lobo_compact_menu', 'compact-menu' ) == 'compact-menu' ) : ?> style="background-image:url(<?php echo get_option( 'lobo_compact_menu_bg' ) ;?>)"<?php endif; ?>>

	            	<?php if ( has_nav_menu( 'primary' ) ) {

						wp_nav_menu( array(
							'container' => false,
							'menu_class' => 'sf-menu',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="selector"></li><li class="current-selector"></li></ul>',
							'link_after' => '',
							'depth' => 2,
							'theme_location' => 'primary',
							'walker' => new lobo_Nav_Walker()
							)
						);

					} else {

                        echo '<ul><li><a href="' . home_url() . '">' . __( 'Home', 'lobo' ) . '</a></li></ul>';

                    } ?>

					<!-- Compact Menu -->

					<?php if ( get_option( 'lobo_compact_menu', 'compact-menu' ) == 'compact-menu' ) : ?>

					<div class="menu-footer">
                        <div class="menu-logo"></div>
                        <div class="menu-branding">
                            <p><?php echo get_option( 'lobo_compact_menu_text' ); ?></p>
                        </div>
                    </div>

                	<?php endif; ?>

                </nav>
                
            </div>

        </header>
        <!-- End Main Nav -->

        <!-- Hero Start -->

        <div class="hero-spacer" style="height: 130px;"></div>

        <section class="hero-module">

        	<?php echo $page_hero[1]; ?>

            <div class="overlay">
                <span class="close-btn">
                    <span class="hr"></span>
                    <span class="vr"></span>
                </span>
            </div>

            <div class="sticky-head-elmnts">
                <div class="actions">

                	<?php if ( is_singular( 'portfolio' ) && get_option( 'lobo_show_folio', 'disabled' ) == 'enabled' ) : ?>

                		<div class="action"><a href="<?php lobo_get_portfolio_page(); ?>" class="action-link"><?php _e( 'Portfolio' ); ?></a></div>

               		<?php endif; ?>

               		<?php if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product() || is_product_category() || is_product_tag() ) ) : ?>

                        <div class="action shop-search-filter" data-action="filter"><a href="#"><?php _e( 'SEARCH', 'lobo' ); ?></a></div>

                	<?php elseif ( is_page_template( 'template-blog.php' ) || is_search() || is_archive() || is_singular( 'post' ) || get_option( 'lobo_show_search', 'disabled' ) == 'enabled' ) : ?>

                        <div class="action action-filters" data-action="filter"><a href="#"><?php _e( 'SEARCH', 'lobo' ); ?></a></div>

                	<?php endif; ?>

                	<?php if ( is_page_template( 'template-portfolio.php' ) ) : ?>

                        <div class="action action-filters pf" data-action="filter"><a href="#"><?php _e( 'FILTERS', 'lobo' ); ?></a></div>

                	<?php endif; ?>

                	<?php if ( get_option( 'lobo_show_share', 'enabled' ) == 'enabled' ) : ?>

                    	<div class="action action-share" data-action="share"><a href="#"><?php _e( 'SHARE', 'lobo' ); ?></a></div>

                	<?php endif; ?>

                	<?php if ( get_option( 'lobo_show_fullscreen', 'enabled' ) == 'enabled' ) : ?>
                    	
                    	<div class="action action-fullscreen" data-action="fullscreen"><a href="#"><?php _e( 'FULLSCREEN', 'lobo' ); ?></a></div>

                	<?php endif; ?>

                	<?php if ( get_option( 'lobo_show_gotop', 'enabled' ) == 'enabled' ) : ?>

						<div class="action action-scroll-top" data-action="scroll"><a href="#"><?php _e( 'GO TOP', 'lobo' ); ?><i class="icon-up-open-big"></i></a></div>
                    	
                	<?php endif; ?>
                    
                </div>

                <h2 class="hero-sticky-title"><?php echo lobo_title( $post ); ?></h2>

            </div>

        	<?php lobo_page_actions(); ?>

            <div class="hero-info-shdw"></div>

            <?php echo $page_hero[2]; ?>

        </section>

        <!-- Hero End -->

        <!-- Content Start -->

        <section id="content-wrapper">