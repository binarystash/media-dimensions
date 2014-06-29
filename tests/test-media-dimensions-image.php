<?php

class Media_Dimensions_ImageTest extends PHPUnit_Framework_TestCase {

	protected $_mdir; //Media Dimensions Image reflection instance
	protected $_mdi; //Media Dimensions Image instance

	function setUp() {

		$this->_mdir = new ReflectionClass("Media_Dimensions_Image");

		$this->_mdi = new Media_Dimensions_Image( MEDIA_DIMENSIONS_DIR . '/tests/media/test.png' );

	}

	function test_find_dimensions() {

		$method = $this->_mdir->getMethod("_find_dimensions");
		$method->setAccessible( true );
		$method->invoke( $this->_mdi );

		$width = $this->_mdir->getProperty("_width");
		$width->setAccessible( true );
		$this->assertEquals( 499, $width->getValue( $this->_mdi ) );

		$height = $this->_mdir->getProperty("_height");
		$height->setAccessible( true );
		$this->assertEquals( 310, $height->getValue( $this->_mdi ) );

	}

	function test_is_supported_file() {

		$method = $this->_mdir->getMethod("_is_supported_file");
		$method->setAccessible( true );
		$output = $method->invoke( $this->_mdi );

		$this->assertTrue( $output );

	}

	function test_get_width() {

		$this->assertEquals( 499, $this->_mdi->get_width() );

	}

	function test_get_height() {

		$this->assertEquals( 310, $this->_mdi->get_height() );

	}

}