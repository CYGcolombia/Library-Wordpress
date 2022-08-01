<?php
/**
 * Admin feature for Custom Meta Box
 *
 * @author 		Themeum
 * @category 	Admin Core
 * @package 	Varsity
 *-------------------------------------------------------------*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Registering meta boxes
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

add_filter( 'rwmb_meta_boxes', 'skillate_core_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */

function skillate_core_register_meta_boxes( $meta_boxes )
{

	/**
	 * Prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */

	// Better has an underscore as last sign
	$prefix = 'skillate_';

	/**
	 * Register Post Meta for Movie Post Type
	 *
	 * @return array
	 */


	// --------------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Post Open ----------------------------------------------------------
	// --------------------------------------------------------------------------------------------------------------
	$meta_boxes[] = array(
		'id' => 'post-meta-quote',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title' => esc_html__( 'Post Quote Settings', 'Skillate-core' ),

		// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
		'pages' => array( 'post'),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context' => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority' => 'high',

		// Auto save: true, false (default). Optional.
		'autosave' => true,

		// List of meta fields
		'fields' => array(
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Quote Text', 'Skillate-core' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}qoute",
				'desc'  => esc_html__( 'Write Your Quote Here', 'Skillate-core' ),
				'type'  => 'textarea',
				// Default value (optional)
				'std'   => ''
			),
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Quote Author', 'Skillate-core' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}qoute_author",
				'desc'  => esc_html__( 'Write Quote Author or Source', 'Skillate-core' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => ''
			)

		)
	);



	$meta_boxes[] = array(
		'id' => 'post-meta-link',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title' => esc_html__( 'Post Link Settings', 'Skillate-core' ),

		// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
		'pages' => array( 'post'),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context' => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority' => 'high',

		// Auto save: true, false (default). Optional.
		'autosave' => true,

		// List of meta fields
		'fields' => array(
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Link URL', 'Skillate-core' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}link",
				'desc'  => esc_html__( 'Write Your Link', 'Skillate-core' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => ''
			)

		)
	);


	# --------------------------------------------------------------	
	# -------------------  Course Options  ---------------------
	# --------------------------------------------------------------

	$meta_boxes[] = array(
		'id' 			=> 'courses-meta-settings',
		'title' 		=> esc_html__( 'Course Options', 'Skillate-core' ),
		'pages' 		=> array( 'courses'),
		'context' 		=> 'normal',
		'priority' 		=> 'high',
		'fields' 		=> array(
			array(
				'name'     		=> esc_html__( 'Featured', 'Skillate-core' ),
				'id'       		=> $prefix."best_selling",
				'type'     		=> 'checkbox',
				'std'         	=> ''
			),
		)
	);

	

	# --------------------------------------------------------------	
	# ------------------- sub Header Page Open ---------------------
	# --------------------------------------------------------------
	$meta_boxes[] = array(
		'id' 			=> 'page-meta-settings',
		'title' 		=> esc_html__( 'Page Settings', 'Skillate-core' ),
		'pages' 		=> array( 'page', 'portfolio'),
		'context' 		=> 'normal',
		'priority' 		=> 'high',
		'fields' 		=> array(
			array(
				'name'             => esc_html__( 'Upload Individual Page Logo', 'Skillate-core' ),
				'id'               => $prefix."individual_page_logo",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'name'             	=> esc_html__( 'Select Header Style', 'Skillate-core' ),
				'id'               	=> $prefix."header_style",
				'type'             	=> 'select',
				'placeholder'     	=> 'Select an Item',
				'options'         	=> array(
			        'transparent_header'   => 'Transparent Header',
			        'solid_header' 			=> 'Solid Header',
			        'white_header' 			=> 'White Header'
			    ),
			),
			array(
				'name'     		=> esc_html__( 'Sticky Header', 'Skillate-core' ),
				'id'       		=> $prefix."sticky_header",
				'type'     		=> 'select',
				'placeholder'     	=> 'Select an Item',
				'options'         	=> array(
			        'enable' 			=> 'Enable',
			        'disable' 			=> 'Disable'
			    ),
			),
			array(
				'name'             => esc_html__( 'Choose Header Background Color', 'Skillate-core' ),
				'id'               => $prefix."header_bgc",
				'type'             => 'color',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Choose Sticky Background Color', 'Skillate-core' ),
				'id'               => $prefix."sticky_bg_color",
				'type'             => 'color',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Choose Menu Color', 'Skillate-core' ),
				'id'               => $prefix."header_color",
				'type'             => 'color',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Choose Menu Hover Color', 'Skillate-core' ),
				'id'               => $prefix."header_hover_color",
				'type'             => 'color',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Disable Header Search', 'Skillate-core' ),
				'id'               => $prefix."disable_header_search",
				'type'             => 'checkbox',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Hide Header & Footer', 'Skillate-core' ),
				'id'               => $prefix."hide_header_footer",
				'type'             => 'checkbox',
				'std' 			   => ''
			),
			array(
				'name'             => esc_html__( 'Enable Topbar', 'Skillate-core' ),
				'id'               => $prefix."en_topbar",
				'type'             => 'checkbox',
				'std' 			   => ''
			),
			
						
		)
	);


	// --------------------------------------------------------------------------------------------------------------	
	// ----------------------------------------- sub Header Page Open -----------------------------------------------
	// --------------------------------------------------------------------------------------------------------------


	$meta_boxes[] = array(
		'id' 			=> 'post-meta-audio',
		'title' 		=> esc_html__( 'Post Audio Settings', 'Skillate-core' ),
		'pages' 		=> array( 'post'),
		'context' 		=> 'normal',
		'priority' 		=> 'high',
		'autosave' 		=> true,
		'fields' 		=> array(
			array(
				'name'  	=> esc_html__( 'Audio Embed Code', 'Skillate-core' ),
				'id'    	=> "{$prefix}audio_code",
				'desc'  	=> esc_html__( 'Write Your Audio Embed Code Here', 'Skillate-core' ),
				'type'  	=> 'textarea',
				'std'   	=> ''
			)

		)
	);

	$meta_boxes[] = array(
		'id' => 'post-meta-video',
		'title' => esc_html__( 'Post Video Settings', 'Skillate-core' ),
		'pages' => array( 'post'),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields' => array(
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Video Embed Code/ID', 'Skillate-core' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}video",
				'desc'  => esc_html__( 'Write Your Vedio Embed Code/ID Here', 'Skillate-core' ),
				'type'  => 'textarea',
				// Default value (optional)
				'std'   => ''
			),
			array(
				'name'  => __( 'Video Durations', 'Skillate-core' ),
				'id'    => "{$prefix}video_durations",
				'type'  => 'text',
				'std'   => ''
			),
			array(
				'name'     => esc_html__( 'Select Vedio Type/Source', 'Skillate-core' ),
				'id'       => "{$prefix}video_source",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'1' => esc_html__( 'Embed Code', 'Skillate-core' ),
					'2' => esc_html__( 'YouTube', 'Skillate-core' ),
					'3' => esc_html__( 'Vimeo', 'Skillate-core' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '1'
			),

		)
	);


	$meta_boxes[] = array(
		'id' => 'post-meta-gallery',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title' => esc_html__( 'Post Gallery Settings', 'Skillate-core' ),

		// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
		'pages' => array( 'post'),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context' => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority' => 'high',

		// Auto save: true, false (default). Optional.
		'autosave' => true,

		// List of meta fields
		'fields' => array(
			array(
				'name'             => esc_html__( 'Gallery Image Upload', 'Skillate-core' ),
				'id'               => "{$prefix}gallery_images",
				'type'             => 'image_advanced',
				'max_file_uploads' => 6,
			)
		)
	);


	# Single Page Media Settings
	$meta_boxes[] = array(
		'id' 			=> 'blog-featured-post-media-settings',
		'title' 		=> esc_html__( 'Featured Post Settings', 'Skillate-core' ),
		'pages' 		=> array( 'post'),
		'context' 		=> 'normal',
		'priority' 		=> 'high',
		'autosave' 		=> true,
		'fields' 		=> array(
			array(
				'name'     		=> esc_html__( 'Featured Post', 'Skillate-core' ),
				'id'       		=> "{$prefix}post_featured",
				'type'     		=> 'checkbox',
				'std'         	=> ''
			),

		)
	);
	# End Media Settings.



	// --------------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Post Close ---------------------------------------------------------
	// --------------------------------------------------------------------------------------------------------------

	return $meta_boxes;
}


/**
 * Get list of post from any post type
 *
 * @return array
 */

function skillate_core_get_all_posts($post_type)
{
	$args = array(
			'post_type' => $post_type,  // post type name
			'posts_per_page' => -1,   //-1 for all post
		);

	$posts = get_posts($args);

	$post_list = array();

	if (!empty( $posts ))
	{
		foreach ($posts as $post)
		{
			setup_postdata($post);
			$post_list[$post->ID] = $post->post_title;
		}
		wp_reset_postdata();
		return $post_list;
	}
	else
	{
		return $post_list;
	}
}
