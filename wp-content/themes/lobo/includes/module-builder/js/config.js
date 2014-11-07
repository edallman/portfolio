jQuery(window).load(function(){

	"use strict";

	$ = jQuery.noConflict();

/* ----------------------------------------------------
---------- !! CONFIG !! -----------------
------------------------------------------------------- */

    /* -------------------------------
    -----   General Options  -----
    ---------------------------------*/

	var generalOptions = Array(

		// Width
		{
			id: 'width',
			type: 'select',
			title: 'Module Width',
			description: '',
			std: '1',
			choices: Array(
				{
					label: '25%',
					value: '1'
				},
				{
					label: '50%',
					value: '2'
				},
				{
					label: '75%',
					value: '3'
				},
				{
					label: '100%',
					value: '4'
				}
			)
		},

		// Height
		{
			id: 'height',
			type: 'select',
			title: 'Module Height',
			description: 'The height of a module is in percentages, because it is proportionally resized after the module\'s own width',
			std: '1',
			choices: Array(
				{
					label: '25%',
					value: '1'
				},
				{
					label: '50%',
					value: '2'
				},
				{
					label: '75%',
					value: '3'
				},
				{
					label: '100%',
					value: '4'
				},
				{
					label: 'Auto',
					value: '0'
				}
			)
		}

	);

    /* -------------------------------
    -----   Module declaration  -----
    ---------------------------------*/

	var modules = Array(

		// Text Module
		{
			title: 'Text',
			type : 'text',
			options: generalOptions.concat( Array(

				// Title
				{
					id: 'title',
					type: 'text',
					title: 'Module Title',
					description: 'This is an optional field and if filled, will put a small title in the top left area of this module.',
					std: ''
				},

				// Background color
				{
					id: 'bgcolor',
					type: 'colorpicker',
					title: 'Background Color',
					description: '',
					std: '#000'
				},

				// Background image
				{
					id: 'bgimage',
					type: 'upload',
					title: 'Background Image',
					description: 'Optional. If an image is provided, it will be used instead of the background color.',
					std: ''
				},

				// Background repeat
				{
					id: 'bgrepeat',
					type: 'select',
					title: 'Background Image Repeat',
					description: 'If you\'re using a background image you can choose to make it a pattern or stick as a filling background.',
					std: 'fill',
					choices: Array(
						{
							label: 'Fill',
							value: 'fill'
						},
						{
							label: 'Repeat',
							value: 'repeat'
						}
					)
				},

				// Text color
				{
					id: 'color',
					type: 'colorpicker',
					title: 'Text Color',
					description: '',
					std: '#fff'
				},

				// Text align
				{
					id: 'customtransform',
					type: 'select',
					title: 'Text Horizontal Alignment',
					description: '',
					std: 'left',
					choices: Array(
						{
							label: 'Left',
							value: 'left'
						},
						{
							label: 'Center',
							value: 'center'
						},
						{
							label: 'Right',
							value: 'right'
						}
					)
				},

				// Text align #2
				{
					id: 'verticalalign',
					type: 'select',
					title: 'Text Vertical Alignment',
					description: '',
					std: 'middle',
					choices: Array(
						{
							label: 'Middle',
							value: 'middle'
						},
						{
							label: 'Top',
							value: 'top'
						},
						{
							label: 'Bottom',
							value: 'bottom'
						}
					)
				},

				// Content
				{
					id: 'kmbcontent',
					type: 'textarea',
					title: 'Content',
					description: 'This is rich content area. It can include shortcodes for stuff like content sliders, lists or the twitter widget. HTML is also allowed, but please try to keep it really clean, in order to make sure that nothing breaks. If you insert complex shortcodes (content, team, twitter or contact form), please insert only one shortcode and no other content!',
					std: ''
				},

				// Inner wrap
				{
					id: 'innerwrap',
					type: 'select',
					title: 'Inner wrap',
					description: 'Leave this intact for most modules. But if you\'re using a slider (content, team or twitter) or a contact form as a shortcode in this module, set this option to "Don\'t wrap". More info on the subject can found in the documentation (section 3.3) - please read it.',
					std: 'wrap',
					choices: Array(
						{
							label: 'Regular Wrap',
							value: 'wrap'
						},
						{
							label: 'Don\'t Wrap',
							value: 'no-wrap'
						},
						{
							label: 'Custom Wrap',
							value: 'custom-wrap'
						},
						{
							label: 'Auto Height',
							value: 'auto-wrap'
						}
					)
				}

			))
		},

		// Image Module
		{
			title: 'Image',
			type : 'image',
			options: generalOptions.concat( Array(

				// Image
				{
					id: 'bgimage',
					type: 'upload',
					title: 'Image',
					description: '',
					std: ''
				},

				// Caption
				{
					id: 'caption',
					type: 'text',
					title: 'Caption',
					description: 'Optional caption (will appear in the bottom right corner).',
					std: ''
				}

			))
		},

		// Slider Module
		{
			title: 'Slider',
			type : 'slider',
			options: generalOptions.concat( Array(

				// Slider
				{
					id: 'gallery',
					type: 'gallery',
					title: 'Images',
					description: '',
					std: ''
				},

				// Transition
				{
					id: 'transition',
					type: 'select',
					title: 'Transition',
					description: 'Choose transition type between images.',
					std: 'slide',
					choices: Array(
						{
							label: 'Slide',
							value: 'slide'
						},
						{
							label: 'Fade',
							value: 'fade'
						}
					)
				}

			))
		},

		// Gallery 
		{
			title: 'Gallery',
			type : 'gallery',
			options: generalOptions.concat( Array(

				// Background
				{
					id: 'bgimage',
					type: 'upload',
					title: 'Background',
					description: 'This is the image which will appear as a background for the module containing the gallery.',
					std: ''
				},

				// Slider
				{
					id: 'gallery',
					type: 'gallery',
					title: 'Images',
					description: '',
					std: ''
				},

				// Resizing
				{
					id: 'imagecrop',
					type: 'select',
					title: 'Resizing',
					description: 'Choose how the images will be resized in this gallery.',
					std: 'yes',
					choices: Array(
						{
							label: 'Fill',
							value: 'yes'
						},
						{
							label: 'Fit',
							value: 'no'
						}
					)
				},

				// Autoplay
				{
					id: 'autoplay',
					type: 'select',
					title: 'Slideshow',
					description: 'You can either disable the slideshow or set a slide interval.',
					std: 'false',
					choices: Array(
						{
							label: 'Disabled',
							value: 'no'
						},
						{
							label: '3 Seconds',
							value: '3000'
						},
						{
							label: '5 Seconds',
							value: '5000'
						},
						{
							label: '7 Seconds',
							value: '7000'
						},
						{
							label: '9 Seconds',
							value: '9000'
						}
					)
				},

				// Captions
				{
					id: 'showinfo',
					type: 'select',
					title: 'Captions',
					description: 'You can either enable or disable captions. These are defined in the Media Library, when creating your list of images.',
					std: 'false',
					choices: Array(
						{
							label: 'Disabled',
							value: 'no'
						},
						{
							label: 'Enabled',
							value: 'yes'
						}
					)
				},

				// Thumbnails
				{
					id: 'thumbnails',
					type: 'select',
					title: 'Thumbnails',
					description: 'You can choose between having thumbnails or not.',
					std: 'no',
					choices: Array(
						{
							label: 'Disabled',
							value: 'no'
						},
						{
							label: 'Enabled',
							value: 'yes'
						}
					)
				},
				
				// Transition
				{
					id: 'transition',
					type: 'select',
					title: 'Transition',
					description: 'Choose transition type between images.',
					std: 'empty',
					choices: Array(
						{
							label: 'Fade',
							value: 'fade'
						},
						{
							label: 'Flash',
							value: 'flash'
						},
						{
							label: 'Pulse',
							value: 'pulse'
						},
						{
							label: 'Slide',
							value: 'slide'
						},
						{
							label: 'Fade & Slide',
							value: 'fadeslide'
						}
					)
				}

			))
		},

		// Video 
		{
			title: 'Video',
			type : 'video',
			options: generalOptions.concat( Array(	

				// Video URL
				{
					id: 'mp4',
					type: 'text',
					title: 'Youtube / Vimeo / MP4 URL',
					description: 'Insert the link of a video hosted on YouTube or Vimeo. Or insert a link to a self hosted video (*.mp4 format).',
					std: ''
				},

				// Video Poster
				{
					id: 'poster',
					type: 'upload',
					title: 'Poster Image',
					description: 'Upload or link to a post image which will appear on top of the video (optional).',
					std: ''
				}

			))
		},

		// Audio 
		{
			title: 'Audio',
			type : 'audio',
			options: generalOptions.concat( Array(	

				// MP3 URL
				{
					id: 'mp3',
					type: 'upload',
					title: 'MP3 File',
					description: 'Upload or link to an mp3 file.',
					std: ''
				},

				// OGG URL
				{
					id: 'ogg',
					type: 'upload',
					title: 'OGG File',
					description: 'Upload or link to an ogg file (really important if you want to have cross-browser compatibility).',
					std: ''
				},

				// Poster URL
				{
					id: 'bgimage',
					type: 'upload',
					title: 'Poster',
					description: 'Upload an image which will be used as a background for this player.',
					std: ''
				}


			))
		},

		// Map 
		{
			title: 'Map',
			type : 'map',
			options: generalOptions.concat( Array(

				// Lat
				{
					id: 'lat',
					type: 'text',
					title: 'Latitude',
					description: '',
					std: ''
				},

				// Long
				{
					id: 'long',
					type: 'text',
					title: 'Longitude',
					description: 'You can use this tool to find out the proper lat/long values for your location: <a href="http://itouchmap.com/latlong.html" target="_blank">http://itouchmap.com/latlong.html</a>.',
					std: ''
				},

				// Zoom
				{
					id: 'zoom',
					type: 'text',
					title: 'Zoom',
					description: 'Insert a numeric value between 1-20',
					std: '13'
				},

				// Marker
				{
					id: 'marker',
					type: 'upload',
					title: 'Marker Image',
					description: 'Required! Upload a small image for the map\'s marker. If the image is not present, the map will not work.',
					std: ''
				}

			))
		},

		// Call to action 
		{
			title: 'Call to action',
			type : 'cta',
			options: generalOptions.concat( Array(	

				// Title
				{
					id: 'title',
					type: 'text',
					title: 'Title',
					description: '',
					std: ''
				},

				// Subtitle
				{
					id: 'subtitle',
					type: 'text',
					title: 'Subtitle',
					description: '',
					std: ''
				},

				// Link URL
				{
					id: 'linkurl',
					type: 'text',
					title: 'Link URL',
					description: '',
					std: ''
				},

				// Link Target
				{
					id: 'linktarget',
					type: 'select',
					title: 'Link Target',
					description: '',
					std: '_self',
					choices: Array(
						{
							label: 'Same window',
							value: '_self'
						},
						{
							label: 'New window',
							value: '_blank'
						}
					)
				},

				// Background color
				{
					id: 'bgcolor',
					type: 'colorpicker',
					title: 'Background Color',
					description: '',
					std: '#000'
				},

				// Background image
				{
					id: 'bgimage',
					type: 'upload',
					title: 'Background Image',
					description: 'Optional. If an image is provided, it will be used instead of the background color.',
					std: ''
				},

				// Background repeat
				{
					id: 'bgrepeat',
					type: 'select',
					title: 'Background Image Repeat',
					description: 'If you\'re using a background image you can choose to make it a pattern or stick as a filling background.',
					std: 'fill',
					choices: Array(
						{
							label: 'Fill',
							value: 'fill'
						},
						{
							label: 'Repeat',
							value: 'repeat'
						}
					)
				},

				// Text color
				{
					id: 'color',
					type: 'colorpicker',
					title: 'Text Color',
					description: '',
					std: '#fff'
				}

			))
		},

		// Grid
		{
			title: 'Latest projects / posts',
			type : 'latest',
			options: generalOptions.concat( Array(	

				// Type
				{
					id: 'diff',
					type: 'select',
					title: 'Type',
					description: 'Choose the type of the grid you want to include in this page.',
					std: 'post',
					choices: Array(
						{
							label: 'Blog posts',
							value: 'post'
						},
						{
							label: 'Portfolio projects',
							value: 'portfolio'
						}
					)
				},

				// No
				{
					id: 'no',
					type: 'text',
					title: 'Number',
					description: 'Choose the number of items in the grid.',
					std: '4'
				},

				// Columns
				{
					id: 'cols',
					type: 'select',
					title: 'Columns',
					description: 'Choose the layout of the grid.',
					std: 'posts',
					choices: Array(
						{
							label: '2 Columns',
							value: 'col-2'
						},
						{
							label: '4 Columns',
							value: 'col-1'
						}
					)
				},

				// Cats
				{
					id: 'cats',
					type: 'text',
					title: 'Categories',
					description: 'You can select only some categories to appear in the grid. To do this, simply write the categories slug, separated by commas (ex: motion,identity).',
					std: ''
				}

			))
		},

		// Separator
		{
			title: 'Separator',
			type : 'separator',
			options: generalOptions.concat( Array(	

				// Title
				{
					id: 'title',
					type: 'text',
					title: 'Title',
					description: 'Write a title for this separator (optional if you only want a visual divider).',
					std: ''
				},

				// Background color
				{
					id: 'bgcolor',
					type: 'colorpicker',
					title: 'Background Color',
					description: '',
					std: '#000'
				},

				// Text color
				{
					id: 'color',
					type: 'colorpicker',
					title: 'Text Color',
					description: '',
					std: '#fff'
				},

				// Text align
				{
					id: 'customtransform',
					type: 'select',
					title: 'Text Alignment',
					description: '',
					std: 'left',
					choices: Array(
						{
							label: 'Left',
							value: 'left'
						},
						{
							label: 'Center',
							value: 'center'
						},
						{
							label: 'Right',
							value: 'right'
						}
					)
				}

			))
		},

		// Nav 
		{
			title: 'Portfolio Navigation',
			type : 'nav',
			options: generalOptions
		}

	);

	$.kmbModules = modules;

});