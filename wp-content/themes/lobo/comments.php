<?php
/**
 * Comments template
 */
?>

<?php if ( post_password_required() ) : ?>
	<div class="post-excerpt"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'lobo' ); ?></div>
<?php
		return;
	endif;
?>

    <div id="comments">

        <div class="comments-wrapper">

            <div class="comments-header">

			<?php if ( ! comments_open() ) : ?>

				<p><?php _e( 'Comments are closed.', 'lobo' ); ?></p>

			<?php else : ?>

		        <span class="comments-count">
		        	<?php echo get_comments_number(); ?>
		        	<small><?php comments_number( __( 'Comments', 'lobo' ), __( 'Comment', 'lobo' ), __( 'Comments', 'lobo' ) ); ?></small>
		        </span>
		        <a href="#respond" class="read-comments-btn"><?php _e( 'Leave a reply', 'lobo' ); ?></a>
				<h3 id="comments-title"></h3>

			<?php endif; ?>

			</div>

			<ol class="comment-list"><?php wp_list_comments( array( 'callback' => 'lobo_comment' ) ); ?></ol>

			<?php paginate_comments_links(); ?>

			<?php 
				
				$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', array(

					'author' => '<div class="respond-field"><label for="autor" class="screen-reader">' . __( 'Name *', 'lobo' ) . '</label><input id="author" name="author" placeholder="' . __( 'Name', 'lobo' ) . '" type="text" value="" class="respond-name" required="" /></div>',
					'email'  => '<div class="respond-field"><label for="email" class="screen-reader">' . __( 'Email *', 'lobo' ) . '</label><input id="email" name="email" placeholder="' . __( 'Email', 'lobo' ) . '" type="text" value="" class="respond-mail" required="" /></div>',
					'url'    => '<input id="url" name="url" type="text" value="" style="display: none !important" />' ) ),
					'comment_field' => '<div class="respond-comment"><span class="comment-cursor"></span><label for="comment" class="screen-reader">' . __( 'Comment *', 'lobo' ) . '</label><textarea id="comment" name="comment" placeholder="" type="text" class="respond-comment" required=""></textarea></div>',
					'must_log_in' => '<p style="margin-bottom:25px" class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'lobo' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
					'logged_in_as' => '<p style="margin-bottom:25px" class="logged-in-as">' . sprintf( __( 'You are logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) , 'lobo') . '</p>',
					'comment_notes_before' => '',
					'comment_notes_after' => '<span class="submit-btn-helper">' . __( 'Your comment', 'lobo' ) . '</span><small class="submit-caption">' . __( '(click button to send)', 'lobo' ) . '</small>',
					'id_form' => 'comment-form',
					'id_submit' => 'submit',
					'title_reply' => __( 'Leave a comment', 'lobo' ),
					'title_reply_to' => __( 'Leave a reply to %s', 'lobo' ),
					'cancel_reply_link' => __( 'Cancel reply', 'lobo' ),
					'label_submit' => __( 'Submit Comment', 'lobo' )

				); 

				// Modify the structure of the contact form through these actions
				
				function lobo_form_before( ) {
					echo '<div class="respond-form"><aside class="aside-gridder one-fifth clearfix"></aside><div class="respond-inner three-fifth last">';
				}
				add_action( 'comment_form_before', 'lobo_form_before' );
				
				function lobo_form_after( ) {
					echo '</div></div>';
				}
				add_action( 'comment_form_after', 'lobo_form_after' );

				// We can now output the form
				
				comment_form( $defaults ); 
				
			?>
		</div>

	</div>

	
<?php

	// This is the function which outputs an individual comment

	function lobo_comment( $comment, $args, $depth ) {

		global $retina;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>

	        <div class="comment-wrapper">

		        <aside class="aside-gridder one-fifth clearfix"></aside>

		            <div class="comment-inner three-fifth last">

		                <div class="avatar">
		                    <div class="comment-author"><?php comment_author(); ?></div>
		                    <div class="comment-author-overlay"></div>
		                    <?php echo get_avatar( $comment, ( isset( $retina ) && $retina === 'true' ? 256 : 128 ), $default='' ); ?>
		                </div>

                        <div class="comment-author-wrap vcard">
                            <div class="comment-time">
                                <a href="<?php echo get_permalink(); ?>/#comment-<?php comment_ID(); ?>">
                                    <span class="screen-reader"><?php _e( 'Permalink to comment', 'lobo' ); ?></span>#</a>
                                    <time pubdate="" datetime="<?php the_time( 'c' ); ?>"><?php comment_time( __( 'F j Y', 'lobo' ) ); ?></time>
                            </div>
                        </div>

                        <div class="comment-body">

							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em class="await"><?php _e( 'Your comment is awaiting moderation.', 'lobo' ); ?></em>
							<?php endif; ?>

							<?php comment_text(); ?>

							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 2, 'reply_text' => __( 'Reply', 'lobo') ) ) ); ?>

						</div>

					</div>

				</aside>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'lobo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'lobo'), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;

	}

?>