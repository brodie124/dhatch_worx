<?php
/*
Template Name: Blog - Masonry Fullwidth
*/

get_header();
global $tt_option, $wp_query;
$postid = $wp_query->post->ID;

if ( has_post_thumbnail($postid) ) {
	$attachment_id = get_post_thumbnail_id($postid);
	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'fullscreen' );		
	$attachment_url = $attachment_array[0];
}
?>

<div class="section">

	<?php if( has_post_thumbnail($postid) ) {	?>
	<div class="section-heading text-center bg-image parallax" style="background-image: url(<?php echo $attachment_url; ?>)" data-stellar-background-ratio="<?php echo $tt_option['parallax_scroll_speed'] ?>">
		<h1 class="title"><?php if( get_post_meta( $postid, '_tt_title', true ) ) { echo get_post_meta( $postid, '_tt_title', true ); } else { echo get_the_title( $postid ); } ?></h1>
		<?php if( get_post_meta( $postid, '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( $postid, '_tt_subtitle', true ) . '</p>'; } ?>
	</div>
	<?php } ?>
	
	<div class="container">
	
		<?php if( !has_post_thumbnail($postid) ) {	?>
		<div class="section-heading text-center">
			<h1 class="title"><span><?php if( get_post_meta( $postid, '_tt_title', true ) ) { echo get_post_meta( $postid, '_tt_title', true ); } else { echo get_the_title( $postid ); } ?></span></h1>
			<?php if( get_post_meta( $postid, '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( $postid, '_tt_subtitle', true ) . '</p>'; } ?>
		</div>
		<?php } ?>
		
		<?php if( is_404() ) { ?>
			<h1 id="page404">
				<span>404</span>
				<?php _e( 'Page Not Found', 'tt' ); ?>
			</h1>
		<?php }
		else 
			{ // if not 404	?>
		
			<?php if( is_search() ) { ?>
			<div class="custom-heading">
				<h2 class="title"><span><?php printf( __( 'Search Results for: %s', 'tt' ), get_search_query() ); ?></span></h2>
			</div>
			<?php } ?>
			
			<?php if( is_archive() ) { ?>
			<div class="custom-heading">
				<h2 class="title"><span>
				<?php
					if ( is_day() ) :
						printf( __( 'Archive: %s', 'tt' ), get_the_date( _x( 'F d Y', 'Daily archives date format', 'tt' ) ) );	
					elseif ( is_month() ) :
						printf( __( 'Archive: %s', 'tt' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'tt' ) ) );	
					elseif ( is_year() ) :
						printf( __( 'Archive: %s', 'tt' ), get_the_date( _x( 'Y', 'yearly archives date format', 'tt' ) ) );
					else :
						_e( 'Archives', 'tt' );	
					endif;
				?>
				</span></h2>
			</div>
			<?php }	?>
			
	</div><!-- .container -->
	
	<div id="blog-masonry-fullwidth" class="main-content">

	<?php 
	$args = array ( 
		'post_type' => 'post',
		'paged' => get_query_var('paged')	
	);
	query_posts( $args );
	if (have_posts()) : while (have_posts()) : the_post();	
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
		
		<div class="entry-inner">	
			<div class="entry-content">
				<?php 
				get_template_part( 'content', get_post_format() ); 
				
				if( get_post_format() != "link" && get_post_format() != "quote" ) {
				?>
			
				<?php 
				if( is_single() ) { 
					the_content();
				}
				else {
					the_excerpt();
				}
				
				}
				?>
			</div>
		</div>
		
		<?php if( !is_single() ) { ?>
			<div class="entry-meta">
				<i class="fa fa-clock-o"></i>	
				<span class="month"><?php the_time('M'); ?></span>
				<span class="day"><?php the_time('d'); ?></span>						
				<?php if( get_post_format() != "link" && get_post_format() != "quote" ) { ?>
				<span class="comments-meta"><?php if ( comments_open() ) : comments_popup_link(__('<i class="fa fa-comments"></i> 0', 'tt'), __('<i class="fa fa-comments"></i> 1', 'tt'), __('<i class="fa fa-comments"></i> %', 'tt'), 'comments-link', ''); endif; ?></span>
				<?php	} ?>
			</div>
		<?php	} ?>
		
		<?php if( is_single() ) { ?>
		<?php if( $tt_option['blog_author_show'] ) { ?>
		<div id="post-author">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
			<div class="details">
				<h4>Author: <?php the_author(); ?></h4>
				<p><?php the_author_meta('description') ?></p>
			</div>
		</div>
		<?php } ?>
		<?php if ( comments_open() || get_comments_number() ) {
			comments_template();
		} ?>
		<?php } ?>
				
	</article><!-- .entry -->
	<?php endwhile;	?>
	</div>
	
	<div id="pagination-center">
		<?php posts_nav_link(' ', '<i class="btn btn-primary fa fa-angle-left"></i>', '<i class="btn btn-primary fa fa-angle-right"></i>'); ?>
	</div>
	<?php else :
		_e( 'Nothing found.', 'tt' );
	?>
	<?php 
	endif; 
	wp_reset_query();
	?>

	<?php } // end not 404 ?>
	
</div>

<?php
$footnote_show = $tt_option['blog_footnote_show'];
$footnote_text = $tt_option['blog_footnote_text'];
$footnote_button_text = $tt_option['blog_footnote_button_text'];
$footnote_button_url = $tt_option['blog_footnote_button_url'];

if ( $footnote_show ) {
?>
<div id="footnote">
	<div class="arrow-down"></div>
	<div class="container">
		<p>
			<?php echo $footnote_text; ?>
		</p>
		<a class="btn btn-primary btn-lg" href="<?php echo $footnote_button_url; ?>"><?php echo $footnote_button_text; ?></a>
	</div>
</div>
<?php } ?>

<?php get_footer(); ?>