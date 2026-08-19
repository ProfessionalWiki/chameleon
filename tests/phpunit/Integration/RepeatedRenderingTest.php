<?php

declare( strict_types = 1 );

namespace Skins\Chameleon\Tests\Integration;

use Bootstrap\BootstrapManager;
use DOMDocument;
use DOMXPath;
use MediaWiki\Context\RequestContext;
use MediaWiki\Request\FauxRequest;
use MediaWiki\Title\Title;
use MediaWikiIntegrationTestCase;
use Skins\Chameleon\Hooks\SetupAfterCache;

/**
 * Renders the real skin twice through one context, as MediaWiki does when an extension such as PageForms captures a
 * first render of the page before the one it delivers. Needs the database for the page lookups a render makes.
 *
 * @covers \Skins\Chameleon\Chameleon
 * @covers \Skins\Chameleon\ChameleonTemplate
 * @covers \Skins\Chameleon\ComponentFactory
 *
 * @group skins-chameleon
 * @group skins-chameleon-integration
 * @group Database
 */
class RepeatedRenderingTest extends MediaWikiIntegrationTestCase {

	protected function setUp(): void {
		parent::setUp();

		$this->setMwGlobals( 'egChameleonLayoutFile', __DIR__ . '/../Fixture/MainContent.xml' );

		// Registers the skin with the current SkinFactory, which setMwGlobals() replaces, so it has to come second.
		( new SetupAfterCache( BootstrapManager::getInstance(), $GLOBALS, new FauxRequest() ) )->process();
	}

	public function testSecondRenderShowsWhatWasAddedAfterTheFirst(): void {
		$context = $this->newContext();
		$context->getOutput()->addHTML( 'Shown on the first render' );
		$context->getSkin()->generateHTML();

		$context->getOutput()->addHTML( 'Added after the first render' );

		$this->assertStringContainsString( 'Added after the first render', $context->getSkin()->generateHTML() );
	}

	public function testSecondRenderKeepsTheRequestedIds(): void {
		$context = $this->newContext();
		$context->getSkin()->generateHTML();

		$this->assertSame( 1, $this->countElementsWithId( 'content', $context->getSkin()->generateHTML() ) );
	}

	private function newContext(): RequestContext {
		$context = new RequestContext();
		$context->setTitle( Title::makeTitle( NS_MAIN, 'Some page' ) );
		$context->setUser( $this->getServiceContainer()->getUserFactory()->newAnonymous() );
		$context->setSkin( $this->getServiceContainer()->getSkinFactory()->makeSkin( 'chameleon' ) );

		return $context;
	}

	private function countElementsWithId( string $id, string $html ): int {
		$document = new DOMDocument();
		$document->loadHTML( '<meta charset="utf-8">' . $html, LIBXML_NOERROR );

		return ( new DOMXPath( $document ) )->query( "//*[@id='$id']" )->length;
	}

}
