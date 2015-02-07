<?php
/**
 * WooCommerce functions file
 *
 * @package Webmarket
 */

if ( is_woocommerce_active() ) {

	// remove all the woocommerce CSS
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	// Delete page title for WooCommerce pages
	add_filter( 'woocommerce_show_page_title', '__return_false' );


	/**
	 * Theme compatibility
	 *
	 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);



	/**
	 * Missing HTML markup before and after the shop items
	 */
	add_action('woocommerce_before_main_content', 'webmarket_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'webmarket_theme_wrapper_end', 10);

	function webmarket_theme_wrapper_start() {
		?>
		<div class="container">
			<div class="push-up blocks-spacer">
				<div class="row">

					<?php

						$sidebar = webmarket_get_shop_sidebar();

						if ( "no" == $sidebar || empty( $sidebar ) ) {
							$main_class_span = 12;
						} else {
							$main_class_span = 9;
						}

						if ( "left" == $sidebar ) :
					?>
					<aside class="span3 left-sidebar" role="complementary">
						<?php dynamic_sidebar( is_product() ? 'single-product-sidebar' : 'shop-page-sidebar' ); ?>
					</aside>
					<?php
						endif; // $sidebar
					?>

					<div class="span<?php echo $main_class_span; ?>" role="main">

						<div class="underlined push-down-20">
							<div class="row">

								<div class="span<?php echo $main_class_span - 5; ?>">
									<h3><?php echo lighted_title( woocommerce_page_title( false ) );?></h3>
								</div>

								<div class="span5 align-right sm-align-left">
									<?php if ( function_exists( 'woocommerce_catalog_ordering' ) ): ?>
										<?php woocommerce_catalog_ordering(); ?>
									<?php endif ?>
								</div>
							</div>
						</div>

						<div class="woocommerce">
		<?php
	}

	function webmarket_theme_wrapper_end() {

		$sidebar = webmarket_get_shop_sidebar();

		?>
						</div><!-- /.webmarket-woocommerce -->
					</div><!-- /page -->

					<?php
						if ( "right" == $sidebar ) :
					?>
					<aside class="span3 right-sidebar" role="complementary">
						<?php dynamic_sidebar( is_product() ? 'single-product-sidebar' : 'shop-page-sidebar' ); ?>
					</aside>
					<?php
						endif; // $sidebar
					?>

				</div><!-- /row -->
			</div>
		</div><!-- /container -->
		<?php
	}


	/**
	 * Removes the confusing body.woocommerce so it is easier and more
	 * reliable to target the elements within WooCommerce implementation
	 *
	 * @param  array $classes
	 * @return array
	 */
	function webmarket_woo_body_class( $classes ) {
		$classes = (array) $classes;
		$key = array_search( 'woocommerce', $classes );

		if ( $key ) {
			unset( $classes[ $key ] );
		}

		return $classes;
	}
	add_filter( 'body_class', 'webmarket_woo_body_class', 11 );


	/**
	 * Custom sale badge
	 */
	function webmarket_custom_sale_flash() {
		return '<div class="stamp green">' . __( 'Sale!', 'proteusthemes' ) . '</div>';
	}
	add_filter( 'woocommerce_sale_flash', 'webmarket_custom_sale_flash', 10, 0 );


	/**
	 * Remove add to cart after filter
	 */
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	/**
	 * Remove the woocommerce sidebar
	 */
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/**
	 * Remove breadcrumbs on the products archive page
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


	/**
	 * Moved the results count between grid and pagination
	 */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 9 );

	/**
	 * Remove the default catalog ordering
	 */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


	/**
	 * Remove rating in the title of the product
	 */
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );


	/**
	 * Remove the sale badge for the single product
	 */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );


	/**
	 * Filters for my account page - for titles
	 */
	add_action( 'woocommerce_my_account_my_orders_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_downloads_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_address_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_address_title', 'lighted_title' );



	/**
	 * Display custom number of products per page
	 * @param  integer $cols
	 * @return integer
	 */
	function custom_number_of_products_per_page( $cols ) {
		return intval( get_single_theme_mod( 'products_per_page', $cols ) );
	}
	add_filter( 'loop_shop_per_page', 'custom_number_of_products_per_page', 20 );



	// Returns correct ADD TO CART button link for different product types
	function webmarket_return_add_to_cart_button( $product ) {

		$link = array(
			'url'   => '',
			'label' => '',
			'class' => ''
		);

		$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

		switch ( $handler ) {
			case "variable" :
				$link['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'proteusthemes') );
			break;
			case "grouped" :
				$link['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'proteusthemes') );
			break;
			case "external" :
				$link['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= apply_filters( 'external_add_to_cart_text', __( 'Read More', 'proteusthemes') );
			break;
			default :
				if ( $product->is_purchasable() ) {
					$link['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
					$link['label'] 	= apply_filters( 'add_to_cart_text', __( 'Add to cart', 'proteusthemes') );
					$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
				} else {
					$link['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
					$link['label'] 	= apply_filters( 'not_purchasable_text', __( 'Read More', 'proteusthemes') );
				}
			break;
		}

		echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s btn buy btn-danger product_type_%s">%s</a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), esc_html( $link['label'] ) ), $product, $link );

	}


	/**
	 * Get the position of the sidebar for the shop pages, conditionally for the single product
	 */
	function webmarket_get_shop_sidebar() {
		if ( is_product() ) {
			return get_theme_mod( 'single_product_sidebar', 'no' );
		} else {
			return get_post_meta( (int)get_option( 'woocommerce_shop_page_id' ) , 'sidebar_position', true );
		}
	}



	/**
	 * Since price slider widget is pulled in the custom filters widget, we need to enqueue scripts for that widget as well
	 * The only way to do this was to extend the existing class from WC
	 *
	 * @since 2.2.1
	 * @see includes/class-wc-query.php
	 */

	if ( class_exists( 'WC_Query' ) ) {
		class Webmarket_WC_Query extends WC_Query {
			public function __construct() {
				parent::__construct();
				add_action( 'init', array( $this, 'webmarket_layered_nav_init' ) );
				add_action( 'init', array( $this, 'webmarket_price_filter_init' ) );
			}

			/**
			 * Layered Nav Init for custom widget
			 *
			 * @copied from includes/class-wc-query.php
			 */
			public function webmarket_layered_nav_init( ) {

				if ( is_active_widget( false, false, 'webmarket_price_filter', true ) && ! is_admin() ) {

					global $_chosen_attributes;

					$_chosen_attributes = array();

					$attribute_taxonomies = wc_get_attribute_taxonomies();
					if ( $attribute_taxonomies ) {
						foreach ( $attribute_taxonomies as $tax ) {

							$attribute       = wc_sanitize_taxonomy_name( $tax->attribute_name );
							$taxonomy        = wc_attribute_taxonomy_name( $attribute );
							$name            = 'filter_' . $attribute;
							$query_type_name = 'query_type_' . $attribute;

							if ( ! empty( $_GET[ $name ] ) && taxonomy_exists( $taxonomy ) ) {

								$_chosen_attributes[ $taxonomy ]['terms'] = explode( ',', $_GET[ $name ] );

								if ( empty( $_GET[ $query_type_name ] ) || ! in_array( strtolower( $_GET[ $query_type_name ] ), array( 'and', 'or' ) ) )
									$_chosen_attributes[ $taxonomy ]['query_type'] = apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
								else
									$_chosen_attributes[ $taxonomy ]['query_type'] = strtolower( $_GET[ $query_type_name ] );

							}
						}
					}

					add_filter('loop_shop_post_in', array( $this, 'layered_nav_query' ) );
				}
			}

			/**
			 * Price filter Init for custom widget
			 *
			 * @copied from includes/class-wc-query.php
			 */
			public function webmarket_price_filter_init() {
				if ( is_active_widget( false, false, 'webmarket_price_filter', true ) && ! is_admin() ) {

					$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

					wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );

					wp_localize_script( 'wc-price-slider', 'woocommerce_price_slider_params', array(
						'currency_symbol' => get_woocommerce_currency_symbol(),
						'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
						'min_price'       => isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
						'max_price'       => isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : ''
					) );

					add_filter( 'loop_shop_post_in', array( $this, 'price_filter' ) );
				}
			}
		}
		return new Webmarket_WC_Query();
	}

} // is_woocommerce_active