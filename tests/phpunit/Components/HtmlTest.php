<?php

namespace Skins\Chameleon\Tests\Components;

use Skins\Chameleon\Components\Html;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  Stephan Gambke
 *
 * @coversDefaultClass \Skins\Chameleon\Components\Html
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class HtmlTest extends ChameleonSkinComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\Html';

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_OnSyntheticLayoutXml( $domElement ) {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$expected = '';

		foreach ( $domElement->childNodes as $child ) {
			$expected .= $domElement->ownerDocument->saveHTML( $child );
		}

		$instance = new Html ( $chameleonTemplate, $domElement );
		$actual = $instance->getHtml();

		$this->assertEquals( $expected, $actual );
	}
}
