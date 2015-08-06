jQuery(document).ready(function() {

	// Check for mobile device
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		jQuery('#video, .video-btn-play, .video-controls').remove();
	}
	// No mobile device detected
	else {

		// Initialize Background Video Plugin
		jQuery(function(){
			jQuery('#video').mb_YTPlayer();
		});

		jQuery('.video-controls').hide();

		// Start Video
		jQuery('#video').on('YTPStart', function() {
			jQuery('#home .background-overlay, #home .wrapper, .video-btn-play, header.navbar').fadeOut(800);
			jQuery('header.navbar').removeClass('show');
			jQuery('.video-controls').fadeIn(1200);
			jQuery('.video-controls .video-btn-pause').show();
			jQuery('.video-controls .video-btn-play').hide();
		});

		// Pause Video
		jQuery('#video').on('YTPPause', function() {
			jQuery('.video-controls').fadeIn(800);
			jQuery('#home .background-overlay, #home .wrapper, header.navbar').fadeIn(1200);
			jQuery('header.navbar').addClass('show');
			jQuery('.video-controls .video-btn-pause').hide();
			jQuery('.video-controls .video-btn-play').show();
		});

		// End of Video
		jQuery("#video").on("YTPEndPlaylist", function() {
			console.log("YTPEndPlaylist");
			jQuery('.video-controls').fadeOut(800);
			jQuery('#home .background-overlay, #home .wrapper, .video-btn-play, header.navbar').fadeIn(1200);
		});

		// Previous / Next Video
		jQuery('.video-btn-prev, .video-btn-next').click(function() {
			jQuery('#home .background-overlay, #home .wrapper, .video-btn-play').hide();
		});

		// Toggle Volume
		jQuery('.video-btn-volume').click(function() {
			jQuery(this).find('i').toggleClass('fa-volume-up fa-volume-off');
		});

	}

});
