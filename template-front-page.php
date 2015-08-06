<?php get_header();

/*
Template name: Frontpage
*/

// http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items
$menu_name = 'primary';

if ( has_nav_menu($menu_name) ) {
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id) ;
	$menu_arry = array();
	foreach ( $menu_items as $item ) {
		$menu_array[] = $item->object_id;
	}
}

// If no menu is set
if ( !isset($menu_array) ) {
	$args = array (
		'post_type' => 'page',
		'ignore_sticky_posts' => 1
	);	
}

// If menu is set
else {
	$args = array (
		'post_type' => 'page', 
		'post__in' => $menu_array, 
		'posts_per_page' => count($menu_array), 
		'orderby' => 'post__in',
		'ignore_sticky_posts' => 1
	);
}

$query_frontpage = new WP_Query( $args );

if( $query_frontpage->have_posts() ) : while ( $query_frontpage->have_posts() ) : $query_frontpage->the_post();
	
	global $post, $tt_option;
	$home_background_feature = $tt_option['home_background_feature'];
	$frontpage = get_post_meta( get_the_ID(), '_tt_is_frontpage', true );
	$section = get_post_meta( get_the_ID(), '_tt_is_section', true );
	
	if ( $frontpage == "1" && $section == "home" ) {
		// Check if Home Section "Slideshow" is selected
		if ( $home_background_feature == "slideshow" ) {	
			get_template_part( 'section-home-slideshow' );
		}
		// Check if Home Section "Video" is selected
		else if ( $home_background_feature == "video" ) {
			get_template_part( 'section-home-video' );
		}
		// If not use Default Home Section (Fullscreen Background Image)
		else {
			get_template_part( 'section-home' );
		}
	}

	else if ( $frontpage == "1" ) {
		get_template_part( 'section', $section );
	}
	
	endwhile;
	
	// No Page Found
	else : echo "<p>No Page Found!</p>";
    
	endif; 
	
	wp_reset_query();

?>

<?php get_footer(); ?>