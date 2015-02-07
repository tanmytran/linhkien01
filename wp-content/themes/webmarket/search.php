<?php 
/**
 * Archive pages - the same as index.php, but with the excerpt instead of content
 *
 * @package Webmarket
 */

	get_header();

?>

	<div class="container">
		<div class="push-up top-equal blocks-spacer">
			<div class="row">

				<?php get_template_part( 'titlearea' ); ?>

				<?php
					$sidebar = get_post_meta( absint( get_option( 'page_for_posts' ) ), 'sidebar_position', true );
					
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
								<?php the_excerpt(); ?>

								<a href="<?php the_permalink(); ?>" class="btn btn-primary bold higher uppercase"><?php _e('Continue Reading' , 'proteusthemes'); ?></a>
							</div>
							
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
