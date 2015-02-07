<?php
/**
 * Search form for the top menu
 *
 * @package Webmarket
 */
?>
<form role="search" class="navbar-form pull-right" action="<?php echo home_url( '/' ); ?>" method="get">
	<button type="submit"><i class="fa fa-search"></i></button>
	<input type="text" class="span1 js-nav-search" name="s">
	<?php if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) : ?>
	<input type="hidden" name="post_type" value="product">
	<?php endif ?>
</form>