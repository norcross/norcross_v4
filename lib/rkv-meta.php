<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_rkv_';

	$meta_boxes[] = array(
		'id'         => 'plugin_details',
		'title'      => 'Plugin Details',
		'pages'      => array( 'plugins', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Plugin Slug',
				'desc' => 'Enter the slug used in the WP repository',
				'id'   => $prefix . 'plugin_slug',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Banner Image',
				'desc' => 'Upload the banner image',
				'id'   => $prefix . 'plugin_img',
				'type' => 'file',
			),
		)
	);
	//
	$meta_boxes[] = array(
		'id'         => 'download_details',
		'title'      => 'Download Details',
		'pages'      => array( 'downloads', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'	=> 'File URL',
				'desc'	=> 'Enter the entire URL',
				'id'	=> $prefix . 'download_url',
				'type'	=> 'text',
				'std'	=> 'http://andrewnorcross.com/files/music/'
			)
		)
	);
	// github placement
	$meta_boxes[] = array(
		'id'         => 'snippet_detail',
		'title'      => 'Snippet Details',
		'pages'      => array( 'snippets', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Gist Snippet ID',
				'desc' => 'Enter the ID from the Gist on Github',
				'id'   => $prefix . 'gist_id',
				'type' => 'text',
			),
			array(
				'name' => 'Gist URL',
				'desc' => 'Enter the URL from the Gist on Github',
				'id'   => $prefix . 'gist_url',
				'type' => 'text',
			)
		)
	);
	// instagram data
	$meta_boxes[] = array(
		'id'         => 'photo_detail',
		'title'      => 'Photo Details',
		'pages'      => array( 'photos', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Thumbnail URL',
				'desc' => '',
				'id'   => $prefix . 'photo_thumb',
				'type' => 'file',
			),
			array(
				'name' => 'Standard URL',
				'desc' => '',
				'id'   => $prefix . 'photo_stand',
				'type' => 'file',
			),			
			array(
				'name' => 'Full Size URL',
				'desc' => '',
				'id'   => $prefix . 'photo_full',
				'type' => 'file',
			),
			array(
				'name' => 'Plugin ID',
				'desc' => 'Enter the instagram timestamp',
				'id'   => $prefix . 'photo_id',
				'type' => 'text_medium',
			),
		)
	);
//http://www.slideshare.net/norcross
	$meta_boxes[] = array(
		'id'         => 'speaking_details',
		'title'      => 'Speaking Details',
		'pages'      => array( 'speaking', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Conference',
				'desc' => 'Enter the name of the conference / event',
				'id'   => $prefix . 'speaking_event',
				'type' => 'text',
			),
			array(
				'name' => 'Video URL',
				'desc' => 'Enter the full URL for the video',
				'id'   => $prefix . 'speaking_url',
				'type' => 'text',
			),
			array(
				'name' => 'Slides',
				'desc' => 'Enter the full URL of the slides (if any)',
				'id'   => $prefix . 'speaking_deck',
				'type' => 'text',
			),
		)
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'metabox/init.php';

}