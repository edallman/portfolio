<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<section class="content-module post-wrapper clearfix">

            <div class="the-post">

                <aside class="aside-left one-fifth clearfix">

                    <div class="meta">

                        <div class="meta-author">

                            <figure class="avatar"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php echo __( 'Posts written by', 'lobo' ) . ' ' . get_the_author_meta( 'display_name' ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), ( isset( $retina ) && $retina === 'true' ? 256 : 128 ), $default='' ); ?></a>
                            </figure>

                           	<div class="author-post-meta">
                               <span class="post-date"><time pubdate datetime="<?php the_time( 'c' ); ?>"><?php the_time( __( 'jS \o\f\ F Y', 'lobo' ) ); ?></time></span>
                               <span class="post-author-profile"><small><?php _e( 'written by', 'lobo' ); ?></small><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php _e( 'Author Profile', 'lobo' ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a></span>

                           	</div>

                        </div>

                    </div>

                </aside>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry three-fifth last' ); ?>>

					<div class="post-body">

						<h2><?php the_title(); ?></h2>

						<div class="post-excerpt">

						<?php 

							the_content();
							wp_link_pages( array(
								'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'lobo' ) . '</span>'
								)
							);

                            the_tags();

						?>

						</div>

					</div>

				</article>

			</div>

			<?php if( comments_open() )
				comments_template( '', true ); ?>

			<?php 
				$next_post = get_next_post();
				$prev_post = get_previous_post();
			?>

            <div class="pagination clearfix face-control">

                <div class="prev-post">

                <?php if ( ! empty( $next_post ) ) : ?>
                
                    <a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo $next_post->post_title; ?>">
                        <div class="pagination-inner">
                            <small><?php _e( 'Previous Post', 'lobo' ); ?></small>
                            <?php echo $next_post->post_title; ?>
                        </div>
                    </a>

                <?php endif; ?>

                </div>

                <div class="next-post">

            	<?php if ( ! empty( $prev_post ) ) : ?>

                    <a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo $prev_post->post_title; ?>">
                        <div class="pagination-inner">
                            <small><?php _e( 'Next Post', 'lobo' ); ?></small>
                            <?php echo $prev_post->post_title; ?>
                        </div> 
                    </a>

                <?php endif; ?>

                </div>

            </div>

            <div class="call-to-action-btn face-control">
                <a href="<?php echo get_permalink( get_option( 'lobo_blog_page' ) ); ?>" title="<?php _e( 'Back to Blog', 'lobo' ); ?>"><?php _e( 'Back to Posts', 'lobo' ); ?></a>
            </div>

	<?php endwhile; ?>

<?php get_footer(); ?>