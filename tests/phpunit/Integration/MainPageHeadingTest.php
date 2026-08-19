<?php

declare( strict_types = 1 );

namespace Skins\Chameleon\Tests\Integration;

use DOMDocument;
use DOMElement;
use DOMXPath;
use MediaWiki\Context\RequestContext;
use MediaWiki\MainConfigNames;
use MediaWiki\Title\Title;
use MediaWiki\User\User;
use MediaWikiIntegrationTestCase;
use Skins\Chameleon\Chameleon;

/**
 * @covers \Skins\Chameleon\Chameleon
 * @covers \Skins\Chameleon\Components\ContentHeader
 *
 * @group skins-chameleon
 * @group skins-chameleon-integration
 * @group Database
 */
class MainPageHeadingTest extends MediaWikiIntegrationTestCase {

	private const PAGE_TITLE = 'Title of the page being viewed';

	protected function setUp(): void {
		parent::setUp();

		// The test environment ignores the MediaWiki namespace, which is where these headings are set.
		$this->overrideConfigValue( MainConfigNames::UseDatabaseMessages, true );
	}

	public function testMainPageHeadingComesFromTheMainpageTitleMessage(): void {
		$this->editPage( 'MediaWiki:Mainpage-title', 'Welcome, visitor' );

		$this->assertSame( 'Welcome, visitor', $this->getFirstHeading( Title::newMainPage() )->textContent );
	}

	public function testMainPageHeadingOfLoggedInUsersComesFromTheMainpageTitleLoggedinMessage(): void {
		$user = $this->getTestUser()->getUser();
		$this->editPage( 'MediaWiki:Mainpage-title-loggedin', 'Welcome back, $1' );

		$this->assertSame(
			'Welcome back, ' . $user->getName(),
			$this->getFirstHeading( Title::newMainPage(), $user )->textContent
		);
	}

	public function testMainPageHeadingIsThePageTitleWhenTheMessageIsNotSet(): void {
		$this->assertSame( self::PAGE_TITLE, $this->getFirstHeading( Title::newMainPage() )->textContent );
	}

	public function testOrdinaryPageHeadingIsNotAffectedByTheMainpageTitleMessage(): void {
		$this->editPage( 'MediaWiki:Mainpage-title', 'Welcome, visitor' );

		$heading = $this->getFirstHeading( Title::makeTitle( NS_MAIN, 'Some other page' ) );

		$this->assertSame( self::PAGE_TITLE, $heading->textContent );
	}

	public function testMainPageHeadingIsHiddenWhenTheMessageIsBlank(): void {
		$this->editPage( 'MediaWiki:Mainpage-title', '' );

		$this->assertSame( 'display: none', $this->getFirstHeading( Title::newMainPage() )->getAttribute( 'style' ) );
	}

	public function testOrdinaryPageHeadingIsNotHidden(): void {
		$heading = $this->getFirstHeading( Title::makeTitle( NS_MAIN, 'Some other page' ) );

		$this->assertSame( '', $heading->getAttribute( 'style' ) );
	}

	private function getFirstHeading( Title $title, ?User $user = null ): DOMElement {
		$document = new DOMDocument();
		$document->loadHTML( '<meta charset="utf-8">' . $this->renderPage( $title, $user ), LIBXML_NOERROR );

		$headings = ( new DOMXPath( $document ) )
			->query( '//h1[contains(concat(" ", normalize-space(@class), " "), " firstHeading ")]' );

		$this->assertCount( 1, $headings, 'the rendered page should hold exactly one first heading' );

		return $headings->item( 0 );
	}

	private function renderPage( Title $title, ?User $user ): string {
		$context = new RequestContext();
		$context->setTitle( $title );
		$context->setUser( $user ?? $this->getServiceContainer()->getUserFactory()->newAnonymous() );
		$context->setSkin( new Chameleon() );
		$context->getOutput()->setPageTitle( self::PAGE_TITLE );

		return $context->getSkin()->generateHTML();
	}

}
