<?php
/**
 * Plugin Name: Media Dimensions
 * Description: Add width and height columns to the media library
 * Version: 1.0.0
 * Author: BinaryStash
 * Author URI:  binarystash.blogspot.com
 * License: GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */
 
//Define constants
if(!defined('MEDIA_DIMENSIONS_URL')){
	define('MEDIA_DIMENSIONS_URL', plugin_dir_url(__FILE__) );
}

if(!defined('MEDIA_DIMENSIONS_DIR')){
	define('MEDIA_DIMENSIONS_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR );
}


function Media_Dimensions_Instantiate() {

	$media_dimensions = new Media_Dimensions();
	$media_dimensions->register_handlers();

}


function Media_Dimensions_Activate() {

	//Add dimensions to existing attachments
	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
    ));
    
	$media_dimensions = new Media_Dimensions();

    foreach ( $attachments as $attachment ) {

    	$media_dimensions->add_attachment_dimensions( $attachment->ID );

    }

}

if ( get_bloginfo("version") >= 3.5 ) {

	//Load classes
	require_once(MEDIA_DIMENSIONS_DIR . "classes/class-media-dimensions-image.php");
	require_once(MEDIA_DIMENSIONS_DIR . "classes/class-media-dimensions-video.php");
	require_once(MEDIA_DIMENSIONS_DIR . "classes/class-media-dimensions.php");
	
	//Initialize plugin only if Wordpress version >= 3.5
	add_action( 'plugins_loaded', 'Media_Dimensions_Instantiate', 15 );

	//Do some tasks when plugin is activated
	register_activation_hook( __FILE__, 'Media_Dimensions_Activate' );

}