<?php

namespace Skins\Chameleon\Tests\Integration;

use Bootstrap\BootstrapManager;
use MediaWiki\Context\RequestContext;
use MediaWiki\Request\FauxRequest;
use MediaWiki\Title\Title;
use MediaWikiIntegrationTestCase;
use Skins\Chameleon\Hooks\SetupAfterCache;

/**
 * Renders the real skin, so that any MediaWiki deprecation hit while rendering fails the suite:
 * MediaWiki's PHPUnit configuration turns deprecations into errors.
 *
 * @covers \Skins\Chameleon\Chameleon
 * @covers \Skins\Chameleon\ChameleonTemplate
 * @covers \Skins\Chameleon\Components\PageTools
 * @covers \Skins\Chameleon\Components\PersonalTools
 *
 * @group skins-chameleon
 * @group skins-chameleon-integration
 * @group Database
 *
 * @license GPL-3.0-or-later
 */
class ChameleonRenderTest extends MediaWikiIntegrationTestCase {

	protected function setUp(): void {
		parent::setUp();

		( new SetupAfterCache( BootstrapManager::getInstance(), $GLOBALS, new FauxRequest() ) )->process();
	}

	public function testRenderedPageContainsThePersonalTools() {
		$this->assertStringContainsString( 'pt-login', $this->renderMainPage() );
	}

	public function testRenderedPageContainsThePageTools() {
		$this->assertStringContainsString( 'p-contentnavigation', $this->renderMainPage() );
	}

	public function testPersonalToolsMenusAreNotRenderedAsPageToolGroups() {
		$this->assertStringNotContainsString( 'p-user-menu', $this->renderMainPage() );
	}

	private function renderMainPage(): string {
		$context = new RequestContext();
		$context->setTitle( Title::newFromText( 'Main Page' ) );

		$skin = $this->getServiceContainer()->getSkinFactory()->makeSkin( 'chameleon' );
		$skin->setContext( $context );

		return $skin->generateHTML();
	}

}
