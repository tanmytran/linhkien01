<?php
/**
 * Template Name: Front Page with Content
 *
 * @package Webmarket
 */


	// WP header
	get_header();


	/**
	 * Call the slider
	 */
	$alias = get_post_meta( get_the_ID() , 'revo_slider_alias', true );
	$has_slider = false;
	if ( function_exists( 'putRevSlider' ) && ! empty( $alias ) ) {
		putRevSlider( $alias );
		$has_slider = true;
	}
?>

	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="<?php echo $has_slider ? 'push-up over-slider' : 'not-over-slider'; ?> blocks-spacer">
					<div class="row">
						<?php
							$sidebar = get_post_meta( get_the_ID() , 'sidebar_position', true );

							if ( "no" == $sidebar || empty( $sidebar ) ) {
								$main_class_span = 12;
							} else {
								$main_class_span = 8;
							}
							
							if ( "left" == $sidebar ) :
						?>
						<aside class="span4 left-sidebar" role="complementary">
							<?php dynamic_sidebar( 'regular-page-sidebar' ); ?>
						</aside>
						<?php
							endif; // $sidebar
						?>
						
						<div class="span<?php echo $main_class_span; ?>" role="main">
							<?php
								if( have_posts() ) :
								the_post();
							?>


							<article <?php echo post_class( 'clearfix' ); ?>>
								<div class="underlined push-down-20">
									<h3><?php echo lighted_title( get_the_title() ); ?></h3>
								</div>

								<div class="the-content">
									<?php the_content(); ?>
								</div>
							</article>

							<?php
								endif; // have_posts
							?>

							<hr />

							<?php comments_template(); ?> 

						</div><!-- /page -->
						
						<?php 
							if ( "right" == $sidebar ) : 
						?>
						<aside class="span4 right-sidebar" role="complementary">
							<?php dynamic_sidebar( 'regular-page-sidebar' ); ?>
						</aside>
						<?php
							endif; // $sidebar
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
