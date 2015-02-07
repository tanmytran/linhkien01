<?php 
/**
 * Single blogpost or any other default single entry
 *
 * @package Webmarket
 */
?>

	<?php get_header(); ?>
	<div class="container">
		<div class="push-up top-equal blocks-spacer">
			<div class="row">

				<?php get_template_part( 'titlearea' ); ?>

				<?php
					$sidebar = get_post_meta( get_the_ID() , 'sidebar_position', true );


					if( 'as_blog' === $sidebar || empty( $sidebar ) ) {
						$sidebar = get_post_meta( absint( get_option( 'page_for_posts' ) ), 'sidebar_position', true );
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
				
				<div class="span<?php echo $main_class_span; ?>" role="main">
					<?php
						if( have_posts() ) :
						the_post();
					?> 


					<article <?php echo post_class( 'clearfix' ); ?>>
						<div class="post-inner">
							<?php get_template_part( 'content', 'title' ); ?>
							
							<div class="the-content">
								<?php the_content(); ?> 
							</div>

							<?php
								$args = array(
									'before'      => '<div class="bold align-center clearfix">' . __( 'Pages:' , 'proteusthemes') . ' &nbsp; ',
									'after'       => '</div>',
									'link_before' => '<span class="btn btn-primary">',
									'link_after'  => '</span>',
									'echo'        => 1
								);
								wp_link_pages( $args );
							?>
						</div>
					</article>

					<?php
						endif;
					?> 

					<hr />


					<?php comments_template(); ?> 


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
