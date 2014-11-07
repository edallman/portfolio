<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container clearfix" itemprop="reviews" itemscope itemtype="http://schema.org/Review">

		<div class="rating-meta">

            <?php echo get_avatar( $comment, ( isset( $retina ) && $retina === 'true' ? 256 : 128 ), $default='' ); ?>

			<strong itemprop="author"><?php comment_author(); ?></strong> 

			<?php

				if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )

					if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) )

						echo '<em class="verified">(' . __( 'verified owner', 'lobo' ) . ')</em> ';

			?>

			<time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( __( 'jS M Y', 'lobo' ) ); ?></time>

		</div>

		<div class="rating-content">

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) :

				switch ( $rating ) {

					case '5':
						$rating_word = __( 'Perfect', 'lobo' );
						break;

					case '4':
						$rating_word = __( 'Good', 'lobo' );
						break;

					case '3':
						$rating_word = __( 'Average', 'lobo' );
						break;

					case '2':
						$rating_word = __( 'Not that bad', 'lobo' );
						break;

					case '1':
						$rating_word = __( 'Very Poor', 'lobo' );
						break;

				}

				echo '<p class="rating-word">' . $rating_word . '</p>';

			endif; ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>

		</div>

	</div>
