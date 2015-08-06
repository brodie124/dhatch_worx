<?php
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
		
	<div class="container">
		<ul class="row list-unstyled">
		<?php 
		global $post;
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	  $args = array(
	    'post_type' 			=> 'team',
	    'posts_per_page' 	=> '-1', // Show all team members
	    'post_status' 		=> 'publish',
	    'order' 					=> 'ASC',
	    'orderby' 				=> 'date',
	    'paged' 					=> $paged
	  );
	  
	  $team_members_per_row = get_post_meta( get_the_ID(), '_tt_team_member_per_row', true );
	  $team_member_content_position = get_post_meta( get_the_ID(), '_tt_team_member_content_position', true );
	  
	  $team_query = new WP_Query($args);
	  if( $team_query->have_posts() ) : while ( $team_query->have_posts() ) : $team_query->the_post();
	  $slug = $post->post_name;
		?>
	  <li class="col-sm-<?php echo $team_members_per_row; ?>">
	  
	  	<div class="team-member <?php echo $team_member_content_position; ?>">
	  	
	  	<?php if ( $team_member_content_position == "place-side") { ?>
	  	<div class="row">
	  		<div class="col-sm-4">
	  	<?php } ?>
	  	<?php 
	  	if ( has_post_thumbnail()) {
	  		$attachment_id =  get_post_thumbnail_id();
				$attachment_array = wp_get_attachment_image_src( $attachment_id, 'col4' );		
				$attachment_url = $attachment_array[0];
	  	?>
	  	<img src="<?php echo $attachment_url; ?>" alt="" class="avatar" />
	  	<?php } ?>
	  	<?php if ( !has_post_thumbnail()) { ?>
		  <img src="//placehold.it/400x400/ccc/fff&text=Team+Member" alt="" class="avatar" />
	  	<?php } ?>
	  	
	  	<?php if ( $team_member_content_position == "place-side") { ?>
	  		</div>
				<div class="col-sm-8">
	  	<?php } ?>
	  	
	  	<div class="name"><?php echo the_title(); ?></div>
	  	<div class="overlay">
	  		<h3 class="position"><?php echo get_post_meta( get_the_ID(), '_tt_team_member_position', true ); ?></h3>
	  		<div class="separator"></div>
	  		<?php 
	  		if ( $post->post_content != "" ) {
	  			if ( $team_member_content_position == "place-side") {
		  			the_content();
		  		}
					else { ?>
	  		
	  		<a class="btn btn-default" data-toggle="modal" href="#<?php echo $slug; ?>"><?php _e( 'more', 'tt'); ?></a>
	  		<?php 
	  			} 
	  		}
	  		?>
	  	</div>
	  	
	  	<?php if ( $team_member_content_position == "place-side") { ?>
	  		</div>
			</div>
	  	<?php } ?>
	  	
	  	</div><!-- .team-member -->
	  	
	  	<?php if ( $team_member_content_position != "place-side") { ?>
	  	
	  	<div class="modal fade" id="<?php echo $slug; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $slug; ?>" aria-hidden="true">
	  		<div class="modal-dialog">
	  			<div class="modal-content container">
	  				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	  				<div class="modal-profile">
	  					<div class="row">
	  						<div class="col-md-4 col-sm-6">
	  							<?php if ( has_post_thumbnail()) { ?>
								<img src="<?php echo $attachment_url; ?>" alt="<?php echo the_title(); ?>" class="avatar">
								<?php } else { ?>
								<img src="http://placehold.it/400x400/ccc/fff&text=Team+Member" alt="" />
								<?php } ?>
								<div class="name"><?php echo the_title(); ?></div>
	  						</div>
	  						<div class="col-md-8 col-sm-6">
	  							<div class="details">
	  								<h3 class="position"><?php echo the_title(); //get_post_meta( get_the_ID(), '_tt_team_member_position', true ); ?></h3>
	  								<div class="arrow-down"></div>
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- .modal -->
			
			<?php } ?>
	  	
	  </li>
	  <?php
		endwhile;
		endif;		
		wp_reset_postdata();
		?>
		</ul>
		
	</div>

</div>