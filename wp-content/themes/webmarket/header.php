<?php
/**
 * The Header for Webmarket Theme
 *
 * @package Webmarket
 */

?><!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--  = Google Fonts =  -->
	<script type="text/javascript">
		WebFontConfig = {
			google : {
				families : ['Open+Sans:400,700,400italic,700italic:latin,latin-ext,cyrillic', 'Pacifico::latin']
			}
		};
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();
	</script>


	<!--  = HTML5 shim, for IE6-8 support of HTML5 elements =  -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- W3TC-include-js-head -->
	<?php wp_head(); ?>
	<!-- W3TC-include-css -->
</head>

<body <?php body_class( 'yes' === get_single_theme_mod( 'boxed' ) ? 'boxed' : '' ); ?>>
	<!-- W3TC-include-js-body-start -->
	<div class="master-wrapper">

	<header id="header" role="banner">
		<div class="darker-row">
			<div class="container">
				<div class="row">
					<div class="span3">
					<?php if ( is_woocommerce_active() ): ?>
						<div class="higher-line">
							<?php if ( is_user_logged_in() ) : ?>
							<a href="<?php echo is_woocommerce_active() ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : admin_url( 'profile.php' ); ?>" title="<?php _e( 'My Account' , 'proteusthemes'); ?>"><?php _e( 'My Account' , 'proteusthemes'); ?></a>
							<?php
								else : // is_user_logged_in
							?>
							<a href="<?php echo is_woocommerce_active() ? get_permalink( get_option('woocommerce_myaccount_page_id') ) : wp_login_url(); ?>" title="<?php _e( 'Login / Register' , 'proteusthemes'); ?>"><?php _e( 'Login / Register' , 'proteusthemes'); ?></a>
							<?php endif; // is_user_logged_in ?>

						</div>
					<?php endif ?>
					</div>
					<div class="span9">
						<div class="topmost-line">
							<div class="higher-line">

								<?php if ( has_nav_menu( 'top_bar_nav' ) ) : ?>
								<?php
									$top_menu_parameters = array(
										'theme_location' => 'top_bar_nav',
										'container'      => false,
										'echo' 	         => false,
										'items_wrap'     => '%3$s',
										'after'			 => "&nbsp; | &nbsp;",
										'depth' 	     => 1
									);

									echo strip_tags(wp_nav_menu( $top_menu_parameters ), '<a>' );
								?>
								<?php else : // has_nav_menu ?>
									<?php
										printf(
											_x( 'Define your top bar navigation in %sApperance %s Menus%s', 'Three %s represent the HTML markup, must be included. First and last %s are for bold tags, the middle is for the arrow.' , 'proteusthemes'),
											'<b>',
											'<i class="fa fa-angle-right"></i> ',
											'</b>'
										);
									?> &nbsp; | &nbsp;
								<?php endif; // has_nav_menu ?>

								<?php if ( is_woocommerce_active() ) : ?>
									<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="gray-link"><?php printf( __( "Cart (%d)" , 'proteusthemes'), WC()->cart->get_cart_contents_count() ); ?></a>
								<?php endif; // is_woocommerce_active ?>

							</div>
							&nbsp;
							<div class="lang-currency">
								<?php do_action('icl_language_selector'); ?>
								<?php if ( false ): ?>
								<div class="dropdown js-selectable-dropdown">
									<a data-toggle="dropdown" class="selected" href="#"><span class="js-change-text">USD ($)</span> <b class="caret"></b></a>
									<ul class="dropdown-menu js-possibilities" role="menu" aria-labelledby="dLabel">
										<li><a href="#">USD</a></li>
										<li><a href="#">EUR</a></li>
										<li><a href="#">YEN</a></li>
										<li><a href="#">GBP</a></li>
									</ul>
								</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">

				<!--  = Logo =  -->
				<div class="span7">

					<a class="brand" href="<?php echo home_url(); ?>">
						<?php
							$logo = get_single_theme_mod( 'logo_img' );;
							if ( empty( $logo ) ) :
						?>
						<img src="<?php echo get_template_directory_uri() . "/assets/images/logo.png"; ?>" alt="Webmarket Logo" width="48" height="48" />
						<span class="pacifico"><?php bloginfo( 'title' ); ?></span>
						<?php
							else : // empty
						?>
						<img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>" />
						<?php
							endif; // empty
						?>

						<?php
							if ( "yes" === get_single_theme_mod( 'show_tagline' ) ) {
								echo '<span class="tagline">' . get_bloginfo( 'description' ) . '</span>';
							}
						?>
					</a>
				</div>

				<!--  = Social Icons =  -->
				<div class="span5">
					<div class="top-right">
						<?php get_template_part( 'social-icons' ); ?>
					</div>
				</div> <!-- /social icons -->
			</div>
		</div>
	</header>


	<div class="navbar navbar-static-top" id="stickyNavbar">
		<div class="navbar-inner">
			<div class="container">
				<div class="row">
					<div class="span9">
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<div class="nav-collapse collapse">
						<?php
							if ( has_nav_menu( 'main-menu' ) ) {
								$args = array(
									'theme_location' => 'main-menu',
									'container'      => false,
									'menu_class'     => 'nav',
									'echo'           => true,
									'menu_id'        => 'mainNavigation',
								);
								wp_nav_menu( $args );
							}
						?>

						<!--  = Search form =  -->

						<?php
							if ( is_woocommerce_active() ) {
								get_template_part( "searchform-menu" );
							}
						?>

						</div><!-- /.nav-collapse-->
					</div>
					<div class="span3">
						<?php
							if ( is_woocommerce_active() ) :
						?>

							<div class="cart-container  js--cart-container" id="cartContainer">
								<?php echo webmarket_add_to_cart_dropdown(); ?>
							</div>

						<?php
							else : // is_woocommerce_active
								get_template_part( "searchform-menu" );
							endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'content', 'breadcrumbs' ); ?>
