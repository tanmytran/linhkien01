<?php
/**
 * Main blog page
 *
 * @package Webmarket
 */

	get_header();

	global $woocommerce;


?>

	<div class="container">
		<div class="push-up top-equal blocks-spacer">
			<div class="row">

				<?php get_template_part( 'titlearea' ); ?>

				<?php
					$page_id = absint( get_option( 'page_for_posts' ) );

					if( 0 === $page_id ) {
						$sidebar = 'right';
					} else {
						$sidebar = get_post_meta( $page_id, 'sidebar_position', true );
					}

					if ( "no" == $sidebar ) {
						$main_class_span = 12;
					} else {
						$main_class_span = 8;
					}

					if ( "left" == $sidebar ) {
				?>
				<aside class="span4 left-sidebar" role="complementary">
					<?php dynamic_sidebar( 'blog-sidebar' ); ?>
				</aside>
				<?php } ?>

				<div class="blog span<?php echo $main_class_span; ?>" role="main">
					<?php
						if( have_posts() ) :
						while( have_posts() ) :
						the_post();
					?>


					<article <?php echo post_class( 'clearfix' ); ?>>
						<div class="post-inner">
							<?php get_template_part( 'content', 'title' ); ?>

							<div class="the-content">
								<?php the_content( sprintf( '<span class="btn btn-primary bold higher read-more">%s</span>', __('Continue reading' , 'proteusthemes') ) ); ?>
							</div>

							<?php if ( strlen( get_the_title() ) < 1 ) : ?>
									<a href="<?php the_permalink(); ?>"><?php _e( 'Link to this post', 'proteusthemes' ); ?></a>
							<?php endif; ?>
						</div>
					</article>

					<?php
						endwhile;
						endif;
					?>

					<hr />

					<?php kriesi_pagination(); ?>

				</div><!-- /blog -->

				<?php if ( "right" == $sidebar ) { ?>
				<aside class="span4 right-sidebar" role="complementary">
					<?php dynamic_sidebar( 'blog-sidebar' ); ?>
				</aside>
				<?php } ?>

			</div><!-- /row -->
		</div>
	</div><!-- /container -->

<?php get_footer(); ?>
