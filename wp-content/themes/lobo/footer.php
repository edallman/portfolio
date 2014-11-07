<?php
/**
 * The footer of the theme
 */
?>

            <div class="clearfix"></div>

        </section>

        <!-- Content End -->

        <!-- Footer -->
        
       <footer class="footer">
       		<div class="social-area">
                <?php echo do_shortcode( get_option( 'lobo_footer_social' ) ); ?>
            </div>
            <div class="credits">
                <?php echo do_shortcode( get_option( 'lobo_footer_copy' ) ); ?>
            </div>
        </footer>

    </div>

	<!-- Preloader -->

	<div id="preloader">
	    <div class="preloader-image" style="background-image:url(<?php lobo_preloader(); ?>);"></div>
	    <div id="spinner"></div>
	</div>

    <!-- Sharing Start -->

    <?php if ( get_option( 'lobo_show_share', 'enabled' ) == 'enabled' ) : ?>

    <section class="share-wdgt">
        <div class="header">

            <?php if ( get_option( 'lobo_share_bg' ) != '' ) : ?>
            <figure><img src="<?php echo aq_resize( get_option( 'lobo_share_bg' ), '570', '292', true ); ?>" alt="<?php echo bloginfo( 'name' ); ?>"></figure>
            <?php endif; ?>

            <span><?php _e( 'Share', 'lobo' ); ?></span>

            <ul class="share-btns face-control">

                <?php 

                	wp_reset_query();
                    global $post;

                    if ( isset( $post ) ) {

	                    $url = urlencode( get_permalink( $post->ID ) );
	                    $title = urlencode( get_the_title( $post->ID ) );
	                    $media = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
                    } else {

                    	$url = get_bloginfo( 'url' );
                    	$title = get_bloginfo( 'name' );
                    	$media = array('');
                    	
                    }

                ?>

                <li><a class="shr-btn btn-twitter" href="https://twitter.com/home?status=<?php echo $title; ?>+<?php echo $url; ?>" title="<?php _e( 'Share on Twitter', 'lobo' ); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                <li><a class="shr-btn btn-facebook" href="https://www.facebook.com/share.php?u=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="<?php _e( 'Share on Facebook', 'lobo' ); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                <li><a class="shr-btn btn-gplus" href="https://plus.google.com/share?url=<?php echo $url; ?>" title="<?php _e( 'Share on Google Plus', 'lobo' ); ?>" target="_blank"><i class="icon-gplus"></i></a></li>
                <li><a class="shr-btn btn-pinterest" href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $media[0]; ?>&amp;url=<?php echo $url; ?>&amp;is_video=false&amp;description=<?php echo $title; ?>" title="<?php _e( 'Share on Pinterest', 'lobo' ); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                <li><a class="shr-btn btn-tumblr" href="http://www.tumblr.com/share/link?url=<?php echo $url; ?>&amp;name=<?php echo $url; ?>" title="<?php _e( 'Share on Tumblr', 'lobo' ); ?>" target="_blank"><i class="icon-tumblr-1"></i></a></li>
                <li><a class="shr-btn btn-reddit" href="http://www.reddit.com/submit?url=<?php echo $url; ?>" title="<?php _e( 'Share on Reddit', 'lobo' ); ?>" target="_blank"><i class="icon-reddit"></i></a></li>
                <li><a class="shr-btn btn-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="<?php _e( 'Share on Linkedin', 'lobo' ); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
            </ul>
        </div>
    </section>

	<?php endif; ?>

    <!-- Sharing End -->

	<!--[if lt IE 7]>
		<p class="browsehappy"><?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'lobo' ); ?></p>
	<![endif]-->

	<!-- No Scripts Message -->
	<noscript id="scriptie">
		<div>
			<p><?php _e('This is a modern website which will require Javascript to work. <br />Please turn it on!', 'lobo'); ?>
			</p>
		</div>
	</noscript>

    <!-- THE END -->

	<?php wp_footer(); ?>

</body>
</html>