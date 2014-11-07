<?php

/*
Plugin Name: Lobo Shortcodes
Description: A simple shortcode generator. Add buttons, columns, tabs, toggles and alerts to your theme.
Version: 1.0.4
Author: Ruben Bristian
Author URI: http://rubenbristian.com
License: GPL
License URI: http://www.gnu.org/copyleft/gpl.html

This plugin was forked from "Zilla Shortcodes" (plugin under GPL license) http://www.themezilla.com/plugins/zillashortcodes/

*/

class loboShortcodes {

    function __construct() {	

		if ( ! function_exists( 'aq_resize' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . '/assets/aq_resize.php' );
		}

    	$current_theme = wp_get_theme();

    	if ( file_exists( $current_theme->get_template_directory() . '/includes/lobo-shortcodes.php' ) ) {
    		include_once( $current_theme->get_template_directory() . '/includes/lobo-shortcodes.php' );
    	}

    	require_once( plugin_dir_path( __FILE__ ) . 'shortcodes.php' );

    	define( 'lobo_TINYMCE_URI', plugin_dir_url( __FILE__ ) . 'tinymce' );
		define( 'lobo_TINYMCE_DIR', plugin_dir_path( __FILE__ ) . 'tinymce' );
		
        add_action( 'init', array( &$this, 'init' ) );
        add_action( 'admin_init', array( &$this, 'admin_init' ) );

	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init() {

    	$current_theme = wp_get_theme();
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
	
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );

		}

	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array ) {
		global $wp_version;

		if ( version_compare( $wp_version, '3.9', '<' ) ) {
			$plugin_array['loboShortcodes'] = lobo_TINYMCE_URI . '/plugin-old.js';
		} else {
			$plugin_array['loboShortcodes'] = lobo_TINYMCE_URI . '/plugin.js';
		}
		return $plugin_array;
	}

	function ubl_add_tinymce_button( $buttons ) {
	 
	    array_push( $buttons, shortcodes );
	    return $buttons;
	     
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons ) {
		array_push( $buttons, "|", 'lobo_button' );
		return $buttons;
	}
	
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init() {

		global $wp_version;

		// css
		wp_enqueue_style( 'lobo-popup', lobo_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		
		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', lobo_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', lobo_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', lobo_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'lobo-popup', lobo_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
		
		// vars

    	$current_theme = wp_get_theme();
    	
		$shortcodesList = array(
			array( 'Accordion', 'accordion' ),
			array( 'Button', 'button' ),
			array( 'Contact Form', 'form' ),
			array( 'Content Slider', 'cslider' ),
			array( 'Icons', 'icon' ),
			array( 'Images List', 'list' ),
			//array( 'Tabs', 'tabs' ),
			array( 'Team Slider', 'tslider' ),
			array( 'Twitter Feed', 'twitter' )
		);

		wp_localize_script( 
			'jquery', 
			'loboShortcodes', 
			array( 
				'pluginFolder' => WP_PLUGIN_URL . '/lobo-shortcodes/',
				'shortcodesList' => $shortcodesList
			) 
		);

	}
    
}

$lobo_shortcodes = new loboShortcodes();

?>