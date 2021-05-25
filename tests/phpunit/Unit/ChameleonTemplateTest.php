<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke, mwjames
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

namespace Skins\Chameleon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Chameleon;
use Skins\Chameleon\ChameleonTemplate;

/**
 * @uses \Skins\Chameleon\ChameleonTemplate
 *
 * @group skins-chameleon
 * @group skins-chameleon-unit
 * @group mediawiki-databaseless
 *
 * @license   GPL-3.0-or-later
 * @since 1.0
 *
 * @author mwjames
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class ChameleonTemplateTest extends TestCase {

	// This is to ensure that the original value is cached since we are unable
	// to inject the setting during testing
	protected $egChameleonLayoutFile = null;
	protected $egChameleonThemeFile = null;

	protected function setUp(): void {
		parent::setUp();

		$this->egChameleonLayoutFile = $GLOBALS['egChameleonLayoutFile'];
		$this->egChameleonThemeFile = $GLOBALS['egChameleonThemeFile'];
	}

	protected function tearDown(): void {
		$GLOBALS['egChameleonLayoutFile'] = $this->egChameleonLayoutFile;
		$GLOBALS['egChameleonThemeFile'] = $this->egChameleonThemeFile;

		parent::tearDown();
	}

	/**
	 * @covers \Skins\Chameleon\ChameleonTemplate
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf(
			'\Skins\Chameleon\ChameleonTemplate',
			new ChameleonTemplate()
		);
	}

	/**
	 * @covers \Skins\Chameleon\ChameleonTemplate
	 */
	public function testInaccessibleLayoutFileThrowsExeception() {
		$this->expectException( 'RuntimeException' );

		$GLOBALS['egChameleonLayoutFile'] = 'setInaccessibleLayoutFile';

		$skin = new Chameleon();

		$instance = new ChameleonTemplate;
		$instance->set( 'skin', $skin );
		$instance->execute();
	}

}
