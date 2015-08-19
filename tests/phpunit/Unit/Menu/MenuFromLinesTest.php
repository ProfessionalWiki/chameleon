<?php
/**
 * File containing the MenuFromLinesTest class
 *
 * @copyright (C) 2013 - 2015, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
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

namespace Skins\Chameleon\Tests\Unit\Menu;
use Skins\Chameleon\Menu\MenuFromLines;

/**
 * Class MenuFromLinesTest
 *
 * @coversDefaultClass \Skins\Chameleon\Menu\MenuFromLines
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author  Stephan Gambke
 * @since   1.1.2
 * @ingroup Skins
 * @ingroup Test
 */
class MenuFromLinesTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {

		$lines = array();

		/** @var MenuFromLines $instance */
		$instance = new MenuFromLines( $lines, true );

		$this->assertInstanceOf(
			'Skins\Chameleon\Menu\MenuFromLines',
			$instance
		);
	}

	/**
	 * @covers ::__construct
	 *
	 * Just checking that giving an item data parameter does not immediately
	 * break the constructor. No actual functionality beyond that is tested.
	 */
	public function testCanConstructWithItemData() {

		$lines = array();

		/** @var MenuFromLines $instance */
		$instance = new MenuFromLines( $lines, true, array(
			'text'  => 'foo',
			'href'  => 'bar',
			'depth' => 42
		) );

		$this->assertInstanceOf(
			'Skins\Chameleon\Menu\MenuFromLines',
			$instance
		);
	}

	/**
	 * @covers ::getHtml
	 * @covers ::parseLines
	 */
	public function testBuildEmptyMenu() {

		$lines = array(
			'',
			'* Foo',
			'** | FooBar',
			'*** http://foo.com | FooBarBaz',
			'*** # | FooBarQuok',
			'* Test | Bar',
		);

		$ap = $GLOBALS[ 'wgArticlePath' ];

		$expected =
			"\t<ul>\n" .
			"\t\t<li>\n" .
			"\t\t\t<a href=\"" . str_replace( '$1', 'Foo', $ap ) . "\">Foo</a>\n" .
			"\t\t\t<ul>\n" .
			"\t\t\t\t<li>\n" .
			"\t\t\t\t\t<a href=\"#" . "\">FooBar</a>\n" .
			"\t\t\t\t\t<ul>\n" .
			"\t\t\t\t\t\t<li><a href=\"http://foo.com\">FooBarBaz</a></li>\n" .
			"\t\t\t\t\t\t<li><a href=\"#\">FooBarQuok</a></li>\n" .
			"\t\t\t\t\t</ul>\n" .
			"\t\t\t\t</li>\n" .
			"\t\t\t</ul>\n" .
			"\t\t</li>\n" .
			"\t\t<li><a href=\"" . str_replace( '$1', 'Test', $ap ) . "\">Bar</a></li>\n" .
			"\t</ul>\n";

		/** @var MenuFromLines $instance */
		$instance = new MenuFromLines( $lines, true );

		$this->assertEquals(
			$expected,
			$instance->getHtml()
		);

	}
}
