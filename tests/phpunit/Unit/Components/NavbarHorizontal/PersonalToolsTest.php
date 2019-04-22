<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

namespace Skins\Chameleon\Tests\Unit\Components\NavbarHorizontal;

use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Tests\Unit\Components\GenericComponentTestCase;
use Skins\Chameleon\Tests\Util\MockupFactory;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\NavbarHorizontal\PersonalTools
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.6
 * @ingroup Skins
 * @ingroup Test
 */
class PersonalToolsTest extends GenericComponentTestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\NavbarHorizontal\PersonalTools';

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_LoggedInUserHasNewMessages( $domElement ) {

		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'UserIsLoggedIn', true );
		$factory->set( 'UserNewMessageLinks', [ 'foo' ] );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$matcher = [ 'class' => 'pt-mytalk' ];
		$this->assertTag( $matcher, $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 */
	public function testGetHtml_LoggedInUserHasNoNewMessages( $domElement ) {

		$factory = MockupFactory::makeFactory( $this );
		$factory->set( 'UserIsLoggedIn', true );
		$factory->set( 'UserNewMessageLinks', [] );
		$chameleonTemplate = $factory->getChameleonSkinTemplateStub();

		/** @var Component $instance */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$matcher = [ 'class' => 'pt-mytalk' ];
		$this->assertNotTag( $matcher, $instance->getHtml() );
	}


}
