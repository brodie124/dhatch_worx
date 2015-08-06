<?php /* Post Type: Portfolio */

function tt_register_portfolio() {  
	
	$labels = array(
		'name' 								=> __( 'Portfolio', 'tt' ),
		'singular_name' 			=> __( 'Project', 'tt' ),
		'menu_name' 					=> __( 'Portfolio', 'tt' ),
		'add_new' 						=> __( 'Add New Project', 'tt' ),
		'add_new_item' 				=> __( 'Add New Project', 'tt' ),
		'edit_item' 					=> __( 'Edit Project', 'tt' ),
		'new_item' 						=> __( 'Add New Project', 'tt' ),
		'view_item' 					=> __( 'View Project', 'tt' ),
		'search_items' 				=> __( 'Search Portfolio', 'tt' ),
		'not_found' 					=> __( 'No project found', 'tt' ),
		'not_found_in_trash' 	=> __( 'No project found in trash', 'tt' )
	);
	
  $args = array(  
    'labels' 						=> $labels, 
    'public' 						=> true,  
    'show_ui' 					=> true,  
    'show_in_admin_bar' => true,
    'menu_position' 		=> 20,
    'menu_icon' 				=> 'dashicons-portfolio',
    'supports' 					=> array('title', 'editor', 'thumbnail'),
    'rewrite' 					=> array('slug' => 'project')
  );  

  register_post_type( 'portfolio' , $args );
   
}

register_taxonomy( 'portfolio_filter', 'portfolio', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Project Categories', 'tt' ),
    	'singular_name' 							=> __( 'Project Category', 'tt' ),
    	'search_items' 								=> __( 'Search Project Categories', 'tt' ),
    	'popular_items' 							=> __( 'Popular Project Categories', 'tt' ),
    	'all_items' 									=> __( 'All Project Categories', 'tt' ),
    	'edit_item' 									=> __( 'Edit Project Category', 'tt' ),
    	'update_item' 								=> __( 'Update Project Category', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Project Category', 'tt' ),
    	'new_item_name' 							=> __( 'New Project Category Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Project Categories With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Project Categories', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Project Categories', 'tt' ),  
    	'parent' 											=> __( 'Parent Project Category', 'tt' )      	
    	),
    'hierarchical'			=> false,
    'query_var' 				=> true,  
    'rewrite' 					=> true,
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-types table
	)  
);
	
add_action( 'init', 'tt_register_portfolio' );

// Custom Portfolio Columns
function tt_portfolio_columns($portfolio_custom_columns) {
	$portfolio_custom_columns = array(
		'cb' 								=> '<input type=\'checkbox\' />',
		'format' 						=> __('Thumbnail', 'tt'), // Choosing 'format' as it has a width of 10%
		'title' 						=> __('Title' ,'tt'),
		'portfolio_filter'	=> __('Categories' ,'tt'),
		'author' 						=> __('Author', 'tt'),
		'date' 							=> __('Date', 'tt'),
	);
	return $portfolio_custom_columns;
}
add_filter('manage_portfolio_posts_columns', 'tt_portfolio_columns');

function tt_portfolio_custom_columns($portfolio_custom_columns, $id) {
	if($portfolio_custom_columns === 'format') {
		echo the_post_thumbnail( array(75,75) );
	}
	
	if($portfolio_custom_columns === 'portfolio_filter') {
		if ( $project_categories = get_the_term_list( $id, 'portfolio_filter', '', ', ', '' ) ) {
			$project_categories = strip_tags( $project_categories );
			echo $project_categories;
		} else {
			echo __('-', 'tt');
		}
	}
	
}
add_action('manage_portfolio_posts_custom_column', 'tt_portfolio_custom_columns', 10, 2);