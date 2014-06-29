<?php

class Media_Dimensions_Image {

	protected $_width;
	protected $_height;
	protected $_file;

	/**
	* Constructor
	* 
	* @param string $file Path of the image file
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
	* Find the dimensions of the image file
	*/
	protected function _find_dimensions() {

		$dimensions = getimagesize( $this->_file );

		$this->_width = $dimensions[0];
		$this->_height = $dimensions[1];

	}

	/**
	* Checks that the image file type is supported.
	* File type must be supported by getimagesize().
	*
	* @return boolean True if supported; False if not
	*/
	protected function _is_supported_file() {
		//Ensure that the file type is supported

		$imagetype = exif_imagetype( $this->_file );

		if ( $imagetype === false ) {
			return false;
		}

		return true;
	}

	/**
	* Returns the image width
	*
	* @return int $width The image width
	*/
	function get_width() {
		return $this->_width;
	}

	/**
	* Returns the image height
	*
	* @return int $width The image height
	*/
	function get_height() {
		return $this->_height;
	}

}