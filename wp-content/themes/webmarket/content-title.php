<?php 
/**
 * Post title with thumbnail
 *
 * @package Webmarket
 * @todo Video supported
 */
?>

<!-- Thumbnail -->
<?php if( has_post_thumbnail() ) : ?> 
	<a href="<?php the_permalink(); ?>" class="block">
		<?php the_post_thumbnail(); ?> 
	</a>
<?php endif; ?> 

<!-- Title -->
<div class="post-title">
	<h2><a href="<?php the_permalink(); ?>"><?php echo lighted_title( get_the_title() ); ?></a></h2>
	<div class="metadata">
		<?php the_time( get_option( 'date_format' ) ); ?> &nbsp; / &nbsp;
		<a href="<?php comments_link(); ?>"><?php comments_number( 
			__( 'No comments', 'proteusthemes' ), 
			__( 'One comment', 'proteusthemes' ), 
			_x( '% comments', 'translators: % represents the number, you must include it', 'proteusthemes' ) ); ?></a> &nbsp; / &nbsp;
		<?php _e( 'Posted in' , 'proteusthemes'); ?>: <?php the_category(', '); ?><?php if( has_tag() ) { ?> &nbsp; / &nbsp; <?php _e( 'Tagged', 'proteusthemes' ); ?>: <?php the_tags( '', ', ' ); } ?>
	</div>
</div>