<?php

namespace Skins\Chameleon\Hooks;

use bootstrap\BootstrapManager;
use RuntimeException;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/SetupAfterCache
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 * @author Stephan Gambke
 */
class SetupAfterCache {

	protected $bootstrapManager = null;
	protected $configuration = array();

	/**
	 * @since  1.0
	 *
	 * @param BootstrapManager $bootstrapManager
	 * @param array $configuration
	 */
	public function __construct( BootstrapManager $bootstrapManager, array $configuration ) {
		$this->bootstrapManager = $bootstrapManager;
		$this->configuration = $configuration;
	}

	/**
	 * @since  1.0
	 */
	public function process() {
		$this->registerCommonBootstrapModules();
		$this->registerExternalStyleModules();
		$this->registerExternalLessVariables();
	}

	protected function registerCommonBootstrapModules() {
		$this->bootstrapManager->addAllBootstrapModules();
		$this->bootstrapManager->addExternalModule(
			$this->configuration['wgStyleDirectory'] . '/chameleon/styles/' . 'screen.less',
			$this->configuration['wgStylePath'] . '/chameleon/styles/'
		);
	}

	protected function registerExternalStyleModules() {

		if ( $this->hasConfiguration( 'egChameleonExternalStyleModules' )  ) {

			foreach ( $this->configuration['egChameleonExternalStyleModules'] as $localFile => $remotePath ) {

				list( $localFile, $remotePath ) = $this->matchAssociativeElement( $localFile, $remotePath );

				$this->bootstrapManager->addExternalModule(
					$this->isReadableFile( $localFile ),
					$remotePath
				);
			}
		}
	}

	protected function registerExternalLessVariables() {

		if ( $this->hasConfiguration( 'egChameleonExternalLessVariables' )  ) {

			foreach ( $this->configuration['egChameleonExternalLessVariables'] as $key => $value ) {
				$this->bootstrapManager->setLessVariable( $key, $value );
			}
		}
	}

	protected function hasConfiguration( $id ) {
		return isset( $this->configuration[ $id ] ) && is_array( $this->configuration[ $id ] );
	}

	protected function matchAssociativeElement( $localFile , $remotePath ) {

		if ( is_integer( $localFile ) ) {
			return array( $remotePath, '' );
		}

		return array( $localFile, $remotePath );
	}

	protected function isReadableFile( $path ) {

		if ( is_readable( $path ) ) {
			return $path;
		}

		throw new RuntimeException( "Expected an accessible {$path} file" );
	}

}
