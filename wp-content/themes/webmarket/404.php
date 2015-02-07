<?php get_header(); ?>
	
	<div class="container">
		<div class="push-up blocks-spacer">
			<div class="row">
				
				<article class="span12">
					<p class="container-404">
						<img src="<?php echo get_template_directory_uri() . '/assets/images/404.png'; ?>" alt="<?php _e( 'Error 404' , 'proteusthemes'); ?>" width="394" height="161" />
					</p>
					
					<hr />
					
					<p class="center-align size-16">
						<?php _e( 'Looks like something went wrong! The page you were looking for is not here.' , 'proteusthemes'); ?>
					</p>
					<p class="center-align size-16 push-down-50">
						<?php printf( _x( 'Go %sHome%s or try to search:', '%s is for the link to home page, wrap the word Home in two %s' , 'proteusthemes'), '<a href="' . site_url() . '">', '</a>' ); ?>
					</p>
					
					<div class="row">
						<div class="span4 offset4">
							<div class="sidebar-item widget_search">
								<?php echo get_search_form(); ?>
							</div>
						</div>
					</div>
					
				</article> <!-- /main content -->

			</div>
		</div>
	</div>

<?php get_footer(); ?>
