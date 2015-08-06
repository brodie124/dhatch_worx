<?php
global $post, $tt_option;
$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}
$contact_address = $tt_option['contact_address'];
$contact_email = $tt_option['contact_email'];
$contact_phone = $tt_option['contact_phone'];
$show_googlemaps = $tt_option['gmap_show'];

$slug = $post->post_name;

$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}

// If thumbnail set, display parallax contact section
if ( has_post_thumbnail() ) {
	$attachment_id =  get_post_thumbnail_id();
	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'fullscreen' );		
	$attachment_url = $attachment_array[0];
?>
<section class="contact parallax" data-stellar-background-ratio="<?php echo $tt_option['parallax_scroll_speed'] ?>">
	<div class="background-overlay"></div>
	<div class="container">
    <div class="contact-address"><?php echo $contact_address; ?></div>
    <div class="contact-phone"><?php echo $contact_phone; ?></div>
    <div class="contact-email"><a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></div>
	</div>		
</section>
<?php
}
?>

<div id="<?php echo $slug; ?>" class="section">
	<div class="container">
	
		<div class="section-heading text-center">
			<h2 class="title"><span><?php if( get_post_meta( get_the_ID(), '_tt_title', true ) ) { echo get_post_meta( get_the_ID(), '_tt_title', true ); } else { the_title(); } ?></span></h2>
			<?php if( get_post_meta( get_the_ID(), '_tt_subtitle', true ) ) { echo '<p class="subtitle">' . get_post_meta( get_the_ID(), '_tt_subtitle', true ) . '</p>'; } ?>
		</div>
		<?php the_content(); ?>
	
	</div>

</div>
<?php if($show_googlemaps) {?>
<div id="googlemap" class="googlemap"></div>
<?php } ?>