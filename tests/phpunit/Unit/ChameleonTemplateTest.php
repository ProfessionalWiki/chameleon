<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke, mwjames
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
 * @license GNU GPL v3+
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

	protected function setUp() {
		parent::setUp();

		$this->egChameleonLayoutFile = $GLOBALS['egChameleonLayoutFile'];
	}

	protected function tearDown() {
		$GLOBALS['egChameleonLayoutFile'] = $this->egChameleonLayoutFile;

		parent::tearDown();
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Skins\Chameleon\ChameleonTemplate',
			new ChameleonTemplate()
		);
	}

	public function testInaccessibleLayoutFileThrowsExeception() {

		$this->expectException( 'RuntimeException' );

		$GLOBALS['egChameleonLayoutFile'] = 'setInaccessibleLayoutFile';

		$skin = new Chameleon();

		$instance = new ChameleonTemplate;
		$instance->set( 'skin', $skin );
		$instance->execute();
	}

}
