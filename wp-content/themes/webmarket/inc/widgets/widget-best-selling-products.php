<?php
/**
 * Best Selling Products
 * ========================
 * Grid of the best selling products
 *
 * @extends WC_Widget_Best_Sellers
 * @see wp-content/plugins/woocommerce/classes/widgets/class-wc-widget-best-sellers.php
 *
 * @package Webmarket
 */

function register_best_selling_products_widget() {
	if ( is_woocommerce_active() ) {
		class Best_Selling_Products_Widget extends WC_Widget {

			/**
			 * Register widget with WordPress.
			 */

			public function __construct() {
				$this->widget_cssclass    = 'proteusthemes_widget_best_products';
				$this->widget_description = __( 'Grid of the best selling products for the home page', 'proteusthemes' );
				$this->widget_id          = 'woocommerce_best_selling_proteus';
				$this->widget_name        = __( 'Webmarket: Best Selling Products', 'proteusthemes' );
				$this->settings           = array(
					'title'  => array(
						'type'  => 'text',
						'std'   => __( 'Products', 'woocommerce' ),
						'label' => __( 'Title', 'woocommerce' )
					),
					'number' => array(
						'type'  => 'number',
						'step'  => 1,
						'min'   => 1,
						'max'   => '',
						'std'   => 5,
						'label' => __( 'Number of products to show', 'woocommerce' )
					)
				);
				parent::__construct();
			}

			/**
			 * Front-end display of widget.
			 *
			 * @see WP_Widget::widget()
			 *
			 * @param array $args     Widget arguments.
			 * @param array $instance Saved values from database.
			 */
			public function widget( $args, $instance ) {
				global $woocommerce;
				extract( $args );
				$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
				$number      = absint( $instance['number'] );
				if ( !$number = (int) $instance['number'] )
					$number = 10;
				else if ( $number < 1 )
					$number = 1;
				else if ( $number > 15 )
					$number = 15;

				$query_args = array(
					'posts_per_page' => $number,
					'post_status' 	 => 'publish',
					'post_type' 	 => 'product',
					'meta_key' 		 => 'total_sales',
					'orderby' 		 => 'meta_value_num',
					'no_found_rows'  => 1,
				);

				$query_args['meta_query'] = $woocommerce->query->get_meta_query();

				if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
					$query_args['meta_query'][] = array(
						'key'     => '_price',
						'value'   => 0,
						'compare' => '>',
						'type'    => 'DECIMAL',
					);
				}

				$r = new WP_Query($query_args);
				?>

				<div class="span12">
					<div class="row">
						<div class="span12">
							<?php echo $before_title; ?><?php echo lighted_title( $title ); ?><?php echo $after_title; ?>
						</div>
					</div>

					<div class="row popup-products blocks-spacer">

						<?php

						if ($r->have_posts()) :

							$count = 0;
							 while ($r->have_posts()) { $r->the_post();
							 global $product; global $post;

								// divider every 4
								if ( $count !== 0 && $count % 4 === 0 ) {
									echo '<div class="clearfix"></div>';
								}
								$count++;

						?>

						<!--  = Product =  -->
						<div class="span3">
							<div class="product">
								<div class="product-inner">
									<div class="product-img">
										<div class="picture">
											<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?></a>
											<div class="img-overlay">
												<a class="btn more btn-primary" href="<?php the_permalink(); ?>"><?php _e( "More" , 'proteusthemes'); ?></a>
												<?php webmarket_return_add_to_cart_button($product); ?>
											</div>
										</div>
									</div>
									<div class="main-titles no-margin">
										<h4 class="title">
										<?php if ( $price_html = $product->get_price_html() ) :?>
												<?php echo $price_html;?>
										<?php endif; ?>
										</h4>
										<h5 class="no-margin"><?php the_title();?></h5>
									</div>
									<p class="desc"><?php echo strip_tags( get_the_excerpt() ); ?></p>
									<p class="center-align stars">
									<?php

										if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {

											$counter = $product->get_rating_count();

											if ( $counter > 0 ) {

												$average = round( $product->get_average_rating() );

												$empty_stars = 5 - $average;

												for ($i=0; $i < $average; $i++) {
													echo ' <i class="fa fa-star stars-clr"></i> ';
												}

												for ($e=0; $e < $empty_stars; $e++) {
													echo ' <i class="fa fa-star"></i> ';
												}

											}

										}

									?>
									</p>
								</div>

							</div>
						</div> <!-- /product -->

						<?php
							}
						 endif;
						?>

					</div>


				</div><!-- /span12 -->

				<?php
				wp_reset_postdata();
				// echo $out;
			}

		} // class Best_Selling_Products_Widget
		register_widget( "Best_Selling_Products_Widget" );
	}
}
add_action( 'widgets_init', 'register_best_selling_products_widget', 11 );
