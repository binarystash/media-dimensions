<?php

class Media_Dimensions {

	/**
	* Register plugin's filters and actions
	*
	* @return void
	*/
	function register_handlers() {
		add_filter( 'manage_media_columns', array( &$this, 'manage_columns' ) );

		add_filter( 'manage_media_custom_column', array( &$this, 'manage_custom_column' ), 10, 2);

		add_filter( 'manage_upload_sortable_columns', array( &$this, 'manage_sortable_columns' ));

		add_action( 'add_attachment', array( &$this, 'add_attachment_dimensions' ));

		add_action( 'pre_get_posts', array( &$this, 'sort_dimensions' ) ); 
	}

	/**
	* Sort rows
	*
	* @param WP_Query $query Query object
	* @return void
	*/
	function sort_dimensions( $query ) {
		if( ! is_admin() )  
	        return;  

	    $orderby = $query->get( 'orderby');  

	    switch ( $orderby ) {

	    	case 'width':
	    		$query->set('meta_key','width');  
	        	$query->set('orderby','meta_value_num'); 
	        	break;

	        case 'height':
	        	$query->set('meta_key','height');  
	        	$query->set('orderby','meta_value_num');  

	    }

	}

	/**
	* Add new columns
	*
	* @param array $columns Array of columns
	* @return array $columns The new array of columns
	*/
	function manage_columns( $columns ) {

		$new_columns = array(
			'width'=>'Width',
			'height'=>'Height'
		);

		$columns = array_merge( $columns, $new_columns );

		return $columns;
	}

	/**
	* Populate new columns with data
	* 
	* @param string $column Column name
	* @param int $id ID of the row
	* @return void
	*/
	function manage_custom_column( $column, $id ) {

		switch( $column ) {

			case 'width' : 
				echo get_post_meta( $id, 'width', true );
				break;

			case 'height' :
				echo get_post_meta( $id, 'height', true );
				break;

		}

	}

	/**
	* Makes custom columns sortable
	*
	* @param array $columns Array of columns
	* @return array $columns New array of sortable custom columns
	*/
	function manage_sortable_columns( $columns ) {

		$columns['width'] = 'date';
		$columns['height'] = 'date';

		return $columns;

	}

	/**
	* Add dimensions to attachments
	*
	* @param int $id Attachment ID
	* @return void
	*/
	function add_attachment_dimensions( $id ) {

		$attachment = get_post( $id );
		$file = get_attached_file( $id );
		$width = "Unknown";
		$height = "Unknown";

		if ( preg_match('!^image/!', get_post_mime_type( $attachment )) && file_is_displayable_image($file) ) {
			try {
				$file_obj = new Media_Dimensions_Image( $file );
			}
			catch ( Exception $e ) {
				//Do nothing
			}
		}
		elseif ( preg_match( '#^video/#', get_post_mime_type( $attachment ) ) ) {
			try {
				$file_obj = new Media_Dimensions_Video( $file );
			}
			catch ( Exception $e ) {
				//Do nothing
			}
		}

		if ( isset( $file_obj ) ) {
			$width = $file_obj->get_width();
			$height = $file_obj->get_height();
		}

		update_post_meta( $id, 'width', $width );
		update_post_meta( $id, 'height', $height );

	}
}