<?php

class Media_Dimensions_Video {

	protected $_width;
	protected $_height;
	protected $_file;

	/**
	* Constructor
	* 
	* @param string $file Path of the video file
	* @return void
	*/
	function __construct( $file ) {

		$this->_file = $file;

		if ( !$this->_is_supported_file() ) {

			throw new Exception("Unsupported file type");

		}

		//Get dimensions
		$this->_find_dimensions();

	}

	/**
	* Find the dimensions of the video file
	*/
	protected function _find_dimensions() {
		$meta = wp_read_video_metadata( $this->_file );

		$this->_width = $meta['width'];
		$this->_height = $meta['height'];
	}

	/**
	* Checks that the image file type is supported
	* The following files are supported:
	* 	'video/mp4',
	*	'video/m4v',
	*	'video/avi',
	*	'video/mpeg',
	*	'video/quicktime'
	*
	* @return boolean True if supported; False if not
	*/
	protected function _is_supported_file() {

		//Ensure that file type is supported
		$supported_types = array(
			'video/mp4',
			'video/m4v',
			'video/avi',
			'video/mpeg',
			'video/quicktime'
		);

		$php_version = (float) phpversion();
		$mime_type = "";

		if ( $php_version >= 5.3 ) {

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime_type = finfo_file( $finfo, $this->_file );
			finfo_close( $finfo );

		}
		else {

			$mime_type = mime_content_type( $this->_file );

		}

		if ( !in_array ( $mime_type, $supported_types ) ) {
			return false;
		}

		return true;

	}

	/**
	* Returns the video width
	*
	* @return int $width The video width
	*/
	function get_width() {
		return $this->_width;
	}

	/**
	* Returns the video height
	*
	* @return int $width The video height
	*/
	function get_height() {
		return $this->_height;
	}

}