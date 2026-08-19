<?php

declare( strict_types = 1 );

namespace Skins\Chameleon\Tests\Unit;

use FileFetcher\InMemoryFileFetcher;
use Skins\Chameleon\Chameleon;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\ComponentFactory;

/**
 * @covers \Skins\Chameleon\ComponentFactory
 *
 * @group skins-chameleon
 */
class ComponentFactoryTest extends \MediaWikiIntegrationTestCase {

	/**
	 * Refactor idea: inject a LayoutXmlSource into ComponentFactory,
	 * so the latter does not have details about how to obtain the XML.
	 */
	public function testGetLayoutXml(): void {
		$componentFactory = new ComponentFactory(
			'TestLayout.xml',
			$this->createHookContainer( [
				Chameleon::HOOK_GET_LAYOUT_XML => function( string &$xml ) {
					$xml .= ' Hi from hook.';
				}
			] ),
			new InMemoryFileFetcher( [
				'TestLayout.xml' => 'Hi from file.'
			] )
		);

		$this->assertSame(
			'Hi from file. Hi from hook.',
			$componentFactory->getLayoutXml()
		);
	}

	public function testComponentsRenderFromTheSkinTemplateSetLast(): void {
		$componentFactory = new ComponentFactory(
			'TestLayout.xml',
			$this->createHookContainer(),
			new InMemoryFileFetcher( [
				'TestLayout.xml' => '<structure><component type="ContentBody"></component></structure>'
			] )
		);

		$componentFactory->setSkinTemplate(
			$this->newTemplate( $componentFactory, 'body text of the first render' ) );

		$this->assertStringContainsString(
			'body text of the first render',
			$componentFactory->getRootComponent()->getHtml()
		);

		$componentFactory->setSkinTemplate(
			$this->newTemplate( $componentFactory, 'body text of the second render' ) );

		$this->assertStringContainsString(
			'body text of the second render',
			$componentFactory->getRootComponent()->getHtml()
		);
	}

	private function newTemplate( ComponentFactory $componentFactory, string $bodyText ): ChameleonTemplate {
		$template = new ChameleonTemplate();
		$template->set( 'skin', $this->newSkin( $componentFactory ) );
		$template->set( 'bodytext', $bodyText );

		return $template;
	}

	/**
	 * Subcomponents are built through the skin, which in production holds the same factory.
	 */
	private function newSkin( ComponentFactory $componentFactory ): Chameleon {
		$skin = $this->createStub( Chameleon::class );
		$skin->method( 'getComponentFactory' )->willReturn( $componentFactory );

		return $skin;
	}

}
