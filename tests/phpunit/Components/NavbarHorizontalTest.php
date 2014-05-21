<?php

namespace Skins\Chameleon\Tests\Components;

use Skins\Chameleon\Components\NavbarHorizontal;
use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  mwjames
 *
 * @coversDefaultClass \Skins\Chameleon\Components\NavbarHorizontal
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class NavbarHorizontalTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\NavbarHorizontal';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_containsNavElement() {

		$element = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$message = $this->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->any() )
			->method( 'getMsg' )
			->will( $this->returnValue( $message ) );

		$instance = new NavbarHorizontal(
			$chameleonTemplate,
			$element
		);

		$matcher = array( 'tag' => 'nav' );
		$this->assertTag( $matcher, $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_LoggedInUserHasNewMessages( $domElement ) {

		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'UserIsLoggedIn', true );
		$factory->set( 'UserNewMessageLinks', array( 'foo' ) );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var $instance Component */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$matcher = array( 'class' => 'navbar-newtalk-available' );
		$this->assertTag( $matcher, $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_LoggedInUserHasNoNewMessages( $domElement ) {

		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'UserIsLoggedIn', true );
		$factory->set( 'UserNewMessageLinks', array() );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var $instance Component */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$matcher = array( 'class' => 'navbar-newtalk-unavailable' );
		$this->assertTag( $matcher, $instance->getHtml() );
	}

}
