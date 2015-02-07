<?php
/**
 * The template for displaying Comments.
 *
 * @package Webmarket
 */
?>

<section id="comments" class="comments-container">
<?php 
	if ( ! post_password_required() ) :
	if ( comments_open() ) : 
?>

	<?php if( have_comments() ) : ?>
	<h3 class="push-down-25">
		<?php 
			comments_number( 
				__( sprintf( '%sNo%s Comments', '<span class="light">', '</span>' ) , 'proteusthemes'),
				__( sprintf( '%sOne%s Comment', '<span class="light">', '</span>' ) , 'proteusthemes'), 
				_x( sprintf( '%s%%%s Comments', '<span class="light">', '</span>' ), '%% represents the number, you must include it' , 'proteusthemes')
			);
		?>
	</h3>
	<?php endif; // have comments ?>

	<?php 
		wp_list_comments( array(
			'style'        => 'div',
			'format'       => 'html5',
			'avatar_size'  => 140,
			'callback'     => 'webmarket_comment',
			'end-callback' => 'end_webmarket_comment',
		));


/**
 * Comments navigation
 */
if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<div class="navigation clearfix push-down-40" role="navigation">
		<div class="nav-previous pull-left"><?php previous_comments_link( __( '&larr; Older Comments' , 'proteusthemes') ); ?></div>
		<div class="nav-next pull-right"><?php next_comments_link( __( 'Newer Comments &rarr;' , 'proteusthemes') ); ?></div>
	</div>	
<?php endif; //paginate comments or not ?>
	
	<?php if ( have_comments() ) {
		echo '<hr />';
	} ?>
	
	<h3 class="push-down-25">
		<?php echo lighted_title( __( 'Leave a Comment' , 'proteusthemes') ); ?>
	</h3>


<?php
/**
 * Form for posting a new comment
 * @link http://codex.wordpress.org/comment_form
 */

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true' required" : '' );

$form_args = array(
	"title_reply"          => "",
	"label_submit"         => __( "SUBMIT A COMMENT" , 'proteusthemes'),
	"comment_notes_before" => '',
	"comment_notes_after"  => '',
	'id_submit'            => 'submitWPComment',
	'comment_field'        =>  '<p class="push-down-20"><textarea id="comment" name="comment" cols="45" rows="7" aria-required="true" class="input-block-level" placeholder="Your Comment goes here ..." required>' . '</textarea></p>',
	'fields' => array(
		'author' => '<p class="push-down-20"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /><label for="author">' . __( 'Name' , 'proteusthemes') . ( $req ? ' <span class="red-clr bold">*</span>' : '' ) . '</label></p>',
		'email' => '<p class="push-down-20"><input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /><label for="email">' . __( 'Email' , 'proteusthemes') . ( $req ? '<span class="red-clr bold">*</span>' : '' ) . '</label></p>',
		'url' => '<p class="push-down-20"><input id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" /><label for="url">' . __( 'Website' , 'proteusthemes') . ( $req ? ' <span class="red-clr bold">*</span>' : '' ) . '</label></p>',
	)
);

comment_form( $form_args );
	
else : //if comments_open
if ( is_single() ) :
?>

	<h3><?php _e( 'Comments are disabled for this post' , 'proteusthemes') ?></h3>

<?php 
	endif; //if is_page
	endif; //if comments_open 
	else : //if post_password_required
?>

	<h3><?php _e( 'Comments not shown for password protected posts' , 'proteusthemes'); ?></h3>

<?php endif; //if post_password_required ?>
</section>

