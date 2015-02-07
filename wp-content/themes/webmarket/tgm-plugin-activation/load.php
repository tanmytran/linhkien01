<?php
/**
 * Loading the remote and local plugins when the theme is activated
 *
 * @package	   TGM-Plugin-Activation
 * @subpackage Example
 * @version	   2.3.6
 * @author	   Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author	   Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license	   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     => 'Revolution Slider',
			'slug'     => 'revslider',
			'source'   => 'revslider.zip',
			'required' => true,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true,
		),
		array( // http://gndev.info/shortcodes-ultimate/
			'name'     => 'Shortcodes Ultimate',
			'slug'     => 'shortcodes-ultimate',
			'required' => true,
		),
		array( // http://gndev.info/shortcodes-ultimate/
			'name'     => 'Custom Sidebars',
			'slug'     => 'custom-sidebars',
			'required' => false,
		),
		array( // http://wordpress.org/plugins/woocommerce/
			'name'     => 'WooCommerce - excelling eCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array( // http://wordpress.org/plugins/widget-importer-exporter/
			'name'     => 'Widget Importer & Exporter',
			'slug'     => 'widget-importer-exporter',
			'required' => false,
		),

	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'proteusthemes';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'           => $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path'     => trailingslashit( dirname( __FILE__ ) ) . 'plugins/',							// Default absolute path to pre-packaged plugins
		'parent_menu_slug' => 'themes.php', 				// Default parent menu slug
		'parent_url_slug'  => 'themes.php', 				// Default parent URL slug
		'menu'             => 'install-required-plugins', 	// Menu slug
		'has_notices'      => true,                       	// Show admin notices or not
		'is_automatic'     => true,					   	// Automatically activate plugins after installation or not
		'message'          => ''						// Message to output right before the plugins table
	);

	tgmpa( $plugins, $config );
}