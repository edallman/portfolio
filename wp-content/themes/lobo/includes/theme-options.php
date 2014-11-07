<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'content'       => array( 
        array(
          'id'        => 'general_help',
          'title'     => 'General',
          'content'   => '<p>Help content goes here!</p>'
        )
      ),
      'sidebar'       => '<p>Sidebar content goes here!</p>'
    ),
    'sections'        => array( 
      array(
        'id'          => 'analytics',
        'title'       => 'Analytics'
      ),
      array(
        'id'          => 'css',
        'title'       => 'Custom CSS'
      ),

      array(
        'id'          => 'sidebars',
        'title'       => 'Widget Areas'
      ),
      array(
        'id'          => 'admin',
        'title'       => 'Admin'
      ),
      array(
        'id'          => 'updates',
        'title'       => 'Updates'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'lobo_tracking_enable',
        'label'       => 'Enable analytics',
        'desc'        => 'Please select this if you\'ll be using Google Analytics in the theme.',
        'std'         => 'disabled',
        'type'        => 'radio',
        'section'     => 'analytics',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),

      array(
        'id'          => 'lobo_sidebars_text',
        'label'       => 'About the widgets', 'lobo',
        'desc'        => 'All widgets areas that you create here will appear both in the Widgets Page (Appearance &gt; Widgets), from where you\'ll have to configure them (put widgets inside them), and in the modular pages (used within text modules as the widget area shortcode).', 'lobo',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'sidebars',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_sidebars',
        'label'       => 'Create widget area', 'lobo',
        'desc'       => 'Please choose a unique title for each area!', 'lobo',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'sidebars',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array( 
          array(
            'id'          => 'id',
            'label'       => 'ID', 'lobo',
            'desc'       => 'Please write a lowercase id (only letters), with NO SPACES!!!',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        )
      ),

      array(
        'id'          => 'lobo_tracking',
        'label'       => 'Analytics code',
        'desc'        => 'Put your Analytics code inside here. Make sure you include the entire script, not just your ID.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'analytics',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'Write any custom css here. Please don\'t change theme files, because you won\'t be able to easily update in the future.',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'css',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_custom_login_logo_uri',
        'label'       => 'Admin logo',
        'desc'        => 'Add a custom <strong>273x63</strong> image for the WordPress login page.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'admin',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_updates_about',
        'label'       => 'About',
        'desc'        => 'These two fields are required for the theme automatic updates. If you want to protect yourself against security attacks and have the latest features available as soon as they appear, you should complete this section, and you\'ll be notified about new theme updates whenever they appear on ThemeForest.',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_updates_user',
        'label'       => 'Username',
        'desc'        => 'Please insert your ThemeForest username.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'lobo_updates_api',
        'label'       => 'API Key',
        'desc'        => 'Please insert your <a target="_blank" href="http://themeforest.net/help/api">ThemeForest API key</a>.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}

?>