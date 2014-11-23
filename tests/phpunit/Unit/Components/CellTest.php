<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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

namespace Skins\Chameleon\Tests\Unit\Components;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\Cell
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
class CellTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\Cell';

	/**
	 * @covers ::__construct
	 * @dataProvider provideSpanAttributeValues
	 * @param string $in
	 * @param string $expected
	 */
	public function testSpanAttribute( $in, $expected ) {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$domElement->expects( $this->any() )
			->method( 'getAttribute' )
			->will( $this->returnValueMap( array( array( 'span', $in ) ) ) );

		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$this->assertEquals(
			"col-lg-$expected",
			$instance->getClassString()
		);

	}

	/**
	 * @covers ::getClassString
	 */
	public function testGetClassString_WithoutSetting() {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new $this->classUnderTest ( $chameleonTemplate );

		$this->assertTrue( $instance->getClassString() === 'col-lg-12' );

	}

	public function provideSpanAttributeValues() {
		return array(
			array( '9', '9' ),
			array( '-1', '12' ),
			array( '42', '12' ),
			array( 'foo', '12' ),
			array( '10.5', '12' ),
		);
	}

}
