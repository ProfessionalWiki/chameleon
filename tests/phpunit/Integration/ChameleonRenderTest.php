<?php

namespace Skins\Chameleon\Tests\Integration;

use Bootstrap\BootstrapManager;
use MediaWiki\Context\RequestContext;
use MediaWiki\Request\FauxRequest;
use MediaWiki\SpecialPage\SpecialPage;
use MediaWiki\Title\Title;
use MediaWiki\User\User;
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

	public function testRenderedPageContainsTheNamespaceViewAndActionTabs() {
		$html = $this->renderPage(
			$this->getExistingTestPage( 'Chameleon render test' )->getTitle(),
			$this->getTestSysop()->getUser()
		);

		$this->assertStringContainsString( 'ca-nstab-main', $html );
		$this->assertStringContainsString( 'ca-history', $html );
		$this->assertStringContainsString( 'ca-move', $html );
	}

	public function testPersonalToolsMenusAreNotRenderedAsPageToolGroups() {
		$this->assertStringNotContainsString( 'p-user-menu', $this->renderMainPage() );
	}

	public function testRenderedSpecialPageContainsItsNavigationLinks() {
		$this->assertStringContainsString(
			'Special:EditWatchlist/clear',
			$this->renderSpecialPage( 'EditWatchlist', $this->getTestUser()->getUser() )
		);
	}

	private function renderMainPage(): string {
		return $this->renderPage( Title::newFromText( 'Main Page' ) );
	}

	private function renderPage( Title $title, ?User $user = null ): string {
		return $this->newContext( $title, $user )->getSkin()->generateHTML();
	}

	private function renderSpecialPage( string $name, User $user ): string {
		$context = $this->newContext( SpecialPage::getTitleFor( $name ), $user );

		$this->getServiceContainer()->getSpecialPageFactory()->executePath( $name, $context );

		return $context->getSkin()->generateHTML();
	}

	private function newContext( Title $title, ?User $user ): RequestContext {
		$context = new RequestContext();
		$context->setRequest( new FauxRequest() );
		$context->setTitle( $title );

		if ( $user !== null ) {
			$context->setUser( $user );
		}

		$context->setSkin( $this->getServiceContainer()->getSkinFactory()->makeSkin( 'chameleon' ) );

		return $context;
	}

}
