<?php
/**
 * Filters for Webmarket WP theme
 *
 * @package Webmarket
 */


 
/**
 * Add the .light classes to the titles
 */
function customized_title( $title ) {
	if ( ! is_admin() ) {
		return lighted_title( $title );
	} else {
		return $title;
	}
		
}
// add_filter( "the_title", "customized_title" );




/**
 * Make widget titles as all the other titles are - first word normal, other bold
 */
add_filter( "widget_title", "lighted_title" );


/**
 * Change excerpt length
 */
function webmarket_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'webmarket_excerpt_length', 999 );



/**
 * Add custom menu walker to all the menus
 */
function bootstrap_menu_walker( $args ) {
	return array_merge( $args, array(
		'walker' => new Webmarket_Navwalker(),
	) );
}
add_filter( 'wp_nav_menu_args', 'bootstrap_menu_walker' );



/**
 * Add shortcodes in widgets
 */
add_filter( 'widget_text', 'do_shortcode' );



/**
 * Remove the gallery inline styling 
 */
// add_filter( 'use_default_gallery_style', '__return_false' );


function add_disabled_editor_buttons($buttons) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'hr';

	return $buttons;
}
add_filter('mce_buttons', 'add_disabled_editor_buttons');




/**
* Filter to modify original shortcodes data
*
* @param array $shortcodes Basic plugin shortcodes
* @return array Modified array
*/
function modify_su_buttons( $shortcodes ) {
	unset( $shortcodes['button']['atts']['target'] );
	$shortcodes['tabs']['atts']['style']['values']['filled-tabs'] = 'Filled Tabs';
	// Return modified data
	return $shortcodes;
}
add_filter( 'su/data/shortcodes', 'modify_su_buttons' );