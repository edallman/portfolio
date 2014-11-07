jQuery(document).ready(function(){

	var $ = jQuery.noConflict();

    // Global cached variables

    var $body = $('body'),

    $header = $('#header'),

	$heroWrapper = $('#hero-wrapper'),
	$mainWrapper = $('#main-wrapper'),

	$targetTop = $(".target-top"),
	$targetBottom = $(".target-bottom"),

	$navWrapper = $('#nav-wrapper'),
	$mainCartHolder = $('#main-cart-holder'),

	$infinite = null,
    $infiniteLink = null,
    $infiniteContainer = null

    $r960 = null,
    $r480 = null;

	// Create galleria object

	$body.append('<div id="galleria"></div>');
	var $galleria = $('#galleria');

	// Hero header height

	var hType = $heroWrapper.data('height-type'),
		hVal = $heroWrapper.data('height-value');

	if ( hType == 'fixed' || hType == 'percent' ) {
		$body.addClass('no-resize-heros');
	} else {
	    $body.addClass('resize-heros');
	}

    // I apologize for browser sniffing, but there is no other way :(

    if ( navigator.userAgent.toUpperCase().indexOf('TRIDENT') > 0 ) {
        $('html').addClass('ie');
    }

/*
  Collect main functions w/nmspcs
----------------------------------- */
  window.mainScripts = function () {
    "use strict";

    var navH = 80; //size for sticky head behaviors
    window.compactMenu = $body.hasClass("compact-menu"); //check if compact menu enabled

      window.Core = {

          ui : {
            setClassicMenu : function(){

            	// Improved the menu to work well when no menu items are selected

            	var $selected = $('.selected'),
            		$current = $('.current'),
            		$selector = $('.selector'),
            		$currentSelector = $('.current-selector'),
            		$menuItems = $('nav ul li');

            	if ( $selected.length > 0 ) {
					var currentleft = $selected.position().left+"px",
						currentwidth = $selected.css('width');
					$selected.addClass('active');
            	}

            	if ( $current.length > 0 ) {
					var currentleft = $current.position().left+"px",
						currentwidth = $current.css('width');
					$current.addClass('active');
            	}

            	if ( currentwidth && currentleft ) {
					$selector.css( {"left": currentleft, "width": currentwidth} );
					$currentSelector.css( {"left": currentleft, "width": currentwidth} );
				}

				$menuItems.mouseenter(function(){

					$menuItems.removeClass('active');
					$(this).addClass('active');

					currentleft = $(this).position().left+"px";
					currentwidth = $(this).css('width');
					$selector.css({"left":currentleft,"width":currentwidth});

				});

				$menuItems.mouseout(function(){

					$menuItems.removeClass('active');

					if ( $selected.length > 0 ) {
						$selected.addClass('active');
						currentleft=$selected.position().left;
						currentwidth=$selected.css('width');
						$selector.css({"left":currentleft,"width":currentwidth});
					}

				});

				//set superfish
				var menuH = $(".main-d-nav").height(),
					menuPad = $(".main-d-nav").css("padding-top");

				$('.no-cmpt .main-d-nav ul.sf-menu').superfish({
					delay:       555,                          
					animation:   {opacity:'show',top:menuH+parseInt(menuPad)},
					animationOut:  {opacity:'hide',top:menuH},
					speed:       250,
					speedOut:    150,                       
					autoArrows:  false                          
				});

				$(".main-d-nav").hoverIntent({
					over: checkMenuBack,
					timeout: 555,
					out: checkMenuBack
				});

				$('.compact-menu .main-d-nav li.has-subs').hoverIntent(function(){
					$(this).find('.sub-menu').stop().slideDown(250, "easeInQuad");
				}, function(){
					$(this).find('.sub-menu').stop().slideUp(250, "easeInQuad");
				});

				//add class on hover nav function to highlight the menu
				function checkMenuBack(){
					if( $(".has-subs").hasClass("active") ){
						$navWrapper.toggleClass("enabled");
						$mainCartHolder.toggleClass("enabled");
					}else{
						$navWrapper.toggleClass("enabled");
						$mainCartHolder.toggleClass("enabled");
					}
				}
            },
			setCompactMenu : function(){
				if( $body.hasClass("compact-menu") && !$(".actions").find(".menu-firer").length ){
					//add the menu to the sticky head actions too
					$(".menu-firer").clone().appendTo( ".actions" ).addClass("action");
					$('<span class="c-close-btn"><span class="hr"></span><span class="vr"></span></span>').appendTo($(".main-d-nav"));
					var stateCM = false;
					$(".menu-firer").click(function(e){
						if(!stateCM){
							$('#main-wrapper, #hero-wrapper').addClass('menu-open');
							$('body').addClass('compact-menu-open');
							setTimeout(function(){
								$('.main-d-nav').addClass('zifix');
							}, 333);
							//in case of no-sticky (sticky bottom menu), the menu hides
							$(".actions-bottom .sticky-head-elmnts").removeClass("hello");
							$mainCartHolder.removeClass('stick-it');
							//add a layer control over the main-wrapper to help to close on click over
							//and prevent playing with the content
							$('<span class="c-menu-open-overlay"></span>').appendTo($mainWrapper);
							$(".c-menu-open-overlay").click(function(){
								$(".c-close-btn").trigger('click');
							});
						} else {
							$('#main-wrapper, #hero-wrapper').removeClass('menu-open');
							$('body').removeClass('compact-menu-open');
							$('.main-d-nav').removeClass('zifix');
							//remove the control layer
							$('<span class="c-menu-open-overlay"></span>').remove();
							$(".actions-bottom .sticky-head-elmnts").addClass("hello");
						}
						stateCM = !stateCM;
						e.preventDefault();
					});

					$(".c-close-btn").click(function(){
						$('#main-wrapper, #hero-wrapper, .menu-firer').toggleClass('menu-open');
						$('body').toggleClass('compact-menu-open');
						
							$('.main-d-nav').removeClass('zifix');

						//in case of the menu firer is the main in top, not to show the bottom options in case of enabled
						var pos = $(window).scrollTop();
						if( $body.hasClass("actions-bottom") && pos > 100) {
							$(".actions-bottom .sticky-head-elmnts").addClass("hello");
						}
						stateCM = !stateCM;
					});

					var menu = $(".main-d-nav"),
						logo = $(".logo");
					$(menu).appendTo($( "body" ));
					$(logo).clone().appendTo(".menu-logo");

					//social options based on the selected in the footer
					var socialOps = $(".footer .social-area");
					$(socialOps).clone().appendTo(".main-d-nav");
				}
            },
            checkCompactMenu : function(){
				if( !compactMenu && $(window).width() < 961 ) {
					$body.addClass("compact-menu");
					Core.ui.setCompactMenu();
				}else if( !compactMenu && $(window).width() > 960 ){
					$body.removeClass("compact-menu");
					$(".main-d-nav .menu-footer, .main-d-nav .close-btn, .main-d-nav .social-area").remove();
					$(".main-d-nav").appendTo("#nav-wrapper");
					$(".actions").find(".menu-firer").remove();
				}
            },
            checkStickyMenu : function(){

				var posWas;
 
				$(window).bind('scroll', function(){
					//this is for woocommerce
					//only available when compact menu disabled
					if( !$body.hasClass("compact-menu")){
						var pos = $(window).scrollTop();
						var heroSpacerH = $(".hero-spacer").outerHeight();
						
						if(pos > posWas){ //if the user is scrolling down...
							$header.removeClass("scrll-up");
							$header.addClass("scrll-dwn");
						}
						if(pos > posWas && pos > heroSpacerH ){
							$header.addClass("hide-menu");
						}else if( pos < posWas && pos < heroSpacerH  ){
							$header.removeClass("hide-menu");
						}
						if(pos < posWas && pos < (heroSpacerH + 50) ){
							$header.addClass("hide-menu");
						}
						if(pos < posWas && pos < (heroSpacerH - 125) ){
							$header.removeClass("hide-menu");
						}
						if(pos < (posWas - 30) && pos >= heroSpacerH ){ //if the user is scrolling up...
							$header.removeClass("scrll-dwn");
							$header.removeClass("hide-menu");
							$header.addClass("scrll-up sticky");
							$navWrapper.addClass("enabled");
							$mainCartHolder.addClass("enabled");
						}else if( pos < posWas && pos < heroSpacerH ){
							$header.removeClass("sticky");
							$navWrapper.removeClass("enabled");
							$mainCartHolder.removeClass("enabled");
						}
						posWas = pos;
					}
				});
            },
            setHeroArea : function(){

            	if ( hType == 'fixed' || hType == 'percent' ) {

            		var realH = 0;

            		if ( hType == 'fixed' ) {
            			realH = hVal;
            		} else if ( hType == 'percent' ) {
            			realH = $(window).height() * hVal / 100;
            		}

	            	window.checkMenu = true;
					var heroItem = $(".hero-item"),
						heroSpacer = $(".hero-spacer"),
						heroInfo = $(".hero-info");

					if( heroItem.hasClass("hero-image") ){

						heroSpacer.css("height", realH);
						heroInfo.css("top", realH-100);
						Core.ui.resizeElement(heroItem.children('img'), realH);

					} else if( heroItem.hasClass("hero-video") ){

						if( $heroWrapper.find("#ytVideo-hero").length > 0 ){

							$("#ytVideo-hero").height(realH);
							heroSpacer.css("height", realH);
							heroInfo.css("top", realH-100);

						} else if( $heroWrapper.find(".mejs-video").length > 0 ){
									
							heroItem.height(realH);
							heroSpacer.css("height", realH);
							heroInfo.css("top", realH-100);

						} else if( $heroWrapper.find("#vmVideo").length > 0 ){

							$("#vmVideo").height(realH);
							heroSpacer.css("height", realH);
							heroInfo.css("top", realH-100);

						}
					} else if( $heroWrapper.find(".hero-slider").length > 0 ){
						$(".hero-spacer, .hero-spacer .rsOverflow, .hero-slider").css("height", realH);
					} else if( $heroWrapper.find(".hero-intro").length > 0 ){
						$heroWrapper.find('.text-module').height(realH);
						heroSpacer.css("height", realH);
						$body.addClass("hero-text-intro");
					}

            	} else {

	            	window.checkMenu = true;
					var hArea = $(".hero-item").height(),
						heroItem = $(".hero-item"),
						heroSpacer = $(".hero-spacer"),
						heroInfo = $(".hero-info");

					if( heroItem.hasClass("hero-image") ){
						heroSpacer.css("height", hArea);
						heroInfo.css("top", hArea-100);

					} else if( heroItem.hasClass("hero-video") ){

						if( $heroWrapper.find("#ytVideo-hero").length > 0 ){

							var hArea = $("#ytVideo-hero").attr("data-height"),
								videoW = $("#ytVideo-hero").width(),
								ratVH = Math.round( (hArea/1920 * videoW) + 25);
								
							$("#ytVideo-hero").height(ratVH);
							heroSpacer.css("height", ratVH);
							heroInfo.css("top", ratVH-100);
							
						} else if( $heroWrapper.find(".mejs-video").length > 0 ){

							$heroWrapper.find('.mejs-video').css({
								'width': '100%',
								'height': $(window).width()/$heroWrapper.find('#mejsp-hero').data('ratio')
							});

							var hArea = $heroWrapper.find('.mejs-video').height();

							heroSpacer.css("height", hArea);
							heroInfo.css("top", hArea-100);

						}
						//From Vimeo
						else if( $heroWrapper.find("#vmVideo").length > 0 ){
							var hArea = $("#vmVideo").attr("data-height"),
								videoW = $("#vmVideo").width(),
								ratVH = Math.round( (hArea/1920 * videoW) + 25);
							$("#vmVideo").height(ratVH);
							heroSpacer.css("height", ratVH-152);
							heroInfo.css("top", ratVH-245);
						}
					}
					//Check if hero is a slider
					if( $heroWrapper.find(".hero-slider").length > 0 ){
						var hArea = $(".rsImg").height();
						$(".hero-spacer, .rsOverflow, .hero-slider").css("height", hArea-10);
					}
					//Check if hero is a text intro instead media > (image, slideshow or video)
					if( $heroWrapper.find(".hero-intro").length > 0 ){
						var hArea = $(".hero-intro").find(".module").outerHeight();
						heroSpacer.css("height", hArea);
						$body.addClass("hero-text-intro");
					}

				}

				//If no any hero element is set it
				if( $heroWrapper.length <= 0 ){ $body.addClass("no-hero"); }

            },
            resizeElement : function($img, h){

            	// This function resizes a given element over a certain height. It also centeres the element...

            	var maxHeight = h,
            		maxWidth = $(window).width(),
		            oldHeight = $img.height(),
		            oldWidth = $img.width(),
		            ratio = Math.max(oldWidth / oldHeight, oldHeight / oldWidth),
		            newHeight = 0,
		            newWidth = 0;

	            // Complex calculations to get the perfect size

	            if(oldWidth > oldHeight){

			        if ( maxHeight * ratio < maxWidth ) {
			        	newWidth = maxWidth;
			        	newHeight = maxWidth / ratio;
			        } else {
			        	newHeight = maxHeight;
			        	newWidth = maxHeight * ratio;
			        }

			    } else {

			        if ( maxHeight / ratio < maxWidth ) {
			        	newWidth = maxWidth;
			        	newHeight = maxWidth * ratio;
			        } else {
			        	newHeight = maxHeight;
			        	newWidth = maxHeight / ratio;
			        }

			    }

	            // Apply the correct size and reposition

	            $img.css({
	                'width': Math.ceil(newWidth),
	                'height': Math.ceil(newHeight),
	                'top': Math.round((h-newHeight)/2),
	                'left': Math.round(($(window).width()-newWidth)/2)
	            });

            },
            setStickyHero : function(){
				
				var posWas,
					shdwH = $(".hero-info-shdw").height();
 
				$(window).bind('scroll', function(){
					var pos = $(window).scrollTop(),
						heroSpacerH = $(".hero-spacer").outerHeight(); //@todo restar el alto que quede con el sticky para titles;
					
					if( pos >= heroSpacerH - navH ){
						
						if( !$body.hasClass("parallax") ){
							$heroWrapper.addClass("sticky").css("height", navH );
							Core.ui.setStickyHeroHead();
						}else{
							$heroWrapper.addClass("sticky").css("height", navH-1);
							Core.ui.setStickyHeroHead();
						}
						//In case of minimal nav head enabled
						if( $body.hasClass("minimal-nav-head") ){
							$heroWrapper.removeClass("sticky").css("height", navH );
							Core.ui.setStickyHeroHead();
						}
						//Used to check if menu compact mode is in sticky area
						//In this way the menu covers all the available space
						if( $body.hasClass("no-sticky-head") && $body.hasClass("compact-menu") ){ 
							$(".main-c-nav").addClass("full-menu-area");
						}
					}
					if( pos <= heroSpacerH - navH ){
						$heroWrapper.removeClass("sticky");
						$heroWrapper.height(window.heroWrapperH);
						$(".hero-info-shdw").css("height", shdwH).removeClass("sticky");
						$(".hero-sticky-title").removeClass("hello");
						$(".sticky-head-elmnts").removeClass("hello");
						$(".actions").removeClass("hello");
						$mainCartHolder.removeClass('stick-it');
						//$('.form-module').removeClass('stick-it');
						if( $body.hasClass("parallax") ){
							Core.ui.setParallax();
						}
						if( $body.hasClass("no-sticky-head") && $body.hasClass("compact-menu") ){ 
							$(".main-c-nav").removeClass("full-menu-area");
						}
						//removing elements in case they could be opened
						$('.overlay, .cats').fadeOut(333);
						$(".hey").removeClass("hey");
						wdgtStatus = false;
					}
					posWas = pos;
				});
            },
            setStickyHeroHead : function(){

				$(".hero-info-shdw").css("height", navH).addClass("sticky");
				if( $body.hasClass("no-sticky-head") ){ $(".hero-info-shdw").addClass("hidden"); }

				if( $(".hero-info-shdw").hasClass("sticky") ){
					$mainCartHolder.addClass('stick-it');
					//$('.form-module').addClass('stick-it');
					$(".hero-sticky-title").addClass("hello");
					$(".actions").addClass("hello");
					if( $body.hasClass("actions-bottom") ){
						$(".sticky-head-elmnts").appendTo("body").addClass("hello"); //when no sticky head
					}

				}

				if($body.width()<=480){
					$body.addClass('enabled-sticky-shadow');
				}
				

            },
            setParallax : function(){
				$(window).scroll(function() {
					window.scrollPos = $(window).scrollTop();
					$('.hero-item').css('transform', 'translate3d(0px,'+(-scrollPos/window.parRatio)+"px"+',0px)');
					if( $body.hasClass("hero-text-intro") ){
						var txtHeroIntro = $("#hero-wrapper .text-module .copy div div");
						txtHeroIntro.css('transform', 'translate3d(0px,'+(-scrollPos/window.parRatio)+"px"+',0px)')
									.css('opacity',1-((scrollPos/4)/window.parRatio/25));
					}
				});

				if($body.hasClass("ios")){
					$(document).bind('touchmove', function(e) {
						window.scrollPos = $(window).scrollTop();
						$('.hero-item').css('transform', 'translate3d(0px,'+(-scrollPos/window.parRatio)+"px"+',0px)');
						if( $body.hasClass("hero-text-intro") ){
							var txtHeroIntro = $("#hero-wrapper .text-module .copy div div");
							txtHeroIntro.css('transform', 'translate3d(0px,'+(-scrollPos/window.parRatio)+"px"+',0px)')
										.css('opacity',1-(scrollPos/window.parRatio/5));
						}
					});
				}
            },
            placeStickyShdw : function(){
				$(".hero-sticky-shdw").css("height", navH-1);
            },
            showCloseOverlayBtn : function(){
				$('.overlay').mousemove(function(e){
                    $('.close-btn').css('left', e.clientX - 20).css('top', e.clientY);
                });
            },
            showHoverOverlay : function(){
				$('.actions').hover(function(){
					$('.temp-overlay').stop(false, true).fadeIn(150);
				}, function(){
					$('.temp-overlay').stop(false, true).fadeOut(150);
				});
            },
            placeNoStickyHeadActions : function(){
				var stickyTitleSection = $(".hero-sticky-title");
				var actions = $(".actions");
				$(".main-d-nav").append(stickyTitleSection);
				$(".main-d-nav ul").append('<li class="actions-nav"></li>');
				$(".actions-nav").append(actions);
				$("html").trigger("resize");
            },
            showCats : function(){

				$('.action-filters').click(function(){
					$('.overlay').stop(false, true).fadeIn(150);
					$('.cats').stop(false, true).fadeIn(300).addClass("hey");
				 	$('.blog-actions').stop(false, true).fadeIn(300).addClass("hey"); 
					$(".share-wdgt").removeClass("hey");
					$('.actions-titles span').stop(false, true).fadeOut(150);
					return false;
				});

				$(".action-filters a").click(function(){
                  var yWin = $(window).scrollTop(),
                      marginToScroll = $mainWrapper.offset().top,
                      contentMarginTop =  $(".hero-spacer").height(),
                      toScroll = yWin - contentMarginTop;

                    $header.removeClass("scrll-up");
					$header.fadeOut(10);
					$header.delay(2500).fadeIn(350);

                  $("html, body").animate({
                    scrollTop: yWin - (toScroll + navH-3)
                  }, 750);
                });

                if( $('#remove-filters').length > 0 ) {
                	$('.action.action-filters.pf').remove();
                }

            },
            showShrWdgt : function(){
				window.wdgtStatus = false;
				$('.action-share').click(function(e){
					if(!wdgtStatus){
						$('.overlay').stop(false, true).fadeIn(150);
						$('.cats, .blog-actions').stop(false, true).removeClass("hey").fadeOut(150);
						$('.share-wdgt').addClass("hey");
					}else{
						$('.overlay, .cats, .blog-actions').stop(false, true).fadeOut(250);
						$(".hey").removeClass("hey");
					}
					wdgtStatus = !wdgtStatus;
					e.preventDefault();
				});
            },
            setShareWdgtOptions : function(){
            	var wdgtW = $(".share-btns").width(),
            		listN = $(".share-btns li").length,
            		listSize = wdgtW/listN;
            	$(".share-btns li").css("width", listSize);
            },
            closeOverlay : function(){
				$('.overlay').click(function(e){
					$('.overlay, .cats, .blog-actions').stop(false, true).fadeOut(250);
					$(".hey").removeClass("hey");
					wdgtStatus = false;
					e.preventDefault();
				});
            },
            pageScroller : function() {
				$(".action-scroll-top a").click(function(e){
					$header.removeClass("scrll-up");
					$header.fadeOut(10);
					$("body,html").animate({ scrollTop :0 }, 2500, 'easeInOutQuint');
					$header.delay(2000).fadeIn(350);
					e.preventDefault();
				});
            },
            setFullscreen: function(){
				var doc = window.document;
				var docEl = doc.documentElement;
				var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
				var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;
				if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) { requestFullScreen.call(docEl); }
				else { cancelFullScreen.call(doc); }
            },
            setHeaderSlider : function(){

            	var $firstImg = $('.hero-module .rsContent:first-child img'),
            		initW = 1920,
            		initH = 1080;

            	if ($firstImg.data('init-width') != '' && $firstImg.data('init-height') != '') {
            		initW = $firstImg.data('init-width');
            		initH = $firstImg.data('init-height');
            	} else if ( $firstImg[0].naturalWidth > 0 ) {
            		initW = firstImg[0].naturalWidth;
            		initH = firstImg[0].naturalHeight;
            	}

        		$(".hero-module .royalSlider").royalSlider({
					keyboardNavEnabled: true,
					autoScaleSlider: $body.hasClass('resize-heros') ? true : false,
					controlNavigation: 'none',
					slidesSpacing: 0,
					minSlideOffset: 0,
					imageScaleMode: 'fill',
					loopRewind: $body.hasClass('sldr-loop') ? true : false,
					transitionType: $body.hasClass('sldr-fade') ? 'fade' : 'move',
					autoScaleSliderWidth: initW,     
					autoScaleSliderHeight: initH,
				    autoPlay: {
				        enabled: $('.hero-module .royalSlider').hasClass('enable-autoplay') ? true : false,
				        pauseOnHover: true,
				        delay: parseInt($('.hero-module .royalSlider').data('speed')) > 0 ? $('.hero-module .royalSlider').data('speed') : 3000
				    }

				});
				window.slider = $(".hero-module .royalSlider").data('royalSlider');
				slider.ev.on('rsAfterSlideChange', function(event) {
					//refreshing the background checker in order to set the elements color
					setTimeout(function(){
						BackgroundCheck.set('images', slider.slides[slider.currSlideId].content[0].childNodes[0]);
						Core.ui.setElmColor();
					}, 100);
				});
            },
            setModuleSlider : function(wdth, hgt){
				//check if slider has class visibleNearby. If not, "normal" slider
				var $slider = $(".slider-"+sldrIndx);

				if ( $slider.hasClass("visibleNearby") ) {
					$slider.royalSlider({
						keyboardNavEnabled: false,
						autoScaleSlider: true,
						controlNavigation: 'bullets',
						arrowsNav: false,
						slidesSpacing: 0,
						minSlideOffset: 0,
						imageScaleMode: 'fill',
						visibleNearby: {
							enabled: true,
							centerArea: 0.5,
							center: true,
							breakpoint: 650,
							breakpointCenterArea: 0.64,
							navigateByCenterClick: true
						},
						autoScaleSliderWidth: wdth,     
						autoScaleSliderHeight: hgt
					});
				} else if ( $slider.hasClass('tabs') ) {
					$slider.royalSlider({
						keyboardNavEnabled: false,
						autoScaleSlider: true,
						controlNavigation: 'tabs',
						arrowsNav: false,
						slidesSpacing: 0,
						sliderDrag: false,
						sliderTouch: false,
						minSlideOffset: 0,
						imageScaleMode: 'fill',
						navigateByClick: false,
						autoScaleSliderWidth: wdth,     
						autoScaleSliderHeight: hgt
					});
				} else {
					if($body.hasClass('single-product')){
						wdth = hgt = 960;
					}
					$slider.royalSlider({
						keyboardNavEnabled: false,
						autoScaleSlider: true,
						controlNavigation: 'bullets',
						arrowsNav: false,
						slidesSpacing: 0,
						minSlideOffset: 0,
						imageScaleMode: 'fill',
						transitionType: $slider.hasClass('will-fade') ? 'fade' : 'move',
						autoScaleSliderWidth: wdth,     
						autoScaleSliderHeight: hgt
					});
					if($body.hasClass('single-product')){
						$('.images').children('.thumbnails').appendTo($slider.parent());
					}
				}
            },
            backgroundCheck : function(){

            	if ( $body.hasClass('force-detect-light') ) {
            		
            		// Manual "detection" - light

            		$targetTop.addClass('background--dark');
            		$targetBottom.addClass('background--dark');

            	} else if ( $body.hasClass('force-detect-dark') ) {

            		// Manual "detection" - dark

            		$targetTop.addClass('background--light');
            		$targetBottom.addClass('background--light');

            	} else {

            		// Automatic detection

	            	if( $heroWrapper.find(".royalSlider").length > 0 ){
	            		BackgroundCheck.init({
							targets: '.target',
							images: slider.slides[slider.currSlideId].content[0].childNodes[0],
							minComplexity: 80,
							maxDuration: 1250,
							threshold: 50,
							minOverlap: 10
						});
	            	}else{
	            		BackgroundCheck.init({
							targets: '.target',
							images: '.hero-item img',
							minComplexity: 80,
							maxDuration: 1250,
							threshold: 50,
							minOverlap: 10
						});
	            	}

				}

				Core.ui.setElmColor();

            },
            //this function sets the color for elements based on backgroundCheck()
            setElmColor : function(){
				if( $targetTop.hasClass("background--light") ){
					$mainWrapper.addClass("top-light").removeClass("top-dark");
				}else if( $targetTop.hasClass("background--dark") ){
					$mainWrapper.addClass("top-dark").removeClass("top-light");
				}

				if( $targetBottom.hasClass("background--light") ){
					$mainWrapper.addClass("bottom-light").removeClass("bottom-dark");
				}else if( $targetBottom.hasClass("background--dark") ){
					$mainWrapper.addClass("bottom-dark").removeClass("bottom-light");
				}
            },
            setIsotopeLayout : function(){
              // Isotope layout
              var $container = $('.portfolio');

              var colClass = $('.portfolio').attr('data-cols'),
                  colSplit = colClass.split("cols-"),
                  columnsNumber = colSplit[1];


              var columns = 3,
                  iniCols = columnsNumber;
              window.setColumns = function() {
                  var winWidth = $(document).width();
                  if(winWidth > 800){
                      columns = iniCols;
                  }
                  else if(winWidth > 420){
                      columns = 2;
                  }
                  else{
                      columns = 1;
                  }

                  var theWidth = 100/columns - 0.5;

                  $('.prtfl-item').css('width', getWidth);
                  function getWidth(){
                      return theWidth +'%';
                  }
              };
              setColumns();
              
              //just removing this function
              //you can disable the isotope behaviors
              $(window).on('debouncedresize', function(){
                setColumns();
                $container.isotope({
                  itemSelector : '.prtfl-item',
                  resizable: false,
                  masonry: { columnWidth: $container.width() / columns}
                });
                //istope filtering
                 if( $body.hasClass("isotope-filtering") && $body.hasClass("page-template-template-portfolio-php") ){
                    $('.cats li a').click(function(){
                      var selector = $(this).attr('data-filter');
                      $container.isotope({ filter: selector });
                      $('.overlay').trigger('click');
                      return false;
                    });
                  }
              }).trigger('debouncedresize');
                
              $container.imagesLoaded( function(){
                  $(window).trigger('debouncedresize');
              });

            },
            listenInfiniteScrolling : function() {

		        if($(window).scrollTop()+900 >= $infiniteContainer.offset().top+$infiniteContainer.height()){

		            // Prepare loading

		            $(window).off('scroll.infinite');
		            $infinite.stop().slideDown(150);

		            // Start AJAX call

		            $.ajax({
		                type: 'POST',
		                url: $infinite.find('a').prop('href'),
		                dataType: 'html',
		                success: function(data){

		                    var $data = $(data),
		                        $posts = $data.find('.ifpt');

		                    if($posts.length>0){

		                        // If there are posts

		                        $posts.imagesLoaded(function(){

		                            // When the images are loaded, setup & insert elements

		                            $infiniteContainer.isotope('insert', $posts);

		                            if ( $infiniteContainer.hasClass('type-masonry') ) {

		                            	$posts.each(function(){

		                            		$(this).click(function(){
												var link = $(this).attr("href");
												$('body').fadeOut(555, function(){
													window.location.href = link;
												});						
												return false;
	                            			});

		                            	});

	                            	} else {

	                            		Core.ui.setModules();

		                            	$posts.find('.view-item-btn').click(function(){

											var link = $(this).attr("href");
											$('body').fadeOut(555, function(){
												window.location.href = link;
											});						
											return false;

                            			});

	                            	}

	                                setTimeout(function(){
	                                    $(window).trigger('resize');
	                                }, 1000);

		                            // Prepare for next page

		                            $infinite.stop().slideUp(150);
		                            $infiniteLink.prop('href', $data.find('#infinite-link').prop('href'));
		                            $(window).on('scroll.infinite', Core.ui.listenInfiniteScrolling);

		                        });

		                    } else {

		                        // If no more posts

		                        $infinite.find('i').stop().fadeOut(100);
                        		$infinite.find('p').stop().fadeIn(100);

                        		setTimeout(function(){
                        			$infinite.stop().slideUp(300);
                        		}, 3000);

		                    }

		                }

	            	});

		        }

            },
            makeIsotopeGrid : function(){
              // Isotope layout
              var $container = $('.content-module');

              var colClass = $('.content-module').attr('data-cols'),
                  colSplit = colClass.split("cols-"),
                  columnsNumber = colSplit[1];


              var columns = 2,
                  iniCols = columnsNumber;
              window.setColumns = function() {
                  var winWidth = $(document).width();
                  if(winWidth > 800){
                      columns = iniCols;
                  }
                  else if(winWidth > 420){
                      columns = 2;
                  }
                  else{
                      columns = 1;
                  }

                  var theWidth = 100/columns - 0.5;

                  $('.module').css('width', getWidth);
                  function getWidth(){
                      return theWidth +'%';
                  }
              };
              setColumns();
              
              //just removing this function
              //you can disable the isotope behaviors
              $(window).on('debouncedresize', function(){
                setColumns();
                $container.isotope({
                  itemSelector : '.module',
                  resizable: false,
                  masonry: { columnWidth: $container.width() / columns}
                });
              }).trigger('debouncedresize');
                
              $container.imagesLoaded( function(){
                  $(window).trigger('debouncedresize');
              });
            },

            // The size of the modules needs to be calculated on each resize, but the initialization doesn't. That's why i've created this extra function to handle module resize, while leaving the inits to be done only once (a lot of bugs and preformance issues appear otherwise)

            setModulesSize : function(){

				window.sldrIndx = 0;

                $(".module").each(function(i, elem) {
                    Core.ui.getModuleSize($(this));
                });

            },

            getModuleSize : function($this){

            	// We need this in a different function to avoid code duplication

				window.itemW = $this.outerWidth();
				window.itemH = $this.outerHeight();

				if( $this.attr("data-size") ){

					var itemSizer = $this.attr("data-size"),
					sizeSplit = itemSizer.split("-"),

					sizrCols = parseInt(sizeSplit[0], 10),
					sizrFactor = parseInt(sizeSplit[1], 10),

					ratH = 0;

					if ( sizrFactor == 0 ) {

						// This is auto height

						ratH = 'auto';

					} else {

						// Get size based on screen resolution and module ratio

						if ( $r960.css('display') == 'none' && $r480.css('display') == 'none' ) {

							ratH = Math.round( ($(window).width() / 4) * sizrFactor);

						} else if ( $r960.css('display') == 'block' ) {

							if (sizrCols == 1 ) {

								ratH = Math.round( ($(window).width() / 2) * sizrFactor);

							} else {

								ratH = Math.round( ($(window).width() / sizrCols) * sizrFactor);

							}

						} else if ( $r480.css('display') == 'block' ) {

							ratH = Math.round( ($(window).width() / sizrCols) * sizrFactor);

						}

					}

					// If map

					if ( $this.find(".insert-map") ) {
						$(".insert-map").css("height", ratH);
					}

					// Set module size

					$this.css("height", ratH);

					// If YouTube video

					if ( $this.find(".yt-movie").length > 0 ) {
						var hArea = $("#ytVideo").attr("data-height"),
							videoW = $("#ytVideo").width(),
							ratVH = Math.round( (hArea/480 * videoW) );
						$("#ytVideo").height(ratVH);
						$("#ytVideo iframe").height(ratVH);
					}

					// If royal slider

					if ( $this.find('.royalSlider').length > 0 ) {
						var slider = $this.find('.royalSlider').data('royalSlider');
						if ( slider != undefined ) {
							setTimeout(function(){
								slider.updateSliderSize(true);
							}, 500)
						}
					}

					// Do actual return (used in setModules function)

					return ratH;

				}

            },

            setModules : function(){

				window.sldrIndx = 0;

                $(".module").each(function(i, elem) {

                	var ratH = Core.ui.getModuleSize($(this));

					//Case a module contains a map. Create all proper objects and setup everything the right way - needs to be before the size init

					if( $(this).hasClass('map-module') ) {
						$(this).append('<section class="map-full-mode clearfix"><div class="map-zoom"><a class="zoom-in" href="#"><i class="fa fa-plus"></i></a><a class="zoom-out" href="#"><i class="fa fa-minus"></i></a></div><div id="map' + Math.floor(Math.random()*1000) + '" class="insert-map"></div></section>');
					}

					//Case a module contains a form with a select element (element styling)
					if( $(this).find(".contact-form").length > 0 ){

						$(this).addClass("form-module").find('form div, form em').wrapAll('<div class="default-module-inner"></div>');

						if( $(this).find("select").length > 0 ){ $('.select-form').customSelect(); }

						// AJAX driven contact form with data validation - can be used multiple times in the same page (with different contact details of course)

						var $form = $(this).find('form'),
					        $name = $form.find('.name'),
					        $email = $form.find('.email'),
					        $subject = $form.find('.subject'),
					        $message = $form.find('.message'),
					        $success = $form.parent().find('.success-message');

				        $name.focus(function(){Core.form.resetError($(this))});
				        $email.focus(function(){Core.form.resetError($(this))});
				        $message.focus(function(){Core.form.resetError($(this))});

				        $form.submit(function(e){

				            var ok = true;
				            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

				            if($name.val().length < 3 || $name.val() == $name.data('value')){
				                Core.form.showError($name);
				                ok = false;
				            }

				            if($email.val() == '' || $email.val() == $email.data('value') || !emailReg.test($email.val())){
				                Core.form.showError($email);
				                ok = false;
				            }

				            if($message.val().length < 5 || $message.val() == $message.data('value')){
				                Core.form.showError($message);
				                ok = false;
				            }

				            if(ok){

				                $form.fadeOut();

				                $.ajax({
				                    type: $form.prop('method'),
				                    url: $form.prop('action'),
				                    data: $form.serialize(),
				                    success: function(){
				                      $success.fadeIn();
				                  }
				              });

				            }

				            e.preventDefault();

				        });

						$form.find('input, textarea').each(function(){
    
					        if($(this).attr('type') != 'submit' && $(this).attr('type') != 'button'){

					            $(this)
					                .data('value', $(this).val())
					                .focus(function(){
					                    $(this).addClass('focus-input');
					                    if($(this).val() == $(this).data('value')){
					                      $(this).val('');
					                    } else {
					                      $(this).select();
					                    }
					                })
					                .blur(function(){
					                    $(this).removeClass('focus-input');
					                    if($(this).val() == ''){
					                      $(this).val($(this).data('value'));
					                    }
					                });
					        }
					      
					    });

					}
					//Case a module contains a slider
					if( $(this).find(".royalSlider").length > 0 ){

		            	//check for tabs and do proper changes

		            	if( $(this).find(".royalSlider").hasClass('tabs') ){

		            		var $tabs = $(this).find(".royalSlider"),
		            			tabsDom = '',
		            			i = 0;
							
							$tabs.find('.rsContent').each(function(){

								$(this).append('<div class="rsTmb">' + $(this).find('h2').text() + '</div>');

								$(this).find('h2').remove();
								$(this).find('.img-asset.fa').remove();

							});

		            	}

						$(this).addClass("slider-module");
						sldrIndx ++;
						//assign a class to each slider in order to get more control in a isolated way
						$(this).find(".royalSlider").addClass("slider-"+sldrIndx);

						if($(this).hasClass('in-single-product')) {
							Core.ui.setModuleSlider(960, 960);
						} else {
							Core.ui.setModuleSlider(itemW, ratH);
						}

					}
					//Case a module contains a Twitter feed
					if( $(this).find(".twitter-feed").length > 0 ){
						if( ! $(this).hasClass('twitter-module') ) {
							$(this).addClass("twitter-module");
							//Wrap the tweets items with a slider instance and generate the slider
							$(this).find(".tweet_list li").wrapAll("<div class='royalSlider rsDefault'>");
							$(this).find(".tweet_list li").wrap("<div class='copy'><div><div>");
							// if( $(".twitter-fllw-link").length <= 0 ){ $(this).append('<a href="#" class="twitter-fllw-link vh-align">Follow us</a>'); }
							sldrIndx ++;
							$(this).find(".royalSlider").addClass("slider-"+sldrIndx);
							Core.ui.setModuleSlider(itemW, ratH);
						}
					}
					//Case a module cotains a blockquote; Add icon
					if( $(this).find("blockquote").length > 0 ){
						$(this).find("blockquote").append('<span class="quote-tag">"</span>');
					}
					//Case a module contains an accordion
					if ( $(this).find('.lobo-accordion').length > 0 ) {
						$(this).find('.lobo-accordion').each(function(){

				        	var $sections = $(this).children('.section'),
            					$opened = $(this).data('opened') == '-1' ? null : $sections.eq(parseInt($(this).data('opened')));

            				if ( $opened != null ) {
					            $opened.addClass('opened');
					            $opened.children('div').slideDown(0);
				            }	

					        $sections.children('h3').click(function(){

					            var $this = $(this).parent();

				                if($opened != null){
				                    $opened.removeClass('opened');
				                    $opened.children('div').stop().slideUp(300);
				                }

					            if(!$this.hasClass('opened')){
					                $opened = $this;
					                $this.addClass('opened');
					                $this.children('div').stop().slideDown(300);
					            }

					        });

						});

					}

                });

                if ( $(".text-module").length > 0 || $(".default-module").length > 0 || $(".image-module").length > 0 || $('.pagination-module').length > 0 || $(".gallery-module").length > 0 ) {

					$(".module").each(function(i, elem) {
						var elm = $(this);
						//if the module sets a bg color
						var itemScheme = $(this).attr("data-bgcolor");
						if( itemScheme )
							$(this).css("background-color", itemScheme);
						//if the module has set a bg image
						var itemBgImage = $(this).attr("data-bgimage");
						if( itemBgImage )
							$(this).css('background-image', 'url("' + itemBgImage + '")');
						//if the module has set a bg image pattern
						var itemBgImagePattern = $(this).attr("data-bgimagepattern");
						if( itemBgImagePattern )
							$(this).css('background-image', 'url("' + itemBgImagePattern + '")');
						//if the module sets a text color
						var itemTxtColor = $(this).attr("data-color");
						if( itemTxtColor )
							$(this).css("color", itemTxtColor);
						//custom transforms for text. Properties like uppercase, text align...
						var itemTrans = $(this).attr("data-customTransform");
						if( itemTrans ){
							var transProp = itemTrans.split(",");
							$.each(transProp, function(index, value) {
								if( value === 'uppercase' )
									$(elm).css("text-transform", value);
								if( value === 'left' )
									$(elm).css("text-align", value);
								if( value === 'center' )
									$(elm).css("text-align", value);
								if( value === 'right' )
									$(elm).css("text-align", value);
							});
						}
						//vertical align
						var vertAlign = $(this).attr('data-verticalalign');
						if ( vertAlign ) {
							$(this).find('.copy > div > div').css({'verticalAlign': vertAlign, 'paddingTop': '5%', 'paddingBottom': '5%'});
						}
						//color style for buttons
						if( $(this).find(".btn").length > 0 ) {

							$(this).find('.btn').each(function(){

								var itemBtnTxtColor = $(this).attr("data-btn-txt-color");
								if( itemBtnTxtColor )
									$(this).css("color", itemBtnTxtColor);
								var itemBtnBgColor = $(this).attr("data-btn-bg-color");
								if( itemBtnBgColor )
									$(this).css("background-color", itemBtnBgColor);

							});

							//method to change the buttons color inverting the bgColor with the text color
							if( $(".btn").attr("data-btn-bg-color") || $(".btn").attr("data-btn-txt-color") ){
								$(".btn").hover(function(){
									$(this).css("color", $(this).attr("data-btn-bg-color")).css("background-color", $(this).attr("data-btn-txt-color"));
								}, function(){
									$(this).css("color", $(this).attr("data-btn-txt-color")).css("background-color", $(this).attr("data-btn-bg-color"));
								});
							}
						}
					});
				}
            },
            setPrjctPag : function() {
				var n = 0;
				$(".pag-image").find("img").each(function(i, elem) {
					var img = $(this),
					theIMG = img.attr("src"),
					item = $(".pag-image");

					item.eq(n).css('background-image', 'url("' + theIMG + '")');
					img.remove();
					n++;
                });
            },
            setBlogFeatImg : function() {
				var n = 0;
				$(".post-item").find(".post-feat-img").each(function(i, elem) {
					var img = $(this);
					var parent = img.parent();

					img.removeAttr('width');
					img.removeAttr('height');

					img.attr('width', parent.width());

					if (img.height() < parent.height()) {
						img.css('width', img.width() * parent.height() / img.height());
					}

					img.css({
						left: parseInt((img.width() - parent.width())/-2) + 'px',
						top: parseInt((img.height() - parent.height())/-2) + 'px'
					});
					n++;
                });
            },
            videoDetection : function(){

				// YouTube videos (all)

				$(".yt-movie").each(function(i, elem) {
					$(this).mb_YTPlayer({
						addRaster: true,
						quality: 'hd1080'
					});
				});

				// Self Hosted videos

				if ( $('.mejs-video-play').length > 0 ) {

					$('.mejs-video-play').each(function(){

						if ( $('.mejs-video-play').attr('id') == 'mejsp-hero' ) 
						{

							var $this = $(this),
								vid = document.getElementById('mejsp-hero');

							vid.addEventListener( "loadedmetadata", function (e) {
							    $this.data('ratio',  this.videoWidth / this.videoHeight);
							    $(window).trigger('resize');
							}, false );

						}

						var $videoContainer = $(this).closest('.hero-video, .module'),
							dataObj = $(this);

						$('#' + $(this).attr('id')).mediaelementplayer({
				            alwaysShowControls: false,
				            iPadUseNativeControls: false,
				            iPhoneUseNativeControls: false,
				            AndroidUseNativeControls: false,
				            loop: dataObj.data('show-loop') == '1' ? true : false,
				            enableKeyboard: false,
				            pluginPath: themeObjects.base + '/js/mediaelement/',
								            
				            success: function(mediaElement, domObject, player){

				                var globalME = mediaElement;

				                // Autoplay

				                if(dataObj.data('show-autoplay') == '1'){
				                	mediaElement.play();
				                }

				                // Controls
				                
				                if(dataObj.data('show-controls') == '0'){
				                	player.container.find('.mejs-overlay-play, .mejs-controls').remove();
				                }

				                // Mute
				                
				                if(dataObj.data('show-mute') == '1'){
				                	mediaElement.setMuted(true);
				                }

	                  			// Handle resize if available (most complex thing here)

				                var origWidth = player.width,
				                    origHeight = player.height,
				                    ratio = Math.max(origWidth / origHeight, origHeight / origWidth);

	                  			var $poster = player.container.find('.mejs-poster');

	                  			if(dataObj.data('resize') != 'no') {

	                  				player.container.addClass('yes-resize')

		                  			mediaElement.addEventListener('play', function(){
		                  				setTimeout(function(){
		                  					$(window).trigger('resize');
		                  				}, 100);
		                  			});

					                $(window).on('debouncedresize', function(){

					                    var maxWidth = $videoContainer.width(),
					                        maxHeight = $videoContainer.height(),
					                        newHeight = 0,
					                        newWidth = 0;

					                    // Complex calculations to get the perfect size

					                    if(origWidth > origHeight){

					                        if(maxWidth / ratio < maxHeight){
					                            newHeight = maxHeight;
					                            newWidth = maxHeight * ratio;
					                        } else {
					                            newWidth = maxWidth;
					                            newHeight = maxWidth / ratio;
					                        }

					                    } else {

					                        if(maxHeight / ratio < maxWidth){
					                            newWidth = maxWidth;
					                            newHeight = maxWidth * ratio;
					                        } else {
					                            newHeight = maxHeight;
					                            newWidth = maxHeight / ratio;
					                        }

					                    }

					                    // Apply the correct size and reposition

					                    $('#' + player.media.id).css({
					                        'width': Math.ceil(newWidth),
					                        'height': Math.ceil(newHeight),
					                        'top': Math.round((maxHeight - newHeight)/2),
					                        'left': Math.round((maxWidth - newWidth)/2)
					                    });

					                    if ( player.media.pluginType != 'native' ) {
					                    	globalME.setVideoSize(newWidth,newHeight);
										}

					                    if($poster != null){

					                        $poster.css({
					                            'width': Math.ceil(newWidth),
					                            'height': Math.ceil(newHeight),
					                            'top': Math.round((maxHeight - newHeight)/2),
					                        	'left': Math.round((maxWidth - newWidth)/2)
					                        });
					                        
					                    }

					                }).trigger('debouncedresize');

									setTimeout(function(){
										$(window).trigger('resize');
									}, 200)

								}

							}

			            });

					});

				}

				// Vimeo videos (talking about the hero element, all other video instances don't need this)

				if($('.hero-video #vmVideo').length > 0) {

					var iframe = $('.hero-video #vmPlayer')[0],
					player = $f(iframe);
					player.addEvent('ready', function(player_id) {

						iframe.player = $f(player_id);

						if($('#vmVideo').data('mute') == 'mtrue'){
							iframe.player.api('setVolume', 0);
						}

						setTimeout(function(){
							Core.init.initSite()
						}, 1000);

					});

					$(".hero-video #vmPlayer").css('position', 'relative');
					$(window).resize(function() { videoResize(); });
					videoResize();

				}

				var bgStretch = true;
				// Detect mobile device
				if( navigator.userAgent.match(/Android/i) ||
					navigator.userAgent.match(/webOS/i) ||
					navigator.userAgent.match(/iPhone/i) ||
					navigator.userAgent.match(/iPad/i) ||
					navigator.userAgent.match(/iPod/i)
				){
					mobileDevice = true;
				}else{
					mobileDevice = false;
				}

				function videoResize(){

					// This is only required for the hero element, because the module iframes are actually static

					var $vmPlayer = $(".hero-video #vmPlayer");

					if($vmPlayer.length > 0) {

						var maxHeight = $(window).height(),
			                maxWidth = $(window).width(),
			                oldHeight = $vmPlayer.height(),
			                oldWidth = $vmPlayer.width(),
			                ratio = 1.776198,
			                newHeight = 0,
			                newWidth = 0;

			            // Get the perfect size

		                if(maxWidth / ratio < maxHeight){
		                    newHeight = maxHeight;
		                    newWidth = maxHeight * ratio;
		                } else {
		                    newWidth = maxWidth;
		                    newHeight = maxWidth / ratio;
		                }

						$('.hero-video div').css({width:newWidth, height:newHeight});

			            // Apply the correct size and reposition

			            $vmPlayer.css({
			                'width': Math.ceil(newWidth),
			                'height': Math.ceil(newHeight),
			                'top': Math.round((maxHeight - newHeight)/2),
			                'left': Math.round((maxWidth - newWidth)/2)
			            });

					}

				}
            },
            videoEmbedded : function(){

            	$('.video-embedded').each(function(){

            		if ( mobileDevice ) {

        				$(this).children('img').remove();
        				$(this).css('height', '100%');

            			if ( $(this).hasClass('y') ) {

            				$(this).find('.bottom-controls').remove();

            			} else {

            				$(this).append('<iframe id="vmPlayer" src="' + $(this).data('src').replace('autoplay=1', 'autoplay=0') + '" width="100%" height="100%" webkitAllowFullScreen mozallowfullscreen allowFullScreen frameborder="0"></iframe>');

            			}

            		} else {

            			$(this).append('<div class="vem-overlay"><div class="vem-play"></div></div>').find('.vem-overlay').click(function(e){

		        			var $this = $(this).closest('.video-embedded');

			                if(!$this.hasClass('loading')) {

			                	if ( $this.hasClass('y') ) {

			                		$this.addClass('loading');
			                		$this.find('.yt-movie').playYTP();

			                		setTimeout(function(){
				                		$this.find('img, .vem-overlay').fadeOut(200);
				                		$this.removeClass('loading').css('height', '100%');
			                		});

			                	} else {

				                    var href = $this.data('src'),
				                        id = $this.data('id');

				                    $this.append('<div class="css-loader"></div><iframe id="video-frame-' + id + '" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + ($('html').hasClass('ie') ? ' allowtransparency="true"' : '') + '></iframe>')

				                        .addClass('loading')

				                        .find('.close-iframe').click(function(){
				                            $(this).closest('.video-embedded')
				                                .removeClass('loading')
				                                .find('iframe, .close-iframe').remove();
				                        });

			                    	$('#video-frame-' + id).prop('src', href)   
			                        .load(function(){
			                            $(this).animate({'opacity': 1}, 200)
			                                .siblings('.css-loader').remove();
			                        });

		                    	}

			                }     

			                e.preventDefault();

		        		});

            		}


            	});
            	
            },
            audioDetection : function(){

            	if( $body.find('audio') )
            		$( function() { $( 'audio' ).audioPlayer(); } );
            	$("audio").each(function(){
            		$(this).parent().addClass("audio-module");
            	});

				document.addEventListener('play', function(e){
				    var audios = $('audio');
				    for(var i = 0, len = audios.length; i < len;i++){
				        if(audios[i] != e.target){
				            audios[i].pause();
				            audios.eq(i).parent().removeClass("audioplayer-playing").addClass("audioplayer-stopped");
				        }
				    }
				}, true);

            },
            setMap : function(){

            	// We need to consider that there might be more than one map on a page, case in which each map needs to be initialized with it's own parameters

            	$('.map-module').each(function(){

            		var map,
            			$mapInsert = $(this);

	                function initialize() {
	                    
	                    var styles=[
	                        {
	                            stylers:[
	                                {hue:"#00ffe6"},
	                                {saturation:-100},
	                                {gamma:0.8}
	                            ]
	                        }
	                        ,{
	                            
	                            featureType:"road",
	                            elementType:"geometry",
	                            stylers:[
	                                {lightness:100},
	                                {saturation:0}
	                            ]
	                        }
	                        ,{
	                            
	                            featureType:"road",
	                            elementType:"labels",
	                            stylers:[
	                                {lightness:55}
	                            ]
	                        }
	                        ,{
	                            
	                            featureType:"road",
	                            elementType:"labels.text.stroke",
	                            stylers:[
	                                {visibility:"off"}
	                            ]
	                        
	                        }
	                        ,{
	                            
	                            featureType:"poi.park",
	                            elementType:"geometry",
	                            stylers:[
	                                {lightness:55}
	                            ]
	                        }
	                    ];
	                  
	                    var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
	                    var latlng = new google.maps.LatLng($mapInsert.data('lat'), $mapInsert.data('long'));
	                    var mapOptions = {
	                        zoom: $mapInsert.data('zoom'),
	                        center: latlng,
	                        mapTypeId: google.maps.MapTypeId.ROADMAP,
	                        navigationControl: false,
	                        streetViewControl: false,
	                        mapTypeControl: false,
	                        scaleControl: false,
	                        scrollwheel: false,
	                        disableDefaultUI: true
	                    };
	                       
	                    map = new google.maps.Map(document.getElementById($mapInsert.find('.insert-map').attr('id')), mapOptions);
	                    map.mapTypes.set('map_style', styledMap);
	                    map.setMapTypeId('map_style');

	                    var myLatlng = new google.maps.LatLng($mapInsert.data('lat'), $mapInsert.data('long'));
	                    var image = new google.maps.MarkerImage(
	                        $mapInsert.data('marker')/*,
	                        //- with custom images this is now harder -
	                        new google.maps.Size(57,57),
	                        new google.maps.Point(0,0),
	                        new google.maps.Point(24,62)*/
	                    );
	                    
	                    var marker = new google.maps.Marker({
	                        position: myLatlng,
	                        map: map,
	                        clickable: false,
	                        title: '',
	                        icon: image
	                    });

	                    var dragFlag = false;
	                    var start = 0, end = 0;

	                    function thisTouchStart(e)
	                    {
	                        //this will stop the dragging feats. on touch devices
	                        map.setOptions( { draggable: false });
	                        dragFlag = true;
	                        start = e.touches[0].pageY;
	                    }

	                    function thisTouchEnd()
	                    {
	                        dragFlag = false;
	                    }

	                    function thisTouchMove(e)
	                    {
	                        if ( !dragFlag ) return;
	                        end = e.touches[0].pageY;
	                        window.scrollBy( 0,( start - end ) );
	                    }

	                    $(".insert-map").on("touchstart", thisTouchStart, true);
	                    $(".insert-map").on("touchend", thisTouchEnd, true);
	                    $(".insert-map").on("touchmove", thisTouchMove, true);
	                }
	                //initialize the map on load
	                if ( google )
	                	google.maps.event.addDomListener(window, 'load', initialize);

	                $(function(){
	                  $(".zoom-in").click(function(){
	                    var zoom = map.getZoom();
	                    map.setZoom(zoom+1);
	                    return false;
	                  });
	                  $(".zoom-out").click(function(){
	                    var zoom = map.getZoom();
	                    map.setZoom(zoom-1);
	                    return false;
	                  });
	                });

            	});
               
            },

            setGalleria : function(){

            	// Load theme

				Galleria.loadTheme(themeObjects.galleriaSkin);
				
				$('.galleria-run').click(function(){
					Core.ui.runGalleria($(this).closest('.gallery-module'), $(this).siblings('.galleria'));
				});

				// Prepare galleria

				Galleria.ready(function(options) {

					$('.gal-close-btn').click(function(e){

						$galleria.fadeOut(500);
						$("html, body").css("overflow", "visible");
						e.preventDefault();

					});

				});

            },

            runGalleria : function( $options, $content ){

            	var data = Array();
            	$content.find('img').each(function(){

            		var $this = $(this);

            		data.push({
            			thumb: $this.attr('src'),
            			image: $this.data('big'),
            			title: $this.data('title'),
            			description: $this.data('description')
            		});

            	});

            	$galleria.stop().fadeIn(350);

            	//esc key trigger to close gallery
				$(document).keyup(function(e) {     
					if(e.keyCode== 27) {
						$('.gal-close-btn').trigger('click');
					} 
				});

            	Galleria.run('#galleria', {
            		dataSource: data,
            		imageCrop: $options.data('imagecrop') == 'yes' ? true : false,
            		maxScaleRatio: $options.data('imagecrop') == 'yes' ? undefined : 1,
            		thumbnails: $options.data('thumbnails') == 'yes' ? true : false,
            		autoplay: $options.data('autoplay') == 'no' ? false : $options.data('autoplay'),
            		showInfo: $options.data('showinfo') == 'yes' ? true : false,
            		transition: $options.data('transition')
            	});

            }

          },//ui

          tweaks : {
            textAreaComments : function(){
				$('textarea').autosize();
            },
            setupForm : function(){

            	var timer;
				function endAndStartTimer() {
				  window.clearTimeout(timer);
				  //var millisecBeforeRedirect = 10000; 
				  timer = window.setTimeout(function(){console.log('Hello!');},10000); 
				  timer;
				}

            	$(document).on('keyup input paste', '.respond-comment textarea', function(){

            		if ( $(this).val() != '' ) {
            			$(".comment-form input#submit, .submit-caption").addClass("hello");
						$(".submit-btn-helper").addClass("bye");
            		} else {
						$(".comment-form input#submit, .submit-caption").removeClass("hello");
						$(".submit-btn-helper").removeClass("bye");
            		}

            	});

				$('.respond-comment textarea').focus(function(){

					$(".respond-comment").addClass("active");

				}).blur(function(){

					if ( $(this).val() == '' ) {
						$(".respond-comment").removeClass("active");
					}

				});

            },
            cursorAnimation : function(){

				$('.comment-cursor').animate({
					opacity: 0
				}, 'fast', 'swing').animate({
					opacity: 1
				}, 'fast', 'swing', function(){
					setTimeout(function(){
						Core.tweaks.cursorAnimation();
					}, 1250)
				});
				
            }

          },//tweeks
          
          form : {

		    // Contact form functions

		    showError : function($input){
		        $input.val($input.data('value'));
		        $input.addClass('contact-error-border');
		    },

		    resetError : function($input){
		        $input.removeClass('contact-error-border');
		    }

          },

          // WooCommerce

          woo : {

         	setupProducts : function() {

         		// Remove double image
         		$('li.product').find('img.wp-post-image').remove();

				// Setup search items

				var $shopSearch = $('#shop-search');

				$shopSearch.prependTo($('#content-wrapper'));

				$shopSearch.find('.c-tabs').prepend('<div class="titles"><ul></ul></div><div class="contents clearfix"></div>');

				if ( $('.woocommerce-ordering').length > 0 ){
					var sortWidgetDom = '<div class="widget"><h6 class="wsf-heading">' + themeObjects.textSort + '</h6><ul>';
					$('.woocommerce-ordering').find('option').each(function(){
						sortWidgetDom += '<li><a href="' + window.location.href.split('?')[0] + '?orderby=' + $(this).val() + '">' + $(this).text() + '</a></li>';
					});
					sortWidgetDom += '</ul></div>';
					$shopSearch.append(sortWidgetDom);
				}

				$shopSearch.find('.widget').each(function(){
					$(this).find('.wsf-heading').appendTo($shopSearch.find('.titles ul')).wrap('<li></li>');
					$(this).children('ul, div, form').appendTo($shopSearch.find('.contents')).wrap('<div></div>');
					$(this).remove();
				});

				$('.shop-search-filter a').click(function(){

					var yWin = $(window).scrollTop(),
                        marginToScroll = $mainWrapper.offset().top,
                        contentMarginTop =  $(".hero-spacer").height(),
                        toScroll = yWin - contentMarginTop;

                    $header.removeClass("scrll-up");
					$header.fadeOut(10);
					$header.delay(2500).fadeIn(350);

                	$('html, body').animate({
                		//scrollTop: $shopSearch.offset().top
                		scrollTop: yWin - (toScroll + navH-3)
                	}, 750, function(){

						if($shopSearch.hasClass('opened')){
							$shopSearch.stop().slideUp('400');
							$shopSearch.addClass('opened');
						} else {
							$shopSearch.stop().slideDown('400');
							$shopSearch.removeClass('opened');
						}

                	});

                	return false;

				});

				$('.ss-cls-btn').click(function(e){
					$shopSearch.stop().slideUp('400');
					$shopSearch.removeClass('opened');
					e.preventDefault();
				});

				// Setup notices

				$('.woocommerce-info, .woocommerce-error, .woocommerce-message').insertAfter('.woo-cheader');

				// Checkout coupons 

				$('.checkout_coupon').appendTo('#checkout_coupon');

				// Move login

				if($('.post-excerpt').children('.woocommerce').children('form.login').length > 0){
					$('.post-excerpt').children('.woocommerce').children('form.login').wrapInner('<div class="lobo-tabs clearfix"><div class="contents at-top"><div class="p-form"></div></div></div>');
					$('.post-excerpt').children('.woocommerce').children('form.login').find('.p-form').children('p').eq(0).prependTo($('.post-excerpt').children('.woocommerce').children('form.login')).addClass('custom-idea');
				}

         	},

         	setupProject : function() {

         		// This chunk simply moves some stuff from a place to another
         		$('.related.products').insertAfter('.insert-related');
         		$('.upsells.products').insertAfter('.insert-related');
         		$('.woocommerce-breadcrumb').insertBefore('.product_title');

		        var $onsale = $('.single-product').find('.onsale').clone();
		        $('.single-product').find('.onsale').remove();
		        $('.single-product').find('.images').append($onsale);
		        $('.single-product').find('.onsale').show();

		        // Activate thumbnails (fancybox)

			    if($('.fancybox').length>0){
			        $('.fancybox').fancybox({
			            padding: 0,
			            margin: 50,
			            aspectRatio: true,
			            scrolling: 'no',
			            mouseWheel: false,
			            openMethod: 'zoomIn',
			            closeMethod: 'zoomOut',
			            nextEasing: 'easeInQuad',
			            prevEasing: 'easeInQuad'
			        }).append('<span></span>');
			    }

			    // Notice exchange, hmm?

			    $('.woocommerce-message .button').appendTo('.woocommerce-message');

			    // Set content size

			    var $prodContent = $('.single-product').find('.product-content').children('.module'),
			    	$prodImg = $('.single-product').find('.images.wcif');
			    $(window).on('resize', function(){
			    	$prodContent.height($prodImg.height());
			    }).trigger('resize');

			    // Variations fix

			    if ( $('.variations_form.cart').length > 0 ) {

				    var variations = $('.variations_form.cart').data('product_variations');

					for ( var i = 0; i < variations.length; i++ ) {
						variations[i].image_src = variations[i].image_link;
					}

					var oI = $('.variations_form.cart').find('option:selected').index()-1;

					if ( oI == -1 ) oI = 0;

					if(oI != 0 && variations[oI] != undefined && variations[oI].image_link != undefined) {
						$('.images.wcif .rsSlide:first-child img').prop('src', variations[oI].image_link);
					}
					
				    if ( $('.images.wcif').children('div.module').hasClass('default-module')) {

					    var $zoom = $('.images.wcif .zoom'),
					    	$imgObject = $('.images.wcif .change-here'),
					    	zoomImg = $zoom.attr('href');

					    setInterval(function(){

					    	if ( $zoom.attr('href') != zoomImg && $zoom.attr('href') != '#' ) {

					    		zoomImg = $zoom.attr('href');
					    		$imgObject.css('backgroundImage', 'url(' + zoomImg + ')');

					    	}

					    }, 100);

					}

				}

         	},

         	setupReviews : function() {

         		// Reviews modal window

         		$('#tab-reviews').children('h3').off('click').click(function(e){
         			e.preventDefault();
         		}).on('click', function(e){
         			$('#reviews-modal').modal('show');
         			setTimeout(function(){
         				$(window).trigger('resize');
         			}, 100);
         			e.preventDefault();
         		});

         		$('body').append('<div id="reviews-modal" class="modal fade"><div id="lobo-reviews"><div><div><div><h5>' + themeObjects.textReviews + '</h5><div class="content"></div><div class="form"></div></div></div></div></div></div>');

         		var $reviews = $('#tab-reviews').find('.comment_container'),
         			$form = $('#tab-reviews').find('#review_form_wrapper');

         		$('#lobo-reviews .content').append($reviews);
         		$('#lobo-reviews .form').append($form);

         		// Reviews slider

         		$reviews.wrapAll('<div class="royalSlider contentSlider rsDefault reviews-slider"></div>');

         		$('.reviews-slider').find('.avatar').addClass('rsImg');

				$('.reviews-slider').royalSlider({
					controlNavigation: 'none',
					sliderDrag: false,
					slidesSpacing: 0,
					minSlideOffset: 0,
					imageScaleMode: 'none',
					imageAlignCenter: false,
					loop: false,
					loopRewind: true,
					fadeinLoadedSlide: false,
					autoHeight: true,
					navigateByClick: false
				});

				// Reviews form

				$('#rating').customSelect();

				$('#respond #author').val($('#respond label[for="author"]').text());
				$('#respond #email').val($('#respond label[for="email"]').text());
				$('#respond #comment').val($('#respond label[for="comment"]').text());

         		$('#reviews-modal').click(function(){
         			$('#reviews-modal').modal('hide');
         		});
         		$('#lobo-reviews > div > div > div').click(function(e){
         			e.stopPropagation();
         		});

         		// Append stars to proper place

         		$('.custom.star-rating').appendTo('#tab-reviews h3');

         	},

         	setupCart : function() {

			    // Basic menu animation (cart widget)

			    if($('#main-cart').length > 0){

			        var $cartWidget = $('#main-cart').find('.widget_shopping_cart');

			        $('#main-cart').hover(function(){
			            $cartWidget.stop().css('height', 'auto').slideDown(150);
			        }, function(){
			            $cartWidget.stop().slideUp(100);
			        });

			    }

         	},

         	checkThumbs : function() {

         		var $thumbs = $("li.product");

         		$thumbs.each(function(){

					var thumbHeight = $(this).height();

					if( thumbHeight < 479 ){
						$(this).addClass("small-product-thumb");
					}else {
						$(this).removeClass("small-product-thumb");
					}

				});

			}



          },

          // Initialize site

          init: {

          	initializedSite : false,

          	initSite : function(){

          		Core.init.initializedSite = true;

				$("#preloader").fadeOut(1150, function(){ 
					$(this).remove(); 
					$('.main-d-nav').removeClass('iefix');
				});
				$("#main-wrapper").animate({ opacity: 1 }, 750);
				$("html, body").animate({ scrollTop: 0 }, 50);

				if ( $body.hasClass('blog') || $body.find('.latest-module.mt-post').length > 0 ) { Core.ui.setBlogFeatImg(); }

				//get some global vars
				window.contentH = $body.height();
				window.heroH = $heroWrapper.height();
				window.heroWrapperH = $(".hero-item").height();
				window.parRatio = Math.round( (contentH/heroH) + 5 );

				// set infinite loading
				if( ( $body.hasClass("page-template-template-portfolio-php") || ( $body.hasClass('woocommerce') && $body.hasClass('archive') ) ) && $('#infinite').length > 0 ) {
					
	                $infinite = $('#infinite');
	                $infiniteLink = $('#infinite-link');
	                $infiniteContainer = $('.portfolio');
	                
	                $(window).on('scroll.infinite', Core.ui.listenInfiniteScrolling);

				}

				//set hero
				Core.ui.setHeroArea();
				if( $body.hasClass("parallax") ){ Core.ui.setParallax(); }
				if( ( $body.hasClass("page-template-template-portfolio-php") && $('.portfolio').hasClass('type-masonry') ) || ( $body.hasClass('woocommerce') && $body.hasClass('archive') ) ){ Core.ui.setIsotopeLayout(); }
				Core.ui.backgroundCheck();

				if ( $('html').hasClass('ie') ) {
					setTimeout(function(){
						if ( $('.hero-slider.royalSlider').length > 0 )
							$('.hero-slider.royalSlider').data('royalSlider').updateSliderSize(true);
					}, 1000);
				}

				setTimeout(function(){
					$(window).trigger('resize');
				}, 2000);

          	}

          }


      };

  window.menuStickyControl = $body.hasClass("menu-layout-fixed");

  //check mobile capabilities
  if( navigator.userAgent.match(/Android/i) ||
   navigator.userAgent.match(/webOS/i) ||
   navigator.userAgent.match(/iPhone/i) ||
   navigator.userAgent.match(/iPad/i) ||
   navigator.userAgent.match(/iPod/i)
   ){
    window.mobileDevice = true;
	$body.addClass("mobile");
  } else {
    window.mobileDevice = false;
  }
  //check & detect iOS devices
  if( navigator.userAgent.match(/iPhone/i) ||
   navigator.userAgent.match(/iPad/i) ||
   navigator.userAgent.match(/iPod/i) ) { $body.addClass("ios"); }

  //hide for the iPhone´s search bar to minimize fixed back with scroll issue
  /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
    if (!pageYOffset) window.scrollTo(0, 1);
    if( $(".intro-slider").length > 0 ){
      Core.ui.setHomeSliderProps();
    }
  }, 1000);

  //assign & locate inner links to achieve a lazy/fade load between pages
  var fdTrgts = ['.main-d-nav a', '.pagination div a', 'a.btn-link', '.read-btn a', '.post-title a', '.prtfl-item', '.view-item-btn', '.logo', '.action-link', '#main-cart a', '.woo-cheader a', 'li.product .view_button'];
  $.each(fdTrgts, function(i, elem) { 
	$(elem).addClass('inner-link');
  });
  //run the option to fade on click
  $(function(){
    //fade when load pages from cat menu
    if( $("body").hasClass("woocommerce-page") ){ $(".prtfl-item").removeClass("inner-link"); }
    $('.inner-link').on('click.fadeClick', function(e){
      var link = $(this).attr('href');
      if ( $(this).attr('target') != '_blank' && link.indexOf('#') < 0 ) {
	      $('body').fadeOut(555, function(){
	           window.location.href = link;
	      });
	      e.preventDefault();
  		}
    })
  });

  //fix for Safari back-forward cache issue
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
     window.location.reload() 
    }
  });


	//Responive helpers
	$body.append('<div id="r-960"></div><div id="r-480"></div>');
	$r960 = $('#r-960');
	$r480 = $('#r-480');

  //Main functions
  Core.ui.setCompactMenu();
  Core.ui.setClassicMenu();
  Core.ui.checkStickyMenu();

  if( $body.hasClass("sticky-head") ){
	Core.ui.setStickyHero();
	Core.ui.placeStickyShdw();
  }
  if( $body.hasClass("no-sticky-head") ){
	$body.addClass("actions-bottom");
	Core.ui.setStickyHero();
  }
  Core.ui.checkCompactMenu()
  Core.ui.videoEmbedded();
  Core.ui.videoDetection();
  Core.ui.audioDetection();
  Core.ui.setHeroArea();
  Core.ui.showCloseOverlayBtn();
  Core.ui.showHoverOverlay();
  Core.ui.showCats();
  Core.ui.showShrWdgt();
  Core.ui.setShareWdgtOptions();
  Core.ui.closeOverlay();
  Core.ui.pageScroller();
  if( $heroWrapper.find(".royalSlider").length > 0 ){ Core.ui.setHeaderSlider(); }
  if( $body.hasClass("single-post") ){
	Core.tweaks.textAreaComments();
	Core.tweaks.setupForm();
	Core.tweaks.cursorAnimation();
  }
  Core.ui.setModules();
  if( $body.find(".gallery-module").length > 0 ) { Core.ui.setGalleria(); }
  Core.ui.setModulesSize();
  Core.ui.setPrjctPag();

  //set GoogleMap in case the map canvas is present
  //in any part of any page
  if( $body.find(".map-module").length > 0 ){ Core.ui.setMap(); }
	
	if( $body.hasClass("page-template-template-modular-php") || $('body').hasClass('single-portfolio') ){

		var $contentModule = $('.content-module');

		$(window).on('debouncedresize', function(){

			var leftOver = $(window).width() % 4;

			if ( leftOver != 0 ) {
				$contentModule.width($(window).width()+4-leftOver);
			} else {
				$contentModule.width($(window).width());
			}

			var columWidthh = $contentModule.width()/4;

			$contentModule.isotope({
				resizable: false,
				itemSelector: '.module',
				transitionDuration: 0,
				masonry: {
					columnWidth: columWidthh
				}
			});

		}).trigger('debouncedresize');

	}

	//here we are listening for this method that is
	//only supported for IE (even ie10) in order
	//to center and target some behaviors because IE
	//can´t manage a so simple task like this one.
	//we can´t access to IE10 with modernizer either
	if (window.clipboardData) { $body.addClass("explorer"); }
	//Modern IE detection
	var ie11Styles = ['msTextCombineHorizontal'];
	
	/*Test all IE only CSS properties*/
	var d = document;
	var b = d.body;
	var s = b.style;
	var ieVersion = null;
	var property;
	
	// Test IE11 properties
	for (var i = 0; i < ie11Styles.length; i++) {
		property = ie11Styles[i];
		
		if (s[property] != undefined) {
			ieVersion = "ie11";
		}
	}
	if (ieVersion === "ie11") { $("body").addClass("modernIE"); }
	
	//HTML5 fullscreen API: feature control; in case the browser  not support
	//this feature, the trigger is removed.
	if ( $("body").hasClass("explorer") || $("body").hasClass("modernIE") || window.mobileDevice ) { $(".action-fullscreen").remove(); }
	$(".action-fullscreen a").click(function(){ Core.ui.setFullscreen(); }); 

	// Try to fix some init bugs? :)
	setTimeout(function(){
		$(window).trigger('resize');
	}, 200);

  };
  mainScripts();

	$(window).on('load', function() {

		  // WooCommerce inits
		  if ( $body.hasClass('woocommerce-page') ) {
			Core.woo.setupProducts();
		  }
		  if ( $body.hasClass('single-product') ) {
		  	Core.woo.setupProject();
		  	Core.woo.setupReviews();
		  }
		  if ( $body.hasClass('woocommerce') ) {
		  	Core.woo.setupCart();
		  }
		  if ( $body.hasClass('woocommerce-page')) {
		  	$body.removeClass('single-post');
		  }

	    /* -------------------------------
	    -----   Tabs   -----
	    ---------------------------------*/

	    $('.lobo-tabs, .c-tabs').each(function(){

	        var $titles = $(this).find('.titles').find('li'),
	        $contents = $(this).find('.contents').children('div'),
	        $openedT = $titles.eq(0),
	        $openedC = $contents.eq(0);

	        $openedT.addClass('opened');
	        $openedC.stop().slideDown(0);
	        
	        $titles.find('a').prop('href', '#').off('click');

	        $titles.click(function(e){

	            $openedT.removeClass('opened');
	            $openedT = $(this);
	            $openedT.addClass('opened');

	            $openedC.stop().slideUp(200);
	            $openedC = $contents.eq($(this).index());
	            $openedC.stop().delay(200).slideDown(200);

	            e.preventDefault();

	        });

	    });

		  // Password protected
		  if ( $('.pwdprt').length > 0 ) {
		  	$body.addClass('is-w-pwd force-detect-dark');
		  	$('.pwdprt').prependTo($body);
		  	$('.menu-firer').click(function(){
		  		$('.main-d-nav').css('zIndex', 99);
		  	});
		  }

		if ( ! Core.init.initializedSite ) {
			Core.init.initSite();
		}

	});

	$(window).on('resize', function() {

		window.heroWrapperH = $(".hero-item").height();

		if( $body.hasClass("isotope-filtering") && $body.hasClass("woocommerce-page") ){
			Core.woo.checkThumbs();
		}

		Core.ui.checkCompactMenu();
		if( !compactMenu ) { Core.ui.setClassicMenu(); }

		Core.ui.setModulesSize();

		if ( $body.hasClass('blog') || $body.find('.latest-module.mt-post').length > 0 ) { Core.ui.setBlogFeatImg(); }

		if ( $body.hasClass('no-resize-heros') ) {
			Core.ui.setHeroArea();
		} else {
			clearTimeout(checkMenu);
			checkMenu = setTimeout(function(){
				Core.ui.setHeroArea();
			}, 50);
		}

	});

});//end document.ready