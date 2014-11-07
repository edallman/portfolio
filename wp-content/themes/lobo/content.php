<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>

	<?php global $post_i; ?>

		<article class="post-item <?php echo $post_i++ % 2 == 0 ? 'even' : 'odd'; ?>">

            <div class="inner-post">

                <header class="post-header">
                    <span class="post-date"><time pubdate datetime="<?php the_time( 'c' ); ?>"><?php the_time( __( 'jS \o\f\ F Y', 'lobo' ) ); ?></time><span class="isu"><i class="timer-hr"></i><?php __( 'issue', 'lobo' ) . lobo_post_no( $post_i ); ?></span></span>
                    <h2 class="post-title"><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                </header>

                <footer>
                    <span class="read-btn"><a href="<?php echo get_permalink(); ?>"><?php _e( 'Read Article', 'lobo' ); ?> -</a></span>
                </footer>

            </div>

            <span class="post-overlay"></span>

            <?php if ( has_post_thumbnail() ) {

                $thumb = get_post_thumbnail_id( $post->ID );
                $img_url = wp_get_attachment_url( $thumb, 'full' );

                switch ( get_option( 'lobo_blog_cols', '3' ) ) {

                	case '1':
                		$img = aq_resize( $img_url, '1600', '1600', true, false );
                		break;

                	case '2':
                		$img = aq_resize( $img_url, '800', '800', true, false );
                		break;

                	case '4':
                		$img = aq_resize( $img_url, '400', '400', true, false );
                		break;

                	case '5':
                		$img = aq_resize( $img_url, '320', '320', true, false );
                		break;
                	
                	default:
                		$img = aq_resize( $img_url, '560', '560', true, false );

                }

                echo '<img src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '" alt="' . get_the_title() . '" class="post-feat-img" />';
         
            } ?>

        </article>