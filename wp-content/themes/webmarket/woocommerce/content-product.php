<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

$classes[] = 'span3';


// webmarket sidebar settings
$sidebar = webmarket_get_shop_sidebar();

$clearfix_every = 'no' === $sidebar ? 4 : 3;

if ( 1 !== $woocommerce_loop['loop'] &&  1 === $woocommerce_loop['loop'] % $clearfix_every ) {
	echo "<div class='clearfix'></div>";
}

?>


<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="product-inner">
		<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
		<div class="product-img">
			<div class="picture">
				<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?></a>
				<div class="img-overlay">
					<a class="btn more btn-primary" href="<?php the_permalink(); ?>"><?php _e( 'More', 'proteusthemes' ); ?></a>
					<?php webmarket_return_add_to_cart_button( $product ); ?>
				</div>
			</div>
		</div>
		<div class="main-titles no-margin">
			<h4 class="title">
				<?php if ( $price_html = $product->get_price_html() ) :?>
					<?php echo $price_html;?>
				<?php endif; ?>
			</h4>
			<h5 class="no-margin isotope--title"><?php the_title(); ?></h5>
		</div>
		<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>
		<p class="center-align stars">
			<?php
				$count = $product->get_rating_count();

				if ( $count > 0 ) {
					$average = round( $product->get_average_rating() );

					$empty_stars = 5 - $average;

					for ( $i=0; $i < $average; $i++ ) {
						echo ' <i class="fa fa-star stars-clr"></i> ';
					}

					for ( $i=0; $i < $empty_stars; $i++ ) {
						echo ' <i class="fa fa-star"></i> ';
					}
				}
			?>
		</p>
		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</div> <!-- /single product -->