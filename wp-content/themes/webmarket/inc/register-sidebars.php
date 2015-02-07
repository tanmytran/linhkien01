<?php
/**
 * Register sidebars for Webmarket
 *
 * @package Webmarket
 */

function add_my_sidebars() {
	// blog sidebar
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar' , 'proteusthemes'),
			'id'            => 'blog-sidebar',
			'description'   => __( 'Sidebar on the blog layout' , 'proteusthemes'),
			'class'         => 'blog sidebar',
			'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="underlined"><h3>',
			'after_title'   => '</h3></div>'
		)
	);


	// regular page
	register_sidebar(
		array(
			'name'          => __( 'Regular Page Sidebar' , 'proteusthemes'),
			'id'            => 'regular-page-sidebar',
			'description'   => __( 'Sidebar on the regular page' , 'proteusthemes'),
			'class'         => 'sidebar',
			'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="underlined"><h3>',
			'after_title'   => '</h3></div>'
		)
	);


	// shop filters
	register_sidebar(
		array(
			'name'          => __( 'Shop Filter Sidebar' , 'proteusthemes'),
			'id'            => 'shop-page-sidebar',
			'description'   => __( 'Sidebar on the shop page' , 'proteusthemes'),
			'class'         => 'sidebar',
			'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="underlined"><h3>',
			'after_title'   => '</h3></div>'
		)
	);


	// single product
	register_sidebar(
		array(
			'name'          => __( 'Single Product Sidebar' , 'proteusthemes'),
			'id'            => 'single-product-sidebar',
			'description'   => __( 'Sidebar on the single product page' , 'proteusthemes'),
			'class'         => 'sidebar',
			'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="underlined"><h3>',
			'after_title'   => '</h3></div>'
		)
	);


	// home page - above latest news, row 1
	register_sidebar(
		array(
			'name'          => __( 'Home Page - Row One' , 'proteusthemes'),
			'id'            => 'home-row-1',
			'description'   => __( 'Sidebar row 1 on the front page' , 'proteusthemes'),
			'before_widget' => '<div class="span4"><div id="%1$s" class="blocks-spacer %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="main-titles lined"><h2 class="title">',
			'after_title'   => '</h2></div>'
		)
	);


	// home page - above latest news, row 2
	register_sidebar(
		array(
			'name'          => __( 'Home Page - Row Two' , 'proteusthemes'),
			'id'            => 'home-row-2',
			'description'   => __( 'Sidebar row 2 on the front page' , 'proteusthemes'),
			'before_widget' => '<div class="span4"><div id="%1$s" class="blocks-spacer %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="main-titles lined"><h2 class="title">',
			'after_title'   => '</h2></div>'
		)
	);


	// home page - above latest news, row 3
	register_sidebar(
		array(
			'name'          => __( 'Home Page - Row Three' , 'proteusthemes'),
			'id'            => 'home-row-3',
			'description'   => __( 'Sidebar row 3 on the front page' , 'proteusthemes'),
			'before_widget' => '<div class="span4"><div id="%1$s" class="blocks-spacer %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="main-titles lined"><h2 class="title">',
			'after_title'   => '</h2></div>'
		)
	);

	// home page - under latest news
	register_sidebar(
		array(
			'name'          => __( 'Home Page - Row Four' , 'proteusthemes'),
			'id'            => 'home-under-news',
			'description'   => __( 'Sidebar under the latest news on the homepage' , 'proteusthemes'),
			'before_widget' => '<div class="row"><div class="span12"><div id="%1$s" class="blocks-spacer %2$s">',
			'after_widget'  => '</div></div></div>',
			'before_title'  => '<div class="main-titles lined"><h2 class="title">',
			'after_title'   => '</h2></div>'
		)
	);

	// footer top
	register_sidebar(
		array(
			'name'          => __( 'Top Footer' , 'proteusthemes'),
			'id'            => 'footer-sidebar-top',
			'description'   => __( 'First footer area - accepts 3 widgets' , 'proteusthemes'),
			'before_widget' => '<div class="span4"><div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="main-titles lined"><h3 class="title">',
			'after_title'   => '</h3></div>'
		)
	);

	// footer bottom
	register_sidebar(
		array(
			'name'          => __( 'Bottom Footer' , 'proteusthemes'),
			'id'            => 'footer-sidebar-bottom',
			'description'   => __( 'Second footer area - accepts 4 widgets' , 'proteusthemes'),
			'before_widget' => '<div class="span3"><div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="main-titles lined"><h3 class="title">',
			'after_title'   => '</h3></div>'
		)
	);
}
add_action( "widgets_init", "add_my_sidebars" );
