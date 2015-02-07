<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="meta">

		<span class="tag"><?php echo $product->get_price_html(); ?></span>

		<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
		<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
		<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
		<?php
			$show_stock_btns = get_theme_mod( 'show_stock_btns', 'yes' );

			if ( 'no' !== $show_stock_btns ) :
		?>
		<span class="stock">
			<span class="btn btn-<?php echo $product->is_in_stock() ? 'success' : 'danger'; ?> bold uppercase"><?php echo $product->is_in_stock() ? __( 'In stock' , 'proteusthemes') : __( 'Out of Stock' , 'proteusthemes'); ?></span>
		</span>
		<?php endif; ?>
	</div>
</div><!-- starts in title.php -->