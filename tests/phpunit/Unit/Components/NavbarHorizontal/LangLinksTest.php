<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

namespace Skins\Chameleon\Tests\Unit\Components\NavbarHorizontal;

use Skins\Chameleon\Components\NavbarHorizontal\LangLinks;
use Skins\Chameleon\Tests\Unit\Components\GenericComponentTestCase;
use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\NavbarHorizontal\LangLinks
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 2.0
 * @ingroup Skins
 * @ingroup Test
 */
class LangLinksTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\NavbarHorizontal\LangLinks';

	/**
	 * @covers ::getHtml
	 */
	public function testAfterPortletContentIsRenderedWithoutLanguageLinks() {
		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'AfterPortlet',
			[ 'lang' => '<span class="wbc-editpage">AFTER_PORTLET_MARKER</span>' ] );

		$component = new LangLinks( $factory->getChameleonSkinTemplateStub() );

		$this->assertStringContainsString( 'AFTER_PORTLET_MARKER', $component->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtmlIsEmptyWithoutLanguageLinksOrAfterPortletContent() {
		$component = new LangLinks( MockupFactory::makeFactory( $this )->getChameleonSkinTemplateStub() );

		$this->assertSame( '', $component->getHtml() );
	}

}
