<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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

/**
 * @coversDefaultClass \Skins\Chameleon\Components\FooterInfo
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
class FooterInfoTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\FooterInfo';
	protected $componentUnderTest = 'FooterInfo';

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_GetsAllKeys() {
		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$chameleonTemplate->expects( $this->exactly( 4 ) )
			->method( 'get' )
			->withConsecutive(
				[ $this->equalTo( 'key1' ) ],
				[ $this->equalTo( 'key2' ) ],
				[ $this->equalTo( 'key3' ) ],
				[ $this->equalTo( 'key4' ) ]
			)
			->willReturn( $this->returnValue( 'SomeHTML' ) );

		$instance = new $this->classUnderTest( $chameleonTemplate );

		$instance->getHtml();
	}

}
