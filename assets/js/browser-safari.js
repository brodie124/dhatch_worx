jQuery(window).load(function() {

	var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	
	if( isSafari ) {
		jQuery('.parallax').addClass('safari');
	}

});