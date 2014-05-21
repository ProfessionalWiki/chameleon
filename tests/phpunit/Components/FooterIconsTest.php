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
 * @coversDefaultClass \Skins\Chameleon\Components\FooterIcons
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class FooterIconsTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\FooterIcons';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$skin = $chameleonTemplate->getSkin();

		$skin->expects( $this->at( 0 ) )
			->method( 'makeFooterIcon' )
			->with( $this->equalTo( 'icon1' ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$skin->expects( $this->at( 1 ) )
			->method( 'makeFooterIcon' )
			->with( $this->equalTo( 'icon2' ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$skin->expects( $this->at( 2 ) )
			->method( 'makeFooterIcon' )
			->with( $this->equalTo( 'icon3' ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$skin->expects( $this->at( 3 ) )
			->method( 'makeFooterIcon' )
			->with( $this->equalTo( 'icon4' ) )
			->will( $this->returnValue( 'SomeHTML' ) );

		$chameleonTemplate->expects( $this->any() )
			->method( 'getFooterIcons' )
			->will( $this->returnValue( array(
				'block1' => array( 'icon1', 'icon2' ),
				'block2' => array( 'icon3', 'icon4' ),
			) ) );

		$instance = new $this->classUnderTest ( $chameleonTemplate );

		$this->assertValidHTML( $instance->getHtml() );
	}

}
