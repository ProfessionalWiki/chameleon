<?php
/**
 * File containing the MenuFromLinesTest class
 *
 * @copyright (C) 2013 - 2014, Stephan Gambke
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

namespace Skins\Chameleon\Tests\Menu;
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
	 *
	 */
	public function testBuildEmptyMenu() {

		$lines = array(
			'',
			'* Foo',
			'** FooBar',
			'*** FooBarBaz',
			'* Test | Bar',
		);

		$sp = $GLOBALS[ 'wgScriptPath' ];

		$expected = "<ul><li><a href=\"$sp/index.php/Foo\">Foo</a><ul><li><a href=\"$sp/index.php/FooBar\">FooBar</a><ul><li><a href=\"$sp/index.php/FooBarBaz\">FooBarBaz</a></li></ul></li></ul></li><li><a href=\"$sp/index.php/Test\">Bar</a></li></ul>";

		/** @var MenuFromLines $instance */
		$instance = new MenuFromLines( $lines, true );

		$this->assertEquals(
			$expected,
			$instance->getHtml()
		);

	}
}
