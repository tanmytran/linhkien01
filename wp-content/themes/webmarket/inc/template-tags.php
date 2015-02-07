<?php
/**
 * Cart dropdown in the main menu. Gets inserted with AJAX on page load
 *
 * @package Webmarket
 */


add_filter( 'add_to_cart_fragments', 'webmarket_add_to_cart_fragments' );
function webmarket_add_to_cart_fragments( $fragments ) {
	$fragments['.js--cart-container'] = webmarket_add_to_cart_dropdown();
	return $fragments;
}

function webmarket_add_to_cart_dropdown() {
	ob_start();

	?>
	<div class="cart-container  js--cart-container" id="cartContainer">

		<div class="cart">
			<p class="items"><?php _e( 'CART' , 'proteusthemes'); ?> <span class="dark-clr">(<?php echo WC()->cart->cart_contents_count; ?>)</span></p>
			<p class="dark-clr hidden-tablet"><?php echo WC()->cart->get_cart_subtotal(); ?></p>
			<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="btn btn-danger">
				<i class="fa fa-shopping-cart"></i>
			</a>
		</div>
		<div class="open-panel">

		<?php
			if ( 0 === sizeof( WC()->cart->cart_contents ) ) :
				echo '<p class="empty">'.__('No products in the cart.','woocommerce', 'proteusthemes').'</p>';
			else :
				$i = -1;
				foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) :
					$i++;

					if ( $i > 3 ) :
					?>
						<div class="item-in-cart clearfix">
							<h5 class="titles  align-center  no-margin">
								<a href="<?php echo WC()->cart->get_cart_url(); ?>"><?php printf( __( 'And %d more', 'proteusthemes' ), sizeof( WC()->cart->cart_contents ) - 4 ); ?></a>
							</h5>
						</div>

						<?php
						break;
					endif; // $i > 3

					$_product = $values['data'];
					if ( $_product->exists() && $values['quantity'] > 0 ) :
		?>

			<div class="item-in-cart clearfix">
				<div class="image">
				<?php
					$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );

					if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) ) {
						echo $thumbnail;
					} else {
						printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
					}
				?>
				</div>
				<div class="desc">
					<strong>
						<?php
							if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) ) {
								echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
							} else {
								printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );
							}

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) ) {
								echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' , 'proteusthemes') . '</p>';
							}
						?>
					</strong>
					<span class="light-clr qty">
						<?php _e( "Qty:" , 'proteusthemes'); ?> <?php echo $values['quantity']; ?>
						&nbsp;
						<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="fa fa-times-circle js-cart-item-remove" title="%s"></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce', 'proteusthemes') ), $cart_item_key ); ?>
					</span>
				</div>
				<div class="price">
					<strong>
						<?php
							$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();

							echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
						?>
					</strong>
				</div>
			</div><!-- /.item-in-cart -->

		<?php
					endif; // $_product->exists() && $values['quantity'] > 0
				endforeach; // WC()->cart->get_cart() as $cart_item_key => $values
		?>
			<div class="summary">
				<div class="line">
					<div class="row-fluid">
						<div class="span6"><?php _e( "Subtotal:" , 'proteusthemes'); ?></div>
						<div class="span6 align-right size-16"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
					</div>
				</div>
			</div>
			<div class="proceed">
				<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="btn btn-danger pull-right bold higher"><?php _e( "CHECKOUT" , 'proteusthemes');?> <i class="icon-shopping-cart"></i></a>
				<small><?php echo get_theme_mod( 'text_shipping_cart', 'Shipping costs are calculated based on location. <a href="http://webmarket.demo.proteusthemes.com">More information.</a>' ); ?></small>
			</div>
		<?php
			endif;
		?>

		</div>
	</div>
	<?php

	$html = ob_get_clean();

	return $html;
}