<?php

namespace Skins\Chameleon\Tests\Hooks;

use Skins\Chameleon\Hooks\SetupAfterCache;

/**
 * @covers \Skins\Chameleon\Hooks\SetupAfterCache
 *
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @licence GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class SetupAfterCacheTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$bootstrapManager = $this->getMockBuilder( '\bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$configuration = array();

		$this->assertInstanceOf(
			'\Skins\Chameleon\Hooks\SetupAfterCache',
			new SetupAfterCache( $bootstrapManager, $configuration )
		);
	}

	public function testProcessWithValidExternalModuleWithoutLessVariables() {

		$bootstrapManager = $this->getMockBuilder( '\bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->at( 1 ) )
			->method( 'addExternalModule' );

		$bootstrapManager->expects( $this->at( 2 ) )
			->method( 'addExternalModule' )
			->with(
				$this->equalTo( __DIR__ . '/../Fixture/' . 'externalmodule.less' ),
				$this->equalTo( '' ) );

		$bootstrapManager->expects( $this->at( 3 ) )
			->method( 'addExternalModule' )
			->with(
				$this->equalTo( __DIR__ . '/../Fixture/' . 'externalmodule.less' ),
				$this->equalTo( 'someRemoteWeDontCheck' ) );

		$bootstrapManager->expects( $this->never() )
			->method( 'setLessVariable' );

		$mixedExternalStyleModules = array(
			__DIR__ . '/../Fixture/' . 'externalmodule.less',
			__DIR__ . '/../Fixture/' . 'externalmodule.less' => 'someRemoteWeDontCheck'
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

	public function testProcessWithInvalidExternalModuleThrowsException() {

		$this->setExpectedException( 'RuntimeException' );

		$bootstrapManager = $this->getMockBuilder( '\bootstrap\BootstrapManager' )
			->disableOriginalConstructor()
			->getMock();

		$bootstrapManager->expects( $this->atLeastOnce() )
			->method( 'addExternalModule' )
			->will( $this->returnValue( true ) );

		$externalStyleModules = array(
			__DIR__ . '/../Fixture/' . 'externalmoduleDoesNotExist.less'
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

		$instance->process();
	}

	public function testProcessWithLessVariables() {

		$bootstrapManager = $this->getMockBuilder( '\bootstrap\BootstrapManager' )
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

}
