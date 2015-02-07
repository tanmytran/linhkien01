<?php
/**
 * Template Name: Default Template With Exposed Title
 * 
 * @package Webmarket
 */
?>

<?php get_header(); ?>
	
	<div class="container">
		<div class="push-up blocks-spacer">
			<div class="row">

				<?php get_template_part( 'titlearea' ); ?>

				<?php
					$sidebar = get_post_meta( get_the_ID() , 'sidebar_position', true );

					if ( "no" == $sidebar ) {
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
				
				<?php if ( "right" == $sidebar ) { ?>
				<aside class="span4 right-sidebar" role="complementary">
					<?php dynamic_sidebar( 'regular-page-sidebar' ); ?>
				</aside>
				<?php } ?>
				
			</div><!-- /row -->
		</div>
	</div><!-- /container -->

<?php get_footer(); ?>
