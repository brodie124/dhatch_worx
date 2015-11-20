jQuery(document).ready(function() {

	// Check for mobile device
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		jQuery('#video, .video-btn-play, .video-controls').remove();
	} else {
        // No mobile device detected
		// Initialize Background Video Plugin
		jQuery(function(){
			jQuery('#video').mb_YTPlayer();
		});

        var $video = jQuery("#video");

		// Start Video
		$video.on('YTPStart', function() {
            setNavbarVisible(false);
			jQuery('.mb_YTVPBar').css('visibility', 'visible');
		});

		// Pause Video
        $video.on('YTPPause', function() {
            setNavbarVisible(true);
			jQuery('#video').trigger('YTPEnd');
		});

		// End of Video
        $video.on("YTPEndPlaylist", function() {
            setNavbarVisible(true);

		});

		// Previous / Next Video
		jQuery('.video-btn-prev, .video-btn-next').click(function() {
			setNavbarVisible(false);
		});

		// Toggle Volume
		jQuery('.video-btn-volume').click(function() {
			jQuery(this).find('i').toggleClass('fa-volume-up fa-volume-off');
		});











        //SET VISIBILITY OF NAVIGATION BAR
        function setNavbarVisible(state) {
            var $navbar = jQuery('#home .background-overlay, #home .wrapper, header.navbar');
            if(state) {

                //MAKE VISIBLE
                $navbar.fadeIn(1200);
                jQuery('header.navbar').addClass('show');

            } else {

                //MAKE INVISIBLE
                $navbar.fadeOut(800);
                jQuery('header.navbar').removeClass('show');

            }

            setVideoControlsVisible(!state);
        }

        function setVideoControlsVisible(state) {
            var $btnPause = jQuery('.video-controls .video-btn-pause');
            var $btnPlay = jQuery('.video-controls .video-btn-play');
            var $btnVolume = jQuery('.video-controls .video-btn-volume');

            if(state) {
                jQuery('.video-controls').fadeIn(1200);
                jQuery('.mb_YTVPProgress').fadeIn(1200);
                $btnPause.show();
                $btnVolume.show();
                $btnPlay.hide();
            } else {
                jQuery('.video-controls').fadeIn(1200);
                jQuery('.mb_YTVPProgress').fadeOut(1200);
                $btnPause.hide();
                $btnVolume.hide();
                $btnPlay.show();
            }
        }

	}

});
