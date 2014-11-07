<?php 
/**
 * This file contains the output of the WordPress Theme Customizer (frontend)
 */

if( ! function_exists( 'lobo_custom_css' ) ) {

	function lobo_custom_css() {

		// Get fonts
		
		$f_type_1 = is_serialized( get_option('lobo_type_1' ) ) ? unserialize( get_option('lobo_type_1' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_2 = is_serialized( get_option('lobo_type_2' ) ) ? unserialize( get_option('lobo_type_2' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_3 = is_serialized( get_option('lobo_type_3' ) ) ? unserialize( get_option('lobo_type_3' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_4 = is_serialized( get_option('lobo_type_4' ) ) ? unserialize( get_option('lobo_type_4' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );

		// Get colors
		
		$colors = get_option( 'lobo_colors' );

		if ( ! isset( $colors['main1'] ) ) {
			$colors['main1'] = '#fff85f';
		}

		$o_rgb = hex_to_rgb( $colors['main1'] );
		$o_hsl = rgb_to_hsl( $o_rgb[0], $o_rgb[1], $o_rgb[2] );

		$colors['main2'] = hsl_to_rgb( $o_hsl[0] + 4, $o_hsl[1], $o_hsl[2] + 0.1 );
		$colors['main3'] = hsl_to_rgb( $o_hsl[0], $o_hsl[1], $o_hsl[2] + 0.16 );
		$colors['main4'] = hsl_to_rgb( $o_hsl[0] + 4, $o_hsl[1], $o_hsl[2] + 0.18 );
		$colors['main5'] = hsl_to_rgb( $o_hsl[0] + 3, $o_hsl[1], $o_hsl[2] +  0.27 );
		$colors['main6'] = hsl_to_rgb( $o_hsl[0] - 2, $o_hsl[1] , $o_hsl[2] - 0.19 );

		// Create Custom CSS

		$custom_css = '

			/* CUSTOM FONTS */

			.actions .action,.compact-menu .main-d-nav ul li a, .view-item-btn, .item-meta h2, .prjct-hvr-title h2, body .module .heading, .blog-action-title, .blog-search-box, .comments-count, .comment-reply-link, .footer .social-area ul li a, .product .button, li.product .price, .product .item-cat, .cart-contents span, .shop_table *, .lobo-tabs .shop_table p, .lobo-tabs *, .lobo-tabs input[type="submit"], .lobo-tabs button, .order_details, .woocommerce-page .post-excerpt .variation p, #shop-search a, #shop-search .wsf-heading { font-family: ' . $f_type_1['font-family'] . ' }

			.text-hero-title, .text-hero-subtitle { font-family: ' . $f_type_1['font-family'] . ' !important; }

			body, .hero-text-intro .hero-intro h1, .hero-text-intro .hero-intro h2, .inner-post .post-title, .comment-body p, .pagination div a, .call-to-action-btn a, .show-map-btn, .product-content, .product_title, .product-content h2, .product-content h3, .single-product .cart input, #lobo-reviews h5, #lobo-reviews .form input, #lobo-reviews .form select, #lobo-reviews .form textarea, #lobo-reviews .form-submit input#submit, .products > h2, .woocommerce-message .button, .blog-actions .woocommerce.widget .widget-title, .wcp-title, .woocommerce-page .the-post h2, .product-quantity .input-text, .lobo-tabs input, .lobo-tabs select, .lobo-tabs textarea, .lobo-tabs radio, .lobo-tabs checkbox, .lobo-tabs label, .lobo-tabs label abbr, .module .lobo-accordion h3, li.product .price del + ins { font-family: ' . $f_type_2['font-family'] . ' }

			.contact-form form ::-webkit-input-placeholder { font-family: ' . $f_type_2['font-family'] . ' } .contact-form form ::-moz-placeholder { font-family: ' . $f_type_2['font-family'] . ' } .contact-form form ::-ms-input-placeholder { font-family: ' . $f_type_2['font-family'] . ' } 

			h1, h2, h3, h4, h5, h6, .inner-post .post-date, .inner-post footer a, .single-post h3, .single-post blockquote, .single-post .post-excerpt .left-note, .read-comments-btn, .author-post-meta, .comment-author-wrap, .single-post .comment-reply-title, .respond-field input, .respond-comment textarea, .comment-form input#submit, .submit-caption, .footer .credits, .module blockquote, .contact-form label, .galleria-run .text, #galleria .galleria-control, #galleria .galleria-counter, #galleria .galleria-info-description, #galleria .gal-close-btn, .royalSlider.tabs .rsTab, .rating-meta time, .wcp-subtitle strong, .wcp-subtitle a, .woocommerce-message, .woocommerce-error, .woocommerce-info, .lobo-tabs p, .payment_methods li label, .woocommerce-page .post-excerpt p, .woocommerce-page .post-excerpt dl, .order-actions a, .address a, .lobo-tabs address, #scriptie { font-family: ' . $f_type_3['font-family'] . ' }

			.hero-info h1, .hero-info h2, .secondary-typeface, .compact-menu .main-d-nav .menu-footer p, .module-title, .text-module .copy h4, .text-module .copy h5, .text-module .copy h6, .module-caption, .slide-caption, .prjct-description-head h3, body .module .copy-highlight, .item-meta .item-cat { font-family: ' . $f_type_4['font-family'] . ' }

			/* CUSTOM COLORS */

			::-moz-selection { background-color: ' . $colors['main1'] . '; }
			::selection { background-color: ' . $colors['main1'] . '; }

			#header .main-d-nav ul .sub-menu, .module-caption, .slide-caption, .audioplayer-bar-played, .post-item:hover .inner-post footer a, .cats a:after, .cats-blog a:after, .action a:after, .call-to-action-module h2:after, .call-to-action-module h3:after, .call-to-action-module h4:after, .mb_YTVTime, .comment-list .bypostauthor .comment-inner:after, .hero-info a:after, #galleria .galleria-info-description, .royalSlider.tabs .rsTab:after, .galleria-container.background--light .galleria-close-wrapper a:hover, .separator h3:after, .galleria-container.background--dark .galleria-close-wrapper a:hover, .separator h3:after, .galleria-close-wrapper a:hover, .separator h3:after, .single_add_to_cart_button, #lobo-reviews h5, li.product .view_button, .woocommerce-message .button, .blog-actions .woocommerce.widget > ul, .cart-contents span, #main-cart .widget_shopping_cart .button.view, .woocommerce-page input[type="submit"], .woocommerce-page button, .wc-button, .woo-cheader a:after, .wcp-subtitle a:after, #shop-search a:after, .mejs-controls .mejs-time-rail .mejs-time-current { background-color: ' . $colors['main1'] . '; }

			body .module .copy-highlight, .single-product .product_meta a:hover, .reviews-slider .rsArrow:hover .rsArrowIcn:before, .onsale, .woocommerce-message .button:hover, .blog-actions .woocommerce.widget .widget-title.expand:hover, .blog-actions .woocommerce.widget .widget-title.expand.opened, #main-cart .cart-title:first-letter, #main-cart .widget_shopping_cart .button:hover, .single_add_to_cart_button:hover, .woocommerce-page input[type="submit"]:hover, .woocommerce-page button:hover, .star-rating .star:before, .wcp-subtitle a:hover, .order-actions a:hover, a.wc-button:hover { color: ' . $colors['main1'] . '; }

			.woocommerce #s, .blog-actions .woocommerce.widget .widget-title.expand:hover, .blog-actions .woocommerce.widget .widget-title.expand.opened { border-color: ' . $colors['main1'] . '; }

			.compact-menu .main-d-nav .c-close-btn span, .actions-bottom .sticky-head-elmnts .hero-sticky-title, .actions-bottom .sticky-head-elmnts .action-scroll-top a i, .share-wdgt span, .overlay .close-btn span, .pagination .prev-post a, .woocommerce-pagination .page-numbers a:hover { background-color: ' . $colors['main2'] . '; }

			.blog-actions .cats-blog li a, .call-to-action-btn a, .show-map-btn { color: ' . $colors['main2'] . '; }

			.no-touch .compact-menu .main-d-nav ul li a:hover, .compact-menu .main-d-nav .menu-footer p .copy-highlight, .compact-menu .main-d-nav ul li.current a { color: ' . $colors['main3'] . '; }

			.pagination .next-post a, .comment-list .even, form input[type="submit"], .selector, .current-selector { background-color: ' . $colors['main4'] . '; }

			.comment-list .odd, .mb_YTVPLoaded, .pagination, .video-embedded .vem-overlay:hover .vem-play, .mejs-overlay:hover .mejs-overlay-button, .mejs-controls .mejs-time-rail .mejs-time-loaded { background-color: ' . $colors['main5'] . '; }

			.rating-word { color: ' . $colors['main4'] . '; }

			.woocommerce-page .item-hover:hover:before { border-color: ' . $colors['main1'] . '; }

			a:active, a:focus, .no-touch a:active, .no-touch a:focus { color: ' . $colors['main6'] . '; }

			/* IE uses absolute paths to .cur files - YAY!!! :) */

			.ie .sldr-nofade .bottom-dark .hero-item .rsOverflow,
			.ie .sldr-nofade .top-dark .hero-item .rsOverflow,
			.ie .sldr-nofade .bottom-dark .grab-cursor,
			.ie .sldr-nofade .top-dark .grab-cursor {  
			  cursor: url(' . get_template_directory_uri() . '/img/grab-sldr-light.cur), move !important;
			}
			.ie .sldr-nofade .bottom-light .hero-item .rsOverflow,
			.ie .sldr-nofade .top-light .hero-item .rsOverflow,
			.ie .sldr-nofade .bottom-light .grab-cursor,
			.ie .sldr-nofade .top-light .grab-cursor {
			  cursor: url(' . get_template_directory_uri() . '/img/grab-sldr-dark.cur), move !important;
			}
			.ie .bottom-dark .hero-item .rsOverflow .rsArrowLeft,
			.ie .top-dark .hero-item .rsOverflow .rsArrowLeft,
			.ie .bottom-dark .rsArrowLeft .grab-cursor,
			.ie .top-dark .rsArrowLeft .grab-cursor,
			.ie .galleria-container.background--dark .galleria-image-nav-left i {  
			  cursor: url(' . get_template_directory_uri() . '/img/grab-gallery-left-light.cur), move !important;
			}
			.ie .bottom-light .hero-item .rsOverflow .rsArrowLeft,
			.ie .top-light .hero-item .rsOverflow .rsArrowLeft,
			.ie .bottom-light .rsArrowLeft .grab-cursor,
			.ie .top-light .rsArrowLeft .grab-cursor,
			.ie .galleria-container.background--light .galleria-image-nav-left i {  
			  cursor: url(' . get_template_directory_uri() . '/img/grab-gallery-left-dark.cur), move !important;
			}
			.ie .bottom-dark .hero-item .rsOverflow .rsArrowRight,
			.ie .top-dark .hero-item .rsOverflow .rsArrowRight,
			.ie .bottom-dark .rsArrowRight .grab-cursor,
			.ie .top-dark .rsArrowRight .grab-cursor,
			.ie .galleria-container.background--dark .galleria-image-nav-right i { 
				cursor: url(' . get_template_directory_uri() . '/img/grab-gallery-right-light.cur), move !important;
			}
			.ie .bottom-light .hero-item .rsOverflow .rsArrowRight,
			.ie .top-light .hero-item .rsOverflow .rsArrowRight,
			.ie .bottom-light .rsArrowRight .grab-cursor,
			.ie .top-light .rsArrowRight .grab-cursor,
			.ie .galleria-container.background--light .galleria-image-nav-right i {  
			  cursor: url(' . get_template_directory_uri() . '/img/grab-gallery-right-dark.cur), move !important;
			}

			/* CUSTOM CSS */

		';

		$custom_css .= ot_get_option( 'lobo_custom_css', '' );

		// Embed Custom CSS

		wp_add_inline_style( 'lobo-style', $custom_css );

	}

}

if ( ! function_exists( 'lobo_custom_fonts' ) ) {

	function lobo_custom_fonts() {

		// Get Options

		$f_type_1 = is_serialized( get_option('lobo_type_1' ) ) ? unserialize( get_option('lobo_type_1' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_2 = is_serialized( get_option('lobo_type_2' ) ) ? unserialize( get_option('lobo_type_2' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_3 = is_serialized( get_option('lobo_type_3' ) ) ? unserialize( get_option('lobo_type_3' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_4 = is_serialized( get_option('lobo_type_4' ) ) ? unserialize( get_option('lobo_type_4' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );

		$protocol = is_ssl() ? 'https' : 'http';

		// Enequeue Google Fonts

		if ( ! isset( $f_type_1['default'] ) ) {
			wp_enqueue_style( $f_type_1['css-name'], "$protocol://fonts.googleapis.com/css?family=" . $f_type_1['css-name'] . ":300,400,400italic,500,600,700,700,800,900" );
		}

		if ( isset( $f_type_2['css-name'] ) && ! isset( $f_type_2['default'] ) ) {
			wp_enqueue_style( $f_type_2['css-name'], "$protocol://fonts.googleapis.com/css?family=" . $f_type_2['css-name'] . ":300,400,400italic,500,600,700,700,800,900" );
		}

		if ( isset( $f_type_3['css-name'] ) && ! isset( $f_type_3['default'] ) ) {
			wp_enqueue_style( $f_type_3['css-name'], "$protocol://fonts.googleapis.com/css?family=" . $f_type_3['css-name'] . ":300,400,400italic,500,600,700,700,800" );
		}

		if ( isset( $f_type_4['css-name'] ) && ! isset( $f_type_4['default'] ) ) {
			wp_enqueue_style( $f_type_4['css-name'], "$protocol://fonts.googleapis.com/css?family=" . $f_type_4['css-name'] . ":300,400,400italic,500,600,700,700,800" );
		}

	}

}

add_action( 'wp_enqueue_scripts', 'lobo_custom_css', 101 );

add_action( 'wp_enqueue_scripts', 'lobo_custom_fonts', 99 );


// Because of the way the admin bar works, it really breaks the layout of the theme into pieces (it adds bad margin at the top, thus making everything smaller). So we need a bulletproof solution to make sure that the admin bar will not interfer with the user editing (we keep it, but we minimalize it)

if ( ! function_exists( 'lobo_custom_admin_bar_soft' ) ) {

	function lobo_custom_admin_bar_soft() {

		echo '<style type="text/css">

			html, * html body {
				margin-top: 0 !important;
			}

			#wpadminbar {
				background: rgba(0, 0, 0, .4) !important;
				opacity: .7 !important;
				-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)" !important;
				filter: alpha(opacity=70) !important;
			}

		</style>';

	}

}

add_action( 'wp_head', 'lobo_custom_admin_bar_soft', 99 );

?>