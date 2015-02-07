<?php
/**
 * Load here all the individual widgets
 *
 * @package Webmarket
 */


/**
 * Require the individual widgets
 */
$files_to_require = array(
	'widget-opening-time',
	'widget-featured-link',
	'widget-brands-slider',
	'widget-text-custom-width',
	'widget-bootstrap-menu',
	'widget-featured-products',
	'widget-new-products-grid',
	'widget-best-selling-products',
	'widget-shop-category-filter'
);

foreach( $files_to_require as $file ) {
	locate_template ( "inc/widgets/{$file}.php", true, true );
}