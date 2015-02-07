<?php
/**
 * Helper file for the breadcrumbs
 *
 * @package Webmarket
 */


if(
	! is_page_template( 'front-template.php' ) &&
	! is_page_template( 'front-template-page.php' )
) :
?>
	<div class="darker-stripe">
		<div class="container">
			<div class="row">
				<div class="span12">
					<?php
						if ( is_woocommerce_active() && is_woocommerce() && function_exists( 'woocommerce_breadcrumb' ) ) {
							woocommerce_breadcrumb( array(
								'delimiter'   => ' <li><span class="fa fa-chevron-right"></span></li> ',
								'wrap_before' => '<ul class="breadcrumb">',
								'wrap_after'  => '</ul>',
								'before'      => ' <li>',
								'after'       => '</li> ',
								'home'        => __( 'Home Page', 'proteusthemes' )
							) );
						} else {
							echo dimox_breadcrumbs();
						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
	endif;
?>