<div class="header-media">
	<?php
	$audio_oembed = get_post_meta( get_the_ID(), "_tt_blog_audio_oembed", true );
	$audio_url = get_post_meta( get_the_ID(), '_tt_blog_audio_url', true );
	
	if( $audio_oembed ) {
		echo wp_oembed_get( $audio_oembed );  
	}
	if( $audio_url ) {
		echo '<audio controls="controls"><source src="' . $audio_url . '" /></audio>'; 
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