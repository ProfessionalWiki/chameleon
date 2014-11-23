<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke, mwjames
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

namespace Skins\Chameleon\Tests\Unit\Hooks;

use Skins\Chameleon\Hooks\SetupAfterCache;

/**
 * @coversDefaultClass \Skins\Chameleon\Hooks\SetupAfterCache
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group skins-chameleon
 * @group skins-chameleon-unit
 * @group mediawiki-databaseless
 *
 * @author mwjames
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class SetupAfterCacheTest extends \PHPUnit_Framework_TestCase {

	protected $dummyExternalModule = null;

	protected function setUp() {
		parent::setUp();

		$this->dummyExternalModule = __DIR__ . '/../../Fixture/externalmodule.less';
	}

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$configuration = array();

		$this->assertInstanceOf(
			'\Skins\Chameleon\Hooks\SetupAfterCache',
			new SetupAfterCache( $bootstrapManager, $configuration )
		);
	}

	/**
	 * @covers ::process
	 * @covers ::registerCommonBootstrapModules
	 * @covers ::registerExternalLessModules
	 */
	public function testProcessWithValidExternalModuleWithoutLessVariables() {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->at( 1 ) )
			->method( 'addExternalModule' );

		$bootstrapManager->expects( $this->at( 2 ) )
			->method( 'addExternalModule' )
			->with(
				$this->equalTo( $this->dummyExternalModule ),
				$this->equalTo( '' ) );

		$bootstrapManager->expects( $this->at( 3 ) )
			->method( 'addExternalModule' )
			->with(
				$this->equalTo( $this->dummyExternalModule ),
				$this->equalTo( 'someRemoteWeDontCheck' ) );

		$bootstrapManager->expects( $this->never() )
			->method( 'setLessVariable' );

		$mixedExternalStyleModules = array(
			$this->dummyExternalModule,
			$this->dummyExternalModule => 'someRemoteWeDontCheck'
		);

		$configuration = array(
			'egChameleonExternalStyleModules' => $mixedExternalStyleModules,
			'IP'                              => 'notTestingIP',
			'wgScriptPath'                    => 'notTestingwgScriptPath',
			'wgStyleDirectory'                => 'notTestingwgStyleDirectory',
			'wgStylePath'                     => 'notTestingwgStylePath',
		);

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration
		);

		$instance->process();
	}

	/**
	 * @covers ::process
	 * @covers ::registerExternalLessModules
	 */
	public function testProcessWithInvalidExternalModuleThrowsException() {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->atLeastOnce() )
			->method( 'addExternalModule' )
			->will( $this->returnValue( true ) );

		$externalStyleModules = array(
			__DIR__ . '/../../Util/Fixture/' . 'externalmoduleDoesNotExist.less'
		);

		$configuration = array(
			'egChameleonExternalStyleModules' => $externalStyleModules,
			'IP'                              => 'notTestingIP',
			'wgScriptPath'                    => 'notTestingwgScriptPath',
			'wgStyleDirectory'                => 'notTestingwgStyleDirectory',
			'wgStylePath'                     => 'notTestingwgStylePath'
		);

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration
		);

		$this->setExpectedException( 'RuntimeException' );

		$instance->process();
	}

	/**
	 * @covers ::process
	 * @covers ::registerExternalLessVariables
	 */
	public function testProcessWithLessVariables() {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->once() )
			->method( 'addExternalModule' )
			->will( $this->returnValue( true ) );

		$bootstrapManager->expects( $this->once() )
			->method( 'setLessVariable' )
			->with(
				$this->equalTo( 'foo' ),
				$this->equalTo( '999px' ) );

		$externalLessVariables = array(
			'foo' => '999px'
		);

		$configuration = array(
			'egChameleonExternalLessVariables' => $externalLessVariables,
			'IP'                               => 'notTestingIP',
			'wgScriptPath'                     => 'notTestingwgScriptPath',
			'wgStyleDirectory'                 => 'notTestingwgStyleDirectory',
			'wgStylePath'                      => 'notTestingwgStylePath'
		);

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration
		);

		$instance->process();
	}

	/**
	 * @covers ::adjustConfiguration
	 *
	 * @dataProvider adjustConfigurationProvider
	 */
	public function testAdjustConfiguration( $origConfig, $changes, $expected ) {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$changes
		);

		$instance->adjustConfiguration( $origConfig );

		$this->assertEquals( $expected, $origConfig );
	}

	/**
	 * @covers ::process
	 * @covers ::addLateSettings
	 *
	 * @depends testAdjustConfiguration
	 *
	 * @dataProvider lateSettingsProvider
	 */
	public function testProcessWithLateSettingsToAdjustConfiguration( $configuration, $expected ) {

		$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$IP = str_replace( DIRECTORY_SEPARATOR, '/', realpath( __DIR__ . '/../../../../../../' ) );

		$defaultConfiguration = array(
			'IP'                => $IP,
			'wgScriptPath'      => 'notTestingwgScriptPath',
			'wgStyleDirectory'  => 'notTestingwgStyleDirectory',
			'wgResourceModules' => array(),
		);

		$expected[ 'chameleonLocalPath' ] = $IP . '/skins/chameleon';
		$expected[ 'chameleonRemotePath' ] = $defaultConfiguration[ 'wgScriptPath' ] . '/skins/chameleon';

		$expected[ 'wgResourceModules' ] = array();
		$expected[ 'wgResourceModules' ][ 'skin.chameleon.jquery-sticky' ] = array(
			'localBasePath'  => $expected[ 'chameleonLocalPath' ] . '/resources/js',
			'remoteBasePath' => $expected[ 'chameleonRemotePath' ] . '/resources/js',
			'group'          => 'skin.chameleon',
			'skinScripts'    => array(
				'chameleon' => array( 'jquery-sticky/jquery.sticky.js', 'Components/Modifications/sticky.js' )
			)
		);

		$configurationToBeAdjusted = $configuration + $defaultConfiguration;

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configurationToBeAdjusted
		);

		$instance->process();

		$this->assertEquals(
			$expected + $defaultConfiguration,
			$configurationToBeAdjusted
		);
	}

	/**
	 * Provides test data for the lateSettings test
	 */
	public function lateSettingsProvider() {

		$provider = array();

		$provider[ ] = array(
			array(),
			array()
		);

		$provider[ ] = array(
			array(
				'wgVisualEditorSupportedSkins' => array(),
			),
			array(
				'wgVisualEditorSupportedSkins' => array(),
			)
		);

		$provider[ ] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
			),
			array(
				'egChameleonEnableVisualEditor' => true,
			)
		);

		$provider[ ] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo' ),
			),
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			)
		);

		$provider[ ] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			),
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			)
		);

		$provider[ ] = array(
			array(
				'egChameleonEnableVisualEditor' => false,
				'wgVisualEditorSupportedSkins'  => array( 'chameleon', 'foo' => 'chameleon', 'foo' ),
			),
			array(
				'egChameleonEnableVisualEditor' => false,
				'wgVisualEditorSupportedSkins'  => array( 1 => 'foo' ),
			)
		);

		return $provider;
	}

	public function adjustConfigurationProvider() {

		$provider = array();

		$provider[ ] = array(
			array(
				'key1' => 'value1',
				'key2' => 'value2',
			),
			array(
				'key2' => 'value2changed',
				'key3' => 'value3changed',
			),
			array(
				'key1' => 'value1',
				'key2' => 'value2changed',
				'key3' => 'value3changed',
			)
		);

		return $provider;
	}

}
