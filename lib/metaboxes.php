<?php
/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = '_tt_';

// Page Metaboxes
$meta_boxes[] = array(
	'id' => 'section_settings',
	'title' => __( 'Section Settings', 'tt' ),
	'pages' => array('page'),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __( 'Add this Page to the Frontpage', 'tt' ),
			'desc' => __( 'If checked, this page will be added as a section to your frontpage.', 'tt' ),
			'id' => $prefix . 'is_frontpage',
			'type' => 'checkbox',
			'std' => 1
		),
		array(
			'name' => __( 'Hide Menu Link', 'tt' ),
			'desc' => __( 'If checked, no link to this section will appear in the menu.', 'tt' ),
			'id' => $prefix . 'hide_menu_link',
			'type' => 'checkbox',
			'std' => 0
		),
		array(
			'name' => __( 'Alternate Page Title', 'tt' ),
			//'desc' => __( 'field description (optional)', 'tt' ),
			'id' => $prefix . 'title',
			'type' => 'text'
		),
		array(
			'name' => __( 'Page Subtitle', 'tt' ),
			//'desc' => __( 'field description (optional)', 'tt' ),
			'id' => $prefix . 'subtitle',
			'type' => 'text'
		),
		array(
			'name' => __( 'Background Color', 'tt' ),
			//'desc' => __( 'field description (optional)', 'tt' ),
			'id' => $prefix . 'page_background_color',
			'type' => 'color',
		),
		array(
			'name'    => __( 'Set this page to', 'tt' ),
			//'desc'    => __( 'field description (optional)', 'tt' ),
			'id'      => $prefix . 'is_section',
			'type'    => 'select',
			'options' => array(
				'home' 							=> __( 'Home Section', 'tt' ),
				'parallax' 					=> __( 'Parallax Section', 'tt' ),
				'team' 							=> __( 'Team Section', 'tt' ),
				'portfolio' 				=> __( 'Portfolio Section', 'tt' ),
				'contact' 					=> __( 'Contact Section', 'tt' ),
				'latest-blog-posts' => __( 'Latest Posts Section', 'tt' ),
			),
			'multiple'    => false,
			'placeholder' => __( 'Select a Section', 'tt' ),
		)
	)
);

// Team Member Rows
$meta_boxes[] = array(
	'id' => 'team_member_row',
	'title' => __( 'Team Member Settings', 'tt' ),
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'high',	
	'fields' => array(
		array(
			'name'    => __( 'Team Members per Row', 'tt' ),
			//'desc'    => __( 'Project images, slideshow & video width. When selecting a width of 100% the project details will be shown below the media.', 'tt' ),
			'id'      => $prefix . 'team_member_per_row',
			'type'    => 'select',
			'options' => array(
				'12' 	=> '1',
				'6' 	=> '2',
				'4' 	=> '3',
				'3' 	=> '4',
			),
			'std' 	=> '4'
		),
		array(
			'name'    => __( 'Position of Name & Title', 'tt' ),
			//'desc'    => __( 'field description (optional)', 'tt' ),
			'id'      => $prefix . 'team_member_content_position',
			'type'    => 'select',
			'options' => array(
				'place-overlay' 					=> __( 'Overlay', 'tt' ),
				'place-underneath'				=> __( 'Underneath Photo', 'tt' ),
				'place-side'							=> __( 'All Information Next To Photo', 'tt' ),
			),
			'std' 				=> 'place-overlay',
			'multiple'    => false,
			//'placeholder' => __( 'Select a Section', 'tt' ),
		)
	)
);

// Team Member Content
$meta_boxes[] = array(
	'id' => 'team_member_content',
	'title' => __( 'Team Member Content', 'tt' ),
	'pages' => array( 'team' ),
	'context' => 'normal',
	'priority' => 'high',	
	'fields' => array(
		array(
			'name'    => __( 'Position within the company', 'tt' ),
			//'desc'    => __( 'Project images, slideshow & video width. When selecting a width of 100% the project details will be shown below the media.', 'tt' ),
			'id'      => $prefix . 'team_member_position',
			'type'    => 'text',
			'std' 		=> 'Position'
		),
	)
);

// Project Content
$meta_boxes[] = array(
	'id' => 'project_content',
	'title' => __( 'Project Content', 'tt' ),
	'pages' => array( 'portfolio' ),
	'context' => 'normal',
	'priority' => 'high',	
	'fields' => array(
		array(
			'name'    => __( 'Media Width', 'tt' ),
			'desc'    => __( 'Project images, slideshow & video width. When selecting a width of 100% the project details will be shown below the media.', 'tt' ),
			'id'      => $prefix . 'project_media_width',
			'type'    => 'select',
			'options' => array(
				'6' => __( '50% (Default)', 'tt' ),
				'8' => __( '75%', 'tt' ),
				'12' => __( '100% Boxed', 'tt' ),
				'100' => __( '100% Full-Width', 'tt' ),
			)
		)
	)
);

// Project Images
$meta_boxes[] = array(
	'id' => 'project_images',
	'title' => __( 'Project Images', 'tt' ),
	'pages' => array( 'portfolio' ),
	'context' => 'normal',
	'priority' => 'high',	
	'fields' => array(
		array(
			'name'	=> 'Project Image / Slideshow',
			'desc'	=> '<br />Upload your project images. Uploading more than one image will create a slideshow.<br /><br /><strong>Notice:</strong> Featured image will serve as preview image.',
			'id'	=> $prefix . 'project_slideshow_images',
			'type'	=> 'plupload_image',
			'max_file_uploads' => 30,
		)
	)
);

// Project Video
$meta_boxes[] = array(
	'id' 				=> 'project_video',
	'title' 		=> __( 'Project Video', 'tt' ),
	'pages' 		=> array( 'portfolio' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields' 		=> array(
		array(
			'name'			=> 'Video Service',
			'desc'			=> '',
			'id'				=> $prefix . 'project_video_service',
			'type'    	=> 'select',
			'options' 	=> array(
				'youtube' 	=> __( 'YouTube', 'tt' ),
				'vimeo' 		=> __( 'Vimeo', 'tt' )
			)
		),
		array(
			'name'	=> 'Video ID',
			'desc'	=> 'Paste your video ID (www.youtube.com/watch?v=<strong>mSLAF_DjiDU</strong>). If filled out, video will be shown instead of project images.',
			'id'		=> $prefix . 'project_video_id',
			'type'  => 'text'
		)
	)
);

// Blog Post "Video"
$meta_boxes[] = array(
	'id'				=> 'post_type_video',
	'title'			=> 'Video Settings',
	'pages'			=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields'		=> array(
		array(
			'name'		=> 'Video Service',
			'id'			=> $prefix . 'blog_video_service',
			'type'		=> 'select',
			'options'	=> array(
				'youtube'	=> 'Youtube',
				'vimeo'		=> 'Vimeo',
				'custom'	=> 'Custom Embed Code'
			),
			'multiple'=> false,
			'std'			=> array( 'no' )
		),
		array(
			'name'	=> 'Embed Code',
			'id'	=> $prefix . 'blog_video_embed',
			'desc'	=> 'Paste your video ID (www.youtube.com/watch?v=<strong>mSLAF_DjiDU</strong>).<br />When selecting "Custom Embed Code" insert the full embed code .',
			'type' 	=> 'text',
			'std' 	=> ''
		)
	)
);

// Blog Post "Audio"
$meta_boxes[] = array(
	'id'				=> 'post_type_audio',
	'title'			=> 'Audio Settings',
	'pages'			=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields'		=> array(
		array(
			'name'		=> 'Audio oEmbed',
			'desc'		=> 'Paste your oEmbed code. Soundcloud etc.',
			'id'			=> $prefix . 'blog_audio_oembed',
			'type'		=> 'textarea',
			'std' 		=> ''
		),
		array(
			'name'		=> 'or audio URL',
			'desc'		=> 'Paste your audio URL. Link to mp3 file etc.',
			'id'			=> $prefix . 'blog_audio_url',
			'type'		=> 'text',
			'std' 		=> ''
		)
	)
);

// Blog Post "Link"
$meta_boxes[] = array(
	'id'				=> 'post_type_link',
	'title'			=> 'Link Settings',
	'pages'			=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields'		=> array(
		array(
			'name'		=> 'Link URL',
			'desc'		=> 'Paste your link URL.',
			'id'			=> $prefix . 'blog_link_url',
			'type'		=> 'text',
			'std' 		=> 'http://themetrail.com'
		)
	)
);

// Blog Post "Quote"
$meta_boxes[] = array(
	'id'				=> 'post_type_quote',
	'title'			=> 'Quote Settings',
	'pages'			=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields'		=> array(
		array(
			'name'		=> 'Quote Text',
			'desc'		=> 'Enter your quote.',
			'id'			=> $prefix . 'blog_quote_text',
			'type'		=> 'textarea',
			'std' 		=> ''
		),
		array(
			'name'		=> 'Quote Author',
			'desc'		=> 'Enter the Quote\'s Author',
			'id'			=> $prefix . 'blog_quote_author',
			'type'		=> 'text',
			'std' 		=> ''
		)
	)
);

// Blog Post "Gallery"
$meta_boxes[] = array(
	'id'				=> 'post_type_gallery',
	'title'			=> 'Gallery Slideshow Settings',
	'pages'			=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',	
	'fields'		=> array(
		array(
			'name'							=> 'Slides',
			'desc'							=> '<br />Upload your blog post gallery images. Uploading more than one image will create a slideshow.<br /><br /><strong>Notice:</strong> Featured image will serve as preview image.',
			'id'								=> $prefix . 'blog_gallery_slideshow',
			'type'							=> 'plupload_image',
			'max_file_uploads' 	=> 30
		)
	)
);

function tt_register_metaboxes() {
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			new RW_Meta_Box( $meta_box );
		}
	}
}

add_action( 'admin_init', 'tt_register_metaboxes' );