<?php

class Media_Dimensions_VideoTest extends PHPUnit_Framework_TestCase {

	protected $_mdvr; //Media Dimensions Video reflection instance
	protected $_mdv; //Media Dimensions Video instance

	function setUp() {

		$this->_mdvr = new ReflectionClass("Media_Dimensions_Video");

		$this->_mdv = new Media_Dimensions_Video( MEDIA_DIMENSIONS_DIR . '/tests/media/test.mov' );

	}

	function test_find_dimensions() {

		$method = $this->_mdvr->getMethod("_find_dimensions");
		$method->setAccessible( true );
		$method->invoke( $this->_mdv );

		$width = $this->_mdvr->getProperty("_width");
		$width->setAccessible( true );
		$this->assertEquals( 240, $width->getValue( $this->_mdv ) );

		$height = $this->_mdvr->getProperty("_height");
		$height->setAccessible( true );
		$this->assertEquals( 180, $height->getValue( $this->_mdv ) );

	}

	function test_is_supported_file() {

		$method = $this->_mdvr->getMethod("_is_supported_file");
		$method->setAccessible( true );
		$output = $method->invoke( $this->_mdv );

		$this->assertTrue( $output );

	}

	function test_get_width() {

		$this->assertEquals( 240, $this->_mdv->get_width() );

	}

	function test_get_height() {

		$this->assertEquals( 180, $this->_mdv->get_height() );

	}

}