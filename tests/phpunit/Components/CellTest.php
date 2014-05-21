<?php

namespace Skins\Chameleon\Tests\Components;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  Stephan Gambke
 *
 * @coversDefaultClass \Skins\Chameleon\Components\Cell
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class CellTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\Cell';

	/**
	 * @covers ::__construct
	 * @dataProvider canConstructWithDomElementProvider
	 */
	public function testSpanAttribute( $in, $expected ) {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$domElement->expects( $this->any() )
			->method( 'getAttribute' )
			->will( $this->returnValueMap( array( array( 'span', $in ) ) ) );

		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$this->assertEquals(
			"col-lg-$expected",
			$instance->getClassString()
		);

	}

	/**
	 * @covers ::getClassString
	 */
	public function testGetClassString_WithoutSetting() {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new $this->classUnderTest ( $chameleonTemplate );

		$this->assertTrue( $instance->getClassString() === 'col-lg-12' );

	}

	public function canConstructWithDomElementProvider() {
		return array(
			array( '9', '9' ),
			array( '-1', '12' ),
			array( '42', '12' ),
			array( 'foo', '12' ),
			array( '10.5', '12' ),
		);
	}

}
