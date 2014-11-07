<?php 

/* ------------------------
-----   Contact Form    -----
------------------------------*/

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
    	<form method="POST" action="' . get_template_directory_uri() . '/includes/contact-form.php">';

    	$subject_arr = explode( "\n", $label_subject );

    	$html .= '
    		<div class="block">
    			<label class="screen-reader">' . __( 'name *', 'lobo' ) . '</label>
    			<input type="text" name="name" class="name" placeholder="' . $label_name . '" />
    		</div>
    		<div class="block">
    			<label class="screen-reader">' . __( 'email *', 'lobo' ) . '</label>
    			<input type="text" name="email" class="email" novalidate="" placeholder="' . $label_email . '" />
    		</div>
    		<div class="block message-area">
    			<label class="screen-reader">' . __( 'message *', 'lobo' ) . '</label>
    			<textarea name="message" class="message" placeholder="' . $label_message . '"></textarea>
    		</div>
    		<input type="text" name="fred" class="fred hidden" value="" />
        	<input type="submit" class="send-btn" value="'. $label_send . '" />
    		<input type="hidden" name="dlo128" class="hidden dlo128" value="' . $email . '" />';

    	if ( sizeof( $subject_arr ) == 1 ) {
    		$html .= '<div class="block">
    			<label class="screen-reader">' . __( 'subject', 'lobo' ) . '</label>
    			<input type="text" name="subject" class="subject" placeholder="' . $label_subject . '" />
    		</div>';
    	} else {

	    	$html .= '
	    		<div class="block">
	    			<label class="screen-reader">' . __( 'subject', 'lobo' ) . '</label>
	    			<select class="select-form subject" name="subject">';
	    			foreach ( $subject_arr as $subject ) {
	    				$html .= '<option value="' . $subject . '">' . $subject . '</option>';
	    			}
    		$html .= '</select>
	    		</div>';

    	}

    $html .= '<em class="form-legend">' . $required . '</em></form>
    	<p class="success-message" style="display:none">' . str_replace( "\n", "<br />", $success ) . '</p>
    </div>';
   
   return $html;

}

add_shortcode( 'lobo_form', 'lobo_form_function' );

/* ------------------------
-----   Social Links    -----
------------------------------*/

function lobo_new_social_function( $atts, $content ) {

	extract(shortcode_atts(array(
		'target' => '_self'
	), $atts));

	$html = '<ul>';

	foreach ( $atts as $key => $item ) {

		if ( $key != 'target' ) {

			$html .= '<li><a target="' . $target . '" href="' . $item . '" title="' . __( 'Join us on', 'lobo' ) . ' ' . ucfirst( $key ) . '" class="shr-btn-' . $key . '"><span>' . ucfirst( $key ) . '</span><i class="icon-' . $key . '"></i></a></li>';
			
		}

	}

	$html .= '</ul>';

	return $html;

}

add_action( 'init', 'swap_social_shortcode', 99 );

function swap_social_shortcode(){
	remove_shortcode( 'lobo_social' );
	add_shortcode( 'lobo_social', 'lobo_new_social_function' );
}

?>