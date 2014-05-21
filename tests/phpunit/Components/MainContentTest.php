<?php

namespace Skins\Chameleon\Tests\Components;

use Skins\Chameleon\Components\MainContent;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  mwjames
 *
 * @coversDefaultClass \Skins\Chameleon\Components\MainContent
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class MainContentTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\MainContent';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_OnEmptyDataProperty() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$chameleonTemplate->data = array(
			'subtitle'         => '',
			'undelete'         => '',
			'printfooter'      => '',
			'dataAfterContent' => ''
		);

		$instance = new MainContent( $chameleonTemplate );
		$this->assertInternalType( 'string', $instance->getHtml() );
	}
}
