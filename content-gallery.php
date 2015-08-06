<?php
$gallery = get_post_meta( get_the_ID(), "_tt_blog_gallery_slideshow", false );
?>
<div class="header-media">

	<ul class="slideshow-controls list-unstyled">
	<?php
	
	$args = array(
		'post_type' => 'attachment',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post__in' => $gallery,
		'posts_per_page' => count($gallery)
	);
	
	$gallery_array = get_posts( $args );
	
	foreach ($gallery_array as $slide) {
		$attachment = wp_get_attachment_image_src( $slide->ID, 'wide' );
		$attachment_url = $attachment[0];
	?>
		<li><img src="<?php echo $attachment_url; ?>" /></li>
	<?php 
	}
	?>
	</ul>
	
</div>

<div class="entry-header">
<?php if( is_single() ) {
	the_title( '<h2 class="title post-title">', '</h2>' );
}
else {
	the_title( '<h2 class="title post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
}?>
</div>