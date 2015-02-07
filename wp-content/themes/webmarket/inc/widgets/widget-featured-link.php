<?php
/**
 * Featured link widget
 * ====================
 * Featured links are used at the top of the front page
 *
 * @package Webmarket
 */

class Featured_Link_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			false, // ID, auto generate when false
			__( "Webmarket: Featured Link" , 'proteusthemes'), // Name
			array(
				'description' => __( 'Featured links usually used at the top of the front page' , 'proteusthemes')
			)
		);

		// color picker needed
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
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
		$title    = $instance['title'];
		$subtitle = $instance['subtitle'];
		?>

		<?php echo $before_widget; ?>
			<a href="<?php echo $instance['link']; ?>" class="btn btn-block banner" style="color: <?php echo $instance['text_color']; ?>; background: <?php echo $instance['bg_color']; ?>;">
				<span class="title"><?php echo lighted_title( $title ); ?></span>
				<?php if ( ! empty( $subtitle ) ) { ?>
					<em><?php echo $subtitle; ?></em>
				<?php } ?>
			</a>
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

		$instance['title']      = wp_kses_post( $new_instance['title'] );
		$instance['subtitle']   = wp_kses_post( $new_instance['subtitle'] );
		$instance['link']       = esc_url( $new_instance['link'] );
		$instance['text_color'] = esc_html( $new_instance['text_color'] );
		$instance['bg_color']   = esc_html( $new_instance['bg_color'] );


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
		$title      = isset( $instance['title'] ) ? $instance['title'] : 'Summer Sale';
		$subtitle   = isset( $instance['subtitle'] ) ? $instance['subtitle'] : 'up to 60% off on all shoes';
		$link       = isset( $instance['link'] ) ? $instance['link'] : 'http://www.proteusthemes.com';
		$text_color = isset( $instance['text_color'] ) ? $instance['text_color'] : '#ffffff';
		$bg_color   = isset( $instance['bg_color'] ) ? $instance['bg_color'] : '#BABABA';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'proteusthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle:' , 'proteusthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' , 'proteusthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
		</p>

		<script type="text/javascript">
			jQuery('document').ready(function ($) {
				$('.js-attach-color-picker').wpColorPicker();
			});
		</script>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php _e( 'Text Color:' , 'proteusthemes'); ?></label> <br>
			<input class="js-attach-color-picker" id="<?php echo $this->get_field_id( 'text_color' ); ?>" name="<?php echo $this->get_field_name( 'text_color' ); ?>" type="text" value="<?php echo esc_attr( $text_color ); ?>" data-default-color="<?php echo esc_attr( $text_color ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php _e( 'Background Color:' , 'proteusthemes'); ?></label> <br>
			<input class="js-attach-color-picker" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" data-default-color="<?php echo esc_attr( $bg_color ); ?>" />
		</p>

		<?php
	}

} // class Featured_Link_Widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Featured_Link_Widget" );' ) );
