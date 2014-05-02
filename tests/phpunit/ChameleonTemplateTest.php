<?php

namespace Skins\Chameleon\Tests;

use Skins\Chameleon\ChameleonTemplate;

/**
 * @uses \Skins\Chameleon\ChameleonTemplate
 *
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class ChameleonTemplateTest extends \PHPUnit_Framework_TestCase {

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

		$this->setExpectedException( 'RuntimeException' );

		$GLOBALS['egChameleonLayoutFile'] = 'setInaccessibleLayoutFile';

		$instance = new ChameleonTemplate;
		$instance->execute();
	}

}
