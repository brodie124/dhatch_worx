<?php 
get_header();
global $tt_option;	
$blog_id = get_option('page_for_posts');

if ( has_post_thumbnail($blog_id) ) {
	$attachment_id = get_post_thumbnail_id($blog_id);
	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'fullscreen' );		
	$attachment_url = $attachment_array[0];
}
?>

<div class="section">

	<?php if( !is_404() && !is_single() && has_post_thumbnail($blog_id) ) {	?>
	<div class="section-heading text-center bg-image parallax" style="background-image: url(<?php echo $attachment_url; ?>)" data-stellar-background-ratio="<?php echo $tt_option['parallax_scroll_speed'] ?>">
		<h1 class="title"><?php if( is_home() && is_front_page() ) { echo bloginfo('name'); } else { if( get_post_meta( $blog_id, '_tt_title', true ) ) { echo get_post_meta( $blog_id, '_tt_title', true ); } else { echo get_the_title( $blog_id ); } } ?></h1>
		<?php if( get_post_meta( $blog_id, '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( $blog_id, '_tt_subtitle', true ) . '</p>'; } ?>
	</div>
	<?php } ?>

	<div class="container">
	
		<?php if( !is_404() && !is_single() && !has_post_thumbnail($blog_id) ) {	?>
		<div class="section-heading text-center">
			<h1 class="title"><span><?php if( is_home() && is_front_page() ) { echo bloginfo('name'); } else { if( get_post_meta( $blog_id, '_tt_title', true ) ) { echo get_post_meta( $blog_id, '_tt_title', true ); } else { echo get_the_title( $blog_id ); } } ?></span></h1>
			<?php if( get_post_meta( $blog_id, '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( $blog_id, '_tt_subtitle', true ) . '</p>'; } ?>
		</div>
		<?php } ?>
		
		<?php if( is_404() ) { ?>
			<h1 id="page404">
				<span><?php _e( '404', 'tt' ); ?></span>
				<?php _e( 'Page Not Found', 'tt' ); ?>
			</h1>
		<?php }
		else 
			{ // If not is_404()	?>
		
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
					endif;
					
					if ( is_category() ) {
						printf( __( 'Category: %s', 'tt' ), single_cat_title( '', false ) );
					}
					if ( is_tag() ) {
						printf( __( 'Tag: %s', 'tt' ), single_tag_title( '', false ) );
					}
					if ( is_author() ) {
						printf( __( 'All posts by: %s', 'tt' ), get_the_author() );
					}
				?>
				</span></h2>
			</div>
			<?php }	?>
			
			<div class="row">
				<?php 
				global $tt_option;
				
				$show_sidebar = $tt_option['blog_sidebar_show'];
				if( $show_sidebar ) { ?>
				<div class="col-sm-9 main-content">
				<?php } else { ?>
				<div class="col-sm-12 main-content">
				<?php } ?>
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
					
						<?php if( !is_single() ) { ?>
							<div class="entry-meta">	
								<div class="month"><?php the_time('M'); ?></div>
								<div class="day"><?php the_time('d'); ?></div>						
								<?php if( get_post_format() != "link" && get_post_format() != "quote" ) { ?>
								<div class="comments-meta"><?php if ( comments_open() ) : comments_popup_link(__('<i class="fa fa-comments"></i> 0', 'tt'), __('<i class="fa fa-comments"></i> 1', 'tt'), __('<i class="fa fa-comments"></i> %', 'tt'), 'comments-link', ''); endif; ?></div>
								<?php	} ?>
							</div>
						<?php	} ?>
						
						<div class="entry-inner">	
							<div class="entry-content clearfix">
								<?php 
								get_template_part( 'content', get_post_format() ); 
								
								if( get_post_format() != "link" && get_post_format() != "quote" ) {
								?>
							
								<?php 
								if( is_single() ) { 
									the_content();
									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tt' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
									) );
								}
								else {
									the_excerpt();
								}
								
								}
								?>
							</div>
						</div>
								
					</article><!-- .entry -->
					
					<?php					
					if( is_single() ) { 
											
						global $tt_option;
						
						$social_sharing = $tt_option['blog_social_sharing'];

						if( $social_sharing != "0" ) { ?>
						
						<div id="sharrre">
						  <?php if( isset( $social_sharing['twitter'] ) ) { ?>
						  <div id="share-twitter" data-toggle="tooltip" title="<?php _e('Share on Twitter', 'tt'); ?>" data-url="<?php the_permalink() ?>" data-text="<?php echo get_the_title(); ?>"></div>
						  <?php }
						  if( isset( $social_sharing['facebook'] ) ) { ?>
						  <div id="share-facebook" data-toggle="tooltip" title="<?php _e('Share on Facebook', 'tt'); ?>" data-url="<?php the_permalink() ?>" data-text="<?php echo get_the_title(); ?>"></div>
						  <?php }
						  if( isset( $social_sharing['googleplus'] ) ) { ?>
						  <div id="share-googleplus" data-toggle="tooltip" title="<?php _e('Share on Google+', 'tt'); ?>" data-url="<?php the_permalink() ?>" data-text="<?php echo get_the_title(); ?>"></div>
						  <?php }
						  if( isset( $social_sharing['pinterest']) ) { ?>
						  <div id="share-pinterest" data-toggle="tooltip" title="<?php _e('Share on Pinterest', 'tt'); ?>" data-url="<?php the_permalink() ?>" data-text="<?php echo get_the_title(); ?>"></div>
						  <?php } ?>
						</div>
						
						<?php }	?>
						
						<?php if( $tt_option['blog_author_show'] ) { ?>
						<div id="post-author">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
							<div class="details">
								<h4>Author: <strong><?php the_author(); ?></strong></h4>
								<p><?php the_author_meta('description') ?></p>
							</div>
							<div class="clearfix"></div>
						</div>
						<?php } ?>
						
						<?php 
						// Previous / Next Post Navigation
						$previousPost = get_adjacent_post();
						$nextPost = get_adjacent_post( false, "", false );	
						
						if ( $previousPost || $nextPost ) { ?>
						<div id="blog-prev-next-post">
							<div class="row">
								<?php	if ( $previousPost ) {
									$previous_attachment_id =  get_post_thumbnail_id( $previousPost->ID ) ;
									?>
							    <div class="prev-post <?php if ( $nextPost ) { echo "col-sm-6"; } else { echo "col-sm-12 text-center"; } ?>">
								    <a href="<?php echo get_permalink( $previousPost->ID )?>">
								    	
								    	<div class="text-muted"><?php _e( 'Previous read:', 'tt'); ?></div>
								    	<h5 class="title"><?php echo $previousPost->post_title; ?></h5>
								    	
								    </a>
							    </div>
									<?php }
										
									if ( $nextPost ) {
									$next_attachment_id =  get_post_thumbnail_id( $nextPost->ID );
									?>
							    <div class="next-post <?php if ( $previousPost ) { echo "col-sm-6 text-right"; } else { echo "col-sm-12 text-center"; } ?>">
								    <a href="<?php echo get_permalink( $nextPost->ID )?>">
								    	
								    	<div class="text-muted"><?php _e( 'Next read:', 'tt'); ?></div>
								    	<h5 class="title"><?php echo $nextPost->post_title; ?></h5>
											
								    </a>
							    </div>
									<?php } ?>	
							</div>
						</div><!-- #blog-prev-next-post -->
						<?php
						}
						?>
						
						<?php if ( comments_open() || get_comments_number() ) {
							comments_template();
						} ?>
						
						<?php } ?>
					
					<?php endwhile;	?>
					<div id="pagination-left">
						<?php posts_nav_link(' ', '<i class="btn btn-default fa fa-angle-left"></i>', '<i class="btn btn-default fa fa-angle-right"></i>'); ?>
					</div>
					<?php else :
						_e( 'Nothing found.', 'tt' );
					?>
					<?php 
					endif; 
					wp_reset_query();
					?>
				</div>
				
				<?php if( $show_sidebar ) { ?>
				<div class="col-sm-3">
					<?php get_sidebar(); ?>
				</div>
				<?php } ?>
			</div>
		
		<?php } // end not 404 ?>
		</div><!-- .container -->
	
</div>

<?php
global $tt_option;
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