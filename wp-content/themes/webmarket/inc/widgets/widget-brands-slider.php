<?php
/**
 * Brands Slider Widget
 * ====================
 * Slider for the brands on the front page
 *
 * @package Webmarket
 */

class Brands_Slider_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			false, // ID, auto generate when false
			__( "Webmarket: Brands Slider" , 'proteusthemes'), // Name
			array(
				'description' => __( 'Slider of the brands for the front page' , 'proteusthemes')
			),
			array( 'width' => 400 )
		);
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
		extract( $args );
		$title   = $instance['title'];
		$content = $instance['content'];
		?>
		
		<?php echo $before_widget; ?>
			<div class="main-titles lined">
				<h2 class="title"><?php echo lighted_title( $title ); ?></h2>
				<div class="arrows">
					<a href="#" class="fa fa-chevron-left" id="<?php echo $widget_id; ?>Left"></a>
					<a href="#" class="fa fa-chevron-right" id="<?php echo $widget_id; ?>Right"></a>
				</div>
			</div>
			<div class="brands carouFredSel" data-nav="<?php echo $widget_id; ?>" data-autoplay="true">
				<?php echo $content; ?>
			</div>
		<?php echo $after_widget; ?>

		<?php

		// echo $out;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['content'] = wp_kses_post( $new_instance['content'] );


		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title   = isset( $instance['title'] ) ? $instance['title'] : __( 'Summer Sale' , 'proteusthemes');
		$content = isset( $instance['content'] ) ? esc_textarea( $instance['content'] ) : <<<EOH
<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrrazbccoqoqc" alt="Dummy Logo" width="203" height="104" />

<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrrczbccoqoqd" alt="Dummy Logo" width="203" height="104" />

<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrrdzbccoqoqe" alt="Dummy Logo" width="203" height="104" />

<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrrpzbccoqoqo" alt="Dummy Logo" width="203" height="104" />

<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrrqzbccoqoqp" alt="Dummy Logo" width="203" height="104" />

<img src="https://www.diigo.com/item/p/pdbsqoszbsbsqbrqrzbccoqoqb" alt="Dummy Logo" width="203" height="104" />
EOH;

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'proteusthemes'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>

		<?php
	}

} // class Brands_Slider_Widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Brands_Slider_Widget" );' ) );

