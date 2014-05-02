<?php

namespace Skins\Chameleon\Tests\Components;

use Skins\Chameleon\Tests\Util\XmlFileProvider;
use Skins\Chameleon\Tests\Util\DocumentElementFinder;

use Skins\Chameleon\Components\NavbarHorizontal;

use Title;

/**
 * @uses \Skins\Chameleon\Components\NavbarHorizontal
 *
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class NavbarHorizontalTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$this->assertInstanceOf(
			'\Skins\Chameleon\Components\NavbarHorizontal',
			new NavbarHorizontal( $chameleonTemplate )
		);
	}

	public function testGetHtmlToMatchNavElement() {

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
	 * @dataProvider xmlFileProvider
	 */
	public function testValidityForGetHtmlOnDeployedLayoutXml( $xmlFile ) {

		$message = $this->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->any() )
			->method( 'getMsg' )
			->will( $this->returnValue( $message ) );

		$chameleonTemplate->expects( $this->any() )
			->method( 'getSidebar' )
			->will( $this->returnValue( array() ) );

		$chameleonTemplate->expects( $this->any() )
			->method( 'getSkin' )
			->will( $this->returnValue( $this->getSkinStub() ) );

		$chameleonTemplate->expects( $this->any() )
			->method( 'getPersonalTools' )
			->will( $this->returnValue( array() ) );

		$chameleonTemplate->data = $this->getSkinTemplateDummyDataSetForMainNamespace();
		$chameleonTemplate->translator = $this->getTranslatorStub();

		$elementFinder = new DocumentElementFinder( $xmlFile );

		$instance = new NavbarHorizontal(
			$chameleonTemplate,
			$elementFinder->getComponentByTypeAttribute( 'NavbarHorizontal' )
		);

		$this->assertInternalType( 'string', $instance->getHtml() );
	}

	public function xmlFileProvider() {

		$xmlFileProvider = new XmlFileProvider( __DIR__ . '/../../../layouts' );
		$provider = array_chunk( $xmlFileProvider->getFiles(), 1 );

		return $provider;
	}

	private function getSkinStub() {

		$title = Title::newFromText( 'FOO' );

		$user = $this->getMockBuilder( '\User' )
			->disableOriginalConstructor()
			->getMock();

		$skin = $this->getMockBuilder( '\Skin' )
			->disableOriginalConstructor()
			->getMock();

		$skin->expects( $this->any() )
			->method( 'getTitle' )
			->will( $this->returnValue( $title ) );

		$skin->expects( $this->any() )
			->method( 'getUser' )
			->will( $this->returnValue( $user ) );

		return $skin;
	}

	private function getTranslatorStub() {

		$translator = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'translate' ) )
			->getMock();

		$translator->expects( $this->any() )
			->method( 'translate' )
			->will( $this->returnValue( 'translate' ) );

		return $translator;
	}

	/**
	 * Dummy values are by no means to represent a particular intention or
	 * objective and merely used to pass through the respective method
	 *
	 * Testing specific conditions should be done separately in each sub
	 * component
	 */
	private function getSkinTemplateDummyDataSetForMainNamespace() {
		return array(

			// Required by Logo
			'logopath' => 'foo',

			// Required by NavMenu
			'nav_urls' => array(
				'mainpage' => array( 'href' => 'bat' )
			),

			// Required by PageTools
			'content_navigation' => array(
				'namespaces' => array(
					'main' => array( '' )
				)
			),

			// Required by SearchBar
			'wgScript' => 'bam',
			'searchtitle' => 'jouy'
		);
	}

}
