<?php
/**
 * Shop Category Filters
 *
 * @package Webmarket
 */

function register_shop_category_filter_widget() {
	if ( is_woocommerce_active() ) {
		class Shop_Category_Filter extends WP_Widget {
			/**
			 * Register widget with WordPress.
			 */
			public function __construct() {
				parent::__construct(
					'webmarket_price_filter', // ID, auto generate when false
					_x( 'Webmarket: Shop Filters', 'backend', 'proteusthemes' ), // Name
					array(
						'description' => _x( 'Use this widget only on the Shop Filter Sidebar of the Webmarket theme. With this widget you enable users to filter products by category, price and custom attributes.', 'backend', 'proteusthemes' ),
						'classname'   => 'sidebar-filters'
					)
				);
			}

			/**
			 * Print out the widget HTML on frontend
			 * @return void
			 */
			public function widget( $args, $instance ) {

				// global  variables
				global $woocommerce,
					$_chosen_attributes,
					$_attributes_array,
					$wpdb,
					$wp_query,
					$wp;

				// arguments
				extract( $args );

				// title
				$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

				$title_categories = wp_kses_post( $instance['title_categories'] );
				$title_prices     = wp_kses_post( $instance['title_prices'] );

				$show_categories  = intval( $instance['show_categories'] );
				$show_prices      = intval( $instance['show_price'] );

				$filter_btn_txt   = wp_kses_post( $instance['filter_btn_txt'] );

				// opening HTML
				echo $before_widget;

				if ( ! empty( $instance['title'] ) ) {
					echo $before_title . $instance['title'] . $after_title;
				}

				$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );

				?>
				<form action="<?php echo $shop_page_url; ?>" class="js--filter-form-webmarket" method="GET">

					<div style="hide" class="js--filter-form-webmarket-fields"></div>

				<?php

					// Show HTML for categories filter with checkboxes
					if ( $show_categories ) {
						$this->categories_filter_html( $title_categories );
					}


					// Price slider data
					if ( $show_prices ) {
						$this->price_slider_filter_html( $title_prices );
					}


					// Custom attributes
					$attribute_taxonomies = wc_get_attribute_taxonomies();

					foreach ( $attribute_taxonomies as $single_attribute ) {
						$this->single_attribute_filter_html( $instance, $single_attribute );
					}
				?>
					<button type="submit" class="btn btn-primary btn-block bold higher uppercase"><?php echo $filter_btn_txt; ?></button>
				</form>

				<?php

				// closing HTML
				echo $after_widget;
			}

			/**
			 * Echo the HTML needed to display hierarchial checkboxes for advanced filters
			 *
			 * @param  string $title_categories
			 * @todo should be implemented with wp_list_categories
			 * @see class-wc-widget-product-categories.php
			 * @since  2.2.1
			 * @return void
			 */
			private function categories_filter_html( $title_categories ) {
					global $wp_query;

					// Categories
					$product_categories = get_terms( 'product_cat', array(
						'orderby'    => 'post_title',
						'hide_empty' => false,
						'parent'     => 0
					) );
					$selected_term = get_queried_object();
					// TODO $selected_term = $queried_object = get_queried_object();

					if ( isset ( $selected_term->term_id ) ) {
						$selected_term_id = $selected_term->term_id;
					} else {
						$selected_term_id = 0;
					}

				?>
					<!--  = Categories =  -->
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#filterOne"><?php echo $title_categories; ?> <b class="caret"></b></a>
						</div>
						<div id="filterOne" class="accordion-body collapse in">
							<div class="filter-attribute" data-attribute="product_cat"></div><!-- /.filter-attribute -->
							<div class="accordion-inner"
							>
							<?php
								echo '<ul class="categories-checkboxes  js--categories-checkboxes">';

								locate_template( 'inc/class-product-cat-checkboxes-walker.php', true, true );

								wp_list_categories( array(
									'show_count' => true,
									'taxonomy'   => 'product_cat',
									'title_li'   => '',
									'walker'     => new Product_Cat_Checkboxes_Walker()
								) );

								echo '</ul>';
							?>
							</div>
						</div>
					</div> <!-- /categories -->
				<?php
			}

			/**
			 * Echo HTML for the price range filter, rather than reimplementing ours, we parse the needed HTML from the woocommerce widget
			 *
			 * @since 2.2.1
			 * @see class-wc-widget-price-filter.php
			 * @return void
			 */
			private function price_slider_filter_html( $title_prices ) {

				// title and before UI slider
				?>
					<!--  = Prices slider =  -->
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#filterPrices"><?php echo $title_prices; ?> <b class="caret"></b></a>
						</div>
						<div id="filterPrices" class="accordion-body in collapse">
							<div class="accordion-inner with-slider">

				<?php

				// start getting the HTML
				ob_start();

				// display dummy original woocommerce price filter
				the_widget( 'WC_Widget_Price_Filter', array(
				'title' => 'internal title'), array(
					'name'          => 'internal sidebar',
					'id'            => 'internal-sidebar',
					'description'   => '',
					'class'         => 'internal-widget',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => ''
				) );

				$html = ob_get_clean();

				// take care for the utf8 encodings
				$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>' . $html . '</body></html>';

				if ( ! empty( $html ) ) {
					// create the DOM document
					$dom = new DOMDocument;
					$dom->loadHTML( $html );
					$xpath = new DOMXpath( $dom );
					$slider = $xpath->query("//*[@class='price_slider_wrapper']");

					if ( ! is_null( $slider ) ) {
						foreach ( $slider as $item ) {
							$tmp_dom = new DOMDocument();
							$tmp_dom->appendChild( $tmp_dom->importNode( $item, true ) );
							$html = $tmp_dom->saveHTML();
						}
					}

					// remove all hidden <input> fields
					$html = preg_replace( '/<input.+?type="hidden".+?>/i', '', $html );

				} else {
					$html = __( 'No price to filter', 'proteusthemes' );
				}

				echo $html;

				// after UI slider
				?>
							</div>
						</div>
					</div> <!-- /prices slider -->
				<?php

			}


			/**
			 * Echo HTML for the single custom attribute filter
			 *
			 * @since 2.2.1
			 * @return void
			 */
			private function single_attribute_filter_html( $instance, $single_attribute ) {
				$show_attribute = isset( $instance['show_' . $single_attribute->attribute_name] ) ? intval( $instance['show_' . $single_attribute->attribute_name] ) : 0;

				if( 1 !== $show_attribute )
					return;

				$attribute_title        = wp_kses_post( $instance['title_' . $single_attribute->attribute_name] );
				$active_filter          = isset( $_GET['filter_' . $single_attribute->attribute_name] ) ? esc_attr( $_GET[ 'filter_' . $single_attribute->attribute_name ] ) : '';
				$active_filter_exploded = explode(",", $active_filter);
				$taxonomy               = wc_attribute_taxonomy_name( $single_attribute->attribute_name );

				if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) )
					return;

				$taxonomy = wc_attribute_taxonomy_name( $single_attribute->attribute_name );

				if ( ! taxonomy_exists( $taxonomy ) )
					return;

				$terms = get_terms( $taxonomy, array( 'hide_empty' => '0' ) );

			?>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle <?php if ( ! isset( $_GET['filter_' . $single_attribute->attribute_name ]) ) { echo ' collapsed'; } ?>" data-toggle="collapse" href="#filterAttr-<?php echo $single_attribute->attribute_id; ?>"><?php echo $attribute_title; ?> <b class="caret"></b></a>
					</div>
					<div id="filterAttr-<?php echo $single_attribute->attribute_id; ?>" class="accordion-body<?php if ( isset( $_GET['filter_' . $single_attribute->attribute_name ]) ) { echo ' in'; } ?> collapse">
						<div class="accordion-inner">
							<input type="hidden" value="or" name="query_type_<?php echo $single_attribute->attribute_name; ?>" />

							<div class="filter-attribute" data-attribute="filter_<?php echo $single_attribute->attribute_name; ?>"></div>
							<?php
								foreach ( $terms as $term ):
							?>

								<div class="control-group">
									<div class="controls">
										<label class="checkbox">
											<input <?php checked( in_array( $term->term_id, $active_filter_exploded ) ); ?>type="checkbox" data-attribute="filter_<?php echo $single_attribute->attribute_name; ?>" value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?>
										</label>
									</div>
								</div>

							<?php
								endforeach;
							?>

						</div>
					</div>
				</div> <!-- /size filter -->
				<?php
			}


			/**
			 * Sanitize and save the data to DB
			 *
			 * @return array Updated safe values to be saved.
			 */
			public function update( $new_instance, $old_instance ) {

				$attribute_taxonomies = wc_get_attribute_taxonomies();

				$instance                     = $old_instance;
				$instance['title']            = wp_kses_post( $new_instance['title'] );
				$instance['title_categories'] = wp_kses_post( $new_instance['title_categories'] );
				$instance['title_prices']     = wp_kses_post( $new_instance['title_prices'] );
				$instance['show_categories']  = intval( $new_instance['show_categories'] );
				$instance['show_price']       = intval( $new_instance['show_price'] );
				$instance['filter_btn_txt']   = wp_kses_post( $new_instance['filter_btn_txt'] );

				foreach ( $attribute_taxonomies as $attribute ) {
					$instance['title_' . $attribute->attribute_name] = wp_kses_post( $new_instance['title_' . $attribute->attribute_name] );
					$instance['show_' . $attribute->attribute_name]  = intval( $new_instance['show_' . $attribute->attribute_name] );
				};

				return $instance;
			}

			/**
			 * Back-end widget form.
			 */
			public function form( $instance ) {
				$attribute_taxonomies = wc_get_attribute_taxonomies();

				$default_variables = array(
					'title'            => 'Shop Filters',
					'title_categories' => 'Categories',
					'title_prices'     => 'Price',
					'show_categories'  => '1',
					'show_price'       => '1',
					'filter_btn_txt'   => 'Filter Products'
				);

				foreach ( $attribute_taxonomies as $attribute ) {
					$default_variables['title_' . $attribute->attribute_name] = $attribute->attribute_name;
					$default_variables['show_' . $attribute->attribute_name]  = '1';
				}

				$instance = wp_parse_args( (array)$instance, $default_variables );

				?>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex( 'Title:', 'backend', 'proteusthemes' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<hr />

				<p>
					<label for="<?php echo $this->get_field_id( 'title_categories' ); ?>"><?php _ex( 'Title for categories filter:', 'backend', 'proteusthemes' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title_categories' ); ?>" name="<?php echo $this->get_field_name( 'title_categories' ); ?>" type="text" value="<?php echo esc_attr( $instance['title_categories'] ); ?>" />
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'show_categories' ); ?>" name="<?php echo $this->get_field_name( 'show_categories' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_categories'], '1' ); ?> /> <label for="<?php echo $this->get_field_id( 'show_categories' ); ?>"><?php _ex( 'Show categories filter', 'backend', 'proteusthemes' ); ?></label>
				</p>

				<hr />

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex( 'Title for price slider filter:', 'backend', 'proteusthemes' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title_prices' ); ?>" name="<?php echo $this->get_field_name( 'title_prices' ); ?>" type="text" value="<?php echo esc_attr( $instance['title_prices'] ); ?>" />
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'show_price' ); ?>" name="<?php echo $this->get_field_name('show_price'); ?>" type="checkbox" value="1" <?php checked( $instance['show_price'], '1' ); ?> /> <label for="<?php echo $this->get_field_id('show_price'); ?>"><?php _ex( 'Show price slider filter', 'backend', 'proteusthemes' ); ?></label>
				</p>

				<hr />

				<?php
					foreach ( $attribute_taxonomies as $attribute ) :
				?>
						<p>
							<label for="<?php echo $this->get_field_id( 'title_' . $attribute->attribute_name ); ?>"><?php _ex( 'Title for attribute:', 'backend', 'proteusthemes' ); ?> <strong><?php echo $attribute->attribute_name; ?></strong></label>
							<input class="widefat" id="<?php echo $this->get_field_id( 'title_' . $attribute->attribute_name ); ?>" name="<?php echo $this->get_field_name( 'title_' . $attribute->attribute_name ); ?>" type="text" value="<?php echo esc_attr( $instance['title_' . $attribute->attribute_name] ); ?>" />
						</p>
						<p>
							<input id="<?php echo $this->get_field_id( 'show_' . $attribute->attribute_name ); ?>" name="<?php echo $this->get_field_name( 'show_' . $attribute->attribute_name ); ?>" type="checkbox" value="1" <?php checked( $instance['show_' . $attribute->attribute_name], '1' ); ?> /> <label for="<?php echo $this->get_field_id( 'show_' . $attribute->attribute_name ); ?>"><?php _ex( 'Show filter for attribute:', 'backend', 'proteusthemes'); ?> <strong><?php echo $attribute->attribute_name; ?></strong></label>
						</p>

						<hr />

				<?php
					endforeach;
				?>

				<p>
					<label for="<?php echo $this->get_field_id( 'filter_btn_txt' ); ?>"><?php _ex( 'Filter button text:', 'backend', 'proteusthemes' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'filter_btn_txt' ); ?>" name="<?php echo $this->get_field_name( 'filter_btn_txt' ); ?>" type="text" value="<?php echo esc_attr( $instance['filter_btn_txt'] ); ?>" />
				</p>

				<?php
			}

		} // class Show_Category_Filter
		register_widget( "Shop_Category_Filter" );
	}
}
add_action( 'widgets_init', 'register_shop_category_filter_widget', 11 );