<?php
/**
 * Featured Products Widget
 * ========================
 * Slider of the featured products
 *
 * @extends WC_Widget_Featured_Products
 * @see wp-content/plugins/woocommerce/classes/widgets/class-wc-widget-featured-products.php
 *
 * @package Webmarket
 */

function register_featured_products_widget() {
	if ( is_woocommerce_active() ) {
		class Featured_Products_Widget extends WC_Widget {

			/**
			 * Register widget with WordPress.
			 */

			public function __construct() {
				$this->widget_cssclass    = 'proteusthemes_widget_featured_products';
				$this->widget_description = __( 'Slider of the featured products for the home page' , 'proteusthemes' );
				$this->widget_id          = 'woocommerce_featured_proteus';
				$this->widget_name        = __( 'Webmarket: Featured Products Slider' , 'proteusthemes' );
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

				$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );

				$query_args['meta_query'] = $woocommerce->query->get_meta_query();
				$query_args['meta_query'][] = array(
					'key' => '_featured',
					'value' => 'yes'
				);

				$r = new WP_Query($query_args);
				?>

				<div class="span12">
					<div class="blocks-spacer">
						<div class="main-titles lined">
							<h2 class="title"><?php echo lighted_title( $title ); ?></h2>
							<div class="arrows">
								<a href="#" class="fa fa-chevron-left" id="<?php echo $widget_id; ?>Left"></a>
								<a href="#" class="fa fa-chevron-right" id="<?php echo $widget_id; ?>Right"></a>
							</div>
						</div>



						<!--  = Carousel =  -->
						<div class="carouFredSel" data-autoplay="false" data-nav="<?php echo $widget_id; ?>">
							<div class="slide">
								<div class="row">

									<?php

									if ($r->have_posts()) :

										$count = 0;
										 while ($r->have_posts()) { $r->the_post();
											global $product; global $post;

											// every 3 products make a break for a new slide
											if ( 0 !== $count && $count % 3 === 0 ) {
												echo '</div></div><div class="slide"><div class="row">';
											}

									?>
									<!--  = Product =  -->
									<div class="span4">
										<div class="product">
											<div class="product-img featured">
												<div class="picture">
													<a href="<?php the_permalink(); ?>"><?php echo $product->get_image(); ?></a>
													<div class="img-overlay">
														<a href="<?php echo esc_url( get_permalink( $r->post->ID ) ); ?>" class="btn more btn-primary"><?php _e( "More" , 'proteusthemes');?></a>
														<?php webmarket_return_add_to_cart_button( $product ); ?>
													</div>
												</div>
											</div>
											<div class="main-titles">
												<h4 class="title">
													<?php if ( $price_html = $product->get_price_html() ) :?>
															<?php echo $price_html;?>
													<?php endif; ?>
												</h4>
												<h5 class="no-margin"><?php if ( $r->post->post_title ) echo get_the_title( $r->post->ID ); else echo $r->post->ID; ?></h5>
											</div>
											<p class="desc"><?php echo strip_tags( get_the_excerpt() ); ?></p>
										</div>
									</div> <!-- /product -->
									<?php
										$count++;
										} // while
									endif; /// have pstss
									?>

								</div>
							</div>
						</div> <!-- /carousel -->
					</div>
				</div><!-- /span12 -->

				<?php
				wp_reset_postdata();
				// echo $out;
			}

		} // class Featured_Products_Widget
		register_widget( "Featured_Products_Widget" );
	}
}
add_action( 'widgets_init', 'register_featured_products_widget', 11 );
