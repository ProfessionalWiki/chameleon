<?php
/**
 * File containing the BeforeInitialize class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke, mwjames
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

namespace Skins\Chameleon\Hooks;

use Bootstrap\BootstrapManager;
use MediaWiki\MediaWikiServices;
use RuntimeException;
use Skins\Chameleon\Chameleon;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/SetupAfterCache
 *
 * @since 1.0
 *
 * @author mwjames
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class SetupAfterCache {

	protected $bootstrapManager = null;
	protected $configuration = [];
	protected $request;

	/**
	 * @since  1.0
	 *
	 * @param BootstrapManager $bootstrapManager
	 * @param array &$configuration
	 * @param \WebRequest $request
	 */
	public function __construct( BootstrapManager $bootstrapManager, array &$configuration,
		\WebRequest $request ) {
		$this->bootstrapManager = $bootstrapManager;
		$this->configuration = &$configuration;
		$this->request = $request;
	}

	/**
	 * @since  1.0
	 *
	 * @return self
	 */
	public function process() {
		$this->setInstallPaths();
		$this->addLateSettings();
		$this->registerCommonBootstrapModules();
		$this->registerExternalScssModules();
		$this->registerExternalStyleVariables();

		return $this;
	}

	/**
	 * @since 1.0
	 *
	 * @param array &$configuration
	 */
	public function adjustConfiguration( array &$configuration ) {
		foreach ( $this->configuration as $key => $value ) {
			$configuration[ $key ] = $value;
		}
	}

	/**
	 * Set local and remote base path of the Chameleon skin
	 */
	protected function setInstallPaths() {
		$this->configuration[ 'chameleonLocalPath' ] =
			$this->configuration['wgStyleDirectory'] . '/chameleon';
		$this->configuration[ 'chameleonRemotePath' ] =
			$this->configuration['wgStylePath'] . '/chameleon';
	}

	protected function addLateSettings() {
		$this->registerSkinWithMW();
		$this->addChameleonToVisualEditorSupportedSkins();
		$this->addResourceModules();
		$this->setLayoutFile();
	}

	protected function registerCommonBootstrapModules() {
		$this->bootstrapManager->addAllBootstrapModules();

		// FIXME: Make configurable, e.g. in LocalSettings.php
		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/styles/themes/_light.scss', 'beforeVariables'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/styles/_variables.scss', 'variables'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/fontawesome/scss/fontawesome.scss'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/fontawesome/scss/fa-solid.scss'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/fontawesome/scss/fa-regular.scss'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/fontawesome/scss/fa-brands.scss'
		);

		$this->bootstrapManager->addStyleFile(
			$this->configuration[ 'chameleonLocalPath' ] .
				'/resources/styles/chameleon.scss'
		);

		$this->bootstrapManager->setScssVariable( 'fa-font-path',
			$this->configuration[ 'chameleonRemotePath' ] . '/resources/fontawesome/webfonts' );
	}

	protected function registerExternalScssModules() {
		if ( $this->hasConfigurationOfTypeArray( 'egChameleonExternalStyleModules' ) ) {

			foreach ( $this->configuration[ 'egChameleonExternalStyleModules' ]
				as $localFile => $position ) {

				$config = $this->matchAssociativeElement( $localFile, $position );
				$config[ 0 ] = $this->isReadableFile( $config[ 0 ] );

				$this->bootstrapManager->addStyleFile( ...$config );
			}
		}
	}

	protected function registerExternalStyleVariables() {
		if ( $this->hasConfigurationOfTypeArray( 'egChameleonExternalStyleVariables' ) ) {

			foreach ( $this->configuration[ 'egChameleonExternalStyleVariables' ] as $key => $value ) {
				$this->bootstrapManager->setScssVariable( $key, $value );
			}
		}
	}

	/**
	 * @param string $id
	 * @return bool
	 */
	private function hasConfiguration( $id ) {
		return isset( $this->configuration[ $id ] );
	}

	/**
	 * @param string $id
	 * @return bool
	 */
	private function hasConfigurationOfTypeArray( $id ) {
		return $this->hasConfiguration( $id ) && is_array( $this->configuration[ $id ] );
	}

	/**
	 * @param mixed $localFile
	 * @param mixed $position
	 *
	 * @return array
	 */
	private function matchAssociativeElement( $localFile, $position ) {
		if ( is_int( $localFile ) ) {
			return [ $position ];
		}

		return [ $localFile, $position ];
	}

	/**
	 * @param string $file
	 * @return string
	 */
	private function isReadableFile( $file ) {
		if ( is_readable( $file ) ) {
			return $file;
		}

		throw new RuntimeException( "Expected an accessible {$file} file" );
	}

	protected function addChameleonToVisualEditorSupportedSkins() {
		// if Visual Editor is installed and there is a setting to enable or disable it
		if ( $this->hasConfiguration( 'wgVisualEditorSupportedSkins' ) &&
			$this->hasConfiguration( 'egChameleonEnableVisualEditor' ) ) {

			// if VE should be enabled
			if ( $this->configuration[ 'egChameleonEnableVisualEditor' ] === true ) {

				// if Chameleon is not yet in the list of VE-enabled skins
				if ( !in_array( 'chameleon', $this->configuration[ 'wgVisualEditorSupportedSkins' ] ) ) {
					$this->configuration[ 'wgVisualEditorSupportedSkins' ][] = 'chameleon';
				}

			} else {
				// remove all entries of Chameleon from the list of VE-enabled skins
				$this->configuration[ 'wgVisualEditorSupportedSkins' ] = array_diff(
					$this->configuration[ 'wgVisualEditorSupportedSkins' ],
					[ 'chameleon' ]
				);
			}
		}
	}

	protected function addResourceModules() {
		$this->configuration[ 'wgResourceModules' ][ 'skin.chameleon.sticky' ] = [
			'localBasePath'  => $this->configuration[ 'chameleonLocalPath' ] . '/resources/js',
			'remoteBasePath' => $this->configuration[ 'chameleonRemotePath' ] . '/resources/js',
			'group'          => 'skin.chameleon',
			'skinScripts'    =>
				[ 'chameleon' => [ 'hc-sticky/hc-sticky.js', 'Components/Modifications/sticky.js' ] ]
		];
	}

	protected function setLayoutFile() {
		$layout = $this->request->getVal( 'uselayout' );

		if ( $layout !== null &&
			$this->hasConfigurationOfTypeArray( 'egChameleonAvailableLayoutFiles' ) &&
			array_key_exists( $layout, $this->configuration[ 'egChameleonAvailableLayoutFiles' ] ) ) {

			$this->configuration[ 'egChameleonLayoutFile' ] =
				$this->configuration[ 'egChameleonAvailableLayoutFiles' ][ $layout ];
		}
	}

	protected function registerSkinWithMW() {
		MediaWikiServices::getInstance()->getSkinFactory()->register( 'chameleon', 'Chameleon',
			function () {
				$styles = [
					'mediawiki.ui.button',
					'skins.chameleon',
					'zzz.ext.bootstrap.styles',
				];

				if ( $this->configuration[ 'egChameleonEnableExternalLinkIcons' ] === true ) {
					array_unshift( $styles, 'mediawiki.skinning.content.externallinks' );
				}

				return new Chameleon( [
					'name' => 'chameleon',
					'styles' => $styles
				] );
			} );
	}

}
