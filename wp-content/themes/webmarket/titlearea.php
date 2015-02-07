<?php 
/**
 * Main title area above the content
 *
 * @package Webmarket
 */

$subtitle = false;

if( is_home() || is_single() ) {
	$title    = get_single_theme_mod( 'blog_title' );
	$subtitle = get_single_theme_mod( 'blog_tagline' );
	if ( strlen( $subtitle ) < 1 ) {
		$subtitle = false;
	}
} else if ( is_page() ) {
	$title = lighted_title( get_the_title() );
} else if ( is_category() ) {
	$title    = __( 'Category Archive' , 'proteusthemes');
	$subtitle = single_cat_title( '', false );
} else if ( is_tag() ) {
	$title    = __( 'Tag Archive' , 'proteusthemes');
	$subtitle = single_tag_title( '', false );
} else if ( is_search() ) {
	$title    = __( 'Search Results' , 'proteusthemes');
	$subtitle = get_search_query();
} else {
	$title = strip_tags( get_the_title() );
}

?>

<div class="span12">
	<div class="title-area">
		<h1 class="inline"><?php echo lighted_title( $title ); ?></h1>
		<?php if( $subtitle ) : ?> 
		<h2 class="inline tagline">&ndash; <?php echo $subtitle; ?></h2>
		<?php endif; ?> 
	</div>
</div>