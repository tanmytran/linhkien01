<?php
/**
 * Meta Boxes for various data
 *
 * @package Webmarket
 */


add_action( 'admin_init', 'custom_meta_boxes' );

function custom_meta_boxes() {
	if ( ! function_exists( 'ot_register_meta_box' ) ) {
		return;
	}

	// default array of data
	$default = array(
		'id'       => 'webmarket_options',
		'title'    => __( 'Webmarket Options' , 'proteusthemes'),
		'desc'     => __( 'Options specific to Webmarket theme' , 'proteusthemes'),
		'pages'    => array(),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array()
	);

	// page
	$meta_box_data = array_replace_recursive( $default, array(
		'pages'  => array( 'page' ),
		'fields' => array(
			array(
				'id'      => 'sidebar_position',
				'label'   => __( 'Position of the sidebar' , 'proteusthemes'),
				'desc'    => __( 'Position the sidebar for this particular page to the left, right or do not display it at all.' , 'proteusthemes'),
				'std'     => 'right',
				'type'    => 'radio',
				'class'   => '',
				'choices' => array(
					array(
						'value' => 'right',
						'label' => __( 'Right' , 'proteusthemes')
					),
					array(
						'value' => 'left',
						'label' => __( 'Left' , 'proteusthemes')
					),
					array(
						'value' => 'no',
						'label' => __( 'No sidebar' , 'proteusthemes')
					),
				)
			),
			array(
				'id'      => 'revo_slider_alias',
				'label'   => __( 'Slider Revolution alias' , 'proteusthemes'),
				'desc'    => __( 'Only applies to the templates "Front Page with Revolution Slider" and "Front page with Content". Paste the alias of the slider you created in the Revolution Slider plugin to this box (only <a href="https://www.diigo.com/item/image/3rli1/s9bj?size=o" target="_blank">alias</a>, not the whole shortcode).' , 'proteusthemes'),
				'std'     => '',
				'type'    => 'text',
				'class'   => '',
				'choices' => array()
			),
		)
	));
	ot_register_meta_box( $meta_box_data );


	// post/single
	$meta_box_data = array_replace_recursive( $default, array(
		'pages'    => array( 'post' ),
		'fields'   => array(
			array(
				'id'      => 'sidebar_position',
				'label'   => __( 'Position of the sidebar' , 'proteusthemes'),
				'desc'    => __( 'Position the sidebar for this particular post to the left, right or do not display it at all.' , 'proteusthemes'),
				'std'     => 'as_blog',
				'type'    => 'radio',
				'class'   => '',
				'choices' => array(
					array(
						'value' => 'as_blog',
						'label' => __( 'Default (the same as blog layout)' , 'proteusthemes')
					),
					array(
						'value' => 'right',
						'label' => __( 'Right' , 'proteusthemes')
					),
					array(
						'value' => 'left',
						'label' => __( 'Left' , 'proteusthemes')
					),
					array(
						'value' => 'no',
						'label' => __( 'No sidebar' , 'proteusthemes')
					),
				)
			),
		)
	));

	ot_register_meta_box( $meta_box_data );
}