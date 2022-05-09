<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke, mwjames
 * @license   GPL-3.0-or-later
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup Skins
 */

namespace Skins\Chameleon\Tests\Unit\Components;

use Message;
use Skins\Chameleon\ChameleonTemplate;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\MainContent
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author  mwjames
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class MainContentTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\MainContent';

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_OnEmptyDataProperty( $domElement ) {
		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$chameleonTemplate->data = [
			'subtitle'         => '',
			'undelete'         => '',
			'printfooter'      => '',
			'dataAfterContent' => ''
		];

		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );
		$this->assertIsString( $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @throws \MWException
	 */
	public function testGetHtml_AllSubComponentsDisplayed() {
		$chameleonTemplate = $this->createChameleonTemplateStub();
		$instance = new $this->classUnderTest( $chameleonTemplate, null );

		$html = $instance->getHtml();

		$this->assertStringContainsString( 'SomeTitle', $html );
		$this->assertStringContainsString( 'SomeBodytext', $html );
		$this->assertStringContainsString( 'SomeIndicatorId', $html );
		$this->assertStringContainsString( 'SomeIndicatorContent', $html );
		$this->assertStringContainsString( 'SomeCategory', $html );
	}

	/**
	 * @covers ::getHtml
	 * @throws \MWException
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_AllSubComponentsHidden( $domElement ) {
		$chameleonTemplate = $this->createChameleonTemplateStub();
		$domElement->setAttribute('hideContentHeader', 'yes');
		$domElement->setAttribute('hideContentBody', 'yes');
		$domElement->setAttribute('hideIndicators', 'yes');
		$domElement->setAttribute('hideCatLinks', 'yes');
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$html = $instance->getHtml();

		$this->assertStringNotContainsString( 'SomeTitle', $html );
		$this->assertStringNotContainsString( 'SomeBodytext', $html );
		$this->assertStringNotContainsString( 'SomeIndicatorId', $html );
		$this->assertStringNotContainsString( 'SomeIndicatorContent', $html );
		$this->assertStringNotContainsString( 'SomeCategory', $html );
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\Stub|ChameleonTemplate
	 */
	private function createChameleonTemplateStub() {
		$chameleonTemplate = $this->createStub( ChameleonTemplate::class );
		$chameleonTemplate->method( 'get' )->willReturnMap( [
			[ 'title', null, 'SomeTitle' ],
			[ 'bodytext', null, 'SomeBodytext' ],
			[ 'indicators', null, [ 'SomeIndicatorId', 'SomeIndicatorContent' ] ],
			[ 'catlinks', null, 'SomeCategory' ],
		] );
		$chameleonTemplate->method( 'getMsg' )->willReturn( new Message( '' ) );

		return $chameleonTemplate;
	}

}
