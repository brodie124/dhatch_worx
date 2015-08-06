<?php
global $post, $tt_option;
$project_meta_data = $tt_option['project_meta_data'];
$portfolio_mode = $tt_option['portfolio_mode'];
$portfolio_full_width = $tt_option['portfolio_full_width'];
$portfolio_filter_on = $tt_option['portfolio_filter'];
$portfolio_filters = get_terms('portfolio_filter');
$slug = $post->post_name;

$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}
?>

<div id="<?php echo $slug; ?>" class="section">

	<div class="container section-heading text-center">
		<h2 class="title"><span><?php if( get_post_meta( get_the_ID(), '_tt_title', true ) ) { echo get_post_meta( get_the_ID(), '_tt_title', true ); } else { the_title(); } ?></span></h2>
		<?php if( get_post_meta( get_the_ID(), '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( get_the_ID(), '_tt_subtitle', true ) . '</p>'; } ?>
	</div>
	
	<?php if( ! $portfolio_full_width ) { ?>
	<div class="container">
	<?php } ?>
	
	<?php if( $portfolio_filter_on ) { ?>
	<!-- Portfolio Filter -->
	<ul id="portfolio-filter" class="list-inline">
		<li class="active"><a href="#" data-filter="*"><span class="type"><?php _e('All', 'tt'); ?></span></a></li>
		<?php foreach($portfolio_filters as $portfolio_filter) { ?>
	  <li><a href="#" data-filter=".<?php echo $portfolio_filter->slug; ?>"><span class="type"><?php echo $portfolio_filter->name; ?></span></a></li>
		<?php } ?>
	</ul>
	<?php } ?>
	
	<!-- Project List -->
	<div class="clearfix"></div>
	 <?php echo do_action('class_portfolio_list'); ?>
	<ul id="portfolio-list">
	<?php 
	global $wp_query, $post;
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args = array(
    'post_type' 			=> 'portfolio',
    'posts_per_page' 	=> '-1', // Show all projects
    'post_status' 		=> 'publish',
    'order' 					=> 'ASC',
    'orderby' 				=> 'date',
    'paged' 					=> $paged
  );
  
  $wp_query = new WP_Query($args);
  if( have_posts() ) : 
  while ( $wp_query->have_posts() ) : $wp_query->the_post();
	$project_categories = get_the_terms( get_the_ID(), 'portfolio_filter' ); 
	$project_categorie_list = strip_tags( get_the_term_list(get_the_ID(), 'portfolio_filter', '', ', ', '') );
	?>
  <li class="<?php if( $project_categories ) { foreach ($project_categories as $project_category) { echo $project_category->slug . ' '; } } ?>">
  	<?php if ( has_post_thumbnail()) {
  		$attachment_id =  get_post_thumbnail_id();
			$attachment_array = wp_get_attachment_image_src( $attachment_id, 'portfolio_grid' );		
			$attachment_url = $attachment_array[0];
  	?>
  	<?php
  	if ( $portfolio_mode ) { ?>
	  	<a href="<?php $slug = $post->post_name; echo home_url('/') . get_post_type() . '/' . $slug; ?>">
  	<?php 
  	}
  	else {
  	?>
  	<a href="#<?php $slug = $post->post_name; echo $slug; ?>">
  	<?php } ?>
	  	<div class="project-thumbnail">
		  	<img src="<?php echo $attachment_url; ?>" alt="" />
	  	</div>
	  	<div class="portfolio-item-content <?php echo $project_meta_data; ?>">
				<div class="wrapper">
					<div class="inner">
						<div class="header"><?php echo the_title(); ?></div>
						<div class="separator"></div>
						<p class="body"><?php echo $project_categorie_list; ?></p>
					</div>
				</div>
			</div>
		</a>
  	<?php } ?>
  </li>
  <?php
	endwhile;
	endif;
	wp_reset_query();
	?>
	</ul>
	
	<?php if( ! $portfolio_full_width ) { ?>
		</div><!-- .container -->
	<?php } ?>

	<!-- Project Expander -->
	<div id="project-container">
		<div class="project-loadbox">
			<div class="spinner-css">
				<div class="dot1"></div>
				<div class="dot2"></div>
			</div>
		</div>
	  <div class="project-navigation">
			<button type="button" class="prev"><i class="fa fa-angle-left"></i></button>
			<button type="button" class="close">&times;</button>
		  <button type="button" class="next"><i class="fa fa-angle-right"></i></button>
	  </div>
	  <div class="project-content">
		  <!-- Open project will be loaded here via AJAX load() -->
	  </div>
	</div>
	
	<div id="projects">

	<?php
	
	global $post;
	global $wp_query;
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args = array(
    'post_type' 			=> 'portfolio',
    'posts_per_page' 	=> '-1', // Show all projects
    'post_status' 		=> 'publish',
    'order' 					=> 'ASC',
    'orderby' 				=> 'date',
    'paged' 					=> $paged
  );
  
  $wp_query = new WP_Query($args);
	if( have_posts() ) : 
  while ( $wp_query->have_posts() ) : $wp_query->the_post();
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
	  </div>
	  <?php } ?>
	
	</div>

  <?php
	endwhile;
	endif;
	wp_reset_query();
	
	?>
	
	</div><!-- #projects -->

</div>