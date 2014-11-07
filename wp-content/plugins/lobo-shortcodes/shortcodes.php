<?php

/* ------------------------
-----   Accordion    -----
------------------------------*/

if ( ! function_exists( 'lobo_accordion_function' ) ) {

	function lobo_accordion_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'opened' 	=> '0'
	    ), $atts ) );

	    $html = '<div data-opened="' . $opened . '" class="lobo-accordion ' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';

	    $html .= do_shortcode( $content );

	    $html .= '</div>';

	    return $html;

	}

	add_shortcode( 'lobo_accordion', 'lobo_accordion_function' );

}

if ( ! function_exists( 'lobo_accordion_section_function' ) ) {

	function lobo_accordion_section_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'title' => 'Section',
	    ), $atts ) );

	    $html = '<div class="section">
	    	<h3>' . $title . '</h3>
	    	<div class="content">' . do_shortcode( apply_filters( 'the_content', $content ) ) . '</div>
	    </div>';

	    return $html;

	}	

	add_shortcode( 'lobo_accordion_section', 'lobo_accordion_section_function' );

}

/* ------------------------
-----   Content Slider    -----
------------------------------*/

if ( ! function_exists( 'lobo_cslider_function' ) ) {

	function lobo_cslider_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'style' => 'slider'
	    ), $atts ) );

	    $html = '<div class="royalSlider rsDefault ' . $style . ( $el_class != '' ? ' ' . $el_class : '' ) . '">';

	    $html .= do_shortcode( $content );

	    $html .= '</div>';

	    return $html;

	}

	add_shortcode( 'lobo_cslider', 'lobo_cslider_function' );

}

if ( ! function_exists( 'lobo_cslider_slide_function' ) ) {

	function lobo_cslider_slide_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'title' => 'Slide Title',
	        'icon' => 'none'
	    ), $atts ) );

	    $html = '<div class="rsContent text-slide"><div class="slide-inner"><div class="copy"><div><div>';

	    if ( $icon != 'none' ) {
	    	$html .= '<i class="img-asset fa fa-4x ' . $icon . '"></i>';
	    }
	    $html .= '<h2>' . $title . '</h2>
	    	<div>' . do_shortcode( apply_filters( 'the_content', $content ) ) . '</div>
	    </div></div></div></div></div>';

	    return $html;

	}	

	add_shortcode( 'lobo_cslider_slide', 'lobo_cslider_slide_function' );

}

/* ------------------------
-----   Images List    -----
------------------------------*/

if ( ! function_exists( 'lobo_list_function' ) ) {

	function lobo_list_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => ''
	    ), $atts ) );

	    $html = '<div class="list-module' . ( $el_class != '' ? ' ' . $el_class : '' ) . '"><ul>';

	    $html .= do_shortcode( $content );

	    $html .= '</ul></div>';

	    return $html;

	}

	add_shortcode( 'lobo_list', 'lobo_list_function' );

}

if ( ! function_exists( 'lobo_list_image_function' ) ) {

	function lobo_list_image_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'image' => '',
	    ), $atts ) );

	    $html = '';

	    if ( $image != '' ) {
	    	$html .= '<li><img src="' . $image . '" alt="" /></li>';
	    }

	    return $html;

	}	

	add_shortcode( 'lobo_list_image', 'lobo_list_image_function' );

}

/* ------------------------
-----   Team Slider    -----
------------------------------*/

if ( ! function_exists( 'lobo_tslider_function' ) ) {

	function lobo_tslider_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'type' => 'one'
	    ), $atts ) );

	    $html = '<div class="royalSlider rsDefault' . ( $type == 'one' ? ' visibleNearby team-wdgt' : ' team-wdgt info-bottom' ) . ( $el_class != '' ? ' ' . $el_class : '' ) . '">';

		global $tslider_type;
		$tslider_type = $type;

	    $html .= do_shortcode( $content );

	    $html .= '</div>';

	    if ( $type == 'two' ) {
	    	$html .= '<div class="team-info-area"></div>';
	    }

	    return $html;

	}

	add_shortcode( 'lobo_tslider', 'lobo_tslider_function' );

}

if ( ! function_exists( 'lobo_tslider_slide_function' ) ) {

	function lobo_tslider_slide_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'title' => 'Title',
	        'subtitle' => 'Subtitle',
	        'image' => ''
	    ), $atts ) );

		global $tslider_type;

	    $html = '<div class="rsContent text-slide"><div class="member-info rsABlock">
	    	<h3>' . $title . '</h3>
	    	<span class="member-role">' . $subtitle . '</span>';

	    if ( $content != '' && $tslider_type == 'one' ) {
	    	$html .= do_shortcode( $content );
	    }

	    $html .= '</div>';

	    if ( $image != '' ) {
	    	$html .= '<figure class="img-asset"><img src="' . $image . '" alt="' . $title . '" /></figure>';
	    }

	    $html .= '</div>';

	    return $html;

	}	

	add_shortcode( 'lobo_tslider_slide', 'lobo_tslider_slide_function' );

}

/* ------------------------
-----   Social Links    -----
------------------------------*/

function lobo_social_function( $atts, $content ) {

	$html = '<ul>';

	foreach ( $atts as $key => $item ) {

		$html .= '<li><a href="' . $item . '" title="' . __( 'Join us on', 'lobo' ) . ' ' . ucfirst( $key ) . '" class="shr-btn-' . $key . '"><span>' . ucfirst( $key ) . '</span><i class="icon-' . $key . '"></i></a></li>';

	}

	$html .= '</ul>';

	return $html;

}

add_shortcode( 'lobo_social', 'lobo_social_function' );

/* ------------------------
-----   Buttons    -----
------------------------------*/

if ( ! function_exists( 'lobo_button_function' ) ) {

	function lobo_button_function( $atts, $content ) {

	extract(shortcode_atts(array(
		'label' => 'Label',
		'target' => '_self',
		'url' => '#',
		'color' => '#000',
		'bgcolor' => '#fff',
		'el_class' => ''
	), $atts));

	$output = '<a class="btn' . ( $el_class != '' ? ' ' . $el_class : '' ) . '" style="color: ' . $color . '; background-color: ' . $bgcolor . '" data-btn-txt-color="' . $color . '" data-btn-bg-color="' . $bgcolor . '" target="' . $target . '" href="' . $url . '">' . $label . '</a>';

	return $output;

}

add_shortcode( 'lobo_button', 'lobo_button_function' );

}

/* ------------------------
-----   Contact Form    -----
------------------------------*/

if ( ! function_exists( 'lobo_form_function' ) ) {

	function lobo_form_function($atts, $content) { 

	    extract( shortcode_atts( array(
	        'el_class' 		 => '',
	        'label_name'	 => 'Name',
	        'label_email' 	 => 'Email',
	        'label_subject'  => 'Subject',
	        'label_message'  => 'Message',
	        'label_send' 	 => 'Send',
	        'email' 		 => '',
	        'success' 		 => 'Your message was sent!',
	        'required' 		 => '* required fields'
	    ), $atts ) );

	    $html = '<div class="contact-form' . ( $el_class != '' ? ' ' . $el_class : '' ) . '">
	    	<form method="POST" action="' . plugin_dir_url( __FILE__ ) . 'assets/contact-form.php">';

	    	$subject_arr = explode( "\n", $label_subject );

	    	$html .= '
	    		<div class="block">
	    			<label class="screen-reader">' . $label_name . '</label>
	    			<input type="text" name="name" class="name" placeholder="' . $label_name . '" />
	    		</div>
	    		<div class="block">
	    			<label class="screen-reader">' . $label_email . '</label>
	    			<input type="text" name="email" class="email" novalidate="" placeholder="' . $label_email . '" />
	    		</div>
	    		<div class="block message-area">
	    			<label class="screen-reader">' . $label_message . '</label>
	    			<textarea name="message" class="message" placeholder="' . $label_message . '"></textarea>
	    		</div>
	    		<input type="text" name="fred" class="fred hidden" value="" />
	        	<input type="submit" class="send-btn" value="'. $label_send . '" />
	    		<input type="hidden" name="dlo128" class="hidden dlo128" placeholder="' . $email . '" />
	    		<em class="form-legend">' . $required . '</em>';

	    	if ( sizeof( $subject_arr ) == 1 ) {
	    		$html .= '<div class="block">
	    			<label class="screen-reader">' . ' ' . '</label>
	    			<input type="text" name="subject" class="subject" placeholder="' . $label_subject . '" />
	    		</div>';
	    	} else {

		    	$html .= '
		    		<div class="block">
		    			<label class="screen-reader">' . ' ' . '</label>
		    			<select class="select-form subject" name="subject">';
		    			foreach ( $subject_arr as $subject ) {
		    				$html .= '<option value="' . $subject . '">' . $subject . '</option>';
		    			}
	    		$html .= '</select>
		    		</div>';

	    	}

	    $html .= '</form>
	    	<p class="success-message" style="display:none">' . str_replace( "\n", "<br />", $success ) . '</p>
	    </div>';
	   
	   return $html;

	}

	add_shortcode( 'lobo_form', 'lobo_form_function' );

}

/* ------------------------
-----   Flickr Feed   -----
------------------------------*/

if ( ! function_exists( 'lobo_flickr_function' ) ) {

	function lobo_flickr_function( $atts, $content ){

	    extract( shortcode_atts(array(
	        'el_class'  => '',
	        'id' 		=> '52617155@N08',
	        'no' 		=> '15'
	    ), $atts ) );

		$html = '<section class="lobo-flickr' . ( $el_class != '' ? ' ' . $el_class : '' ) . '"><ul class="clearfix">';
		$html .= lobo_parse_flickr_feed( $id, $no );

		$html .= '</ul></section>';

		return $html;

	}

	add_shortcode( 'lobo_flickr', 'lobo_flickr_function' );

}

function lobo_parse_flickr_feed( $id, $no ) {

	$url = "http://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=en-en&format=rss_200";
	$s = file_get_contents( $url );

	preg_match_all('#<item>(.*)</item>#Us', $s, $items);

	$output = "";

	for ( $i = 0; $i < count( $items[1] ); $i++ ) {

		if( $i >= $no ) {
			return $output;
		} 		

		$item = $items[1][$i];
		preg_match_all( '#<link>(.*)</link>#Us', $item, $temp );

		$link = $temp[1][0];
		preg_match_all( '#<title>(.*)</title>#Us', $item, $temp );

		$title = $temp[1][0];
		preg_match_all( '#<media:thumbnail([^>]*)>#Us', $item, $temp );

		$thumb = lobo_parse_flickr_attr( $temp[0][0], "url" );

		$output .= "<li><a href='$link' target='_blank' title=\"" . str_replace( '"', '', $title ) . "\"><img alt='$title' src='$thumb'/></a></li>";

	}

	return $output;

}

function lobo_parse_flickr_attr( $s, $attrname ) { 

	preg_match_all( '#\s*(' . $attrname . ')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x );

	if ( count( $x ) >= 3 ) {
		return $x[2][0]; 
	} else { 
		return "";
	}

}

/* ------------------------
-----   Icons    -----
------------------------------*/

if ( ! function_exists( 'lobo_icon_function' ) ) {

	function lobo_icon_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'size' => 'fa-lg',
	        'icon' => 'none',
	        'color' => 'grey',
	        'break' => 'float',
	        'el_class' => ''
	    ), $atts ) ) ;

	    if ( $icon != 'none' ) {
	    	$html = '<i class="fa ' . $icon . ' ' . $size . ( $el_class != '' ? ' ' . $el_class : '' ) . ' ' . $break . '" style="color:' . $color . '"></i>';
	    } else {
	    	$html = '';
	    }
	   
	   return $html;

	}

	add_shortcode( 'lobo_icon', 'lobo_icon_function' );

}


/* ------------------------
-----   Tabs   -----
------------------------------*/

if ( ! function_exists( 'lobo_tabs_function' ) ) {

	function lobo_tabs_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => ''
	    ), $atts ) );

	    $html = '<div class="lobo-tabs' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';

		$tabs = explode('<!-- cut out -->', do_shortcode( $content ) );
		$i = 0; $top = ''; $bottom = '';

		foreach ( $tabs as $item ) {

			if( $i++%2 == 0 ) {
				$top .= $item;
			} else { 
				$bottom .= $item;
			}

		}

	    $html .= '<ul class="titles clearfix autop">' . preg_replace( '/<li>/' , '<li class="opened">', $top, 1 ) . '</ul>';
	    $html .= '<div class="contents clearfix autop">' . $bottom . '</div>';
	    $html .= '</div>';

	    return $html;

	}

	add_shortcode( 'lobo_tabs', 'lobo_tabs_function' );

}

if ( ! function_exists( 'lobo_tabs_section_function' ) ) {

	function lobo_tabs_section_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'title'  => 'Section'
	    ), $atts ) );

		$html = '<li><h5>' . $title . '</h5></li><!-- cut out --><div>' . do_shortcode( $content ) . '</div><!-- cut out -->';

	    return $html;

	}

	add_shortcode( 'lobo_tabs_section', 'lobo_tabs_section_function' );

}

/* ------------------------
-----   Twitter Feed   -----
------------------------------*/

if ( ! function_exists( 'lobo_twitter_function' ) ) {

	function lobo_twitter_function( $atts, $content ) {

	    extract( shortcode_atts( array(
	        'el_class' 		 => '',
	        'user' 			 => 'rubenbristian',
	        'no' 			 => '1',
	    ), $atts ) );

	    $html = '';

		if ( function_exists( 'getTweets' ) ) {

			$tweets = getTweets( $user, $no );

		    if ( ! empty ( $tweets['error'] ) ) {

				$html .= '<p>Error (go to Settings > Twitter Feed Auth to resolve this): <span style="color:red; ">' . $tweets['error'] . '</span></p>';

		    } else {

				$html = '<div class="twitter-feed' . ( $el_class != '' ? ' ' . $el_class : '' ) . '">
				<ul class="tweet_list">';

		    	foreach ( $tweets as $tweet ) {

		    		$html .= '<li>
		    			<span class="tweet_text">' . lobo_parse_tweet( $tweet['text'] ) . '</span></li>';

		    	}

		    }

		} else {

			$html = '<p style="font-weight:bold;">Please install the <a href="http://wordpress.org/plugins/oauth-twitter-feed-for-developers/">oAuth Twitter Feed Plugin</a> and configure it properly for the twitter widget to run. Read more about this in the manual.</p>';

		}

		$html .= '</ul></div>';

		return $html;

	}

	add_shortcode( 'lobo_twitter', 'lobo_twitter_function' );

}

function lobo_parse_tweet( $string ) {

	$content_array = explode( " ", $string );
	$output = '';

	foreach ( $content_array as $content ) {

		if ( substr( $content, 0, 7 ) == "http://" ) {
			$content = '<a href="' . $content . '">' . $content . '</a>';
		}

		//starts with www.
		if ( substr( $content, 0, 4 ) == "www." ) {
			$content = '<a href="http://' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 8 ) == "https://" ) {
			$content = '<a href="' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 1 ) == "#" ) {
			$content = '<a href="https://twitter.com/search?src=hash&q=' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 1 ) == "@" ) {
			$content = '<a href="https://twitter.com/' . $content . '">' . $content . '</a>';
		}

		$output .= " " . $content;

	}

	$output = trim( $output );

	return $output;

}

/* ------------------------
-----   Widget Area   -----
------------------------------*/

if ( ! function_exists( 'lobo_widget_function' ) ) {

	function lobo_widget_function( $atts, $content ) {

	    extract( shortcode_atts( array(
	        'el_class' 		 => '',
	        'id' 			 => ''
	    ), $atts ) );

	    if ( $id != '' && is_active_sidebar( $id ) ) {
	    	
			ob_start();
			dynamic_sidebar( $id );
			$html = ob_get_contents();
			ob_end_clean();
			return $html;

	    }

	}

	add_shortcode( 'lobo_widget', 'lobo_widget_function' );

}

?>