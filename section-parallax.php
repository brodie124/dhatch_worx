<?php
global $post, $tt_option;
$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}
?>
<section id="<?php $slug = $post->post_name; echo $slug; ?>" class="parallax" data-stellar-background-ratio="<?php echo $tt_option['parallax_scroll_speed'] ?>">
	<div class="background-overlay"></div>
	<div class="container">
    <?php the_content(); ?>
	</div>		
</section>