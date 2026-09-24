<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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

use DOMElement;
use Skins\Chameleon\Components\PageTools;
use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\PageTools
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class PageToolsTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\PageTools';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_PersonalToolsMenusAreNotRenderedAsToolGroups() {
		$html = $this->getHtmlForContentNavigation( [
			'associated-pages' => [ 'main' => [ 'text' => 'Page' ] ],
			'views' => [ 'edit' => [ 'text' => 'Edit' ] ],
			'user-interface-preferences' => [ 'uls' => [ 'text' => 'Language' ] ],
			'user-page' => [ 'userpage' => [ 'text' => 'FooUser' ] ],
			'notifications' => [ 'notifications-alert' => [ 'text' => 'Alerts' ] ],
			'user-menu' => [ 'logout' => [ 'text' => 'Log out' ] ],
		] );

		$this->assertTag( [ 'class' => 'p-associated-pages' ], $html );
		$this->assertTag( [ 'class' => 'p-views' ], $html );
		$this->assertNotTag( [ 'class' => 'p-user-interface-preferences' ], $html );
		$this->assertNotTag( [ 'class' => 'p-user-page' ], $html );
		$this->assertNotTag( [ 'class' => 'p-notifications' ], $html );
		$this->assertNotTag( [ 'class' => 'p-user-menu' ], $html );
	}

	/**
	 * @dataProvider namespaceMenuProvider
	 * @covers ::getHtml
	 */
	public function testGetHtml_HideDiscussionLinkRemovesTheTalkTab( string $menu ) {
		$html = $this->getHtmlForContentNavigation(
			[
				$menu => [
					'main' => [ 'text' => 'Page' ],
					'talk' => [ 'text' => 'Discussion' ],
				],
			],
			$this->newDomElementWithAttribute( 'hideDiscussionLink' )
		);

		$this->assertTag( [ 'class' => 'tool-main' ], $html );
		$this->assertNotTag( [ 'class' => 'tool-talk' ], $html );
	}

	/**
	 * @dataProvider namespaceMenuProvider
	 * @covers ::getHtml
	 */
	public function testGetHtml_HideSelectedNamespaceRemovesTheSelectedTab( string $menu ) {
		$html = $this->getHtmlForContentNavigation(
			[
				$menu => [
					'main' => [ 'text' => 'Page' ],
					'talk' => [ 'text' => 'Discussion' ],
				],
			],
			$this->newDomElementWithAttribute( 'hideSelectedNameSpace' )
		);

		$this->assertNotTag( [ 'class' => 'tool-main' ], $html );
		$this->assertTag( [ 'class' => 'tool-talk' ], $html );
	}

	public static function namespaceMenuProvider(): array {
		return [
			'associated-pages' => [ 'associated-pages' ],
			'namespaces' => [ 'namespaces' ],
		];
	}

	private function getHtmlForContentNavigation( array $contentNavigation, ?DOMElement $domElement = null ): string {
		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'ContentNavigation', $contentNavigation );

		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();
		$chameleonTemplate->method( 'makeListItem' )
			->willReturnCallback( static fn ( string $key ): string => '<div class="tool-' . $key . '"></div>' );

		$instance = new PageTools( $chameleonTemplate, $domElement );

		return $instance->getHtml();
	}

	private function newDomElementWithAttribute( string $attribute ): DOMElement {
		$domElement = $this->domElementProviderFromSyntheticLayoutFiles()[0][0];
		$domElement->setAttribute( $attribute, 'yes' );

		return $domElement;
	}

}
