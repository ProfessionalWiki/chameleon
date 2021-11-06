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

use Skins\Chameleon\ChameleonTemplate;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\NavMenu
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
class NavMenuTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\NavMenu';

	/**
	 * @covers ::getHTML
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHTML_HasValidId( $domElement ) {
		global $wgFragmentMode;
		// MW 1.37 defaults to html5 fragment mode. Force legacy mode for the test
		// to ensure the question mark is encoded as "3F" instead of "?".
		$wgFragmentMode = [ 'legacy' ];

		$chameleonTemplate = $this->getMockBuilder( ChameleonTemplate::class )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->any() )
			->method( 'getSidebar' )
			->will( $this->returnValue( [
				'A long question?!' => [
					'id' => 'p-A long question?',
					'header' => 'A long question?',
					'generated' => 1,
					'content' => [
						[
							'text' => 'An exclamation!',
							'href' => '/wiki/An_exclamation!',
							'id' => 'n-An-exclamation.21',
							'active' => false,
						]
					]
				]
			] ) );

		/** @var Component $instance */
		$instance = new $this->classUnderTest( $chameleonTemplate, $domElement );

		self::assertTag( [ 'id' => 'p-A-long-question.3F' ], $instance->getHTML() );
		self::assertTag( [ 'class' => 'p-A-long-question.3F' ], $instance->getHTML() );
	}

}
