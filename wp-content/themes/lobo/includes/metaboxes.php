<?php

// This file contains sidebar information.

add_action( 'admin_init', 'lobo_meta_boxes' );

//global $sidebars_array;

function lobo_meta_boxes() {

/*---------------------------------
    INIT SOME USEFUL VARIABLES
    ------------------------------------*/
  
  $sidebars = ot_get_option('lobo_sidebars');
  $sidebars_array = array();
  $sidebars_k = 0;
  if(!empty($sidebars)){
      foreach($sidebars as $sidebar){
          $sidebars_array[$sidebars_k++] = array(
              'label' => $sidebar['title'],
              'value' => $sidebar['id']
          );
      }
  }

  $lobo_folio_design = array(
    'id'        => 'lobo_folio_design',
    'title' => 'Portfolio Settings',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Style',
          'id' => 'folio_style',
          'type' => 'select',
          'desc' => '',
          'std' => 'none',
          'choices' => array(
            array(
                'label' => 'Masonry grid',
                'value' => 'masonry'
                ),
            array(
                'label' => 'Simple list',
                'value' => 'full'
                )
            )
          ),
        array(
          'label' => 'Columns',
          'id' => 'folio_cols',
          'type' => 'select',
          'desc' => 'Only available for the masonry grid.',
          'std' => 'cols-2',
          'choices' => array(
            array(
                'label' => 'One',
                'value' => 'cols-1'
                ),
            array(
                'label' => 'Two',
                'value' => 'cols-2'
                ),
            array(
                'label' => 'Three',
                'value' => 'cols-3'
                ),
            array(
                'label' => 'Four',
                'value' => 'cols-4'
                )
            )
          ),

        array(
          'label' => 'Categories',
          'id' => 'folio_cats',
          'type' => 'taxonomy-checkbox',
          'taxonomy'    => 'portfolio_category',
          'desc' => 'You have the possibility to select only certain categories to appear in this portfolio page. If there is no selection, all portfolio items will appear in the grid.'
        ),

        array(
          'label' => 'Infinite loading',
          'id' => 'folio_infinite',
          'type' => 'select',
          'desc' => 'You can enable infinite loading and set a custom number of portfolio items per page below (useful for large portfolios).',
          'std' => 'no-infinite',
          'choices' => array(
            array(
                'label' => 'Disabled',
                'value' => 'no-infinite'
                ),
            array(
                'label' => 'Enabled',
                'value' => 'yes-infinite'
                )
            )
        ),

        array(
          'label' => 'Projects per page',
          'id' => 'folio_per',
          'type' => 'text',
          'std' => '10',
          'desc' => 'Available only when infinite loading is enabled, otherwise all projects will be shown.'
        )
      )
    );

  $lobo_page_subtitle = array(
    'id'        => 'lobo_page_subtitle',
    'title' => 'Custom Titles',
    'desc' => 'Each page/post with a media hero element (image/slider/video) will show a title/subtitle over the hero element. You can set them here.',
    'pages' => array( 'page', 'post' ),
    'context' => 'normal',
    'priority' => 'core',
    'fields' => array(
        array(
          'label' => 'Title',
          'id' => 'lobo_p_title',
          'type' => 'text',
          'desc' => 'If empty, the page title will be used.'
          ),
        array(
          'label' => 'Subtitle',
          'id' => 'lobo_p_subtitle',
          'type' => 'text',
          'desc' => ''
          )
      )
    );

  $lobo_folio_url = array(
    'id'        => 'lobo_folio_url',
    'title' => 'Custom Link',
    'desc' => 'If you want this project be a custom URL (in the portfolio grid), you can configure it here. Don\'t forget to add the <strong>link</strong> text in the project\'s excerpt, as explained in the manual',
    'pages' => array( 'portfolio' ),
    'context' => 'side',
    'priority' => 'core',
    'fields' => array(
        array(
          'label' => 'URL',
          'id' => 'lobo_folio_url_link',
          'type' => 'text',
          'desc' => ''
          ),
        array(
          'label' => 'Target',
          'id' => 'lobo_folio_url_target',
          'type' => 'select',
          'desc' => '',
          'choices' => array(
            array(
                'value' => '_self',
                'label' => 'Same tab'
                ),
            array(
                'value' => '_blank',
                'label' => 'New tab'
                )
            )
          )
      )
    );

  $krown_hero_options = array(
    'id'        => 'krown_hero_options',
    'title' => 'Hero Header',
    'desc' => 'The "hero element" is the awesome header at the top of each page. You can of course leave it empty, but you should take full advantage of this area in order to present your content in the best possible way.',
    'pages' => array( 'page', 'post', 'portfolio', 'product' ),
    'context' => 'normal',
    'priority' => 'core',
    'fields' => array(

        array(
          'label' => 'Choose hero element',
          'id' => 'krown_page_hero',
          'type' => 'select',
          'desc' => 'Select the type of the hero element. It will be configured below.',
          'std' => 'none',
          'choices' => array(
            array(
                'value' => 'none',
                'label' => 'None'
                ),
            array(
                'value' => 'image',
                'label' => 'Image'
                ),
            array(
                'value' => 'slider',
                'label' => 'Slider'
                ),
            array(
                'value' => 'video',
                'label' => 'Video'
                ),
            array(
                'value' => 'text',
                'label' => 'Text'
                )
            )
          ),

        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Image / slider settings</span>',
            'desc'        => 'The options below refer to when you\'re using an image or a video hero.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),

        array(
          'label' => 'Image hero',
          'id' => 'krown_hero_img',
          'type' => 'upload',
          'std' => '',
          'desc' => 'Upload a large image in case you\'ll go with a single image. This asset will be resized to fill the entire screen (though only a certain part will be entirely seen), so make sure that you add a large image.<br><br>An image should also be choose when you are using a video hero, to stand as a fallback.',
          ),


        array(
            'id'          => 'krown_hero_slider',
            'label'       => 'Slider hero',
            'desc'        => 'Use the following fields to configure the slider if this is used. Notice that each image has a title & subtitle option. On sliders, these will be used instead of the main title & subtitle of the page. So make sure that you fill them, even if you write the same thing in all.',
            'std'         => '',
            'type'        => 'list-item',
            'class'       => '',
            'settings'    => array(
              array(
                'label' => 'Subtitle',
                'id' => 'subtitle',
                'type' => 'text',
                'std' => '',
                'desc' => '',
                ),
                array(
                    'label'       => 'Image',
                    'id'          => 'image',
                    'type'        => 'upload',
                    'desc'        => 'The same rules from the single image apply here.',
                    'std'         => '',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'class'       => ''
                ),
              array(
                'label' => 'URL',
                'id' => 'url',
                'type' => 'text',
                'std' => '',
                'desc' => 'If not empty, this slide will link to the provided url.'
            	),
             )
            ),

        array(
          'label' => 'Slider autoplay',
          'id' => 'krown_hero_slider_autoplay',
          'type' => 'select',
          'std' => 'disable-autoplay',
          'desc' => 'If you are using the slider hero element, you can disable or enable autoplay here.',
          'choices' => array(
            array(
                'value' => 'disable-autoplay',
                'label' => 'Disabled'
                ),
            array(
                'value' => 'enable-autoplay',
                'label' => 'Enabled'
                )
            )
          ),

        array(
          'label' => 'Slider speed',
          'id' => 'krown_hero_slider_speed',
          'type' => 'select',
          'std' => '3000',
          'desc' => 'If you enable autoplay above, you can configure the speed of the slider right here.',
          'choices' => array(
            array(
                'value' => '3000',
                'label' => '3s'
                ),
            array(
                'value' => '4000',
                'label' => '4s'
                ),
            array(
                'value' => '5000',
                'label' => '5s'
                ),
            array(
                'value' => '6000',
                'label' => '6s'
                ),
            array(
                'value' => '7000',
                'label' => '7s'
                ),
            array(
                'value' => '8000',
                'label' => '8s'
                ),
            array(
                'value' => '9000',
                'label' => '9s'
                )
            )
          ),

        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Video settings</span>',
            'desc'        => 'The options below refer to when you\'re using a video element, which has a lot of options as you can see below.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),

        array(
          'label' => 'Video hero',
          'id' => 'krown_hero_video',
          'type' => 'text',
          'std' => '',
          'desc' => 'If a video is used, write the full YouTube or Vimeo URL in here. You can also write the path to an *.mp4 file (for self hosted videos). Only videos from these sources are supported. ',
          ),

        array(
          'label' => 'Show player controls',
          'id' => 'krown_hero_show_controls',
          'type' => 'select',
          'std' => 'true',
          'desc' => '',
          'choices' => array(
            array(
                'value' => 'false',
                'label' => 'Disabled'
                ),
            array(
                'value' => 'true',
                'label' => 'Enabled'
                )
            )
          ),

        array(
          'label' => 'Autoplay',
          'id' => 'krown_hero_show_autoplay',
          'type' => 'select',
          'std' => 'true',
          'desc' => '',
          'choices' => array(
            array(
                'value' => 'false',
                'label' => 'Disabled'
                ),
            array(
                'value' => 'true',
                'label' => 'Enabled'
                )
            )
          ),

        array(
          'label' => 'Loop',
          'id' => 'krown_hero_show_loop',
          'type' => 'select',
          'std' => 'true',
          'desc' => '',
          'choices' => array(
            array(
                'value' => 'false',
                'label' => 'Disabled'
                ),
            array(
                'value' => 'true',
                'label' => 'Enabled'
                )
            )
          ),

        array(
          'label' => 'Start mutted',
          'id' => 'krown_hero_show_mute',
          'type' => 'select',
          'std' => 'true',
          'desc' => '',
          'choices' => array(
            array(
                'value' => 'false',
                'label' => 'Disabled'
                ),
            array(
                'value' => 'true',
                'label' => 'Enabled'
                )
            )
          ),

        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Text settings</span>',
            'desc'        => 'The options below refer to when you\'re using a text hero element.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),

        array(
          'label' => 'Text hero',
          'id' => 'krown_hero_text',
          'type' => 'textarea-simple',
          'std' => '',
          'desc' => 'HTML code & shortcodes are allowed in here.',
          ),

        array(
          'label' => 'Hero background image',
          'id' => 'krown_hero_text_img',
          'type' => 'upload',
          'std' => '',
          'desc' => 'Choose an image for the hero\'s background (it will overwrite the color set below).',
          ),

        array(
          'label' => 'Hero background color',
          'id' => 'krown_hero_text_bg',
          'type' => 'colorpicker',
          'std' => '#ffffff',
          'desc' => 'Choose a color for the hero\'s background.',
          ),

        array(
          'label' => 'Hero text color',
          'id' => 'krown_hero_text_tg',
          'type' => 'colorpicker',
          'std' => '#000000',
          'desc' => 'Choose a color for the hero\'s text.',
          ),

        array(
          'label' => 'Hero text horizontal alignment',
          'id' => 'krown_hero_text_a',
          'type' => 'select',
          'std' => 'left',
          'desc' => 'Set the text\'s horizontal alignment.',
          'choices' => array(
            array(
                'value' => 'left',
                'label' => 'Left'
                ),
            array(
                'value' => 'center',
                'label' => 'Center'
                ),
            array(
                'value' => 'right',
                'label' => 'Right'
                )
            )
          ),

        array(
          'label' => 'Hero text vertical alignment',
          'id' => 'krown_hero_text_av',
          'type' => 'select',
          'std' => 'middle',
          'desc' => 'Set the text\'s vertical alignment.',
          'choices' => array(
            array(
                'value' => 'top',
                'label' => 'Top'
                ),
            array(
                'value' => 'middle',
                'label' => 'Middle'
                ),
            array(
                'value' => 'bottom',
                'label' => 'Bottom'
                )
            )
          ),

        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Height settings</span>',
            'desc'        => 'The hero elements are usually set at auto (they calculate their own correct height, based on the inner element\'s aspect ratio. You can overwrite this behavior with the options below.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),

        array(
          'label' => '',
          'id' => 'krown_hero_height_type',
          'type' => 'select',
          'std' => 'auto',
          'desc' => 'Choose the height calculation method. "Auto" is the default method, "fixed" allows you to set a fixed height in px for any screen size, and "percent" refers to a certain percentage based on the window\'s total height.',
          'choices' => array(
            array(
                'value' => 'auto',
                'label' => 'Auto'
                ),
            array(
                'value' => 'fixed',
                'label' => 'Fixed'
                ),
            array(
                'value' => 'percent',
                'label' => 'Percent'
                )
            )
          ),

        array(
          'label' => '',
          'id' => 'krown_hero_height_value',
          'type' => 'text',
          'std' => '',
          'desc' => 'Write the value that you want here (number). If you choose a "fixed" height, it will refer to pixels, while if you choose a "percent" height, it will refer to a percentage.'
          ),

        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Logo detection</span>',
            'desc'        => 'Another complex setting, it is useful to force a certain logo/menu display when the detection doesn\'t work as you wish or when you\'re using a text/video hero, which don\'t work with auto background detection',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),

        array(
          'label' => '',
          'id' => 'krown_hero_detect',
          'type' => 'select',
          'std' => 'auto',
          'desc' => 'The setting refers to which type of logo/navigation will appear.',
          'choices' => array(
            array(
                'value' => 'auto',
                'label' => 'Auto'
                ),
            array(
                'value' => 'light',
                'label' => 'Light'
                ),
            array(
                'value' => 'dark',
                'label' => 'Dark'
                )
            )
          )

      )
    );


  ////////////////////


    /*---------------------------------
        INIT METABOXES
        ------------------------------------*/

        $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
        $template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

        if ( $template_file == 'template-portfolio.php' ) {
          ot_register_meta_box($lobo_folio_design);
        }

      ot_register_meta_box( $lobo_page_subtitle );
      ot_register_meta_box( $krown_hero_options );
      ot_register_meta_box( $lobo_folio_url );


}

?>