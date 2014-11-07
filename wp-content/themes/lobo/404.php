<?php
/**
 * 404 Page Template
 */
get_header(); ?>

		<section class="content-module post-wrapper clearfix">

            <div class="the-post">

				<article id="error-404" class="hentry four-fifth last">

					<div class="post-body">

						<h2><?php _e( 'Uh oh! (404 Error)', 'lobo' ); ?></h2>

						<div class="post-excerpt">
							<h4><?php _e( 'We are really sorry but the page you requested is missing :(', 'lobo' ); ?></h4>
						</div>
						
						<a class='btn-back-404 btn' href="javascript:javascript:history.go(-1)">← <? _e('Go Back','lobo'); ?></a>

					</div>

				</article>

			</div>

		</section>

	<?php rewind_posts(); ?>

<?php get_footer(); ?>