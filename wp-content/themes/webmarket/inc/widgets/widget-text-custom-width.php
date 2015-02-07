<?php
/**
 * Home Page any width column
 *
 * @package Webmarket
 */


class Home_Text_Custom_Width extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			false, // ID, auto generate when false
			__( "Webmarket: Custom Width Text For Home Page" , 'proteusthemes'), // Name
			array(
				'description' => __( 'Use this widget only on the home page of the Webmarket theme. With this widget you can specify custom width of the text.' , 'proteusthemes'),
			),
			array( 'width' => 400 )
		);
	}

	public function widget( $args, $instance ) {
		$text = apply_filters( 'widget_text', empty( $instance['content'] ) ? '' : $instance['content'], $instance );
		extract( $args );

		?>
		<div class="span<?php echo $instance['num_columns'] ?>">
			<div class="blocks-spacer">
				<?php echo $before_title; ?>
				<?php
					$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
					echo $instance['title'];
				?>
				<?php echo $after_title; ?>
				<div class="textwidget">
					<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
				</div>
			</div>
		</div>
		<?php
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
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['content'] =  $new_instance['content'];
		else
			$instance['content'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['content']) ) ); // wp_filter_post_kses() expects slashed
		$instance['num_columns'] = (int)$new_instance['num_columns'];
		$instance['filter'] = isset($new_instance['filter']);
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
		$instance    = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '' ) );
		$title       = strip_tags( $instance['title'] );
		$content     = esc_textarea($instance['content']);
		$num_columns = isset( $instance['num_columns'] ) ? (int)$instance['num_columns'] : 6;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'proteusthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('num_columns'); ?>"><?php _e('Number of columns:', 'proteusthemes'); ?></label>
			<select id="<?php echo $this->get_field_id('num_columns'); ?>" name="<?php echo $this->get_field_name('num_columns'); ?>">
				<?php for ($i=1; $i < 13; $i++) : ?>
					<option value="<?php echo $i; ?>" <?php selected( $num_columns, $i ); ?>><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs', 'proteusthemes'); ?></label></p>
		<?php
	}

} // class Home_Three_Columns
add_action( 'widgets_init', create_function( '', 'register_widget( "Home_Text_Custom_Width" );' ) );


