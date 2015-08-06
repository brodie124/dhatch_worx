<?php /* Post Type: Team */

function tt_register_team() {  
	
	$labels = array(
		'name' 								=> __( 'Team', 'tt' ),
		'singular_name' 			=> __( 'Team Member', 'tt' ),
		'menu_name' 					=> __( 'Team', 'tt' ),
		'add_new' 						=> __( 'Add New Team Member', 'tt' ),
		'add_new_item' 				=> __( 'Add New Team Member', 'tt' ),
		'edit_item' 					=> __( 'Edit Team Member', 'tt' ),
		'new_item' 						=> __( 'Add New Team Member', 'tt' ),
		'view_item' 					=> __( 'View Team Member', 'tt' ),
		'search_items' 				=> __( 'Search Team', 'tt' ),
		'not_found' 					=> __( 'No team member found', 'tt' ),
		'not_found_in_trash' 	=> __( 'No team member found in trash', 'tt' )
	);
	
  $args = array(  
    'labels' 						=> $labels, 
    'public' 						=> true,  
    'show_ui' 					=> true,  
    'show_in_admin_bar' => true,
    'menu_position' 		=> 20,
    'menu_icon' 				=> 'dashicons-groups',
    'supports' 					=> array('title', 'editor', 'thumbnail'),
    'rewrite' 					=> array('slug' => 'team')
  );  

  register_post_type( 'team' , $args );
   
}

/*
register_taxonomy( 'team_filter', 'team', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Team Member Categories', 'tt' ),
    	'singular_name' 							=> __( 'Team Member Category', 'tt' ),
    	'search_items' 								=> __( 'Search Team Member Categories', 'tt' ),
    	'popular_items' 							=> __( 'Popular Team Member Categories', 'tt' ),
    	'all_items' 									=> __( 'All Team Member Categories', 'tt' ),
    	'edit_item' 									=> __( 'Edit Team Member Category', 'tt' ),
    	'update_item' 								=> __( 'Update Team Member Category', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Team Member Category', 'tt' ),
    	'new_item_name' 							=> __( 'New Team Member Category Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Team Member Categories With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Team Member Categories', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Team Member Categories', 'tt' ),  
    	'parent' 											=> __( 'Parent Team Member Category', 'tt' )      	
    	),
    'hierarchical'			=> false,
    'query_var' 				=> true,  
    'rewrite' 					=> true,
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-types table
	)  
);
*/
	
add_action( 'init', 'tt_register_team' );

// Custom Team Columns
function tt_team_columns($team_custom_columns) {
	$team_custom_columns = array(
		'cb' 								=> '<input type=\'checkbox\' />',
		'format' 						=> __('Thumbnail', 'tt'), // Choosing 'format' as it has a width of 10%
		'title' 						=> __('Name' ,'tt'),
//		'team_filter'				=> __('Categories' ,'tt'),
//		'author' 						=> __('Author', 'tt'),
//		'date' 							=> __('Date', 'tt'),
	);
	return $team_custom_columns;
}
add_filter('manage_team_posts_columns', 'tt_team_columns');

function tt_team_custom_columns($team_custom_columns, $id) {
	if($team_custom_columns === 'format') {
		echo the_post_thumbnail( array(75,75) );
	}
	
	if($team_custom_columns === 'team_filter') {
		if ( $project_categories = get_the_term_list( $id, 'team_filter', '', ', ', '' ) ) {
			$project_categories = strip_tags( $project_categories );
			echo $project_categories;
		} else {
			echo __('-', 'tt');
		}
	}
	
}
add_action('manage_team_posts_custom_column', 'tt_team_custom_columns', 10, 2);