<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

namespace Skins\Chameleon\Tests\Unit\Components;

use DOMElement;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\Grid
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class GridTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\Grid';

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_DefaultModeIsFixed( DomElement $domElement ): void {
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => 'container' ], $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ModeIsFixed( DomElement $domElement ): void {
		$domElement->setAttribute( 'mode', 'fixedwidth' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => 'container' ], $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ModeIsFluid( DomElement $domElement ): void {
		$domElement->setAttribute( 'mode', 'fluid' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => 'container-fluid' ], $instance->getHtml() );
	}

	public function breakpointProvider(): iterable {
		$domElement = $this->domElementProviderFromSyntheticLayoutFiles()[0][0];
		yield 'sm' => [ $domElement, 'sm' ];
		yield 'md' => [ $domElement, 'md' ];
		yield 'lg' => [ $domElement, 'lg' ];
		yield 'xl' => [ $domElement, 'xl' ];
		yield 'xxl' => [ $domElement, 'xxl' ];
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider breakpointProvider
	 */
	public function testGetHtml_ModeIsBreakpoint( DomElement $domElement, string $breakpoint ): void {
		$domElement->setAttribute( 'mode', $breakpoint );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => "container-$breakpoint" ], $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_ModeIsInvalid( DomElement $domElement ): void {
		$domElement->setAttribute( 'mode', 'invalid' );
		$factory = MockupFactory::makeFactory( $this );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		$this->assertTag( [ 'class' => 'container' ], $instance->getHtml() );
	}

}
