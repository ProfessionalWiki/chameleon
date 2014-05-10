<?php

namespace Skins\Chameleon\Hooks;

use Bootstrap\BootstrapManager;
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
		$this->doLateSettings();
		$this->registerCommonBootstrapModules();
		$this->registerExternalStyleModules();
		$this->registerExternalLessVariables();
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	public function getConfiguration() {
		return $this->configuration;
	}

	/**
	 * @since 1.0
	 * @param array $configuration
	 */
	public function adjustConfiguration( array &$configuration ) {

		foreach ( $this->configuration as $key => $value ) {
			$configuration[ $key ] = $value;
		}

	}

	protected function doLateSettings()
	{

		// if Visual Editor is installed and there is a setting to enable or disable it
		if ( isset( $this->configuration[ 'wgVisualEditorSupportedSkins' ] ) && isset ( $this->configuration[ 'egChameleonEnableVisualEditor' ] ) ) {

			// if VE should be enabled
			if ( $this->configuration[ 'egChameleonEnableVisualEditor' ] === true ) {

				// if Chameleon is not yet in the list of VE-enabled skins
				if ( !in_array( 'chameleon', $this->configuration[ 'wgVisualEditorSupportedSkins' ] ) ) {
					$this->configuration[ 'wgVisualEditorSupportedSkins' ][ ] = 'chameleon';
				}

			} else {
				// remove all entries of Chameleon from the list of VE-enabled skins
				$this->configuration[ 'wgVisualEditorSupportedSkins' ] = array_diff($this->configuration[ 'wgVisualEditorSupportedSkins' ], array('chameleon'));
			}

		}
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

	protected function isReadableFile( $file ) {

		if ( is_readable( $file ) ) {
			return $file;
		}

		throw new RuntimeException( "Expected an accessible {$file} file" );
	}

}
