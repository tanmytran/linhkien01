<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

// sidebars
$sidebar = webmarket_get_shop_sidebar();
$available_spans = 'no' === $sidebar ? 12 : 9;

if ( ! empty( $tabs ) ) : ?>

	<div class="blocks-spacer">
		<!--  = Tabs with more info =  -->
		<div class="row">
			<div class="span<?php echo $available_spans; ?>">
				<ul class="nav nav-tabs">
					<?php
					$tabs_counter = 1;
					foreach ( $tabs as $key => $tab ) : ?>

						<li<?php echo $tabs_counter === 1 ? " class='active'" : ''; ?>>
							<a data-toggle="tab" href="#product-tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
						</li>

					<?php
					$tabs_counter++;
					endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php
					$c = 1;
					foreach ( $tabs as $key => $tab ) : ?>

						<div class="fade tab-pane <?php if( $c == 1 ): echo " in active"; endif; ?>" id="product-tab-<?php echo $key ?>">
							 <?php call_user_func( $tab['callback'], $key, $tab ) ?>
						</div>

					<?php
					$c++;
					endforeach; ?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>