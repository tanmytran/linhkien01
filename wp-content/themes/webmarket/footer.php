<?php
/**
 * The template for displaying the footer
 *
 * @package Webmarket
 */
?>

	<footer>
				
		<div class="foot-light">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer-sidebar-top' ); ?>
				</div>
			</div>
		</div>

		<div class="foot-dark">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer-sidebar-bottom' ); ?>
				</div>
			</div>
		</div>
		

		<div class="foot-last">
			<a href="#" id="toTheTop">
				<span class="fa fa-chevron-up"></span>
			</a>
			<div class="container" role="contentinfo">
				<div class="row">
					<div class="span6">
						<?php echo ot_get_option( 'footer_left', '&copy; Copyright 2013' ); ?>
					</div>
					<div class="span6">
						<div class="pull-right">
							<?php echo ot_get_option( 'footer_right', 'Webmarket Theme by <a href="http://www.proteusthemes.com">ProteusThemes</a>' ); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	
	</footer>

	</div><!-- /.master-wrapper -->


<?php echo ot_get_option('footer_scripts', ''); ?>

<?php wp_footer(); ?>
<!-- W3TC-include-js-body-end -->
</body>
</html>