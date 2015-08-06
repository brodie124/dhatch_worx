<?php
if ( post_password_required() ) { 
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<div class="comments-title custom-heading">
		<h2 class="title"><span><?php printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'tt' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></span></h2>
	</div>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<?php endif; // Check for comment navigation. ?>

	<ul class="comment-list">
		<?php
			wp_list_comments( array( 'callback' => 'tt_list_comments' ) );
		?>
	</ul>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="sr-only"><?php _e( 'Comment navigation', 'tt' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'tt' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'tt' ) ); ?></div>
		<div class="clearfix"></div>
	</nav>
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'tt' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<div id="reply-title" class="custom-heading">
		<h3 class="title"><span><?php _e( 'Leave a Reply', 'tt' ); ?></span></h3>
	</div>

	<?php
	
	$custom_args = array (
		'title_reply'       	=> __( ' ', 'tt' ),
		'comment_notes_after' => '',
		'cancel_reply_link' 	=> __( 'Cancel Reply', 'tt' ),
		'label_submit'      	=> __( 'Submit Comment', 'tt' ),
		'comment_notes_before'=> '',
		'comment_field'				=> '<div class="comment-form-comment form-group"><label for="comment">' . _x( 'Comment', 'noun', 'tt' ) . '</label><textarea id="comment"  class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
	);
		
	comment_form($custom_args); 
	
	?>

</div><!-- #comments -->