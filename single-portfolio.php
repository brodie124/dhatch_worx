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

<div class="section project-content">

	<?php
	if ( have_posts() ) : while( have_posts() ) : the_post();
	
	$project_categorie_list = strip_tags( get_the_term_list(get_the_ID(), 'portfolio_filter', '', ' &middot; ', '') );
	$project_media_width = get_post_meta( get_the_ID(), '_tt_project_media_width', true );
	if ( $project_media_width == "6" ) { $project_details_width = "6"; }
	if ( $project_media_width == "8" ) { $project_details_width = "4"; }
	if ( $project_media_width == "12" ) { $project_details_width = "12"; }
	
	if ( has_post_thumbnail()) {
		$attachment_id =  get_post_thumbnail_id();
		$attachment_array = wp_get_attachment_image_src( $attachment_id, 'col12' );		
		$attachment_url = $attachment_array[0];
	}
	?>
  
  <div id="<?php $slug = $post->post_name; echo $slug; ?>">
  
	  <div class="project-header">
			<h3 class="title"><span><?php echo the_title(); ?></span></h3>
			<div class="type"><?php echo $project_categorie_list; ?></div>
		</div>
  
	  <?php if( $project_media_width != "100") { ?>
	  <div class="container">
	  <?php } ?>
	  
			<div class="row">
				<div class="col-sm-<?php echo $project_media_width; ?>">
					<?php 
					$project_slideshow_images = get_post_meta( get_the_ID(), '_tt_project_slideshow_images', false );					
					$project_slideshow_images_count = count($project_slideshow_images);
					$project_video_service = get_post_meta( get_the_ID(), '_tt_project_video_service', true );
					$project_video_id = get_post_meta( get_the_ID(), '_tt_project_video_id', true );
					
					// Check for video ID
					if ( $project_video_id == "" ) {
					
					// Check for uploaded images
					if( !empty($project_slideshow_images) ) {
						// One Single Image found
						if( $project_slideshow_images_count == 1) {
							$project_single_attachment = wp_get_attachment_image_src($project_slideshow_images[0], 'col12');
							$project_single_attachment_meta = wp_get_attachment_metadata(  );
							$project_single_attachment_url = $project_single_attachment[0];
					?>
					<img src="<?php echo $project_single_attachment_url; ?>" class="project-media photobox" alt="" />
					<?php print_r( $project_single_attachment_meta ); ?>
					<?php } 
						// More than one image found, build slideshow
						else {
					?>
					<ul class="slideshow-fade photobox list-unstyled">					
					<?php
	
					$args = array(
						'post_type' => 'attachment',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__in' => $project_slideshow_images,
						'posts_per_page' => count($project_slideshow_images)
					);
					
					$gallery_array = get_posts( $args );
					
					foreach ($gallery_array as $slide) {
						$attachment = wp_get_attachment_image_src( $slide->ID, 'col12' );
						$attachment_url = $attachment[0];
					?>
						<li><img src="<?php echo $attachment_url; ?>" alt="" /></li>
					<?php 
					}
					wp_reset_postdata();
					?>
					</ul>
					<?php
						}
					}
					// No images uploaded, use thumbnail
					else {
						if ( has_post_thumbnail() ) {
							$att=get_post_thumbnail_id();
							$image_src = wp_get_attachment_image_src( $att, 'full' );
							$image_src = $image_src[0]; ?>
							<img src="<?php echo $image_src; ?>" class="project-media" alt="" />
					<?php
						}
					}
					
					}
					// Video ID found
					else { ?>
					<div class="video-full-width">
						<?php if( $project_video_service == "youtube" ) { ?>
						<iframe src="//www.youtube.com/embed/<?php echo $project_video_id ;?>"></iframe>
						<?php }
						else {
						?>
						<iframe src="http://player.vimeo.com/video/<?php echo $project_video_id ;?>?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"></iframe>
						<?php } ?>
					</div>
					<?php
					}
					?>
				</div>
				<?php if( $project_media_width == "100") { ?>
				<div class="container">
				<?php } ?>
				<div class="col-sm-<?php echo $project_details_width; ?>">
					<?php the_content(); ?>
				</div>
				<?php if( $project_media_width == "100") { ?>
				</div>
				<?php } ?>
			</div>
			
		<?php if( $project_media_width != "100") { ?>
	  </div><!-- .container -->
	  <?php } ?>
	
	</div>
	
	<?php	// Previous / Next Post Navigation
	$previousPost = get_adjacent_post();
	$nextPost = get_adjacent_post( false, "", false );	
	
	if ( $previousPost || $nextPost ) { ?>
	<div class="container">
		<div id="blog-prev-next-post">		
			<div class="row">
				<?php	if ( $previousPost ) {
				$previous_attachment_id =  get_post_thumbnail_id( $previousPost->ID ) ;
				?>
		    <div class="prev-post <?php if ( $nextPost ) { echo "col-sm-6"; } else { echo "col-sm-12 text-center"; } ?>">
			    <a href="<?php echo get_permalink( $previousPost->ID )?>">				    	
			    	<div class="text-muted"><?php _e( 'Previous Project:', 'tt'); ?></div>
			    	<h5 class="title"><?php echo $previousPost->post_title; ?></h5>				    	
			    </a>
		    </div>
				<?php } ?>
				
				<?php						
				if ( $nextPost ) {
				$next_attachment_id =  get_post_thumbnail_id( $nextPost->ID );
				?>
		    <div class="next-post <?php if ( $previousPost ) { echo "col-sm-6 text-right"; } else { echo "col-sm-12 text-center"; } ?>">
			    <a href="<?php echo get_permalink( $nextPost->ID )?>">    	
			    	<div class="text-muted"><?php _e( 'Next Project:', 'tt'); ?></div>
			    	<h5 class="title"><?php echo $nextPost->post_title; ?></h5>				
			    </a>
		    </div>
				<?php } ?>	
			</div>
		</div><!-- #blog-prev-next-post -->
	</div>
	
	<?php 
	}	
	endwhile;
	else : _e( 'Nothing found.', 'tt' );
	endif; 
	wp_reset_query();
	?>
	</div>
		
</div>

<?php get_footer(); ?>