<?php

/*---------------------------------
	Setup OptionTree
------------------------------------*/

add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
require_once( 'option-tree/ot-loader.php' );

function filter_ot_upload_text(){
	return __( 'Insert', 'lobo' );
}
function filter_ot_header_list(){
	echo '<li id="option-tree-version"><span>' . __( 'Lobo Options', 'lobo' ) . '</span></li>';
}
function filter_ot_header_version_text(){
	return '2.0.9';
}

add_filter( 'ot_header_list', 'filter_ot_header_list' );
add_filter( 'ot_upload_text', 'filter_ot_upload_text' );
add_filter( 'ot_header_version_text', 'filter_ot_header_version_text');

/*---------------------------------
	Include other files
------------------------------------*/

include( 'includes/metaboxes.php' );
include( 'includes/module-builder/init.php' );
include( 'includes/theme-options.php' );
include( 'includes/customizer-options.php' );
include( 'includes/custom-styles.php' );
include( 'includes/plugins.php' );

if ( function_exists( 'is_woocommerce' ) ) {
	include( 'includes/woocommerce.php' );
}

if ( ! function_exists( 'aq_resize' ) ) {
	include( 'includes/aq_resizer.php' );
}

/*---------------------------------
	Enable SVG upload
------------------------------------*/

function lobo_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'lobo_mime_types' );

/*---------------------------------
	Retina info (by js cookie)
------------------------------------*/

if ( ! function_exists( 'lobo_retina' ) ) {

	function lobo_retina() {

		if ( isset( $_COOKIE['dpi'] ) ) {
			$retina = $_COOKIE['dpi'];
		} else { 
			$retina = false;
		}

		$retina = 'true';

	}

	add_action( 'init', 'lobo_retina' );

}

/*---------------------------------
	Custom pagination functions
------------------------------------*/

if ( ! function_exists( 'lobo_pagination' ) ) {

	function lobo_pagination( $query = null ) {  

		if ( $query == null ) {
			global $wp_query;
			$query = $wp_query;
		}

		$page = $query->query_vars['paged'];
		$pages = $query->max_num_pages;

		if ( $page == 0 ) {
			$page = 1;
		}

		$html = '';

		if( $pages > 1 ) {

			$html .= '<div class="pagination clearfix face-control">';

			if ( $page + 1 <= $pages ) {
				$html .= '<div class="prev-post"><a href="' . get_pagenum_link( $page + 1 ) . '">' . '<div class="pagination-inner">' . __( 'Older Post' ,'lobo' ) . '</div></a></div>';
			}

			if ( $page - 1 >= 1 ) {
				$html .= '<div class="next-post"><a href="' . get_pagenum_link( $page - 1 ) . '"><div class="pagination-inner">' . __( 'Newer Post' ,'lobo' ) . '</div></a></div>';
			}

			$html .= '</div>';

		}

		echo $html;
		 
	}

}

if ( ! function_exists( 'lobo_infinite_pagination' ) ) {

	function lobo_infinite_pagination( $query = null ) {  

		if ( $query == null ) {
			global $wp_query;
			$query = $wp_query;
		}

		$page = $query->query_vars['paged'];
		$pages = $query->max_num_pages;

		if ( $page == 0 ) {
			$page = 1;
		}

		echo get_pagenum_link( $page + 1 );

	}

}


/*---------------------------------
	Make some adjustments on theme setup
------------------------------------*/

if ( ! function_exists( 'lobo_setup' ) ) {

	function lobo_setup() {

		// Setup theme update with PIXELENTITY's class
			
		if( ot_get_option( 'lobo_updates_user' ) != '' && ot_get_option( 'lobo_updates_api' ) != '' ){

			require_once( 'pixelentity-theme-update/class-pixelentity-theme-update.php' );
			PixelentityThemeUpdate::init( ot_get_option( 'lobo_updates_user' ), ot_get_option( 'lobo_updates_api' ), 'VanKarWai' );

		}

		// Add more widget areas based on user settings

		$sidebars = ot_get_option( 'lobo_sidebars' );
		if ( ! empty( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				register_sidebar( array(
					'name' => $sidebar['title'],
					'id' => $sidebar['id'],
					'description' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
					'after_widget' => '</div>',
					'before_title' => '<span class="hidden">',
					'after_title' => '</span>',
				) );
			}
		} 

		// Make theme available for translation

		load_theme_textdomain( 'lobo', get_template_directory() . '/lang' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/lang/$locale.php";

		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
	
		// Define content width (stupid feature, this theme has no width)

		if( ! isset( $content_width ) ) {
			$content_width = 940;
		}

		// Enables post thumbnails
		
		add_theme_support( 'post-thumbnails' );
		
		// Add RSS feed links to head

		add_theme_support( 'automatic-feed-links' );

		// Enable excerpts for pages

		add_post_type_support( 'page', 'excerpt' );

		// Enable shortcodes inside text widgets

		add_filter('widget_text', 'do_shortcode');
			
		// Add primary navigation 

		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'lobo' ),
		) );
		
	}

}

add_action( 'after_setup_theme', 'lobo_setup' );

/*---------------------------------
	Insert analytics code into the footer
------------------------------------*/

if ( ! function_exists( 'lobo_analytics' ) ) {

	function lobo_analytics() {
		echo ot_get_option( 'lobo_tracking' );
	}

}

add_filter( 'wp_footer', 'lobo_analytics' );

/*---------------------------------
	Make some changes to the wp_title function
------------------------------------*/

if ( ! function_exists( 'lobo_filter_wp_title' ) ) {

	function lobo_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) return $title;
			
		global $paged, $page;

		if ( is_search() ) {
		
			$title = sprintf( __( 'Search results for %s', 'lobo' ), '"' . get_search_query() . '"' );

			if ( $paged >= 2 ) {
				$title .= " $separator " . sprintf( __( 'Page %s', 'lobo' ), $paged );
			}

			$title .= " $separator " . get_bloginfo( 'name', 'display' );

			return $title;

		}

		$title .= get_bloginfo( 'name', 'display' );

		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $separator " . $site_description;
		}

		if ( $paged >= 2 || $page >= 2 ) {
			$title .= " $separator " . sprintf( __( 'Page %s', 'lobo' ), max( $paged, $page ) );
		}

		return $title;

	}

}

add_filter( 'wp_title', 'lobo_filter_wp_title', 10, 2 );

/*---------------------------------
	Create a wp_nav_menu fallback, to show a home link
------------------------------------*/

function lobo_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'lobo_page_menu_args' );

/*---------------------------------
	Remove "Recent Comments Widget" Styling
------------------------------------*/

function lobo_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'lobo_remove_recent_comments_style' );


/*---------------------------------
	Register widget areas
------------------------------------*/

function lobo_shop_widget() {

	register_sidebar( array(
		'name' => __('Shop filter sidebar', 'krown'),
		'id' => 'krown_blog_widget_area',
		'description' => __('This "sidebar" will appear when searching in the shop page. You should insert what filters do you want to offer to your visitors, such as a default search form, pricing filters, layered navigation, categories, etc..', 'krown'),
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h6 class="wsf-heading">',
		'after_title' => '</h6>',
	) );

}  

if ( function_exists( 'is_woocommerce' ) ) {
	add_action( 'widgets_init', 'lobo_shop_widget' );
}

/*---------------------------------
	Function that replaces the default the_excerpt function
------------------------------------*/

if ( ! function_exists( 'lobo_excerptlength_post' ) ) {

	// Length (words no)
	 
	function lobo_excerptlength_post() {
	    return 30;
	}

}

if ( ! function_exists( 'lobo_excerptlength_post_big' ) ) {

	// Length (words no)
	 
	function lobo_excerptlength_post_big() {
	    return 120;
	}

}

if ( ! function_exists( 'lobo_excerptmore' ) ) {

	// More text

	function lobo_excerptmore() {
	    return ' ...';
	}

}

if ( ! function_exists( 'lobo_excerpt' ) ) {

	// The actual function
	
	function lobo_excerpt( $length_callback = '', $more_callback = 'lobo_excerptmore' ) {

	    global $post;
		
	    if ( function_exists( $length_callback ) ) {
			add_filter( 'excerpt_length', $length_callback );
	    }
		
	    if ( function_exists( $more_callback ) ){
			add_filter( 'excerpt_more', $more_callback );
	    }
		
	    $output = get_the_excerpt();

	    if ( empty( $output ) ) {

	    	// If the excerpt is empty (on pages created 100% with shortcodes), we should take the content, strip shortcodes, remove all HTML tags, then return the correct number of words

	    	$output = strip_tags( preg_replace( "~(?:\[/?)[^\]]+/?\]~s", '', $post->post_content ) );
	    	$output = explode( ' ', $output, $length_callback() );
	    	array_pop( $output );
	    	$output = implode( ' ', $output ) . $more_callback();

	    } else {

	    	// Continue with the regular excerpt method

		    $output = apply_filters( 'wptexturize', $output );
		    $output = apply_filters( 'convert_chars', $output );

	    }
		
	    return $output;
		
	}   

}

/*--------------------------------
	Function that returns all categories of a custom post
------------------------------------*/

function lobo_categories( $post_id = null, $taxonomy = 'post', $delimiter = ', ', $get = 'name', $echo = true, $link = false ){

	if ( $post_id == null ) {
		global $post;
		$post_id = $post->ID;
	}

	$tags = wp_get_post_terms( $post_id, $taxonomy );
	$list = '';
	foreach( $tags as $tag ){
		if ( $link ) {
			$list .= '<a href="' . get_category_link( $tag->term_id ) . '"> ' . $tag->$get . '</a>' . $delimiter;
		} else {
			$list .= $tag->$get . $delimiter;
		}
	}

	if ( $echo ) {
		echo substr( $list, 0, strlen($delimiter)*(-1) );
	} else { 
		return substr( $list, 0, strlen($delimiter)*(-1) );
	}

}

/*---------------------------------
	Redefine the search form structure
------------------------------------*/

// Regular search

if ( ! function_exists( 'lobo_search_form' ) ) {

	function lobo_search_form( $form ) {

	    $form = '
		<form role="search" method="get" id="searchform" class="search-form" action="' . home_url( '/' ) . '">
			<label class="screen-reader-text hidden" for="s">' . __( 'Search for:', 'lobo' ) . '</label>
			<input class="blog-search-box" type="search" placeholder="' . __( 'Search', 'lobo' ) . '" name="s" id="s" />
			<input id="submit_s" type="submit" style="display:none !important" />
	    </form>';
	    return $form;
		
	}

}

add_filter( 'get_search_form', 'lobo_search_form' );

// WooCommerce search

if ( ! function_exists( 'lobo_product_search_form' ) ) {

	function lobo_product_search_form( $form ) {

	    $form = '
		<form role="search" method="get" id="searchform" class="search-form" action="' . home_url( '/' ) . '">
			<label class="screen-reader-text hidden" for="s">' . __( 'Search:', 'lobo' ) . '</label>
			<p class="wsf-title">' . __( 'Search', 'lobo' ) . '</p>
			<input class="blog-search-box wsf-search" type="search" placeholder="' . __( 'Search Term', 'lobo' ) . '" name="s" id="s" />
			<input id="submit_s" type="submit" class="wsf-help" value="' . __( 'click here to search', 'lobo' ). '" />
			<input type="hidden" name="post_type" value="product" />
	    </form>';
	    return $form;
		
	}

}

add_filter( 'get_product_search_form', 'lobo_product_search_form' );

/*---------------------------------
	Custom login logo
------------------------------------*/

function lobo_custom_login_logo() {
	if ( ot_get_option( 'lobo_custom_login_logo_uri' ) != '' ) {
	    echo '<style type="text/css">
	        h1 a { background-image: url(' . ot_get_option( 'lobo_custom_login_logo_uri' ) . ') !important; background-size: 273px 63px !important; width: 273px !important; height: 63px !important; }
	    </style>';
	}
}

add_action( 'login_head', 'lobo_custom_login_logo' );

/*---------------------------------
	Fix empty search issue
------------------------------------*/

function lobo_request_filter( $query_vars ) {

    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }

    return $query_vars;
}

add_filter('request', 'lobo_request_filter');

/*---------------------------------
	Color conversion functions
------------------------------------*/

function lobo_hex_to_rgba( $hex, $a, $string = true ) {

	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}

	if ( $string ) {
		return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $a . ')';
	} else {
		return array( $r, $g, $b, $a );
	}
   
}

function rgb_to_hex( $rgb ) {

	$hex = '#'; 

	$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

	return $hex;

}

function hex_to_rgb($hex) {

   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }

    return array( $r, $g, $b );
   
}


function rgb_to_hsl( $r, $g, $b ) {

	$oldR = $r;		
	$oldG = $g;
	$oldB = $b;

	$r /= 255;
	$g /= 255;
	$b /= 255;

    $max = max( $r, $g, $b );
	$min = min( $r, $g, $b );

	$h;
	$s;
	$l = ( $max + $min ) / 2;
	$d = $max - $min;

    	if( $d == 0 ){
        	$h = $s = 0; 
    	} else {
        	$s = $d / ( 1 - abs( 2 * $l - 1 ) );

		switch( $max ){
	            case $r:
	            	$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
                        if ($b > $g) {
	                    $h += 360;
	                }
	                break;

	            case $g: 
	            	$h = 60 * ( ( $b - $r ) / $d + 2 ); 
	            	break;

	            case $b: 
	            	$h = 60 * ( ( $r - $g ) / $d + 4 ); 
	            	break;
	        }			        	        
	}

	return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );

}

function hsl_to_rgb( $h, $s, $l ) {

    $r; 
    $g; 
    $b;

	$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
	$m = $l - ( $c / 2 );

	if ( $h < 60 ) {
		$r = $c;
		$g = $x;
		$b = 0;
	} else if ( $h < 120 ) {
		$r = $x;
		$g = $c;
		$b = 0;			
	} else if ( $h < 180 ) {
		$r = 0;
		$g = $c;
		$b = $x;					
	} else if ( $h < 240 ) {
		$r = 0;
		$g = $x;
		$b = $c;
	} else if ( $h < 300 ) {
		$r = $x;
		$g = 0;
		$b = $c;
	} else {
		$r = $c;
		$g = 0;
		$b = $x;
	}

	$r = ( $r + $m ) * 255;
	$g = ( $g + $m ) * 255;
	$b = ( $b + $m  ) * 255;

    return 'rgb(' . floor( $r ) . ', ' . floor( $g ) . ', ' . floor( $b ) . ')';

}

/*---------------------------------
	Enqueue front scripts
------------------------------------*/

function lobo_enqueue_scripts() {

	global $post;

	wp_deregister_style('wp-mediaelement');
	wp_deregister_script('wp-mediaelement');

	// Handle fancybox scripts

	if ( isset( $post ) && is_singular( 'product' ) ) {
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), NULL, true );
	}

	// Handle video scripts

	if ( isset( $post ) && ( strpos( get_post_meta( $post->ID, 'kmb', true), '"type":"video' ) || get_post_meta( $post->ID, 'krown_page_hero', true ) == 'video' ) ) {
		
		wp_enqueue_script( 'mediaelement' );
		wp_enqueue_script( 'YTPlayer', get_template_directory_uri().'/js/jquery.mb.YTPlayer.js', array('jquery'), NULL, true );

	}

	// Enqueue the js libraries

	wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr-2.6.2.min.js', array('jquery'), NULL, true );
	wp_enqueue_script( 'theme_plugins', get_template_directory_uri().'/js/plugins.js', array('jquery'), NULL, true );
	wp_enqueue_script( 'theme_scripts', get_template_directory_uri().'/js/main.js', array('theme_plugins'), NULL, true );

	// Enqueue styles

	wp_enqueue_style( 'lobo-style', get_stylesheet_uri() );

	// Handle comments script

	wp_deregister_script( 'comment-reply' );
	wp_register_script( 'comment-reply', get_template_directory_uri() . '/js/comment-reply.js' );

	if ( is_single() ) {
		wp_enqueue_script( 'comment-reply' );
	} else {
		wp_dequeue_script( 'comment-reply' );
	}

	// Handle galleria scripts

	if ( isset( $post ) && strpos( get_post_meta( $post->ID, 'kmb', true), '"type":"gallery' ) ) {

		wp_enqueue_script( 'galleria', get_template_directory_uri() . '/js/galleria.min.js' );
		wp_enqueue_style( 'galleria-skin', get_template_directory_uri() . '/js/galleria-themes/' . get_option( 'lobo_galleria_skin', 'skin-01' ) . '/galleria-skin.css' );

	}

	// We need to pass some useful variables to the theme scripts through the following function

	wp_localize_script(
		'theme_scripts', 
		'themeObjects',
		array(
			'base' 		=> get_template_directory_uri(),
			'galleriaSkin' => get_template_directory_uri() . '/js/galleria-themes/' . get_option( 'lobo_galleria_skin', 'skin-01' ) . '/galleria-skin.js',
			'textReviews' => __( 'Reviews', 'lobo' ),
			'textSort' => __( 'Sort by', 'lobo' )
		)
	);

}

add_action( 'wp_enqueue_scripts', 'lobo_enqueue_scripts', 100 );

// The function below deregisters the WooCommerce scripts on pages which have nothing to do with WOO. I've wrapped this function to allow for easy disablement is there are any issues with it.

if ( ! function_exists( 'lobo_handle_woo_scripts' ) ) {

	function lobo_handle_woo_scripts() {

		if ( function_exists( 'is_woocommerce' ) && ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {

			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'jquery-blockui' ); 
			wp_dequeue_script( 'jquery-placeholder' ); 
			wp_dequeue_script( 'jquery-cookie' ); 
			wp_dequeue_script( 'wc-country-select' ); 
			wp_dequeue_script( 'jquery-payment' ); 
			wp_dequeue_script( 'wc-credit-card-form' ); 
			wp_dequeue_script( 'woocommerce' ); 

		}

	}

}

add_action( 'wp_enqueue_scripts', 'lobo_handle_woo_scripts', 101 );

/*---------------------------------
	Enqueue admin styles
------------------------------------*/

function lobo_admin_scripts() {
	wp_enqueue_style( 'lobo-admin', get_template_directory_uri() . '/css/admin-style.css' );
}

add_action( 'admin_enqueue_scripts', 'lobo_admin_scripts' );

function lobo_admin_class( $classes ) {

    $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
    $template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

    if ( $template_file == 'template-modular.php' ) {
    	$classes .= ' hide-content-area';
    }

    return $classes;

}

add_filter( 'admin_body_class', 'lobo_admin_class' );

/* ------------------------
-----   Filter Video Shortcode   -----
------------------------------*/

function lobo_video_shortcode($content) {
	$keyword = strpos( $content, 'poster' ) > 0 ? "poster" : "preload";
    echo preg_replace( "(width=.+$keyword)", "width='100%' height='100%' style='width:100%;height:100%' $keyword", $content );
}
add_filter('wp_video_shortcode', 'lobo_video_shortcode');

/*---------------------------------
    Navigation Walker
------------------------------------*/

class lobo_Nav_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth=0, $args=array() ) {
    	if ( $depth == 0 ) {
        	$output .= '<ul class="sub-menu">';
    	} else if ( $depth == 1 ) {
        	$output .= '<ul class="third-menu">';
    	}
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

    }

    function start_el( &$output, $object, $depth=0, $args=array(), $current_object_id=0 ) {

        global $wp_query;
        global $rb_submenus;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $new_output = '';
        $depth_class = ( $args->has_children ? 'has-subs ' : '' );

        $class_names = $value = $selected_class = '';
        $classes = empty( $object->classes ) ? array() : ( array ) $object->classes;

        $current_indicators = array('current-menu-item', 'current-menu-parent', 'current_page_item', 'current_page_parent', 'current-menu-ancestor');

        foreach ( $classes as $el ) {
            if ( in_array( $el, $current_indicators ) ) {
                $selected_class = 'current selected active ';
            }
        }

        $class_names = ' class="' . $selected_class . $depth_class . 'menu-item' . ( ! empty( $classes[0] ) ? ' ' . $classes[0] : '' ) . '"';

        if ( ! get_post_meta( $object->object_id , '_members_only' , true ) || is_user_logged_in() ) {
            $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $class_names . '>';
        }

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

        $object_output = $args->before;
        $object_output .= '<a' . $attributes . '>';
        $object_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
        $object_output .= '</a>';
        $object_output .= $args->after;

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {

            $output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );

        }

        $output .= $new_output;

    }

    function end_el(&$output, $object, $depth=0, $args=array()) {

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {
            $output .= "</li>\n";
        }

    }
    
    function end_lvl(&$output, $depth=0, $args=array()) {

        $output .= "</ul>\n";

    }

}

/*---------------------------------
	Pages preloader
------------------------------------*/

if ( ! function_exists ('lobo_preloader' ) ) {

	function lobo_preloader() {

		global $post;

		if ( isset( $post ) ) {

			if ( ! ( is_page() || is_archive() || is_search() ) && has_post_thumbnail( $post->ID ) ) {
		        $thumb = get_post_thumbnail_id( $post->ID );
		        $img_url = wp_get_attachment_url( $thumb, 'full' );  
		        echo aq_resize( $img_url, 190, 190, true ); 
			} else if ( get_option( 'lobo_loader' ) != '' ) {
				echo get_option( 'lobo_loader' );
			} else {
				echo get_template_directory_uri() . '/img/preloader-def.gif';
			}

		} else {

			if ( get_option( 'lobo_loader' ) != '' ) {
				echo get_option( 'lobo_loader' );
			} else {
				echo get_template_directory_uri() . '/img/preloader-def.gif';
			}

		}

	}

}

/*---------------------------------
	Hero title / subtitle
------------------------------------*/

if ( ! function_exists( 'lobo_subtitle' ) ) {

	function lobo_subtitle( $post_id ) {

		if ( is_search() ) {

			return __( 'for', 'lobo' ) . ' "' . get_search_query() . '"';

		} else if ( is_archive() ) { 

			if ( is_category() ) {
				return get_category( get_query_var( 'cat' ) )->name;
			} else if ( is_author() ) {
				return get_the_author();
			} else if ( is_tag() ) {
				return single_tag_title( '', false );
			} else if ( is_day() ) {
				return get_the_date();
			} else if ( is_month() ) {
				return get_the_date( 'F Y' );
			} else if ( is_year() ) {				
				return get_the_date( 'Y' );
			} else {
				return '';
			}

		} else if ( is_singular( 'portfolio' ) ) {
			return lobo_categories( $post_id, 'portfolio_category', ', ', 'name', false ); 
		} else if ( is_single( $post_id ) ) {
			return lobo_categories( $post_id, 'category', ', ', 'name', false );
		} else {
			return get_post_meta( $post_id, 'lobo_p_subtitle', true );
		}

	}

}

if ( ! function_exists( 'lobo_title' ) ) {

	function lobo_title( $post ) {

		if ( is_404() ) {

			return __( 'Page Not Found', 'lobo' );

		} else if ( is_search() ) {

			return __( 'Search Results', 'lobo' );

		} else if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_shop() || is_product_category() || is_product_tag() ) ) {

			if ( is_product() ) {
				$post_id = $post->ID;
			} else if ( is_shop() || is_product_category() || is_product_tag() ) {
				$post_id = woocommerce_get_page_id( 'shop' );
			} else {
				$post_id = $post->ID;
			}

			if ( get_post_meta( $post_id, 'lobo_p_title', true ) != '' ) {
				return get_post_meta( $post_id, 'lobo_p_title', true );
			} else {
				return get_the_title( $post_id );
			}

		} else if ( isset( $post ) ) {

			$post_id = $post->ID;

			if ( is_archive() ) {

				if ( is_category() ) {
					return __( 'Category Archives', 'lobo' );
				} else if ( is_author() ) {
					return __( 'Author Archives', 'lobo' );
				} else if ( is_tag() ) {
					return __( 'Tag Archives', 'lobo' );
				} else if ( is_day() ) {
					return __( 'Daily Archives', 'lobo' );
				} else if ( is_month() ) {
					return __( 'Monthly Archives', 'lobo' );
				} else if ( is_year() ) {
					return __( 'Yearly Archives', 'lobo' );
				} else {
					return __( 'Blog Archives', 'lobo' );
				}

			} else if ( get_post_meta( $post_id, 'lobo_p_title', true ) != '' ) {
				return get_post_meta( $post_id, 'lobo_p_title', true );
			} else {
				return get_the_title( $post_id );
			}

		} else {

			return '';

		}

	}

}

/*---------------------------------
	Hero element
------------------------------------*/

if ( ! function_exists( 'krown_hero' ) ) {

	function krown_hero( $post ) {

		if ( is_404() ) {

			$post_id = get_option( 'lobo_404_page' );

		} else if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_shop() || is_product_category() || is_product_tag() ) ) {

			if ( is_product() ) {

				$post_id = $post->ID;

			} else if ( is_shop() || is_product_category() || is_product_tag() ) {

				$post_id = woocommerce_get_page_id( 'shop' );

			} else {

				$post_id = $post->ID;

			}

		} else if ( is_search() || is_archive() || is_page_template( 'template-blog.php' ) ) {

			$post_id = get_option( 'lobo_blog_page' );

		} else if ( isset( $post ) ) {

			$post_id = $post->ID;

		} else {

			return array(
				' no-hero',
				'',
				'<section id="hero-wrapper" class="face-control"><span class="target target-top"></span><span class="target target-bottom"></span></section>'
			);

		}

		$hero_class = '';
		$hero_el = '<section id="hero-wrapper" class="face-control" data-height-type="' . get_post_meta( $post_id, 'krown_hero_height_type', true ) . '" data-height-value="' . get_post_meta( $post_id, 'krown_hero_height_value', true ) . '">
	        <span class="target target-top"></span>
	        <span class="target target-bottom"></span>';
	    $hero_title = '<div class="hero-info">
            <h1 class="hero-title">' . lobo_title( $post ) . '</h1>
            <span class="subtitle">' . lobo_subtitle( $post_id ) . '</span>
        </div>';

		// Get hero element based on user input

		switch ( get_post_meta( $post_id, 'krown_page_hero', true ) ) {

			case 'image':

				// Simple image
				$hero_el .= '<figure class="hero-image hero-item"><img src="' . get_post_meta( $post_id, 'krown_hero_img', true ) . '" alt=""></figure></section>';
				break;

			case 'slider':

				// Custom slider

				$slides = get_post_meta( $post_id, 'krown_hero_slider', true );

				if ( ! empty( $slides ) ) {

					$hero_el .= '<section class="hero-slider royalSlider rsDefault hero-item ' . get_post_meta( $post_id, 'krown_hero_slider_autoplay', true ) . '" data-speed="' . get_post_meta( $post_id, 'krown_hero_slider_speed', true ) . '">';
					$i = 0;

					foreach( $slides as $slide ) {

						$hero_el .= '<article class="rsContent">';

						if ( $i == 0 && ini_get( 'allow_url_fopen' ) ){
							$init_size = getimagesize( $slide['image'] );
						}

						$hero_el .= '<img class="rsImg" src="' . $slide['image'] . '" alt=""' . ( ++$i == 1 && ! empty( $init_size ) ? ' data-init-width="' . $init_size[0] . '" data-init-height="' . $init_size[1] . '"' : '' ) . ' /><div class="hero-info rsABlock">';

						if ( isset( $slide['url'] ) && $slide['url'] != '' ) {
							$hero_el .= '<a href="' . $slide['url'] . '">';
						}

						$hero_el .= '<h2 class="hero-title">' . $slide['title'] . '</h2>';

						if ( isset( $slide['url'] ) && $slide['url'] != '' ) {
							$hero_el .= '</a>';
						}

						$hero_el .= '<span class="subtitle">' . $slide['subtitle'] . '</span></div></article>';

					}

					$hero_el .= '</section></section>';
					$hero_title = '';

				}

				break;

			case 'video':

				// Simple video

				$hero_el .= '<figure class="hero-video hero-item">';
				$url = get_post_meta( $post_id, 'krown_hero_video', true );

				if ( strpos( strtolower( $url ), 'vimeo' ) ) {

					$url = str_replace( 'http://vimeo.com/', '', $url );

					$hero_el .= '<div id="vmVideo" data-mute="m' . get_post_meta( $post_id, 'krown_hero_show_mute', true ) . '" data-height="950">
                        <iframe id="vmPlayer" src="http://player.vimeo.com/video/' . $url . '?api=1&amp;player_id=vmPlayer&amp;controls=' . ( get_post_meta( $post_id, 'krown_hero_show_controls', true ) == 'true' ? '1' : '0' ) . '&amp;title=0&amp;byline=0&amp;portrait=0&amp;autoplay=' . ( get_post_meta( $post_id, 'krown_hero_show_autoplay', true ) == 'true' ? '1' : '0' ) . '&amp;loop=' . ( get_post_meta( $post_id, 'krown_hero_show_loop', true ) == 'true' ? '1' : '0' ) . '&amp;color=#FFF" width="1920" height="950" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';

				} else if ( strpos( strtolower( $url ), 'youtube' ) ) {

					$hero_el .= '<div id="ytVideo-hero" class="yt-movie" style="display:block; margin: auto; background: rgba(0,0,0,0.5)" data-height="950" data-property="{videoURL:\'' . $url . '\',containment:\'self\',startAt:0,mute:' . get_post_meta( $post_id, 'krown_hero_show_mute', true ) . ',autoPlay:' . get_post_meta( $post_id, 'krown_hero_show_autoplay', true ) . ',showControls:' . get_post_meta( $post_id, 'krown_hero_show_controls', true ) . ',loop:' . get_post_meta( $post_id, 'krown_hero_show_loop', true ) . ',quality:\'hd1080\',opacity:1}"></div>';

				} else {

            		$hero_el .= '<video id="mejsp-hero" class="mejs-video-play"' . ( get_post_meta( $post_id, 'krown_hero_height_type', true ) != 'fixed' && get_post_meta( $post_id, 'krown_hero_height_type', true ) != 'percent' ? ' width="100%" height="100%" style="width:100%;height:100%;" data-resize="no"' : '' ) . ' data-show-autoplay="' . ( get_post_meta( $post_id, 'krown_hero_show_autoplay', true ) == 'true' ? '1' : '0' ) . '" data-show-loop="' . ( get_post_meta( $post_id, 'krown_hero_show_loop', true ) == 'true' ? '1' : '0' ) . '" data-show-controls="' . ( get_post_meta( $post_id, 'krown_hero_show_controls', true ) == 'true' ? '1' : '0' ) . '" data-show-mute="' . ( get_post_meta( $post_id, 'krown_hero_show_mute', true ) == 'true' ? '1' : '0' ) . '"><source type="video/mp4" src="' . $url . '" /></video>';

				}

                $hero_el .= '</section>';

                break;

			case 'text':

				// Simple text

				$hero_el .= '<div class="hero-intro hero-item clearfix">
                        <div class="module text-module" data-size="4-2" data-bgcolor="' . get_post_meta( $post_id, 'krown_hero_text_bg', true ) . '" data-bgimage="' . get_post_meta( $post_id, 'krown_hero_text_img', true ) . '" data-color="' . get_post_meta( $post_id, 'krown_hero_text_tg', true ) . '" data-customTransform="' . get_post_meta( $post_id, 'krown_hero_text_a', true ) . '">
                            <div class="copy">
                                <div>
                                    <div style="vertical-align:' . get_post_meta( $post_id, 'krown_hero_text_av', true ) . '">' . do_shortcode( get_post_meta( $post_id, 'krown_hero_text', true ) ) . '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
				$hero_title = '';

                break;

			default: 

				// Nothing

				$hero_class = ' no-hero';
				$hero_el .= '</section>';
				$hero_title = '';

		}

		if ( $post_id != '' ) {
			$hero_detect = get_post_meta( $post_id, 'krown_hero_detect', true );
			if ( $hero_detect != '' && $hero_detect != 'auto' ) {
				$hero_class .= ' force-detect-' . $hero_detect;
			}
		}

		return array(
			$hero_class,
			$hero_title,
			$hero_el
		);

	}

}

/*---------------------------------
	Gets post number (in blog grid)
------------------------------------*/

if ( ! function_exists( 'lobo_post_no' ) ) {

	function lobo_post_no( $i, $echo = true ) {

		$no = '';

		if ( $i < 10 ) {
			$no = ' #0' . $i;
		} else {
			$no = ' #' . $i;
		}

		if ( $echo ) {
			echo $no;
		} else {
			return $no;
		}

	}

}

/*---------------------------------
	Adds various classes to the body element, depending on the page template
------------------------------------*/

if ( ! function_exists( 'lobo_custom_body_class' ) ) {

	function lobo_custom_body_class() {

		global $post;

		if ( isset( $post ) ) {

			if ( is_page_template( 'template-blog.php' ) || is_search() || is_archive() ) {
				return ' blog isotope-filtering';
			} else if ( is_page_template( 'template-portfolio.php' ) ) {
				if ( get_post_meta( $post->ID, 'folio_style', true ) == 'full' ) {
					return ' isotope-filtering page-template-template-modular-php';
				} else {
					return ' isotope-filtering';
				}
			} else if ( is_page() && ! ( is_page_template( 'template-modular.php' ) || is_page_template( 'template-portfolio.php' ) ) ) {
				return ' single-post';
			}

		}

	}

}

/*---------------------------------
	Creates the page actions
------------------------------------*/

if ( ! function_exists( 'lobo_page_actions' ) ) {

	function lobo_page_actions() {

		global $post;

		if ( function_exists( 'is_woocommerce') && ( is_woocommerce() ) ) :

			//nada

		elseif ( is_page_template( 'template-blog.php' ) || is_search() || is_archive() || is_singular( 'post' ) || get_option( 'lobo_show_search', 'disabled' ) == 'enabled' ) : 

			// Blog categories and search element ?>

	        <div class="blog-actions">

	            <div class="blog-action-search">
	                <h5 class="blog-action-title"><?php _e( 'Type & click enter', 'lobo' ); ?></h5>
	                <?php get_search_form(); ?>
	            </div>

	            <?php if ( is_page_template( 'template-blog.php' ) || is_search() || is_archive() || is_single() ) : ?>

	            <div class="blog-categories">
	                <h5 class="blog-action-title"><?php _e( 'Categories', 'lobo' ); ?></h5>
	                <ul class="cats-blog"><?php wp_list_categories( 'title_li=' ); ?></ul>
	            </div>

	        	<?php endif; ?>

	        </div>

		<?php endif; 

			// Portfolio categories

			if ( is_page_template( 'template-portfolio.php' ) ) : ?>

	        <ul class="cats">
	        	<li><a href="#" data-filter="*"><?php _e( 'ALL', 'lobo' ); ?></a></li>
	        	<?php 

				$cats = get_post_meta( $post->ID, 'folio_cats', true );
				$filter = '';

				if ( ! empty ( $cats ) ) {

					if ( sizeof( $cats ) == 1 ) {
						echo '<li id="remove-filters"><li>';
					} else {

						foreach ( $cats as $cat ) {
							$filter = get_term_by( 'id', $cat, 'portfolio_category' );
							if ( $filter->slug != '' ) {
								echo "\n" . '<li><a href="#" data-filter=".' . $filter->slug . '">' . $filter->name . '</a></li>';
							}
						}

					}

				} else {

					$cats = get_categories(array('taxonomy'=>'portfolio_category'));

					foreach ( $cats as $cat ) {
						echo "\n" . '<li><a href="#" data-filter=".' . $cat->slug . '">' . $cat->name . '</a></li>';
					}

				}

			?> </ul>

		<?php endif; 

	}

}

/*---------------------------------
	Creates shop search area
------------------------------------*/

if ( ! function_exists( 'lobo_shop_search' ) ) {

	function lobo_shop_search() {

		global $post;

		if ( is_shop() || is_product() || is_product_category() || is_product_tag() ) {

			// Start wrapper and include search form

			echo '<div id="shop-search" class="clearfix"><div class="clearfix">';
			echo '<a href="#" class="ss-cls-btn">+</a>';
			get_product_search_form();

			// Custom content in between

			echo '<div class="right c-tabs clearfix">';
			dynamic_sidebar( 'krown_blog_widget_area' );
			echo '</div>';

			// End wrapper

			echo '</div></div>';

		}

	}

}

if ( function_exists( 'is_woocommerce' ) ) {
	add_filter( 'wp_footer', 'lobo_shop_search' );
}

/*---------------------------------
	Custom styling for TinyMCE
------------------------------------*/

// Add a series of predefined text types

if ( ! function_exists( 'lobo_mce_custom_styles' ) ) {

	function lobo_mce_custom_styles($settings) {
	    $settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';

	    $style_formats = array(
	        array('title' => 'Cite', 'inline' => 'cite', 'classes' => ''),
	        array('title' => 'Left Note', 'inline' => 'span', 'classes' => 'left-note'),
	        array('title' => 'Big Text', 'inline' => 'span', 'classes' => 'big-text'),
	        array('title' => 'Special Link', 'inline' => 'span', 'classes' => 'btn-link')
	    );

	    $settings['style_formats'] = json_encode( $style_formats );

	    return $settings;
	}

}

add_filter('tiny_mce_before_init', 'lobo_mce_custom_styles');

// Customize TinyMCE editor font sizes

if ( ! function_exists( 'lobo_mce_text_sizes' ) ) {

	function lobo_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}

}

add_filter( 'tiny_mce_before_init', 'lobo_mce_text_sizes' );

// Add custom fonts to the fonts list (based on the embedded fonts)

if ( ! function_exists( 'lobo_mce_custom_fonts_array' ) ) {

	function lobo_mce_custom_fonts_array( $initArray ) {

		$initArray['font_formats'] = '';

		$f_type_1 = is_serialized( get_option('lobo_type_1' ) ) ? unserialize( get_option('lobo_type_1' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_2 = is_serialized( get_option('lobo_type_2' ) ) ? unserialize( get_option('lobo_type_2' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_3 = is_serialized( get_option('lobo_type_3' ) ) ? unserialize( get_option('lobo_type_3' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_4 = is_serialized( get_option('lobo_type_4' ) ) ? unserialize( get_option('lobo_type_4' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );

		if ( isset( $f_type_1['css-name'] ) ) {
			$initArray['font_formats'] .= str_replace( '+', ' ', $f_type_1['css-name'] ) . '=' . lobo_format_font_name( $f_type_1['font-family'] );
		}

		if ( isset( $f_type_2['css-name'] ) ) {
			$initArray['font_formats'] .= str_replace( '+', ' ', $f_type_2['css-name'] ) . '=' . lobo_format_font_name( $f_type_2['font-family'] );
		}

		if ( isset( $f_type_3['css-name'] ) ) {
			$initArray['font_formats'] .= str_replace( '+', ' ', $f_type_3['css-name'] ) . '=' . lobo_format_font_name( $f_type_3['font-family'] );
		}

		if ( isset( $f_type_4['css-name'] ) ) {
			$initArray['font_formats'] .= str_replace( '+', ' ', $f_type_4['css-name'] ) . '=' . lobo_format_font_name( $f_type_4['font-family'] );
		}

		$initArray['font_formats'] = rtrim( $initArray['font_formats'], ';' );

        return $initArray;

	}

}

function lobo_format_font_name( $str ) {

	$str_temp = strrchr( $str, ' ' );
	return strtolower( str_replace( $str_temp, substr( $str_temp, 1 ), str_replace( '\'', '', $str) ) );
}

add_filter( 'tiny_mce_before_init', 'lobo_mce_custom_fonts_array' );

// Add new buttons to the TinyMCE interface

if ( ! function_exists( 'lobo_mce_buttons' ) ) {

	function lobo_mce_buttons( $buttons ) {

		// Don't quite like how it's done, but i couldn't find any other way, at least not

		$f_type_1 = is_serialized( get_option('lobo_type_1' ) ) ? unserialize( get_option('lobo_type_1' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_2 = is_serialized( get_option('lobo_type_2' ) ) ? unserialize( get_option('lobo_type_2' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_3 = is_serialized( get_option('lobo_type_3' ) ) ? unserialize( get_option('lobo_type_3' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_type_4 = is_serialized( get_option('lobo_type_4' ) ) ? unserialize( get_option('lobo_type_4' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );

		if ( isset( $f_type_1['css-name'] ) || isset( $f_type_2['css-name'] ) || isset( $f_type_3['css-name'] ) || isset( $f_type_4['css-name'] ) ) {
			array_unshift( $buttons, 'fontselect' );
		}	

		// The other two go simple

		array_unshift( $buttons, 'fontsizeselect' );
    	array_unshift( $buttons, 'styleselect');
		return $buttons;
	}

}

add_filter( 'mce_buttons_2', 'lobo_mce_buttons' );

/*---------------------------------
	Images with captions (filter)
------------------------------------*/

function cleaner_caption( $output, $attr, $content ) {

	if ( is_feed() )
		return $output;

	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	$attr = shortcode_atts( $defaults, $attr );

	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	$output = '<figure' . $attributes .'>';

	$output .= do_shortcode( $content );

	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';

	$output .= '</figure>';

	return $output;

}

add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

/*---------------------------------
	Modular content builder
------------------------------------*/

if ( ! function_exists( 'lobo_modular_content' ) ) {

	function lobo_modular_content( $post ) {

		// This function is the one which handles all modules! It is highly sensitive so be careful if editing

		$html = '<section class="content-module clearfix" data-cols="2">';

    	$kmb = get_post_meta( $post->ID, 'kmb', true );
    	$kmb_decoded = json_decode( $kmb );
        $i = 0;

        if ( ! empty ( $kmb_decoded ) ) {

        	foreach ( $kmb_decoded as $module ) {

        		if ( isset( $module->type ) ) {

	        		if ( $module->type != 'nav' && $module->type != 'slider' && $module->type != 'latest' && $module->type != 'separator' ) {

	            		$data = $w = $h = $type = $content = $title = '';

	                    $wrap_a = '<div class="copy"><div><div>';
	                    $wrap_b = '</div></div></div>';

	                    // We build the content separately for certain modules, then pop those objects out of the array

	                    if ( $module->type == 'map' ) {

	                    	// Embed when maps are needed

							wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false', NULL, true );

	                    } else if ( $module->type == 'cta' ) {

	                    	// Call to action

	                        $content .= '<a class="call-to-action-achr" href="' . $module->linkurl . '" target="' . $module->linktarget . '"><div class="copy"><div><div><h3>' . $module->title . '</h3><p>' . $module->subtitle . '</p><i class="icon-right-open-mini call-action-icon"></i></div></div></div></a>';

	                        $module->linktarget = $module->linkurl = $module->title = $module->subtitle = '';

	                        $data .= ' data-customtransform="center"';

	                    } else if ( $module->type == 'video' ) {

	                    	if ( strpos( strtolower( $module->mp4 ), 'vimeo' ) ) {

		    					$url = str_replace( 'http://vimeo.com/', '', $module->mp4 );
								$colors = get_option( 'lobo_colors' );

		                    	if ( isset( $module->poster ) && $module->poster != '' ) {

	                    			// Videos from Vimeo - w poster

		    						$img = aq_resize( $module->poster, $module->width*480, $module->height*480, true );
									$content .= '<div class="video-embedded" data-id="' . rand( 1, 1000 ) . '" data-src="' . 'http://player.vimeo.com/video/' . $url . '?api=1&amp;player_id=vmPlayer&amp;controls=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;loop=0&amp;color=' . $colors['main1'] . '"><img src="' . $img . '" alt="" /></div>';

								} else {

	                    			// Videos from Vimeo - wout poster

	                				$content .= '<iframe id="vmPlayer" src="http://player.vimeo.com/video/' . $url . '?api=1&amp;player_id=vmPlayer&amp;controls=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0&amp;loop=0&amp;color=' . $colors['main1'] . '" width="' . ( $module->width * 480 ) . '" height="' . ( $module->height * 480 ) . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen frameborder="0"></iframe>';

								}

	                    	} else if ( strpos( strtolower( $module->mp4 ), 'youtube' ) ) {


		                    	if ( isset( $module->poster ) && $module->poster != '' ) {

	                    			// Videos from YouTube - w poster

		    						$img = aq_resize( $module->poster, $module->width*480, $module->height*480, true );
									$content .= '<div class="video-embedded y" data-id="' . rand( 1, 1000 ) . '"><img src="' . $img . '" alt="" />' . '<div id="ytVideo' . $i . '" class="yt-movie" style="display:block; margin: auto; background: rgba(0,0,0,0.5)" data-height="960" data-property="{videoURL:\'' . $module->mp4 . '\',containment:\'self\',startAt:0,mute:false,autoPlay:false,showControls:true,loop:false,quality:\'highres\',opacity:1}"><div class="bottom-controls"></div></div>' . '</div>';

		                    	} else {

	                    			// Videos from Youtbe - w poster

	                    			$content .= '<div id="ytVideo' . $i . '" class="yt-movie" style="display:block; margin: auto; background: rgba(0,0,0,0.5)" data-height="960" data-property="{videoURL:\'' . $module->mp4 . '\',containment:\'self\',startAt:0,mute:false,autoPlay:false,showControls:true,loop:false,quality:\'highres\',opacity:1}"><div class="bottom-controls"></div></div>';

		                    	}

	                    	} else {

	                    		// Self hosted videos

	                    		$content .= '<video id="mejsp-' . $i .'" class="mejs-video-play"' . ( isset( $module->poster ) ? ' poster="' . $module->poster . '"' : '' ) . '><source type="video/mp4" src="' . $module->mp4 . '" /></video>';

	                    	}

	                        $module->mp4 = $module->poster = '';

	                    } else if ( $module->type == 'audio' ) {

	                    	// Audio

	                        $content .= '<audio preload="auto" controls>';

	                        if ( isset( $module->mp3 ) && $module->mp3 != '' ) {
	                            $content .= '<source src="' . $module->mp3 . '" />';
	                            $module->mp3 = '';
	                        }
	                        if ( isset( $module->ogg ) && $module->ogg != '' ) {
	                            $content .= '<source src="' . $module->ogg . '" />';
	                            $module->ogg = '';
	                        }

	                    } else if ( $module->type == 'image' && $module->height == 'auto' ) {

	                    	// Full height image

	                    	$content .= '<img class="image-0" src="' . $module->bgimage . '" alt="" />';

	                    	$module->bgimage = $module->caption = '';

	                    } else if ( $module->type == 'gallery' ) {

	                    	// Gallery handling

	                    	$content .= '<div class="galleria">';

		            		$slider = explode( ',', $module->gallery );

		            		if ( ! empty( $slider ) ) {	
		            			foreach ( $slider as $slide ) {

		            				$img = wp_get_attachment_image_src( $slide, 'full' );

			    					$content .= '<img src="' . aq_resize( $img[0], 100, 45, true ) . '" alt="" data-big="' . $img[0] . '" data-description=" ' . get_post( $slide )->post_excerpt . '" />';

		            			}
		            		}

		            		$content .= '</div><a class="galleria-run" href="#"><div><span class="text"><span class="icon"></span>' . __( 'View Gallery', 'lobo' ) . '</span></div></a><div class="hidden galleria-btn-labels"><span class="gal-next">' . __( 'next', 'lobo' ) . '</span><span class="gal-prev">' . __( 'prev', 'lobo' ) . '</span><span class="gal-close">' . __( 'close', 'lobo' ) . '</span></div>';

		            		$module->gallery = '';

	            		}

	                    // Image handling - we need to set the repeat when needed or crop the image otherwise

	                    if ( isset( $module->bgrepeat ) && $module->bgimage != '' && $module->bgrepeat == 'repeat' ) {
	                        $data .= ' data-bgimagepattern="' . $module->bgimage . '"';
	                        $module->bgimage = '';
	                    } else if ( isset( $module->bgimage ) && $module->bgimage != '' ) {
	                    	
	                    	if ( ! strpos( $module->bgimage, '.gif' ) ) {

			    				$img = aq_resize( $module->bgimage, $module->width*480, $module->height*480, true );
			    				$module->bgimage = $img;

		    				}

	                    }
	                    $module->bgrepeat = '';

	                    // Go through remaining keys

	            		foreach ( $module as $key => $value ) {

	            			switch ( $key ) {

	            				// Keys that go in the content string (inside the actual module)

	            				case 'kmbcontent' :
	            					if ( $value != '' ) {
	            						$content .= do_shortcode( apply_filters( 'the_content', $value ) );
	            					}
	            					break;

	            				case 'caption' :
	            					if ( $value != '' ) {
	            						$content .= '<span class="module-caption">' . $value . '</span>';
	            					}
	            					break;

	            				case 'title' :
	            					if ( $value != '' ) {
	            						$title .= '<h3 class="module-title">' . $value . '</h3>';
	            					}
	            					break;

	                            case 'innerwrap' :
	                                if ( $value != '' && $value == 'no-wrap' ) {
	                                    $wrap_a = '<div class="no-wrap">';
	                                    $wrap_b = '</div>';
	                                }
	                                break;

	            				// Important keys that need "special tratement"

	            				case 'type' :
	            					$type = $value;
	            					break;

	            				case 'width' :
	            					$w = $value;
	            					break;

	            				case 'height' :
	            					$h = $value;
	            					break;

	            				// All other keys go into the data array

	            				default :
	                                if ( $value != '' ) {
	    					           $data .= ' data-' . $key . '="' . $value . '"';
	                               }

	            			}

	            		}

	                    // Type refinement

	                    if ( $type == 'cta' ) {
	                        $type = 'call-to-action-module default';
	                        $wrap_a = $wrap_b = '';
	                    } else if ( $type == 'video' || $type == 'audio' || $type == 'image' ) {
	                        $wrap_a = $wrap_b = '';
	                        $type = 'default';
	                    } else if ( $type == 'map' ) {
	                        $wrap_a = $wrap_b = '';
	                    }

	                    if ( $wrap_b == '</div>' ){
	                        $type = 'default';
	                    }

	                    if ( $module->type == 'text' && isset( $module->innerwrap ) && ( $module->innerwrap == 'custom-wrap' || $module->innerwrap == 'auto-wrap' ) ) {
	                    	$type .= " $module->innerwrap $type";
	                    }

	            		$html .= '<div id="module-' . $post->ID . $i++ . '" class="module ' . $type . '-module" data-size="' . $w . '-' . $h . '"' . $data . '>' . $title . $wrap_a . $content . $wrap_b . '</div>';

	            	} else if ( $module->type == 'slider' ) {

	            		// Slider module, special element

	            		$html .= '<div id="module-' . $post->ID . $i++ . '" class="module default-module no-resize" data-size="' . $module->width . '-' . $module->height . '"><div class="royalSlider rsDefault' . ( isset( $module->transition ) ? ' will-fade' . $module->transition : '' ) . '">';

	            		$slider = explode( ',', $module->gallery );

	            		if ( ! empty( $slider ) ) {	
	            			foreach ( $slider as $slide ) {

	            				$caption = get_post( $slide )->post_excerpt;

	            				$img = wp_get_attachment_image_src( $slide, 'full' );
		    					$html .= '<div><img src="' . aq_resize( $img[0], $module->width*480, $module->height*480, true ) . '" alt="" />';

		    					if ( isset( $caption ) && $caption != '' ) {
		    						$html .= '<h4 class="slide-caption">' . $caption . '</h4>';
		    					}

		    					$html .= '</div>';

	            			}
	            		}

	            		$html .= '</div></div>';

	            	} else if ( $module->type == 'nav') {

	            		// Portfolio navigation, special element

						$adjacent_posts = lobo_get_adjacent_posts();

						$html .= get_adjacent_post_module( $adjacent_posts[0], __( 'Previous Project', 'lobo' ) );
						$html .= get_adjacent_post_module( $adjacent_posts[1], __( 'Next Project', 'lobo' ) );

	            	} else if ( $module->type == 'separator' ) {

	            		// Separator, special element

	            		$html .= '<div class="module separator" style="background-color:' . $module->bgcolor . '; text-align:' . $module->customtransform . '">';

	            		if ( isset( $module->title ) && $module->title != '' ) {
	            			$html .= '<h3 style="color:' . $module->color . '">' . $module->title . '</h3>';
	            		}

	            		$html .= '</div>';

	            	} else if ( $module->type == 'latest' ) {

	            		// Latest posts/portfolio, special element

	        			$args = array(
	        				'post_type' => $module->diff,
	        				'offset' => 0,
	        				'posts_per_page' => $module->no
	        			);

	            		if ( $module->diff == 'portfolio' ) {
	            			$args['portfolio_category'] = $module->cats;
	            		} else {
	            			$args['category_name'] = $module->cats;
	            		}

	            		$all_posts = new WP_Query( $args );

	            		$post_i = 0;

						while ( $all_posts->have_posts() ) {

							$all_posts->the_post();

							// Get thumbnail

							if ( has_post_thumbnail() ) {
								$thumb = get_post_thumbnail_id();
								$old_img = wp_get_attachment_image_src( $thumb, 'full' );
							} else {
								$old_img = Array( get_template_directory_uri() . '/img/blank-pfolio.gif', 480, 480 );
							}

	        				if ( $module->diff == 'portfolio' ) {

	        					// We're talking about latest projects

								$tw = str_replace( 'col-', '', $module->cols );
								$th = max( floor( $old_img[2] / 480 ), 1 );
								$img = aq_resize( $old_img[0], $tw * 480, $th * 480, true );

								// Build object

								$html .= '<div class="module image-module latest-module" data-size="' . $tw . '-' . $th . '" data-bgimage="' . $img . '">
									<a class="prtfl-item ifpt" title="' . get_the_title() . '" href="' . get_permalink() . '">
										<div class="item-hover">
											<div class="item-meta">
												<h2 class="item-title">' . get_the_title() . '</h2>
												<h3 class="item-cat">' . lobo_categories( null, 'portfolio_category', ', ', 'name', false ) . '</h3>
												<span class="thumb-extra-info"></span>
											</div>
										</div>
									</a>
								</div>';

							} else {

	        					// We're talking about latest projects

								$tw = str_replace( 'col-', '', $module->cols );
								$th = $tw;
								$img = aq_resize( $old_img[0], $tw * 480, $th * 480, true );

								// Build object

								$html .= '<div class="module image-module latest-module mt-post" data-size="' . $tw . '-' . $th . '" data-bgimage="' . $img . '">
									<div class="post-item ' . ( $post_i++ % 2 == 0 ? 'even' : 'odd' ) . '">
										<div class="inner-post">
											<header class="post-header">
												<span class="post-date"><time pubdate datetime="' . get_the_time( 'c' ) . '">' . get_the_time(  __( 'jS \o\f\ F Y', 'lobo' ) ) . '</time><span class="isu"><i class="timer-hr"></i>' . __( 'issue', 'lobo' ) . lobo_post_no( $post_i, false ) . '</span></span>
												<h2 class="post-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h2>
											</header>
											<footer>
												<span class="read-btn"><a href="' . get_permalink() . '">' . __( 'Read Article', 'lobo' ) . ' -</a></span>
											</footer>
										</div>
										<span class="post-overlay"></span>
										<img class="post-feat-img" src="' . $img . '" alt="' . get_the_title() . '" />
									</div>
								</div>'; 

							}

						}

						wp_reset_query();

	            	}

            	}
 
        	}

        }

        $html .= '</section>';

    	echo $html;

	}

}

/*---------------------------------
	Portfolio navigation functions
------------------------------------*/

function lobo_get_portfolio_page() {

	$page_id = isset ( $_GET['id'] ) ? $_GET['id'] : get_option( 'lobo_portfolio_page' );

	echo get_permalink( $page_id );
	
}

if ( ! function_exists( 'get_adjacent_post_module' ) ) {

	// This function is the one which creates the actual modules based on the options it gets

	function get_adjacent_post_module( $post, $label ) {

		if ( ! empty( $post ) ) {

			$thumb = get_post_thumbnail_id( $post->ID );
			$img_url = wp_get_attachment_url( $thumb, 'full' );
		    $img = aq_resize( $img_url, '480', '480', true );

			$page_id = isset ( $_GET['id'] ) ? $_GET['id'] : get_option( 'lobo_portfolio_page' );

			return '<div class="module pagination-module" data-size="1-1" data-bgimage="' . $img . '"><div><a title="' . get_the_title( $post->ID ) . '" href="' . get_new_permalink( $page_id, $post->ID, array( 'none' ) ) . '" class="btn-link">' . $label . '</a></div></div>';

		}

	}

}

if ( ! function_exists( 'get_new_permalink' ) ) {

	// This function creates a special permalink (the one with the ?id, helping for unlimited portfolios)

	function get_new_permalink( $page_id = null, $post_id = null, $cats = null ) {

		if ( get_option( 'krown_portfolio_unlimited', 'disabled' ) == 'enabled' ) {
			$page_id = null;
		}

		if ( $page_id == null || empty( $cats ) ) {
			return get_permalink( $post_id );
		} else {

		    global $wp_rewrite;
		    if ( $wp_rewrite->permalink_structure == '' ) {
		        return get_permalink( $post_id ) . '&id=' . $page_id;
		    } else {
		        return get_permalink( $post_id ) . '?id=' . $page_id;
		    }

		}

	}

}

function lobo_get_adjacent_posts() {

	// This is a complex function which handles the adjacent posts

	if ( isset( $_GET['id'] ) && $_GET['id'] != '' ) {

		// If the ?id is not empty it means that we need to get it and find out which categories should be included in the navigation

		$page_id = isset ( $_GET['id'] ) ? $_GET['id'] : get_option( 'lobo_portfolio_page' );

		$cats_excluded = array();
		$cats_included = get_post_meta( $page_id, 'folio_cats', true );

		if ( empty( $cats_included ) ) {

			// Fail safe (don't know if it really has an effect though)

			$cats_excluded = '';

			return array( 
				krown_get_adjacent_post( false, '', false, 'portfolio_category' ), 
				krown_get_adjacent_post( false, '', true, 'portfolio_category' )
			);

		} else {

			// Get all categories

			$cats_all = get_categories( array( 'taxonomy'=>'portfolio_category' ) );

			if ( ! empty( $cats_included ) ) {
				foreach ( $cats_all as $cat ) {
					if ( ! in_array( $cat->cat_ID, $cats_included ) ){
						array_push( $cats_excluded, $cat->cat_ID );
					}
				}
			}

			$cats_excluded = implode(',', $cats_excluded);

			return array( 
				krown_get_adjacent_post( false, $cats_excluded, false, 'portfolio_category' ), 
				krown_get_adjacent_post( false, $cats_excluded, true, 'portfolio_category' )
			);

		}

	} else {

		// Using the default function

		return array( 
			krown_get_adjacent_post( false, '', false, 'portfolio_category' ), 
			krown_get_adjacent_post( false, '', true, 'portfolio_category' )
		);

	}


}

function krown_get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {

	// When we are using navigaton with excluded categories we need to use this special function, which is an adaptation of the WP core to accept excluded taxonomy terms

	global $post, $wpdb;

	if ( ( ! $post = get_post() ) || ! taxonomy_exists( $taxonomy ) ) 
		return null; 

	$current_post_date = $post->post_date;

	$join = '';
	$posts_in_ex_terms_sql = ''; 
	if ( $in_same_term || ! empty( $excluded_terms ) ) { 
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id"; 

		if ( $in_same_term ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) ) 
				return '';
			$term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) ); 
			$join .= $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id IN (" . implode( ',', array_map( 'intval', $term_array ) ) . ")", $taxonomy ); 
		}

		$posts_in_ex_terms_sql = $wpdb->prepare( "AND tt.taxonomy = %s", $taxonomy ); 
		if ( ! empty( $excluded_terms ) ) { 
			if ( ! is_array( $excluded_terms ) ) { 
				if ( false !== strpos( $excluded_terms, ' and ' ) ) { 
					_deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded terms.' ), "'and'" ), 'krown' ); 
					$excluded_terms = explode( ' and ', $excluded_terms ); 
				} else {
					$excluded_terms = explode( ',', $excluded_terms );
				}
			}

			$excluded_terms = array_map( 'intval', $excluded_terms ); 
				
			if ( ! empty( $term_array ) ) { 
				$excluded_terms = array_diff( $excluded_terms, $term_array );
				$posts_in_ex_terms_sql = ''; 
			}

			if ( ! empty( $excluded_terms ) ) { 
				$posts_in_ex_terms_sql = $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id NOT IN (" . implode( $excluded_terms, ',' ) . ')', $taxonomy ); 
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_term, $excluded_terms ); 
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s AND p.post_excerpt NOT like 'link' AND p.post_status = 'publish' $posts_in_ex_terms_sql", $current_post_date, $post->post_type), $in_same_term, $excluded_terms ); 
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

	$query = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort"; 
	
	$query_key = 'adjacent_post_' . md5( $query ); 
	$result = wp_cache_get( $query_key, 'counts' ); 
	if ( false !== $result ) {
		if( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if (null === $result )
		$result = '';

	wp_cache_set( $query_key, $result, 'counts');

	if ( $result ) 
		$result = get_post( $result );

	return $result;

}

/*---------------------------------
	Disable indexing for "link" projects
------------------------------------*/

function lobo_indexing_meta() {

	global $post;

	if ( isset( $post ) && get_post_meta( $post->ID, 'lobo_folio_url_link', true ) != '' ) {
		echo '<meta name="robots" content="noindex">';
	}

}

/*---------------------------------
	Boxed layout background
------------------------------------*/

if ( ! function_exists( 'lobo_boxed_bg' ) ) {

	function lobo_boxed_bg() {

		if ( get_option( 'lobo_layout_type', 'full' ) == 'boxed-layout' ) {

			$type = get_option( 'lobo_bg_type', 'color' );

			if ( $type == 'img-full' ) {
				echo ' style="background-image:url(' . get_option( 'lobo_bg_img' ) . ');background-size:cover;background-repeat:no-repeat;background-position:center center;background-attachment:fixed;"';
			} else if ( $type == 'img-full' || $type == 'img-repeat' ) {
				echo ' style="background-image:url(' . get_option( 'lobo_bg_img' ) . ');background-repeat:repeat;background-attachment:fixed;"';
			} else {
				echo ' style="background-color:' . get_option( 'lobo_bg_color', '#dddddd' ) . '"';
			}

		}

	}

}

/*---------------------------------
	Password protected filters
------------------------------------*/

function lobo_pwd_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $type = get_post_type( $post );
    if ( $type == 'portfolio' )
    	$type = __( 'Project', 'lobo' );
    $o = '<form class="pwdprt" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div><div><div>
	    <p class="title">' . __( "This is a password protected", 'lobo' ) . ' ' . $type . '</p>
	    <p><input name="post_password" id="' . $label . '" type="text" size="20" maxlength="20" placeholder="' . __( 'Password', 'lobo' ) . '" /></p>
	    <p class="subtitle">' . __( 'Type and click enter', 'lobo' ) . '</p>
	    <p><input class="hidden" type="submit" name="Submit" value="' . esc_attr__( "Submit", 'lobo' ) . '" /></p>
	</div></div></div>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'lobo_pwd_form' );

/*---------------------------------
	Fix import errors
------------------------------------*/

add_filter( 'import_end', 'lobo_fix_import' );

function lobo_fix_import(){

	// Loop through all pages and portfolio items

	$args = array( 
		'posts_per_page' => -1, 
		'offset'=> 0,
		'post_type' => array( 'portfolio', 'page' ),
	);

	$all_posts = new WP_Query( $args );

	while ( $all_posts->have_posts() ) : $all_posts->the_post();

		global $post;

		// Gets the kmb meta key

		$kmb = get_post_meta( $post->ID, 'kmb', true );

		if ( ! empty( $kmb ) && $kmb != '' ) {

			$ob = json_decode( $kmb );

			if ( $ob === null ) {

				// The JSON array is invalid, try to fix it

				$newkmb = preg_replace_callback( '/(kmbcontent"):"(.*?)"}/', 'lobo_fix_import_help', $kmb );

				delete_post_meta( $post->ID, 'kmb' );
				add_post_meta( $post->ID, 'kmb', wp_slash( $newkmb ) );

			}

		}

	endwhile; 

}

function lobo_fix_import_help( $m ) {
	return $m[1] . ':"' . addslashes( $m[2] ) . '"}';
}

?>