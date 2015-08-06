<?php
function tt_custom_styles() {
global $tt_option, $post;
?>

<!-- CUSTOM STYLES -->
<style type="text/css">
<?php

$args = array(
	'post_type' => 'page',
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'posts_per_page' => '-1'
);

$query = new WP_Query($args);

if( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

$image_dimension = $tt_option['background_image_dimension'];
$slug = $post->post_name;
$frontpage = get_post_meta( $post->ID, '_tt_is_frontpage', true );
$section = get_post_meta( $post->ID, '_tt_is_section', true );

if ( $section == "parallax" && has_post_thumbnail() ) {
	$attachment_id =  get_post_thumbnail_id();
	if ( $image_dimension == "original" ) {
		$attachment_array = wp_get_attachment_image_src( $attachment_id, 'fullscreen' );
	}
	else {
		$attachment_array = wp_get_attachment_image_src( $attachment_id, 'col12' );
	}
	$attachment_url = $attachment_array[0];
?>
#<?php echo $slug; ?> { background-image: url(<?php echo $attachment_url; ?>); }
<?php
}

if ( $section == "contact" && has_post_thumbnail() ) {
	$attachment_contact_id = get_post_thumbnail_id();
	if ( $image_dimension == "original" ) {
		$attachment_contact_array = wp_get_attachment_image_src( $attachment_contact_id, 'fullscreen' );
	}
	else {
		$attachment_contact_array = wp_get_attachment_image_src( $attachment_contact_id, 'col12' );
	}
	$attachment_contact_url = $attachment_contact_array[0];
?>
.contact.parallax { background-image: url(<?php echo $attachment_contact_url; ?>); }
<?php
}
endwhile;
endif;
?>

#loadbox { background-color: <?php echo $tt_option['loadbox_background_color']; ?>; }

.background-overlay {
opacity: <?php $background_overlay_opacity = $tt_option['background_overlay_opacity'] / 100; echo $background_overlay_opacity; ?>;
<?php if ( empty($tt_option['custom_overlay_pattern']['url']) && $tt_option['overlay_pattern_url'] != "none" ) { echo 'background-image: url(' . get_template_directory_uri() . '/images/patterns/' . $tt_option['overlay_pattern_url'] . '.png);'; } else if ( !empty($tt_option['custom_overlay_pattern']['url']) ) { echo 'background-image: url(' . $tt_option['custom_overlay_pattern']['url'] . ');'; } ?>

}

#footer { color: <?php echo $tt_option['footer_text_color']; ?>; background-color: <?php echo $tt_option['footer_background_color']; ?>; }
#footer a, #footer .fa { color: <?php echo $tt_option['footer_link_color']; ?>; }
#footer a:hover, #footer a:hover .fa { color: <?php echo $tt_option['footer_link_hover_color']; ?>; }

a, a:hover, a:focus, .color-primary,
#timeline #dates a:hover {
  color: <?php echo $tt_option['accent_color']; ?>;
}

.btn-default:hover,
.btn-primary, .btn-primary:focus, .btn-primary:active,
.progress-bar, .progress:hover .progress-bar,
[type="submit"],
#home .color > span,
#home-layout-split-color,
.service .service-title .title, .service .btn:hover,
.pricing-table .pricing-inner.popular .pricing-title,
.pricing-table .close.btn:hover,
.entry-content .bx-wrapper .bx-controls .bx-controls-direction a,
#sidebar ul #widget_tag_cloud a:hover,
#comments #comment-nav-below a:hover {
  background: <?php echo $tt_option['accent_color']; ?>;
}

.arrow-up { border-bottom-color: <?php echo $tt_option['accent_color']; ?>; }
.arrow-down, .pricing-table .pricing-inner.popular .arrow-down { border-top-color: <?php echo $tt_option['accent_color']; ?>; }
.arrow-right { border-left-color: <?php echo $tt_option['accent_color']; ?>; }
.arrow-left { border-right-color: <?php echo $tt_option['accent_color']; ?>; }

body.section-title-style-square .section-heading span,
body.section-title-style-square .custom-heading span {
	border-color: <?php echo $tt_option['typography_section_title']['color']; ?>;
}

<?php echo $tt_option['custom_styles']."\n"; ?>
</style>

<?php }
add_action( 'wp_head', 'tt_custom_styles', 100 );

function tt_custom_scripts() {
?>
<script>
jQuery(document).ready(function() {
<?php
global $tt_option;
$home_background_feature = $tt_option['home_background_feature'];
// Project Title & Categories
$project_meta_data = $tt_option['project_meta_data'];
if ( $project_meta_data == 'meta-data-hover' ) { ?>
// Direction Aware Hover Effect
if ( jQuery.isFunction( jQuery.fn.hoverdir ) ) {
	jQuery('#portfolio-list').find('.portfolio-item-content').each(function() {
		jQuery(this).hoverdir({
			speed : 			200,
			hoverDelay : 	100
		});
	});
}
<?php
}
$portfolio_mode = $tt_option['portfolio_mode'];
if ( !$portfolio_mode ) {
?>
jQuery('#portfolio-list li').find('a').click(function(e) {
e.preventDefault();
});
<?php
}
$video_ids = $tt_option['home_video_id'];
// TYPlayer Script
if( $home_background_feature == "video" || is_page_template('demo-video.php') ) {
?>
var autoplay =  <?php echo ($tt_option['home_video_auto_start_on']) ? 'true' : 'false'; ?>;

var videos = [
<?php
// Strip away all spaces
$video_ids = preg_replace('/\s+/', '', $video_ids);
$video_ids = explode( ',', $video_ids );
foreach( $video_ids as $video_id ) {
	// Autoplay Video On/Off Toggle
	if ( $tt_option['home_video_auto_start_on'] ) {
		echo "{videoURL: '$video_id',containment:'#home',autoPlay:true,loop:true},\n";
	}
	else {
		echo "{videoURL: '$video_id',containment:'#home',autoPlay:false,loop:false},\n";
	}
}
?>
];
var count = videos.length;
// Only Show Prev / Next Button, when there are at least two videos
if(count < 2) {
	jQuery('.video-btn-prev, .video-btn-next').remove();
}
var videoCounter = 1;
jQuery("#video").YTPlaylist(videos, false, nextVideo() ); // Parameter 2 = Shuffle (Default: false)
function nextVideo() {

  jQuery("#video").on("YTPEnd", function() {
    videoCounter++;
	if(videoCounter < count || autoplay) {
    	jQuery("#video").changeMovie(videos[videoCounter]);
	} else {
		setTimeout(function() {
			jQuery("#video").trigger('YTPEndPlaylist');
		}, 100);

	}
	});
}
<?php
} // ENDIF YTPlayer Script
if ( $tt_option['menu_mobile_static'] ) {
?>

if ( isMobile ) {
	jQuery('header.navbar').addClass('mobile');
}
<?php } // ENDIF Static Mobile Navigation ?>
});
<?php if ( $tt_option['home_slideshow_auto_start_on'] ) { ?>
// Home Slideshow Auto Start ON
jQuery(window).load(function() {

	var sectionSlideshow = jQuery('.slideshow-home').bxSlider({
		auto: 					true,
		mode: 					'fade',
		pause: 					5000,
		speed: 					1000,
		adaptiveHeight: true,
		controls: 			true,
		pager: 					false,
		prevText: 			'<i class="fa fa-angle-left"></i>',
	  nextText: 			'<i class="fa fa-angle-right"></i>',
		oneToOneTouch: 	false
	});

	// Stop Auto Play
	jQuery('body, iframe').click(function() {
		sectionSlideshow.stopAuto();
	});

});
<?php } ?>
</script>
<?php
$show_googlemaps = $tt_option['gmap_show'];
$contact_address = $tt_option['contact_address'];
$gmap_zoom = $tt_option['gmap_zoom'];
//$gmap_zoom = intval($gmap_zoom);
$gmap_marker_color = $tt_option['gmap_marker_color'];
$gmap_marker_html = $tt_option['gmap_marker_html'];
$gmap_marker_popup = $tt_option['gmap_marker_popup'];
// Theme Options: Show Google Maps -> Load scripts
if( $show_googlemaps) {?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#googlemap").gMap({
			address: "<?php echo $contact_address; ?>",
			zoom: <?php echo $gmap_zoom; ?>,
			markers:[
				{
					address: "<?php echo $contact_address; ?>",
					html: "<?php echo $gmap_marker_html; ?>",
					popup: <?php echo $gmap_marker_popup;  ?>,
					icon: {
						image: "<?php echo get_template_directory_uri(); ?>/images/marker-<?php echo $gmap_marker_color; ?>.png",
						iconsize: [38, 53],
            iconanchor: [19,53]
					}
				}
			]
		});
	});
</script>
<?php } // ENDIF Googlemap ?>
<?php
// Run SlabText after all Google Fonts finished loading


$default_fonts = 	array(
										"Arial, Helvetica, sans-serif",
						        "'Arial Black', Gadget, sans-serif",
						        "'Bookman Old Style', serif",
						        "'Comic Sans MS', cursive",
						        "Courier, monospace",
						        "Garamond, serif",
						        "Georgia, serif",
						        "Impact, Charcoal, sans-serif",
						        "'Lucida Console', Monaco, monospace",
						        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
						        "'MS Sans Serif', Geneva, sans-serif",
						        "'MS Serif', 'New York', sans-serif",
						        "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
						        "Tahoma,Geneva, sans-serif",
						        "'Times New Roman', Times,serif",
						        "'Trebuchet MS', Helvetica, sans-serif",
						        "Verdana, Geneva, sans-serif"
									);
$font_faces = array(
$tt_option['typography_body']['font-family'],
$tt_option['typography_menu']['font-family'],
$tt_option['typography_section_title']['font-family'],
$tt_option['typography_section_subtitle']['font-family'],
$tt_option['typography_h1']['font-family'],
$tt_option['typography_h2']['font-family'],
$tt_option['typography_h3']['font-family'],
$tt_option['typography_h4']['font-family'],
$tt_option['typography_h5']['font-family'],
$tt_option['typography_h6']['font-family'],
);
$font_faces = array_unique($font_faces);

foreach( $font_faces as $font_face ) {
	if( !in_array( $font_face, $default_fonts ) ) {
		$font_face_array[] = $font_face;
	}
}

$font_face_array = implode("','", $font_face_array);
?>
<script>
function slabTextHeadlines() {
  jQuery('#home .stretch').slabText({
    // Don't run slabtext if viewport is under 380px
    'viewportBreakpoint' : 380
  });
};

WebFont.load({
	google: { families: [ <?php echo "'" . $font_face_array . "'"; ?> ] },
	active: function() {
		slabTextHeadlines();
	}
});
</script>

<?php if( is_single() && isset( $tt_option['blog_social_sharing'] ) ) { ?>
<script>
/* Blog: Social Sharing
-------------------------*/
<?php if( isset( $tt_option['blog_social_sharing']['twitter'] ) ) { ?>
jQuery('#share-twitter').sharrre({
  share: {
    twitter: true
  },
  template: '<a class="box" href="#"><div class="share"><i class="fa fa-twitter social-color"></i></div><div class="count" href="#">{total}</div></a>',
  enableHover: false,
  enableTracking: true,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('twitter');
  }
});
<?php }
if( isset( $tt_option['blog_social_sharing']['facebook'] ) ) { ?>
jQuery('#share-facebook').sharrre({
  share: {
    facebook: true
  },
  template: '<a class="box" href="#"><div class="share"><i class="fa fa-facebook social-color"></i></div><div class="count" href="#">{total}</div></a>',
  enableHover: false,
  enableTracking: true,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('facebook');
  }
});
<?php }
if( isset( $tt_option['blog_social_sharing']['googleplus'] ) ) { ?>
jQuery('#share-googleplus').sharrre({
  share: {
    googlePlus: true
  },
  template: '<a class="box" href="#"><div class="share"><i class="fa fa-google-plus social-color"></i></div><div class="count" href="#">{total}</div></a>',
  enableHover: false,
  enableTracking: true,
  urlCurl: '<?php echo get_template_directory_uri()  . '/lib/sharrre.php'; ?>',
  click: function(api, options){
    api.simulateClick();
    api.openPopup('googlePlus');
  }
});
<?php }
if( isset( $tt_option['blog_social_sharing']['pinterest'] ) ) { ?>
jQuery('#share-pinterest').sharrre({
  share: {
    pinterest: true
  },
  template: '<a class="box" href="#"><div class="share"><i class="fa fa-pinterest social-color"></i></div><div class="count" href="#">{total}</div></a>',
  enableHover: false,
  enableTracking: true,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('pinterest');
  }
});
<?php } ?>
</script>
<?php } ?>

<?php
global $tt_option;
$custom_scripts = $tt_option['custom_scripts'];
if ( !isset($custom_scripts) || trim($custom_scripts) != "" ) { ?>
<!-- CUSTOM SCRIPTS -->
<script>
jQuery.noConflict();
(function($) {
<?php echo $custom_scripts."\n"; ?>
})(jQuery);
</script>
<?php }
}

add_action( 'wp_footer', 'tt_custom_scripts', 20 );
?>
