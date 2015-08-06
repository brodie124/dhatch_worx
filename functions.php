<?php
define('TT_LIB', get_template_directory()  . '/lib');
define('TT_LIB_URI', get_template_directory_uri()  . '/lib');

// Theme Updater
include_once TT_LIB . '/edd-theme-updater.php';

// Metaboxes: https://github.com/rilwis/meta-box
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/lib/metaboxes' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/lib/metaboxes' ) );
require_once TT_LIB . '/metaboxes/meta-box.php';
include_once TT_LIB . '/metaboxes.php';

// TGM Plugin Activation Class & Config file
require_once TT_LIB . '/class-tgm-plugin-activation.php';
require_once TT_LIB . '/tgm-plugin-activation.php';

// Custom Post Types
include_once TT_LIB . '/team.php';
include_once TT_LIB . '/portfolio.php';

include_once TT_LIB . '/custom-styles-scripts.php';

// Redux Options Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( TT_LIB . '/redux/ReduxCore/framework.php' ) ) {
	require_once( TT_LIB . '/redux/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( TT_LIB . '/redux/worx/worx-config.php' ) ) {
	require_once( TT_LIB . '/redux/worx/worx-config.php' );
}

// Redux: Add FontAwesome Icon Font
function tt_themeOptionsStyles($hook) {
	if( 'themes.php?page=_options' == $hook ) {
  	return;
  }
	// Remove elusive icon from theme option panel
	//wp_deregister_style( 'redux-elusive-icon' );
	//wp_deregister_style( 'redux-elusive-icon-ie7' );
	wp_enqueue_style( 'redux-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), time(), 'all' );  
	wp_enqueue_style( 'redux-custom-css', TT_LIB_URI . '/redux/worx/style.css', array( 'redux-css' ), time(), 'all' );  
}
//add_action( 'redux/page/tt_option/enqueue', 'tt_themeOptionsFontawesome' );
add_action( 'admin_enqueue_scripts', 'tt_themeOptionsStyles' );


// Add custom body class to <head>
function tt_body_class( $classes ) {
	global $tt_option;
	//$classes[] = 'loading'; Disabled, because of Chrome's 33 CSS new animation
	$site_style = $tt_option['site_style'];
	$classes[] = $site_style;
	$section_title_style = $tt_option['section_title_style'];
	$classes[] =  $section_title_style;
	return $classes;
}
add_filter( 'body_class', 'tt_body_class' );


// Load Admin Script
function tt_admin_scripts() {	
	wp_register_script('tt_admin_script', TT_LIB_URI .'/admin.js' );
	wp_enqueue_script('tt_admin_script');
}
add_action('admin_enqueue_scripts', 'tt_admin_scripts');

if ( ! isset( $content_width ) ) {
	$content_width = 1170; 
}
	 
function tt_scripts_styles() {
	
	global $tt_option;
	$home_background_feature = $tt_option['home_background_feature'];

	// Stylesheets		
	wp_enqueue_style( 'tt_font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', null, null );
	wp_enqueue_style( 'tt_bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css', null, null );
	if ( $home_background_feature == "video" || is_page_template('demo-video.php') ) {
		wp_enqueue_style( 'ytplayer', get_template_directory_uri() . '/assets/css/YTPlayer.css', null, null );
	}
	wp_deregister_style( 'contact-form-7' ); // Deregister Contact Form 7 CSS
	wp_enqueue_style( 'tt_style', get_stylesheet_uri(), null, null );
	
	// Scripts
	wp_enqueue_script('jquery');
	//wp_enqueue_script( 'tt_webfontloader', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js', array( 'jquery'), null, true );
	wp_enqueue_script( 'tt_webfontloader', get_template_directory_uri() . '/assets/js/webfont.min.js', array( 'jquery'), null, true );		
	wp_enqueue_script( 'tt_slabtext', get_template_directory_uri() . '/assets/js/jquery.slabtext.min.js', array( 'jquery'), null, true );		
	wp_enqueue_script( 'tt_bxslider', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array( 'jquery'), null, true );		
	wp_enqueue_script( 'tt_parallax', get_template_directory_uri() . '/assets/js/jquery.stellar.min.js', array( 'jquery'), null, true );
	wp_enqueue_script( 'tt_timelinr', get_template_directory_uri() . '/assets/js/jquery.timelinr-0.9.54.min.js', array( 'jquery'), null, true );
	wp_enqueue_script( 'tt_isotope', get_template_directory_uri() . '/assets/js/jquery.isotope.min.js', array( 'jquery'), null, true );
	wp_enqueue_script( 'tt_hoverdir', get_template_directory_uri() . '/assets/js/jquery.hoverdir.min.js', array( 'jquery'), null, true );	
	wp_enqueue_script( 'tt_fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.min.js', array( 'jquery'), null, true );
	wp_enqueue_script( 'tt_bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', null, null, true );		
	//wp_enqueue_script( 'tt_bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery'), null, true );
	
	if ( is_single() ) {
		wp_enqueue_script( 'tt_sharrre', get_template_directory_uri() . '/assets/js/jquery.sharrre.min.js', array( 'jquery'), null, true );
	}
	
  // Absolute Template Path
  $tt_abs_path = array( 'template_url' => get_template_directory_uri() );
  wp_localize_script( 'jquery', 'abspath', $tt_abs_path );   
  
  wp_enqueue_script( 'tt_waypoints', get_template_directory_uri() . '/assets/js/waypoints.min.js', array( 'jquery'), null, true );
	if ( $tt_option['gmap_show'] ) { 
		wp_enqueue_script( 'tt_gmap_api', '//maps.google.com/maps/api/js?sensor=false', array( 'jquery'), null, true );
		wp_enqueue_script( 'tt_gmap', get_template_directory_uri() . '/assets/js/jquery.gmap.min.js', array( 'jquery'), null, true );
	}
	wp_enqueue_script( 'tt_theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery'), null, true );
	
	if ( $home_background_feature == "video" || is_page_template('demo-video.php') ) {
		wp_enqueue_script( 'tt_ytplayer', get_template_directory_uri() . '/assets/js/jquery.mb.YTPlayer.js', array( 'jquery'), null, true );
		wp_enqueue_script( 'tt_theme_video', get_template_directory_uri() . '/assets/js/theme-video.js', array( 'jquery', 'tt_ytplayer'), null, true );
	}
	
	if ( $tt_option['safari_parallax_on'] == false ) {
		wp_enqueue_script( 'tt_safari', get_template_directory_uri() . '/assets/js/browser-safari.js', array( 'jquery'), null, true );
	}
	
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'tt_scripts_styles' );

function tt_setup() {
	load_theme_textdomain( 'tt', get_template_directory() . '/languages' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails and declare custom sizes.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'wide', 1200, 400, true );
	add_image_size( 'col12', 1200, 9999, false );
	add_image_size( 'col6', 600, 9999, false );
	add_image_size( 'col4', 400, 9999, false );
	add_image_size( 'col3', 300, 9999, false );
	add_image_size( 'portfolio_grid', 600, 400, true );
	
	// This theme uses wp_nav_menu()
	register_nav_menus( array( 'primary' => __( 'Menu', 'tt' ) ) );
	register_nav_menus( array( 'footer' => __( 'Footer', 'tt' ) ) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	// Enable support for Post Formats - http://codex.wordpress.org/Post_Formats
	add_theme_support( 'post-formats', array( 'gallery', 'audio', 'video', 'quote', 'link' ) );
	// Allow users to set a custom background.
	add_theme_support( 'custom-background', array( 'default-color' => 'fff'	) );
	
}
add_action( 'after_setup_theme', 'tt_setup' );

register_sidebar(array(
 	'name' 					=> __('Blog Sidebar','tt' ),
 	'id'   					=> 'sidebar',
  'description'   => __( 'The following widgets will show on your blog:','tt' ),
  'before_widget' => '<li id="%2$s" class="widget">',
  'after_widget'  => '</li>',
  'before_title'  => '<div class="custom-heading"><h5 class="title"><span>',
	  'after_title'   => '</span></h5></div>'
));  

// Change .current-menu-item to .active
function tt_nav_current_class( $classes, $item ) {
	if( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'active ';
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'tt_nav_current_class' , 10 , 2);

// Worx Shortcodes Only Formatting <p> and <br /> tags
function tt_shortcodes_formatting($content) {
	global $shortcode_tags;
	//$shortcodes = join( '|', array_map( 'preg_quote', array_keys( $shortcode_tags ) ) );
	
	// Apply filter to Worx Shortcodes Only
	$shortcodes_worx = array("home_buttons", "animation", "button_light", "button_dark", "home_title_color", "stretch", "home_layout_split_color", "home_layout_split_light", "home_layout_split_dark", "row", "one_half", "one_third", "two_third", "one_fourth", "three_fourth", "one_sixth", "five_sixth", "button", "accordion", "toggle", "tabs", "tab", "alert", "jumbotron", "map", "icon", "clearfix", "whitespace", "text_left", "text_center", "text_right", "text_justify", "list", "list_item", "fullwidth", "quote", "section_heading", "custom_heading", "timeline", "timeline_dates", "timeline_date", "timeline_events", "timeline_event", "social", "skill", "team_member", "slideshow", "slide", "slideshow_clients", "slide_quote", "service", "pricing_table", "pricing_column", "twitter");

	$shortcodes = join( '|', $shortcodes_worx );
	
	$content = preg_replace("/(<p>)?\[($shortcodes)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
	$content = preg_replace("/(<p>)?\[\/($shortcodes)](<\/p>|<br \/>)/","[/$2]",$content);

	return $content;
}
add_filter('the_content', 'tt_shortcodes_formatting');
add_filter('widget_text', 'tt_shortcodes_formatting');

// Extend nav menu walker class to change page section links to anchors
// http://www.themevan.com/build-an-one-page-portfolio-website-with-wordpress/
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=array(), $id=0) {
	
		global $wp_query, $tt_option;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes = array_slice($classes, 1);
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		
		if ( has_nav_menu('primary') ) {
		
			$section = get_post_meta( $item->object_id, '_tt_is_section', true );
			
			if( $section != "parallax" || $section == "parallax" && $tt_option['menu_show_parallax'] ) {
			
				if ( $item->object == 'page' ) {
				
					$varpost = get_post($item->object_id);                
					$frontpage = get_post_meta( $item->object_id, '_tt_is_frontpage', true );
					$hide_menu_link = get_post_meta( $item->object_id, '_tt_hide_menu_link', true );
										
					if ( $hide_menu_link == false ) {
					
						$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
						
						// DEMO ONLY xxx
						if ( is_page_template('demo-slideshow.php') || is_page_template('demo-video.php') ) {
							$attributes .= ' href="#' . $varpost->post_name . '"';	
						}
						// END DEMO ONLY
						
						else {
							if ( $frontpage == "1" )
								if (is_front_page()) 
									$attributes .= ' href="#' . $varpost->post_name . '"'; 
								else 
									$attributes .= ' href="' . home_url() . '#' . $varpost->post_name . '"';	
							else {
								$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url ) .'"' : '';
							}
						}
						
						$item_output  = $args->before;
						$item_output .= '<a'. $attributes .'>';
						$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
						$item_output .= $args->link_after;
						$item_output .= '</a>';
						$item_output .= $args->after;

						$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );            	              	
					          
					}
					
				}
				
				else {
					
					$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
					$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';	
					$item_output = $args->before;
					$item_output .= '<a'. $attributes .'>';
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
					$item_output .= $args->link_after;
					$item_output .= '</a>';
					$item_output .= $args->after;
					
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
				
				}
				
			}  // END if parallax menu links enabled in Theme Options
				
		} // END if primary menu
	
	} // start_el
	
	function end_el(&$output, $item, $depth=0, $args=array()) {
    $output .= "</li>\n";
  }
	
}

// Run shortcodes in excerpt. Cuts off after 100 words
function tt_shortcode_and_more_in_excerpt( $excerpt ) {
	global $post;
	return "<div class=\"excerpt\">" . do_shortcode( wp_trim_words( $excerpt, 55 ) ) . '<p class="more-link"><a class="btn btn-default" href="'. get_permalink($post->ID) . '">Read More</a></p></div>';
}
add_filter('the_excerpt', 'tt_shortcode_and_more_in_excerpt');

// Customized Comments List
function tt_list_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$args = array(
		'walker'            => null,
		'max_depth'         => '10',
		'style'             => 'ul',
		'callback'          => null,
		'end-callback'      => null,
		'type'              => 'comment',
		'reply_text'        => __( 'Reply', 'tt' ),
		'page'              => '',
		'per_page'          => '',
		'avatar_size'       => 50,
		'reverse_top_level' => null,
		'reverse_children'  => '',
		'format'            => 'html5',
		'short_ping'        => true
	);
	
	if ( 'div' == $args['style'] ) {
	$tag = 'div';
	$add_below = 'comment';
	} else {
	$tag = 'li';
	$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
		<div class="comment-avatar">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div>
		<div class="comment-author vcard">
			<?php printf(__('<h5 class="fn">%s</h5>'), get_comment_author_link()) ?>
			
			<?php if ($comment->comment_approved == '0') : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tt' ) ?></em>
			<br />
			<?php endif; ?>
			
			<div class="comment-meta">
			<span><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . " " . __('ago', 'tt'); ?></span>
			</div>
		
		</div>
		
		<div class="comment-content">
			<?php comment_text() ?>
			<?php if( comments_open() ) { ?>
			<div class="reply btn btn-default btn-xs">
				<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<?php } ?>
		</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif;
}

// Customized Respond Fields
function tt_respond_fields($fields) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$fields['author'] = '<div class="comment-form-author form-group"><label for="author">' . __( 'Name', 'tt' ) . '</label> ' .
	  ( $req ? '<span class="required" data-toggle="tooltip" data-placement="right" title="Required">*</span>' : '' ) .
	  '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' /></div>';
	$fields['email'] = '<div class="comment-form-email form-group"><label for="email">' . __( 'Email', 'tt' ) . '</label> ' .
    ( $req ? '<span class="required" data-toggle="tooltip" data-placement="right" title="Required, but won\'t be published">*</span>' : '' ) .
    '<input id="email" class="form-control" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $aria_req . ' /></div>';
  $fields['url'] = '<div class="comment-form-url form-group"><label for="url">' . __( 'Website', 'tt' ) . '</label>' .
    '<input id="url" class="form-control" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" " /></div>';
	return $fields;
}
add_filter('comment_form_default_fields', 'tt_respond_fields');

// Blog Search: Only search posts
function tt_search($query) {
	if ( $query->is_search ) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts', 'tt_search');