(function ($) {
	var a = $.noConflict();
	
    Galleria.addTheme({
        name: "Lobo",
        author: "VKW",
        defaults: {
            debug: 'false',
            initialTransition: 'fade',
            easing: "galleriaOut",
            responsive: true,
            imagePan: false,
            swipe: true,
            thumbCrop: "height",
            maxVideoSize: 0,
            trueFullscreen: !1,
            _hideDock: Galleria.TOUCH ? !1 : !0,
            _closeOnClick: !1,
            _closeButton: '<span class="galleria-close-wrapper gal-handler"><a class="gal-close-btn" href="#">' + $('.galleria-btn-labels .gal-close').eq(0).text() + '</a></span>',
            _fitContentButton: '<span class="galleria-toggle-fit gal-control gal-handler"><a class="btn-toggle-fit" href="#"><i class="icon-resize-full"></i></a></span>',
            _contentArea: '<div class="galleria-content-area"></div>'
        },
        init: function (b) {
            Galleria.requires(1.28, "This is a warning. Contact to VanKarWai if needed"),
            this.addElement("thumbnails-tab"), this.appendChild("thumbnails-container", "thumbnails-tab");
            var c = this.$("thumbnails-tab"),
                d = this.$("loader"),
                e = this.$("thumbnails-container"),
                f = this.$("thumbnails-list"),
                g = this.$("info-text"),
                h = this.$("info"),
                xy = this.$("image-nav-left"),
                xx = this.$("image-nav-right"),
                i = !b._hideDock,
                j = 0;

        //if galleria option is set to let the user choose if images fit the screen or not
        if( $("body").hasClass("project-size-dynamic") ){
            this.append({ 'stage' : [b._closeButton, b._fitContentButton, b._contentArea, b._titleArea, b._projectInfo] });
        //in other case, the fit to area button is not added
        }else{
            this.append({ 'stage' : [b._closeButton, b._contentArea, b._titleArea, b._projectInfo] });
        }

        // appends info area to the hidden area
        this.appendChild('galleria-content-area','info');
        $(".galleria-container").addClass("mod");
        $(".galleria-image-nav, .galleria-counter").appendTo($(".galleria-content-area"));
        $("<div class='thumbs-trigger'></div>").appendTo($(".galleria-stage"));

        xy.append('<i class="fa fa-angle-left"></i>');
        xx.append('<i class="fa fa-angle-right"></i>');

        //init the new background detection
        BackgroundCheck.init({
            targets: '.mod',
            images: this.getActiveImage(),
            minComplexity: 80,
            maxDuration: 1250,
            threshold: 50,
            minOverlap: 10
        });

        //listen the on change image event to enable the background detection
        this.bind('image', function(e) { BackgroundCheck.set('images', e.imageTarget); });

        $(".gal-close-btn").click(function(){ BackgroundCheck.set('targets', '.target'); });

        //trigger the hover for thumbs with a hidden element
        $(".galleria-thumbnails-container").hover(function(){ c.click(); });

            Galleria.IE && (this.addElement("iefix"), this.appendChild("container", "iefix"), this.$("iefix").css({
                zIndex: 3,
                position: "absolute",
                backgroundColor: "#000",
                opacity: 0.4,
                top: 0
            })), b.thumbnails === !1 && e.hide();
            var k = this.proxy(function (b) {
                if (!b && !b.width) return;
                var c = Math.min(b.width, a(window).width());
            });
            this.bind("rescale", function () {
                j = this.getStageHeight() - c.height() - 2, e.css("top", i ? j - f.outerHeight() + 2 : j);
                var a = this.getActiveImage();
                a && k(a)
            }), this.bind("loadstart", function (b) {
                b.cached || d.show().fadeTo(100, 1), a(b.thumbTarget).css("opacity", 1).parent().siblings().children().css("opacity", 0.6);
            }), this.bind("loadfinish", function (a) {
                d.fadeOut(300), this.$("iefix").toggle(this.hasInfo());
            }), this.bind("image", function (a) {
                $(".galleria-project-title-overlay, .ini-gal-preloader").delay(1500).fadeOut(500);
                k(a.imageTarget);
            }), this.bind("thumbnail", function (d) {
                a(d.thumbTarget).parent(":not(.active)").children().css("opacity", 0.6), a(d.thumbTarget).hover(function () {
                    i && b._closeOnClick && c.click();
                });
            }), this.trigger("rescale"), Galleria.TOUCH || (this.addIdleState(e, {
                opacity: 1
            })), Galleria.IE && this.addIdleState(this.get("iefix"), {
                opacity: 0
            }), this.$("image-nav-left, image-nav-right").css("opacity", 1).hover(function () {
                a(this).animate({
                    opacity: 1
                }, 100);
            }, function () {
                a(this).animate({
                    opacity: 1
                });
            }).show(), b._hideDock ? c.click(this.proxy(function () { //if set c.click() instead e.hover the thumbs open on click
                c.toggleClass("open", !i), i ? e.animate({
                    top: j
                }, 400, b.easing) : e.animate({
                    top: j - f.outerHeight()
                }, 400, b.easing), i = !i
            })) : (this.bind("thumbnail", function () {
                e.css("top", j - f.outerHeight());
            }), c.css("visibility", "hidden")), this.$("thumbnails").children().hover(function () {
                a(this).not(".active").children().stop().fadeTo(100, 1);
            }, function () {
                a(this).not(".active").children().stop().fadeTo(400, 0.6);
            }), this.enterFullscreen(), this.attachKeyboard({
                escape: function (a) {
                    return !1;
                },
                up: function (a) {
                    i || c.click(), a.preventDefault()
                },
                down: function (a) {
                    i && c.click(), a.preventDefault()
                }
            });
        }
    });
})(jQuery);