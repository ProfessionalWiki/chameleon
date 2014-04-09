<?php

namespace Skins\Tests\Chameleon\Components;

use Skins\Chameleon\Components\MainContent;

/**
 * @covers \Skins\Chameleon\Components\MainContent
 *
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @licence GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class MainContentTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$this->assertInstanceOf(
			'\Skins\Chameleon\Components\MainContent',
			new MainContent( $chameleonTemplate )
		);
	}

	public function testGetHtmlOnEmptyDataProperty() {

		$message = $this->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->atLeastOnce() )
			->method( 'getMsg' )
			->will( $this->returnValue( $message ) );

		$chameleonTemplate->data = array(
			'subtitle' => '',
			'undelete' => '',
			'printfooter' => '',
			'dataAfterContent' => ''
		);

		$instance = new MainContent( $chameleonTemplate );
		$this->assertInternalType( 'string', $instance->getHtml() );
	}

}
