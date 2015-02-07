<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @package Webmarket
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class Webmarket_Customize {

	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	*
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*
	* @see add_action('customize_register',$func)
	*/
	public static function register ( $wp_customize ) {
		/**
		 * Settings
		 */

		// styles
		$wp_customize->add_setting( 'webmarket[theme_primary_clr]', array( 'default' => '#00becc' ) );
		$wp_customize->add_setting( 'webmarket[theme_secondary_clr]', array( 'default' => '#e54b5d' ) );
		$wp_customize->add_setting( 'webmarket[logo_img]', array( 'default' => '' ) );
		$wp_customize->add_setting( 'webmarket[favicon]', array( 'default' => '' ) );
		$wp_customize->add_setting( 'webmarket[boxed]', array( 'default' => 'no' ) );
		$wp_customize->add_setting( 'webmarket[bg_pattern]', array( 'default' => '' ) );

		// titles
		$wp_customize->add_setting( 'webmarket[show_tagline]', array( 'default' => 'yes' ) );
		$wp_customize->add_setting( 'webmarket[blog_title]', array( 'default' => 'Webmarket Blog' ) );
		$wp_customize->add_setting( 'webmarket[blog_tagline]', array( 'default' => 'Where smart people write dumb things' ) );
		$wp_customize->add_setting( 'webmarket[shop_sidebar_title]', array( 'default' => 'Shop by Filters' ) );

		// front page
		$wp_customize->add_setting( 'webmarket[display_latest_news]', array( 'default' => 'yes' ) );

		// shop
		$wp_customize->add_setting( 'webmarket[shop_sidebar_position]', array( 'default' => 'left' ) );
		$wp_customize->add_setting( 'webmarket[products_per_page]', array( 'default' => '15' ) );
		$wp_customize->add_setting( 'single_product_sidebar', array( 'default' => 'no' ) );
		$wp_customize->add_setting( 'show_stock_btns', array( 'default' => 'yes' ) );
		$wp_customize->add_setting( 'text_shipping_cart', array( 'default' => 'Shipping costs are calculated based on location. <a href="http://webmarket.demo.proteusthemes.com">More information.</a>' ) );

		// social icons
		$wp_customize->add_setting( 'webmarket[icons_new_window]', array( 'default' => 'no' ) );
		$social_networks = array( 'android', 'appstore', 'blogger', 'dribbble', 'email', 'facebook', 'flickr', 'instagram', 'linkedin', 'pinterest', 'rss', 'skype', 'tumblr', 'twitter', 'vimeo', 'yelp', 'youtube', 'googleplus' );
		sort( $social_networks );

		foreach ($social_networks as $social_network) {
			$wp_customize->add_setting( 'webmarket[zocial_' . $social_network . ']', array( 'default' => '' ) );
		}


		/**
		 * Sections
		 */
		$wp_customize->add_section( 'customizer_appearance', array(
			'title'=> __( 'Appearance', 'proteusthemes' ),
			'description' => __( 'Appearance for the Webmarket theme', 'proteusthemes' ),
			'priority'=> 30
		) );
		if( is_woocommerce_active() ) {
			$wp_customize->add_section( 'customizer_shop', array(
				'title'=> __( 'Shop', 'proteusthemes' ),
				'description' => __( 'Shop settings', 'proteusthemes' ),
				'priority'=> 40
			) );
		}
		$wp_customize->add_section( 'customizer_social_icons', array(
			'title'=> __( 'Social Icons', 'proteusthemes' ),
			'description' => __( 'Insert your link (the whole URL with <code>http(s)://</code>) for specific icon to appear', 'proteusthemes' ),
			'priority'=> 100
		) );



		/**
		 * Controls
		 */

		// Section: title_tagline
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_show_tagline',
			array(
				'label'    => __( 'Show tagline in the header?' , 'proteusthemes'),
				'section'  => 'title_tagline',
				'settings' => 'webmarket[show_tagline]',
				'type'     => 'radio',
				'choices'  => array(
					'yes' => __( 'Yes' , 'proteusthemes'),
					'no'  => __( 'No' , 'proteusthemes'),
				)
			)
		) );
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_blog_title',
			array(
				'label'    => __( 'Blog Title' , 'proteusthemes'),
				'section'  => 'title_tagline',
				'settings' => 'webmarket[blog_title]',
			)
		) );
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_blog_tagline',
			array(
				'label'    => __( 'Blog Tagline' , 'proteusthemes'),
				'section'  => 'title_tagline',
				'settings' => 'webmarket[blog_tagline]',
			)
		) );

		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_shop_title',
			array(
				'label'    => __( 'Shop Sidebar Title' , 'proteusthemes'),
				'section'  => 'title_tagline',
				'settings' => 'webmarket[shop_sidebar_title]',
			)
		) );

		// Section: customizer_appearance
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'webmarket_logo_img',
			array(
				'label'    => __( 'Logo image (recommended dimensions: 200 x 50)' , 'proteusthemes'),
				'section'  => 'customizer_appearance',
				'settings' => 'webmarket[logo_img]',
			)
		) );
		$wp_customize->add_control( new WP_Customize_Upload_Control(
			$wp_customize,
			'webmarket_favicon',
			array(
				'label'    => __( 'Favicon image (16 x 16 px), format .ico' , 'proteusthemes'),
				'section'  => 'customizer_appearance',
				'settings' => 'webmarket[favicon]',
			)
		) );
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_boxed',
			array(
				'label'    => __( 'Boxed or wide version?' , 'proteusthemes'),
				'section'  => 'customizer_appearance',
				'settings' => 'webmarket[boxed]',
				'type'     => 'radio',
				'choices'  => array(
					'no'  => __( 'Wide', 'proteusthemes'),
					'yes' => __( 'Boxed', 'proteusthemes')
				)
			)
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'webmarket_bg_pattern',
			array(
				'label'    => __( 'Background pattern (only for boxed version)' , 'proteusthemes'),
				'section'  => 'customizer_appearance',
				'settings' => 'webmarket[bg_pattern]',
			)
		) );
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_display_latest_news',
			array(
				'label'    => __( 'Display latest news on the front page' , 'proteusthemes'),
				'section'  => 'customizer_appearance',
				'settings' => 'webmarket[display_latest_news]',
				'type'     => 'select',
				'choices'  => array(
					'yes' => __( 'Yes' , 'proteusthemes'),
					'no'  => __( 'No' , 'proteusthemes'),
				)
			)
		) );

		// Section: customizer_shop
		if( is_woocommerce_active() ) {
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'webmarket_products_per_page',
				array(
					'label'    => __( 'Number of products per page' , 'proteusthemes'),
					'section'  => 'customizer_shop',
					'settings' => 'webmarket[products_per_page]',
					'type'     => 'text',
				)
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'webmarket_single_product_sidebar',
				array(
					'label'    => __( 'Show sidebar on single product page' , 'proteusthemes'),
					'section'  => 'customizer_shop',
					'settings' => 'single_product_sidebar',
					'type'     => 'select',
					'choices'  => array(
						'no'    => __( 'No' , 'proteusthemes'),
						'left'  => __( 'Left' , 'proteusthemes'),
						'right' => __( 'Right' , 'proteusthemes'),
					)
				)
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'webmarket_show_stock_btns',
				array(
					'label'    => __( 'Show stock status for the products?' , 'proteusthemes'),
					'section'  => 'customizer_shop',
					'settings' => 'show_stock_btns',
					'type'     => 'select',
					'choices'  => array(
						'yes' => __( 'Yes' , 'proteusthemes'),
						'no'  => __( 'No' , 'proteusthemes'),
					)
				)
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'webmarket_text_shipping_cart',
				array(
					'label'    => __( 'Info text in shopping cart dropdown' , 'proteusthemes'),
					'section'  => 'customizer_shop',
					'settings' => 'text_shipping_cart',
				)
			) );
		}

		// Section: colors
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'webmarket_theme_primary_clr',
			array(
				'label'    => __( 'Primary Theme Color' , 'proteusthemes'),
				'section'  => 'colors',
				'settings' => 'webmarket[theme_primary_clr]',
			)
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'webmarket_theme_secondary_clr',
			array(
				'label'    => __( 'Secondary Theme Color' , 'proteusthemes'),
				'section'  => 'colors',
				'settings' => 'webmarket[theme_secondary_clr]',
			)
		) );

		// Section: customizer_social_icons

		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'webmarket_icons_new_window',
			array(
				'label'    => __( 'Open the icons in the new window?' , 'proteusthemes'),
				'section'  => 'customizer_social_icons',
				'settings' => 'webmarket[icons_new_window]',
				'priority' => 0,
				'type'     => 'radio',
				'choices'  => array(
					'yes' => __( 'Yes' , 'proteusthemes'),
					'no'  => __( 'No' , 'proteusthemes'),
				)
			)
		) );
		foreach ($social_networks as $n => $social_network) {
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'webmarket_zocial_' . $social_network,
				array(
					'label'    => ucwords( $social_network ),
					'section'  => 'customizer_social_icons',
					'settings' => 'webmarket[zocial_' . $social_network . ']',
					'priority' => ( $n+1 ) * 10
				)
			) );
		}

	}


	/**
	* This will output the custom WordPress settings to the live theme's WP head.
	*
	* Used by hook: 'wp_head'
	*
	* @see add_action('wp_head',$func)
	*/
	public static function customizer_styles() {
	 	// customizer settings
		$theme_mods = get_theme_mod( 'webmarket' );

		ob_start();

		if ( ! empty( $theme_mods['theme_primary_clr'] ) ) :
?>
<?php if (false): ?>
<style type="text/css">
<?php endif ?>
/* WP Customizer */
/* ============= */

/* primary */
a,
.theme-clr,
.sidebar-item.widget_nav_menu .nav-pills > li > a:hover,
.sidebar-filters .selectable:hover, .sidebar-filters .selectable:focus,
.opening-time .week-day.today dt,
.table-theme tr.active td,
.accordion-inner label.checked,
.su-spoiler-style-fancy .su-spoiler-icon {
	color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
a:hover {
	color: <?php echo darken_css_color( $theme_mods['theme_primary_clr'], 10 ); ?>;
}

.ui-widget-header,
.btn.btn-primary:hover,
#submitWPComment:hover,
.btn.btn-primary:focus,
#submitWPComment:focus,
.btn.btn-primary:active,
#submitWPComment:active,
.btn.btn-primary.active,
.active#submitWPComment,
.btn.btn-primary.disabled,
.disabled#submitWPComment,
.btn.btn-primary[disabled],
[disabled]#submitWPComment,
.navbar #magic-line,
.topmost-line .dropdown-menu a:hover,
.tp-caption.big_theme,
.tp-caption.btn_theme,
.bg-for-icon,
.sidebar-filters .selectable.selected .box,
.widget_calendar caption,
.pagination > ul > li.highlighted a {
	background-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.sidebar-filters .selectable.selected .box,
.product-preview .thumbs .thumb.active img,
.product-preview .thumbs .thumb img:hover,
.pagination > ul > li > a:hover,
.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus {
	border-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.nav-pills.nav-stacked > li.active > a {
	border-left-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.nav-tabs-style-2 > .active > a,
.nav-tabs-style-2 > .active > a:hover,
.nav-tabs-style-2 > .active > a:focus,
.su-tabs-style-filled-tabs .su-tabs-nav .su-tabs-current {
	border-top-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.su-tabs-nav span.su-tabs-current {
	border-bottom-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.btn.btn-primary,
#submitWPComment,
.navbar .btn-navbar,
div.woocommerce input[type="submit"],
div.woocommerce button,
div.woocommerce .button {
	-webkit-box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_primary_clr'], 17 ); ?>;
	-moz-box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_primary_clr'], 17 ); ?>;
	box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_primary_clr'], 17 ); ?>;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	background-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
	background-image: -moz-linear-gradient(top, <?php echo $theme_mods['theme_primary_clr']; ?>, <?php echo $theme_mods['theme_primary_clr']; ?>);
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $theme_mods['theme_primary_clr']; ?>), to(<?php echo $theme_mods['theme_primary_clr']; ?>));
	background-image: -webkit-linear-gradient(top, <?php echo $theme_mods['theme_primary_clr']; ?>, <?php echo $theme_mods['theme_primary_clr']; ?>);
	background-image: -o-linear-gradient(top, <?php echo $theme_mods['theme_primary_clr']; ?>, <?php echo $theme_mods['theme_primary_clr']; ?>);
	background-image: linear-gradient(to bottom, <?php echo $theme_mods['theme_primary_clr']; ?>, <?php echo $theme_mods['theme_primary_clr']; ?>);
	background-repeat: repeat-x;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF<?php echo $theme_mods['theme_primary_clr']; ?>', endColorstr='#FF<?php echo $theme_mods['theme_primary_clr']; ?>', GradientType=0);
	border-color: <?php echo $theme_mods['theme_primary_clr']; ?> <?php echo $theme_mods['theme_primary_clr']; ?> #007780;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
	*background-color: <?php echo $theme_mods['theme_primary_clr']; ?>;
}
.btn.btn-primary:hover,
#submitWPComment:hover,
.navbar .btn-navbar:hover,
div.woocommerce input[type="submit"]:hover,
div.woocommerce button:hover,
div.woocommerce .button:hover {
	background-color: <?php echo darken_css_color( $theme_mods['theme_primary_clr'], 5 ); ?>;
}

/* secondary */
.btn.btn-danger {
	-webkit-box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_secondary_clr'], 17 ); ?>;
	-moz-box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_secondary_clr'], 17 ); ?>;
	box-shadow: 0 2px 0 <?php echo darken_css_color( $theme_mods['theme_secondary_clr'], 17 ); ?>;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	background-color: <?php echo $theme_mods['theme_secondary_clr']; ?>;
	background-image: -moz-linear-gradient(top, <?php echo $theme_mods['theme_secondary_clr']; ?>, <?php echo $theme_mods['theme_secondary_clr']; ?>);
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $theme_mods['theme_secondary_clr']; ?>), to(<?php echo $theme_mods['theme_secondary_clr']; ?>));
	background-image: -webkit-linear-gradient(top, <?php echo $theme_mods['theme_secondary_clr']; ?>, <?php echo $theme_mods['theme_secondary_clr']; ?>);
	background-image: -o-linear-gradient(top, <?php echo $theme_mods['theme_secondary_clr']; ?>, <?php echo $theme_mods['theme_secondary_clr']; ?>);
	background-image: linear-gradient(to bottom, <?php echo $theme_mods['theme_secondary_clr']; ?>, <?php echo $theme_mods['theme_secondary_clr']; ?>);
	background-repeat: repeat-x;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF<?php echo $theme_mods['theme_secondary_clr']; ?>', endColorstr='#FF<?php echo $theme_mods['theme_secondary_clr']; ?>', GradientType=0);
	border-color: <?php echo $theme_mods['theme_secondary_clr']; ?> <?php echo $theme_mods['theme_secondary_clr']; ?> #007780;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
	*background-color: <?php echo $theme_mods['theme_secondary_clr']; ?>;
}
.btn.btn-danger:hover {
	background-color: <?php echo darken_css_color( $theme_mods['theme_secondary_clr'], 5 ); ?>;
}

<?php if (false) : ?>
</style>
<?php endif; ?>

<?php
		endif;
		if ( 'yes' === $theme_mods['boxed'] ) :
			if ( ! empty( $theme_mods['bg_pattern'] ) ) {
				$bgimage = "background-image: url('" . $theme_mods['bg_pattern'] . "');";
			} else {
				$bgimage = '';
			}
?>

/* boxed or wide */
body.boxed {
	<?php echo $bgimage; ?>
	background-position: center top;
}

<?php
		endif;
		echo "/* Custom CSS */" . PHP_EOL;
		echo ot_get_option( 'user_custom_css', '' );
		/*end of output*/

		$style = ob_get_contents();
		ob_end_clean();

		wp_add_inline_style( 'main', $style );
	}

	/**
	 * Outputs the favicon
	 */
	public static function header_output() {
		$theme_mods = get_theme_mod( 'webmarket' );

		if( ! empty( $theme_mods['favicon'] ) ) : ?>
		<link rel="shortcut icon" href="<?php echo $theme_mods['favicon']; ?>">
		<?php else : ?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png">
		<?php endif;
	}
}

//Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Webmarket_Customize' , 'register' ) );

//Output custom CSS to live site
add_action( 'wp_enqueue_scripts' , array( 'Webmarket_Customize' , 'customizer_styles' ), 20 );
add_action( 'wp_head' , array( 'Webmarket_Customize' , 'header_output' ) );
