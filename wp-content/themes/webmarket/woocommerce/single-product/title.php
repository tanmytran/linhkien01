<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="product-title"><!-- ends in price.php -->
	<h1 itemprop="name" class="product_title entry-title"><?php echo lighted_title( get_the_title() ); ?></h1>