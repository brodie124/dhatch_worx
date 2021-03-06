<?php
global $wpdb, $tt_option;
$background_color = get_post_meta( get_the_ID(), '_tt_page_background_color', true );
if ( $background_color ) { 
	echo '<style>#' . $slug . ', #' . $slug . ' .section-heading .title span, #' . $slug . ' .custom-heading .title span { background-color: ' . $background_color . '; }</style>'; 
}
$image_dimension = $tt_option['background_image_dimension'];
$attachment_url = $tt_option['home_background_image']['url'];

// http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
// Get the upload directory paths
$upload_dir_paths = wp_upload_dir();

// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

	// If this is the URL of an auto-generated thumbnail, get the URL of the original image
	$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

	// Remove the upload path base directory from the attachment URL
	$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

	// Finally, run a custom database query to get the attachment ID from the modified attachment URL
	$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

}

if ( $image_dimension == "original" ) {
	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'fullscreen' );
}
else {
	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'col12' );
}
$attachment_url = $attachment_array[0];
?>
<div id="home" class="parallax" style="background-image: url(<?php echo $attachment_url; ?>)" data-stellar-background-ratio="<?php echo $tt_option['parallax_scroll_speed'] ?>">
	<div class="background-overlay"></div>
	<div class="container">
		<div class="wrapper">
			<div class="inner">
				<?php the_content(); ?>
			</div>
		</div>	
	</div>
</div><!-- #home -->