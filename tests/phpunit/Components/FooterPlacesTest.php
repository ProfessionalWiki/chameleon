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
 * @coversDefaultClass \Skins\Chameleon\Components\FooterPlaces
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class FooterPlacesTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\FooterPlaces';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_GetsAllKeys() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$chameleonTemplate->expects( $this->at( 1 ) )
			->method( 'get' )
			->with( $this->equalTo( 'privacy' ), $this->equalTo( null ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$chameleonTemplate->expects( $this->at( 2 ) )
			->method( 'get' )
			->with( $this->equalTo( 'about' ), $this->equalTo( null ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$chameleonTemplate->expects( $this->at( 3 ) )
			->method( 'get' )
			->with( $this->equalTo( 'disclaimer' ), $this->equalTo( null ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$instance = new $this->classUnderTest ( $chameleonTemplate );

		$instance->getHtml();

	}
}
