<?php

/*
Plugin Name: Lobo Portfolio
Description: A simple portfolio post type manager
Version: 0.1
Author: Ruben Bristian
Author URI: http://rubenbristian.com
License: GPL
License URI: http://www.gnu.org/copyleft/gpl.html
*/

class KrownPortfolio {

    function __construct() {  

        $current_theme = wp_get_theme();
        
        require_once( plugin_dir_path( __FILE__ ) . 'includes/portfolio.php' );
        
        add_action( 'init', array( &$this, 'init' ) );

    }
    
    function init() {
        
    }
    
}

new KrownPortfolio();

?>