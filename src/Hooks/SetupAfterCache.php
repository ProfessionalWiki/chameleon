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
	 *
	 * @return self
	 */
	public function process() {
		$this->addLateSettings();
		$this->registerCommonBootstrapModules();
		$this->registerExternalStyleModules();
		$this->registerExternalLessVariables();

		return $this;
	}

	/**
	 * @since 1.0
	 *
	 * @param array $configuration
	 */
	public function adjustConfiguration( array &$configuration ) {

		foreach ( $this->configuration as $key => $value ) {
			$configuration[ $key ] = $value;
		}
	}

	protected function addLateSettings() {

		// if Visual Editor is installed and there is a setting to enable or disable it
		if ( $this->hasConfiguration( 'wgVisualEditorSupportedSkins' ) && $this->hasConfiguration( 'egChameleonEnableVisualEditor' ) ) {

			// if VE should be enabled
			if ( $this->configuration[ 'egChameleonEnableVisualEditor' ] === true ) {

				// if Chameleon is not yet in the list of VE-enabled skins
				if ( !in_array( 'chameleon', $this->configuration[ 'wgVisualEditorSupportedSkins' ] ) ) {
					$this->configuration[ 'wgVisualEditorSupportedSkins' ][ ] = 'chameleon';
				}

			} else {
				// remove all entries of Chameleon from the list of VE-enabled skins
				$this->configuration[ 'wgVisualEditorSupportedSkins' ] = array_diff(
					$this->configuration[ 'wgVisualEditorSupportedSkins' ],
					array( 'chameleon' )
				);
			}
		}
	}

	protected function registerCommonBootstrapModules() {

		// Should we check for
		// $this->isReadableFile( $this->configuration['wgStyleDirectory'] . '/chameleon/styles/' . 'screen.less' )

		$this->bootstrapManager->addAllBootstrapModules();
		$this->bootstrapManager->addExternalModule(
			$this->configuration['wgStyleDirectory'] . '/chameleon/styles/' . 'screen.less',
			$this->configuration['wgStylePath'] . '/chameleon/styles/'
		);
	}

	protected function registerExternalStyleModules() {

		if ( $this->hasConfigurationOfTypeArray( 'egChameleonExternalStyleModules' )  ) {

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

		if ( $this->hasConfigurationOfTypeArray( 'egChameleonExternalLessVariables' )  ) {

			foreach ( $this->configuration['egChameleonExternalLessVariables'] as $key => $value ) {
				$this->bootstrapManager->setLessVariable( $key, $value );
			}
		}
	}

	private function hasConfiguration( $id ) {
		return isset( $this->configuration[ $id ] );
	}

	private function hasConfigurationOfTypeArray( $id ) {
		return $this->hasConfiguration( $id ) && is_array( $this->configuration[ $id ] );
	}

	private function matchAssociativeElement( $localFile , $remotePath ) {

		if ( is_integer( $localFile ) ) {
			return array( $remotePath, '' );
		}

		return array( $localFile, $remotePath );
	}

	private function isReadableFile( $file ) {

		if ( is_readable( $file ) ) {
			return $file;
		}

		throw new RuntimeException( "Expected an accessible {$file} file" );
	}

}
