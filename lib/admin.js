jQuery(document).ready(function($) {

	// Toggle Metaboxes based on selected Post Format		
	$('#post-formats-select input').change(changeFormat);
	
	function changeFormat() {
		var postFormat = $('#post-formats-select input:checked').attr('value');		
		// Run Only On Posts
		if(typeof postFormat != 'undefined') {			
			// Hide all Post Metaboxes by Default
			$('.postbox-container div[id^=post_type_]').fadeOut();
			// Show Metabox that matches the selected Post Format
			$('.postbox-container #post_type_' + postFormat + '').fadeIn();					
		}
	}
	
	// Toggle Metaboxes based on selected section
	$('#_tt_is_section').change(changeSection);
	
	function changeSection() {
		var isSection = $('#_tt_is_section option:selected').attr('value');		
		if( isSection == "team" ) {
			$('#team_member_row').fadeIn();
		}
		else {
			$('#team_member_row').fadeOut();
		}
	}
	
	$(window).load(function() {
		changeFormat(); // Post Format Meta Boxes
		changeSection(); // Team Meta Boxes
	});
		    
});