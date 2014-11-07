<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>

		<div id="container">
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <meta name="viewport" content="width=device-width, initial-scale=1">
			  <title>Halcyon Days - An Exclusive Freebie for Codrops by Peter Finlan.</title>
			  <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
			  <link href="css/bootstrap.min.css" rel="stylesheet">
			  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
			  <link href="css/flexslider.css" rel="stylesheet" >
			  <link href="css/styles.css" rel="stylesheet">
			  <link href="css/queries.css" rel="stylesheet">
			  <link href="css/animate.css" rel="stylesheet">
			      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			      <!--[if lt IE 9]>
			      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			      <![endif]-->
			    </head>
			    <body id="top">
			      <header id="home">
			        <nav>
			          <div class="container-fluid">
			            <div class="row">
			              <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
			                <nav class="pull">
			                  <ul class="top-nav">
			                    <li><a href="#intro">Introduction <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                    <li><a href="#features">Features <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                    <li><a href="#responsive">Responsive Design <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                    <li><a href="#portfolio">Portfolio <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                    <li><a href="#team">Team <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                    <li><a href="#contact">Get in Touch <span class="indicator"><i class="fa fa-angle-right"></i></span></a></li>
			                  </ul>
			                </nav>
			              </div>
			            </div>
			          </div>
			        </nav>
			        <section class="hero" id="hero">
			          <div class="container">
			            <div class="row">
			              <div class="col-md-12 text-right navicon">
			                <a id="nav-toggle" class="nav_slide_button" href="#"><span></span></a>
			              </div>
			            </div>
			            <div class="row">
			              <div class="col-md-8 col-md-offset-2 text-center inner">
			                <h1 class="animated fadeInDown">HALCYON<span>DAYS</span></h1>
			                <p class="animated fadeInUp delay-05s">An exclusive HTML5/CSS3 freebie by Peter Finlan, for <em>Codrops</em></p>
			              </div>
			            </div>
			            <div class="row">
			              <div class="col-md-6 col-md-offset-3 text-center">
			                <a href="http://tympanus.net/codrops/?p=19439" class="learn-more-btn">Back to the article</a>
			              </div>
			            </div>
			          </div>
			        </section>
			      </header>
			<!-- <header class="header" role="banner">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<a href="<?php echo home_url(); ?>" rel="nofollow"><img class="navlogo" src="<?php echo get_template_directory_uri() . '/img/logo.png' ?>" alt="ED"></a>


					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>
					

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => false,                           // remove nav container
    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					'theme_location' => 'main-nav',                 // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>

					</nav>

				</div>

			</header> -->
