<?php

	// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
	add_filter('add_to_cart_fragments', 'lobo_cart_fragments');

	function lobo_cart_fragments( $fragments ) {
		
	    global $woocommerce;
	    
	    ob_start();
	    
	    ?>
	    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
	        <span><?php echo $woocommerce->cart->cart_contents_count; ?></span>
	    </a>
	    <?php
	    
	    $fragments['a.cart-contents'] = ob_get_clean();
	    
	    return $fragments;
	    
	}

    // Add Theme Support

    add_theme_support('woocommerce');
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    // Remove Unwanted Actions

    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    // Language Changes

	function lobo_add_cart_text1() {
		return __( 'Add to cart', 'lobo' );
	}
	function lobo_add_cart_text2() {
		return __( 'Buy', 'lobo' );
	}

	add_filter( 'woocommerce_product_single_add_to_cart_text', 'lobo_add_cart_text1' );
	add_filter( 'woocommerce_product_add_to_cart_text', 'lobo_add_cart_text2' ); 

	function lobo_project_1() {
		return __( 'Details', 'lobo' );
	}
	function lobo_project_2($tabs) {
		$tabs['description']['title'] = __( 'Details', 'lobo' ); 
	  	return $tabs;
	}

	add_filter( 'woocommerce_product_description_heading', 'lobo_project_1' );
	add_filter( 'woocommerce_product_tabs', 'lobo_project_2');

    // Filter number of items per page

    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . get_option( 'lobo_shop_no', '12' ) . ';' ), 20 );

    // Wrap single project contents

    function lobo_wrap_project1() {
    	echo '<div class="product-content"><div class="module text-module" data-bgcolor="#fff" data-color="#000"><div class="copy"><div><div><div>';
    }
    function lobo_wrap_project2() {
    	echo '</div></div></div></div></div></div>';
    }

    add_filter( 'woocommerce_before_single_product_summary', 'lobo_wrap_project1', 30 );
    add_filter( 'woocommerce_after_single_product_summary', 'lobo_wrap_project2', 30 );

    // Breadcrumb filters

	function lobo_breadcrumb_custom( $defaults ) {    
		return array(
            'delimiter'   => ' <span>></span> ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => __( 'Shop', 'lobo' )
        );
	}
    add_filter( 'woocommerce_breadcrumb_defaults', 'lobo_breadcrumb_custom' );

	function lobo_breadcrumb_home() {
	    return get_permalink( woocommerce_get_page_id( 'shop' ) );
	}
	add_filter( 'woocommerce_breadcrumb_home_url', 'lobo_breadcrumb_home' );

	function lobo_remove_breadcrumb() {
    	if ( is_shop() || is_archive() ) {
	   		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	    }
	}
	add_filter('woocommerce_before_main_content','lobo_remove_breadcrumb');

	// Reposition some elements within the product page

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 15 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_sharing', 16 );

	function lobo_add_tab( $tabs ) {
		$tabs['short'] = array(
			'title' => __( 'Description', 'lobo' ),
			'priority' => 1,
			'callback' => 'lobo_add_tab_content'
		);
		return $tabs;
	}
	function lobo_add_tab_content() {
		global $product;
		echo apply_filters( 'the_content', $product->post->post_excerpt );
	}
    add_filter( 'woocommerce_product_tabs', 'lobo_add_tab' );

    // Reverse reviews order

	function lobo_reviews_order($args){
		$args['reverse_top_level'] = true;
		return $args;
	}
	add_filter( 'woocommerce_product_review_list_args', 'lobo_reviews_order' );

	// Add mini cart title

	function lobo_mini_cart_title() {

		global $woocommerce;
		$size = sizeof( WC()->cart->get_cart() );
		echo '<p class="cart-title">' . sprintf( _n( '1 item in your cart', '%s items in your cart', $size, 'lobo' ), $size ) . '</p>';

	}
	add_filter( 'woocommerce_before_mini_cart', 'lobo_mini_cart_title' );

	// Change thumbnails size (for mini cart)

    global $pagenow;

    if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) 
        add_action( 'init', 'lobo_woocommerce_thumbnails', 1 );

    function lobo_woocommerce_thumbnails() {
        $thumbnail = array(
            'width' => '77',  
            'height'    => '77',  
            'crop'  => 1 
        ); 
        update_option('shop_thumbnail_image_size', $thumbnail);
    }

    // Remove onsale element

    if ( get_option( 'lobo_shop_sale', 'enabled') == 'disabled' ) {
    	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    }

    // Adds a custom header for WooCommerce pages

    function lobo_output_woo_header() {

    	global $post;

    	if ( is_cart() || is_checkout() || is_account_page() ) {

    		$html = '<div class="woo-cheader">';

    		// Account pages

    		if ( is_user_logged_in() ) {

    			$html .= '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . __( 'My Account', 'lobo' ) . '">' . __( 'My Account', 'lobo' ) . '</a>';

    			$html .= '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . get_option( 'woocommerce_myaccount_edit_account_endpoint' ) . '" title="' . __( 'Edit Account', 'lobo' ) . '">' . __( 'Edit Account', 'lobo' ) . '</a>';

    			$html .= '<a href="' . wp_logout_url( get_permalink() ) . '" title="' . __( 'Logout', 'lobo' ) . '">' . __( 'Logout', 'lobo' ) . '</a>';

    		} else {

    			$html .= '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . __( 'Login / Register', 'lobo' ) . '">' . __( 'Login / Register', 'lobo' ) . '</a>';

    		}

    		echo $html;

    		woocommerce_breadcrumb();

    		echo '</div>';

    	}

    }

    // Change ratings style

    function lobo_new_rating() {

        global $wpdb;
        global $post;

        $count = $wpdb->get_var("
            SELECT COUNT(meta_value) FROM $wpdb->commentmeta
            LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
            WHERE meta_key = 'rating'
            AND comment_post_ID = $post->ID
            AND comment_approved = '1'
            AND meta_value > 0
        ");

        $rating = $wpdb->get_var("
            SELECT SUM(meta_value) FROM $wpdb->commentmeta
            LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
            WHERE meta_key = 'rating'
            AND comment_post_ID = $post->ID
            AND comment_approved = '1'
        ");

        if(!($count == 0 || $rating == 0))
            $average = ceil(number_format($rating / $count, 2));
        else 
            $average = 0;

        echo '<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="custom star-rating clearfix" title="' . sprintf( __(  'Rated %d out of 5', 'lobo' ), $average ) . '">';
        for ( $i = 1; $i <= 5; $i++ ){
            if ( $i <= $average )
                echo '<b class="star"></b>';
            else
                echo '<b class="no-star"></b>';
        }
        echo '</div>';
        
    }

    if ( get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) {
        add_filter( 'woocommerce_single_product_summary', 'lobo_new_rating', 15 );
    }

?>
