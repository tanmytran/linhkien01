<?php
/**
 * Template Name: Front Page with Slider Revolution
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
						<?php dynamic_sidebar( 'home-row-1' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="boxed-area blocks-spacer">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( 'home-row-2' ); ?>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<?php dynamic_sidebar( 'home-row-3' ); ?>
		</div>
	</div>


<?php
	$display_latest_news = get_single_theme_mod( 'display_latest_news' );
	if( "no" !== $display_latest_news ) {
		get_template_part( 'darkstripe' );
	}
?> 

	
	<div class="container blocks-spacer-last">
	
		<?php dynamic_sidebar( 'home-under-news' ); ?>
		
		<!--  = Title =  -->
		<div class="row">
			<div class="span12">
				
			</div>
		</div> <!-- /logos -->

	</div><!-- /container -->
	

<?php get_footer(); ?>
