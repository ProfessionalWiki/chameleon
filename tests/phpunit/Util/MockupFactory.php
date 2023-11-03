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

namespace Skins\Chameleon\Tests\Util;

use Config;
use FauxRequest;
use Message;
use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Chameleon;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\ComponentFactory;
use Skins\Chameleon\Components\Component;
use stdClass;
use Title;
use User;

// @codingStandardsIgnoreStart
/**
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
// @codingStandardsIgnoreEnd
class MockupFactory {

	private $testCase;
	private $configuration = [
		'UserIsRegistered'    => false,
		'UserEffectiveGroups' => [ '*' ],
		'UserRights' => [],
	];

	/**
	 * MockupFactory constructor.
	 *
	 * @param TestCase $testCase
	 */
	public function __construct( TestCase $testCase ) {
		$this->testCase = $testCase;
	}

	/**
	 * Returns a new factory. Convenience method to avoid having to use the constructor.
	 *
	 * @param TestCase $testCase
	 *
	 * @return MockupFactory
	 */
	public static function makeFactory( TestCase $testCase ) {
		return new self( $testCase );
	}

	/**
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->configuration[ $key ] = $value;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|ChameleonTemplate
	 * @throws \MWException
	 */
	public function getChameleonSkinTemplateStub() {
		$chameleonTemplate = $this->testCase->getMockBuilder( ChameleonTemplate::class )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->data = $this->getSkinTemplateDummyDataSetForMainNamespace();
		$chameleonTemplate->translator = $this->getTranslatorStub();

		$dataMap = array_map(
			function ( $key, $value ) {
				return [ $key, null, $value ];
			},
			array_keys( $chameleonTemplate->data ),
			array_values( $chameleonTemplate->data )
		);

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'get' )
			->will( $this->testCase->returnValueMap( $dataMap ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getMsg' )
			->will( $this->testCase->returnValue( $this->getMessageStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getSkin' )
			->will( $this->testCase->returnValue( $this->getSkinStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getComponent' )
			->will( $this->testCase->returnValue( $this->getComponentStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getSidebar' )
			->will( $this->testCase->returnValue( [] ) );


		if ( version_compare( MW_VERSION, '1.41', '<' ) ) {
			$chameleonTemplate->expects( $this->testCase->any() )
				->method( 'getToolbox' )
				->will( $this->testCase->returnValue( [] ) );
		}

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getPersonalTools' )
			->will( $this->testCase->returnValue( [
				'foo' => [ 'id' => 'pt-foo' ],
				'bar' => [ 'id' => 'pt-bar' ],
				'notifications-alert' => [ 'id' => 'pt-notifications-alert' ],
				'notifications-notice' => [ 'id' => 'pt-notifications-notice'],
			] ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getFooterLinks' )
			->will( $this->testCase->returnValue(
					[
						'category1' => [ 'key1', 'key2' ],
						'category2' => [ 'key3', 'key4' ],
						'places'    => [ 'privacy', 'about', 'disclaimer' ],
					]
				)
			);

		return $chameleonTemplate;
	}

	/**
	 * Dummy values are by no means to represent a particular intention or
	 * objective and merely used to pass through the respective method
	 *
	 * Testing specific conditions should be done separately in each sub
	 * component
	 *
	 * @return array
	 */
	protected function getSkinTemplateDummyDataSetForMainNamespace() {
		return [

			// Required by Logo
			'logopath'           => 'foo',
			'sitename'           => 'bar',

			// Required by NavMenu
			'nav_urls'           => [
				'mainpage' => [ 'href' => 'bat' ]
			],

			// Required by PageTools
			'content_navigation' => [
				'namespaces' =>
					[
						'talk' =>
							[
								'class'   => '',
								'text'    => 'Discussion',
								'href'    => '/mw/index.php?title=Talk:Main_Page',
								'primary' => true,
								'context' => 'talk',
								'id'      => 'ca-talk',
							],
					],
				'views'      =>
					[
						'view'    =>
							[
								'class'     => 'selected',
								'text'      => 'View',
								'href'      => '/mw/index.php/Main_Page',
								'primary'   => true,
								'redundant' => true,
								'id'        => 'ca-view',
							],
						'edit'    =>
							[
								'class'   => '',
								'text'    => 'Edit',
								'href'    => '/mw/index.php?title=Main_Page&action=edit',
								'primary' => true,
								'id'      => 'ca-edit',
							],
						'history' =>
							[
								'class' => false,
								'text'  => 'History',
								'href'  => '/mw/index.php?title=Main_Page&action=history',
								'rel'   => 'archives',
								'id'    => 'ca-history',
							],
					],
			],

			// Required by SearchBar
			'wgScript'           => 'bam',
			'searchtitle'        => 'jouy',

			// Required by MainContent
			'subtitle'           => 'SomeSubtitle',
			'undelete'           => 'SomeUndeleteMessage',
			'dataAfterContent'   => 'SomeDataAfterContent',
			'catlinks'           => 'SomeCategory',
		];
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getTranslatorStub() {
		$translator = $this->testCase->getMockBuilder( stdClass::class )
			->setMethods( [ 'translate' ] )
			->getMock();

		$translator->expects( $this->testCase->any() )
			->method( 'translate' )
			->will( $this->testCase->returnValue( 'translate' ) );

		return $translator;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getMessageStub() {
		$message = $this->testCase->getMockBuilder( Message::class )
			->disableOriginalConstructor()
			->getMock();

		$message->expects( $this->testCase->any() )
			->method( 'params' )
			->will( $this->testCase->returnSelf() );

		return $message;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 * @throws \MWException
	 */
	protected function getSkinStub() {
		$title = Title::newFromText( 'FOO' );
		$request = new FauxRequest();

		$skin = $this->testCase->getMockBuilder( Chameleon::class )
			->disableOriginalConstructor()
			->getMock();

		$skin->expects( $this->testCase->any() )
			->method( 'getTitle' )
			->will( $this->testCase->returnValue( $title ) );

		$skin->expects( $this->testCase->any() )
			->method( 'getUser' )
			->will( $this->testCase->returnValue( $this->getUserStub() ) );

		$skin->expects( $this->testCase->any() )
			->method( 'getRequest' )
			->will( $this->testCase->returnValue( $request ) );

		$skin->expects( $this->testCase->any() )
			->method( 'getComponentFactory' )
			->will( $this->testCase->returnValue( $this->getComponentFactoryStub() ) );

		$skin->expects( $this->testCase->any() )
			->method( 'msg' )
			->will( $this->testCase->returnValue( $this->getMessageStub() ) );

		$skin->expects( $this->testCase->any() )
			->method( 'getConfig' )
			->will( $this->testCase->returnValue( $this->getConfigStub() ) );

		return $skin;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getConfigStub() {
		$config = $this->testCase->getMockBuilder( Config::class )
			->disableOriginalConstructor()
			->getMock();

		return $config;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getComponentStub() {
		$component = $this->testCase->getMockBuilder( Component::class )
			->disableOriginalConstructor()
			->getMock();

		$component->expects( $this->testCase->any() )
			->method( 'getHtml' )
			->will( $this->testCase->returnValue( 'SomePlainText' ) );

		return $component;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getUserStub() {
		$request = new FauxRequest();

		$user = $this->testCase->getMockBuilder( User::class )
			->disableOriginalConstructor()
			->getMock();

		$user->expects( $this->testCase->any() )
			->method( 'isRegistered' )
			->will( $this->testCase->returnValue( $this->get( 'UserIsRegistered', true ) ) );

		if ( version_compare( MW_VERSION, '1.38', '<' ) ) {
			$user->expects( $this->testCase->any() )
				->method( 'getEffectiveGroups' )
				->will( $this->testCase->returnValue( $this->get( 'UserEffectiveGroups', 0 ) ) );
		}

		$user->expects( $this->testCase->any() )
			->method( 'getTalkPage' )
			->will( $this->testCase->returnValue( $this->getTitleStub() ) );

		$user->expects( $this->testCase->any() )
			->method( 'getRequest' )
			->will( $this->testCase->returnValue( $request ) );

		$user->expects( $this->testCase->any() )
			->method( 'getName' )
			->will( $this->testCase->returnValue( $this->get( 'UserName', 'FooUser' ) ) );

		$user->expects( $this->testCase->any() )
			->method( 'getRealName' )
			->will( $this->testCase->returnValue( $this->get( 'UserRealName', '' ) ) );

		return $user;
	}

	/**
	 * @param mixed $key
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function get( $key, $default = null ) {
		if ( isset( $this->configuration[ $key ] ) ) {
			return $this->configuration[ $key ];
		} else {
			return $default;
		}
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getTitleStub() {
		$title = $this->testCase->getMockBuilder( Title::class )
			->disableOriginalConstructor()
			->getMock();

		$title->expects( $this->testCase->any() )
			->method( 'getLinkUrl' )
			->will( $this->testCase->returnValue( 'SomeLinkUrl' ) );

		return $title;
	}

	/**
	 * @return \PHPUnit\Framework\MockObject\MockObject|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getComponentFactoryStub() {
		$factory = $this->testCase->getMockBuilder( ComponentFactory::class )
			->disableOriginalConstructor()
			->getMock();

		$factory->expects( $this->testCase->any() )
			->method( 'getComponent' )
			->will( $this->testCase->returnValue( $this->getComponentStub() ) );

		return $factory;
	}

}
