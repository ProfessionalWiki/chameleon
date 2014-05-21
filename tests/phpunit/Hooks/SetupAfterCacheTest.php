<?php

namespace Skins\Chameleon\Tests\Hooks;

use Skins\Chameleon\Hooks\SetupAfterCache;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 *
 * @coversDefaultClass \Skins\Chameleon\Hooks\SetupAfterCache
 * @covers ::<private>
 * @group skins-chameleon
 * @group mediawiki-databaseless
 */
class SetupAfterCacheTest extends \PHPUnit_Framework_TestCase {

	protected $dummyExternalModule = null;

	protected function setUp() {
		parent::setUp();

		$this->dummyExternalModule = __DIR__ . '/../../Util/Fixture/' . 'externalmodule.less';
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
	 * @covers ::registerExternalStyleModules
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
				$this->equalTo( $this->dummyExternalModule  ),
				$this->equalTo( 'someRemoteWeDontCheck' ) );

		$bootstrapManager->expects( $this->never() )
			->method( 'setLessVariable' );

		$mixedExternalStyleModules = array(
			$this->dummyExternalModule ,
			$this->dummyExternalModule  => 'someRemoteWeDontCheck'
		);

		$configuration = array(
			'egChameleonExternalStyleModules' => $mixedExternalStyleModules,
			'wgStyleDirectory'                => 'notTestinwgStyleDirectory',
			'wgStylePath'                     => 'notTestingwgStylePath'
		);

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration
		);

		$instance->process();
	}

	/**
	 * @covers ::process
	 * @covers ::registerExternalStyleModules
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
			'wgStyleDirectory'                => 'notTestinwgStyleDirectory',
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
				$this->equalTo( '999px') );

		$externalLessVariables = array(
			'foo' => '999px'
		);

		$configuration = array(
			'egChameleonExternalLessVariables' => $externalLessVariables,
			'wgStyleDirectory'                => 'notTestinwgStyleDirectory',
			'wgStylePath'                     => 'notTestingwgStylePath'
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

		$defaultConfiguration = array(
			'wgStyleDirectory' => 'notTestingwgStyleDirectory',
			'wgStylePath' => 'notTestingwgStylePath'
		);

		$configurationToBeAdjusted = array();

		$instance = new SetupAfterCache(
			$bootstrapManager,
			$configuration + $defaultConfiguration
		);

		$instance
			->process()
			->adjustConfiguration( $configurationToBeAdjusted );

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

		$provider[] = array(
			array(),
			array()
		);

		$provider[] = array(
			array(
				'wgVisualEditorSupportedSkins' => array(),
			),
			array(
				'wgVisualEditorSupportedSkins' => array(),
			)
		);

		$provider[] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
			),
			array(
				'egChameleonEnableVisualEditor' => true,
			)
		);

		$provider[] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo'),
			),
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			)
		);

		$provider[] = array(
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			),
			array(
				'egChameleonEnableVisualEditor' => true,
				'wgVisualEditorSupportedSkins'  => array( 'foo', 'chameleon' ),
			)
		);

		$provider[] = array(
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

		$provider[] = array(
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
