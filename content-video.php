<div class="header-media">
	<?php 
	
	$video_service = get_post_meta( get_the_ID(), '_tt_blog_video_service', true );
	$video_embed = get_post_meta( get_the_ID(), '_tt_blog_video_embed', true ); 
	
	if ($video_service == 'youtube') {
	  echo '<div class="video-full-width"><iframe src="http://www.youtube.com/embed/' . $video_embed . '" frameborder="0" allowfullscreen></iframe></div>'; 
	}
	else if ($video_service == 'vimeo') {
	  echo '<div class="video-full-width"><iframe src="http://player.vimeo.com/video/' . $video_embed . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>'; 
	}
	else {
		echo '<div class="video-full-width">' . $video_embed . '</div>';
	}
		
	?>
</div>

<div class="entry-header">
	<?php if( is_single() ) {
		the_title( '<h2 class="title post-title">', '</h2>' );
	}
	else {
		the_title( '<h2 class="title post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
	}?>
</div>