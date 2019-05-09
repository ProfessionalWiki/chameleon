<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke, mwjames
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

use Bootstrap\BootstrapManager;
use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Hooks\SetupAfterCache;
use WebRequest;

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
class SetupAfterCacheTest extends TestCase {

	protected $dummyExternalModule = null;

	protected function setUp() {
		parent::setUp();

		$this->dummyExternalModule = __DIR__ . '/../../Fixture/externalmodule.scss';
	}

	/**
	 * @return string
	 */
	private function getWorkDirectory() {

		$directory = $GLOBALS[ 'argv' ][ 0 ];

		if ( $directory[ 0 ] !== DIRECTORY_SEPARATOR ) {
			$directory = $_SERVER[ 'PWD' ] . DIRECTORY_SEPARATOR . $directory;
		}

		$directory = dirname( $directory );

		return $directory;
	}

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {

		$bootstrapManager = $this->getMockBuilder( BootstrapManager::class )
			->disableOriginalConstructor()
			->getMock();

		$configuration = [];

		$request = $this->getMockBuilder('\WebRequest')
			->disableOriginalConstructor()
			->getMock();

		$this->assertInstanceOf(
			'\Skins\Chameleon\Hooks\SetupAfterCache',
			new SetupAfterCache( $bootstrapManager, $configuration, $request )
		);
	}

	/**
	 * @covers ::process
	 * @covers ::registerCommonBootstrapModules
	 * @covers ::registerExternalScssModules
	 */
	public function testProcessWithValidExternalModuleWithoutScssVariables() {

		$bootstrapManager = $this->getMockBuilder( BootstrapManager::class )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->at( 9 ) )
			->method( 'addStyleFile' )
			->with(
				$this->equalTo( $this->dummyExternalModule )
			);

		$bootstrapManager->expects( $this->at( 10 ) )
			->method( 'addStyleFile' )
			->with(
				$this->equalTo( $this->dummyExternalModule ),
				$this->equalTo( 'somePositionWeDontCheck' ) );

		$bootstrapManager->expects( $this->once() )
			->method( 'setScssVariable' )
			->with(
				$this->equalTo( 'fa-font-path' ),
				$this->anything()
			);

		$mixedExternalStyleModules = [
			$this->dummyExternalModule,
			$this->dummyExternalModule => 'somePositionWeDontCheck'
		];

		$configuration = [
			'egChameleonExternalStyleModules' => $mixedExternalStyleModules,
			'IP'                              => 'notTestingIP',
			'wgScriptPath'                    => 'notTestingwgScriptPath',
			'wgStyleDirectory'                => 'notTestingwgStyleDirectory',
			'wgStylePath'                     => 'notTestingwgStylePath',
		];

		$request = $this->getMockBuilder( WebRequest::class)
			->disableOriginalConstructor()
			->getMock();

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration,
			$request
		);

		$instance->process();
	}

	///**
	// * @covers ::process
	// * @covers ::registerExternalScssModules
	// */
	//public function testProcessWithInvalidExternalModuleThrowsException() {
	//
	//	$bootstrapManager = $this->getMockBuilder( BootstrapManager::class )
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$bootstrapManager->expects( $this->atLeastOnce() )
	//		->method( 'addStyleFile' );
	//
	//	$externalStyleModules = [
	//		__DIR__ . '/../../Util/Fixture/' . 'externalFileDoesNotExist.scss'
	//	];
	//
	//	$configuration = [
	//		'egChameleonExternalStyleModules' => $externalStyleModules,
	//		'IP'                              => 'notTestingIP',
	//		'wgScriptPath'                    => 'notTestingwgScriptPath',
	//		'wgStyleDirectory'                => 'notTestingwgStyleDirectory',
	//		'wgStylePath'                     => 'notTestingwgStylePath'
	//	];
	//
	//	$request = $this->getMockBuilder('\WebRequest')
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$instance = new SetupAfterCache(
	//		$bootstrapManager,
	//		$configuration,
	//		$request
	//	);
	//
	//	$this->expectException( 'RuntimeException' );
	//
	//	$instance->process();
	//}
	//
	///**
	// * @covers ::process
	// * @covers ::registerExternalStyleVariables
	// */
	//public function testProcessWithScssVariables() {
	//
	//	$bootstrapManager = $this->getMockBuilder( BootstrapManager::class )
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$bootstrapManager->expects( $this->once() )
	//		->method( 'addStyleFile' );
	//
	//	$bootstrapManager->expects( $this->once() )
	//		->method( 'setScssVariable' )
	//		->with(
	//			$this->equalTo( 'foo' ),
	//			$this->equalTo( '999px' ) );
	//
	//	$externalStyleVariables = [
	//		'foo' => '999px'
	//	];
	//
	//	$configuration = [
	//		'egChameleonExternalStyleVariables'=> $externalStyleVariables,
	//		'IP'                               => 'notTestingIP',
	//		'wgScriptPath'                     => 'notTestingwgScriptPath',
	//		'wgStyleDirectory'                 => 'notTestingwgStyleDirectory',
	//		'wgStylePath'                      => 'notTestingwgStylePath'
	//	];
	//
	//	$request = $this->getMockBuilder('\WebRequest')
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$instance = new SetupAfterCache(
	//		$bootstrapManager,
	//		$configuration,
	//		$request
	//	);
	//
	//	$instance->process();
	//}
	//
	///**
	// * @covers ::process
	// * @covers ::registerExternalLessVariables
	// *
	// * @dataProvider processWithRequestedLayoutFileProvider
	// */
	//public function testProcessWithRequestedLayoutFile( $availableLayoutFiles, $defaultLayoutFile, $requestedLayout, $expectedLayoutfile ) {
	//
	//	$bootstrapManager = $this->getMockBuilder( BootstrapManager::class )
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$configuration = [
	//		'egChameleonAvailableLayoutFiles'  => $availableLayoutFiles,
	//		'egChameleonLayoutFile'            => $defaultLayoutFile,
	//		'IP'                               => 'notTestingIP',
	//		'wgScriptPath'                     => 'notTestingwgScriptPath',
	//		'wgStyleDirectory'                 => 'notTestingwgStyleDirectory',
	//		'wgStylePath'                      => 'notTestingwgStylePath'
	//	];
	//
	//	$request = $this->getMockBuilder('\WebRequest')
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$request->expects( $this->once() )
	//		->method( 'getVal' )
	//		->will( $this->returnValue( $requestedLayout ) );
	//
	//	$instance = new SetupAfterCache(
	//		$bootstrapManager,
	//		$configuration,
	//		$request
	//	);
	//
	//	$instance->process();
	//
	//	$this->assertEquals(
	//		$expectedLayoutfile,
	//		$configuration['egChameleonLayoutFile']
	//	);
	//}

	/**
	 * @return array
	 */
	public function processWithRequestedLayoutFileProvider() {

		$provider = [];

		// no layout files available => keep default layout file
		$provider[] = [
			null,
			'standard.xml',
			'someOtherLayout',
			'standard.xml'
		];

		// no specific layout requested => keep default layout file
		$provider[] = [
			[
				'layout1' => 'layout1.xml',
				'layout2' => 'layout2.xml',
			],
			'standard.xml',
			null,
			'standard.xml'
		];

		// requested layout not available => keep default layout file
		$provider[] = [
			[
				'layout1' => 'layout1.xml',
				'layout2' => 'layout2.xml',
			],
			'standard.xml',
			'someOtherLayout',
			'standard.xml'
		];

		// requested layout available => return requested layout file
		$provider[] = [
			[
				'layout1' => 'layout1.xml',
				'layout2' => 'layout2.xml',
			],
			'standard.xml',
			'layout1',
			'layout1.xml'
		];

		return $provider;
	}

	///**
	// * @covers ::adjustConfiguration
	// *
	// * @dataProvider adjustConfigurationProvider
	// */
	//public function testAdjustConfiguration( $origConfig, $changes, $expected ) {
	//
	//	$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$request = $this->getMockBuilder('\WebRequest')
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$instance = new SetupAfterCache(
	//		$bootstrapManager,
	//		$changes,
	//		$request
	//	);
	//
	//	$instance->adjustConfiguration( $origConfig );
	//
	//	$this->assertEquals( $expected, $origConfig );
	//}
	//
	///**
	// * @covers ::process
	// * @covers ::addLateSettings
	// *
	// * @depends testAdjustConfiguration
	// *
	// * @dataProvider lateSettingsProvider
	// */
	//public function testProcessWithLateSettingsToAdjustConfiguration( $configuration, $expected ) {
	//
	//	$bootstrapManager = $this->getMockBuilder( '\Bootstrap\BootstrapManager' )
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$dir = $this->getWorkDirectory();
	//	$IP = dirname(dirname($dir));
	//
	//	$defaultConfiguration = [
	//		'IP'                => $IP,
	//		'wgScriptPath'      => 'notTestingwgScriptPath',
	//		'wgStylePath'      => 'notTestingwgStylePath',
	//		'wgStyleDirectory'  => 'notTestingwgStyleDirectory',
	//		'wgResourceModules' => [],
	//	];
	//
	//	$expected[ 'chameleonLocalPath' ] = $defaultConfiguration[ 'wgStyleDirectory' ] . '/chameleon';
	//	$expected[ 'chameleonRemotePath' ] = $defaultConfiguration[ 'wgStylePath' ] . '/chameleon';
	//
	//	$expected[ 'wgResourceModules' ] = [];
	//	$expected[ 'wgResourceModules' ][ 'skin.chameleon.jquery-sticky' ] = [
	//		'localBasePath'  => $expected[ 'chameleonLocalPath' ] . '/resources/js',
	//		'remoteBasePath' => $expected[ 'chameleonRemotePath' ] . '/resources/js',
	//		'group'          => 'skin.chameleon',
	//		'skinScripts'    => [
	//			'chameleon' => [ 'sticky-kit/jquery.sticky-kit.js', 'Components/Modifications/sticky.js' ]
	//		]
	//	];
	//
	//	$configurationToBeAdjusted = $configuration + $defaultConfiguration;
	//
	//	$request = $this->getMockBuilder('\WebRequest')
	//		->disableOriginalConstructor()
	//		->getMock();
	//
	//	$instance = new SetupAfterCache(
	//		$bootstrapManager,
	//		$configurationToBeAdjusted,
	//		$request
	//	);
	//
	//	$instance->process();
	//
	//	$this->assertEquals(
	//		$expected + $defaultConfiguration,
	//		$configurationToBeAdjusted
	//	);
	//}

	/**
	 * Provides test data for the lateSettings test
	 */
	public function lateSettingsProvider() {

		$provider = [];

		$provider[ ] = [
			[],
			[]
		];

		$provider[ ] = [
			[
				'wgVisualEditorSupportedSkins' => [],
			],
			[
				'wgVisualEditorSupportedSkins' => [],
			]
		];

		$provider[ ] = [
			[
				'egChameleonEnableVisualEditor' => true,
			],
			[
				'egChameleonEnableVisualEditor' => true,
			]
		];

		$provider[ ] = [
			[
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => [ 'foo' ],
			],
			[
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => [ 'foo', 'chameleon' ],
			]
		];

		$provider[ ] = [
			[
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => [ 'foo', 'chameleon' ],
			],
			[
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => [ 'foo', 'chameleon' ],
			]
		];

		$provider[ ] = [
			[
				'egChameleonEnableVisualEditor' => false,
				'wgVisualEditorSupportedSkins'  => [ 'chameleon', 'foo' => 'chameleon', 'foo' ],
			],
			[
				'egChameleonEnableVisualEditor' => false,
				'wgVisualEditorSupportedSkins'  => [ 1 => 'foo' ],
			]
		];

		return $provider;
	}

	/**
	 * Provides test data for the adjustConfiguration test
	 */
	public function adjustConfigurationProvider() {

		$provider = [];

		$provider[ ] = [
			[
				'key1' => 'value1',
				'key2' => 'value2',
			],
			[
				'key2' => 'value2changed',
				'key3' => 'value3changed',
			],
			[
				'key1' => 'value1',
				'key2' => 'value2changed',
				'key3' => 'value3changed',
			]
		];

		return $provider;
	}

}
