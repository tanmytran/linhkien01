<?php
/**
 * Shortcodes for Webmarket WP theme defined
 *
 * @package Webmarket
 */



/**
 * Adds the light class to the titles in the content (for subtitles)
 * @param  array $atts    
 * @param  string $content 
 * @return string HTML
 */
function sc_light( $atts, $content ) {
	return '<span class="light">' . $content . '</span>';
}
add_shortcode( "light", "sc_light" );



/**
 * Shortcode for zocial icons
 * @param  array $atts    
 * @return string HTML
 */
function sc_zocial( $atts ) {
	extract( shortcode_atts( array( 
		'service' => 'acrobat'
	), $atts ) );
	return '<span class="zocial-' . strtolower( $service ) . '"></span>';
}
add_shortcode( "zocial", "sc_zocial" );



/**
 * Shortcode for Font Awesome
 * @param  array $atts    
 * @return string HTML
 */
function sc_font_awesome( $atts ) {
	extract( shortcode_atts( array( 
		'icon' => 'glass'
	), $atts ) );
	return '<i class="fa fa-' . strtolower( $icon ) . '"></i>';
}
add_shortcode( "font_awesome", "sc_font_awesome" );