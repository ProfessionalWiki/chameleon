<?php
/**
 * File holding the SkinChameleon class
 *
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

namespace Skins\Chameleon;

use Bootstrap\BootstrapManager;
use ExtensionRegistryHelper\ExtensionRegistryHelper;
use OutputPage;
use QuickTemplate;
use ResourceLoader;
use Sanitizer;
use Skins\Chameleon\Hooks\SetupAfterCache;
use SkinTemplate;

/**
 * SkinTemplate class for the Chameleon skin
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Chameleon extends SkinTemplate {

	public $skinname = 'chameleon';
	public $stylename = 'chameleon';
	public $template = '\Skins\Chameleon\ChameleonTemplate';
	public $useHeadElement = true;

	private $componentFactory;

	// FIXME: Remove when MW 1.31 compatibility is dropped
	private $stylesHaveBeenProcessed = false;

	/**
	 * @throws \Exception
	 */
	public static function init() {

		ExtensionRegistryHelper::singleton()->loadExtensionRecursive( 'Bootstrap' );

		/**
		 * Using callbacks for hook registration
		 *
		 * The hook registry should contain as less knowledge about a process as
		 * necessary therefore a callback is used as Factory/Builder that instantiates
		 * a business / domain object.
		 *
		 * GLOBAL state should be encapsulated by the callback and not leaked into
		 * a instantiated class
		 */

		/**
		 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeInitialize
		 */
		$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][ ] = function() {

			$setupAfterCache = new SetupAfterCache(
				BootstrapManager::getInstance(),
				$GLOBALS,
				$GLOBALS['wgRequest']
			);

			$setupAfterCache->process();
		};

		// FIXME: Put this in a proper class, so it can be tested
		$GLOBALS[ 'wgHooks' ][ 'ResourceLoaderRegisterModules' ][ ] = function( ResourceLoader $rl ) {

			$rl->register( 'zzz.ext.bootstrap.styles', $GLOBALS['wgResourceModules']['ext.bootstrap.styles'] );

		};

		// set default skin layout
		if ( $GLOBALS[ 'egChameleonLayoutFile' ][0] !== '/' ) {
			$GLOBALS[ 'egChameleonLayoutFile' ] = $GLOBALS[ 'wgStyleDirectory' ] . '/chameleon/' . $GLOBALS[ 'egChameleonLayoutFile' ];
		}

	}

	/**
	 * @return array Array of modules
	 */
	public function getDefaultModules() {
		$modules = parent::getDefaultModules();

		if ( array_key_exists( 'styles', $modules ) ) {

			// FIXME: Remove when MW 1.31 is dropped
			$this->stylesHaveBeenProcessed = true;

			$modulePos = array_search( 'mediawiki.legacy.shared', $modules[ 'styles' ][ 'core' ] );

			if ( $modulePos !== false ) {
				unset( $modules[ 'styles' ][ 'core' ][ $modulePos ] ); // we have our own version of these styles
			}

			$modules[ 'styles' ][ 'content' ][] = 'mediawiki.skinning.content';
			$modules[ 'styles' ][ 'content' ][] = 'zzz.ext.bootstrap.styles';

		}

		return $modules;
	}

	/**
	 * Hook point for adding style modules to OutputPage.
	 *
	 *
	 * @deprecated since 1.32 Kept here for compat with 1.31
	 *
	 * @fixme Remove this method completely when MW 1.31 compatibility is dropped.
	 *
	 * @param OutputPage $out Legacy parameter, identical to $this->getOutput()
	 */
	public function setupSkinUserCss( OutputPage $out ) {

		if ( $this->stylesHaveBeenProcessed === false ) {

			$moduleStyles = [
				'mediawiki.skinning.content',
				'mediawiki.legacy.commonPrint',
				'zzz.ext.bootstrap.styles'
			];

			if ( $out->isSyndicated() ) {
				$moduleStyles[] = 'mediawiki.feedlink';
			}

			// Deprecated since 1.26: Unconditional loading of mediawiki.ui.button
			// on every page is deprecated. Express a dependency instead.
			if ( strpos( $out->getHTML(), 'mw-ui-button' ) !== false ) {
				$moduleStyles[] = 'mediawiki.ui.button';
			}

			$out->addModuleStyles( $moduleStyles );
		}
	}

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		// Enable responsive behaviour on mobile browsers
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no' );
	}

	/**
	 * @return QuickTemplate
	 * @throws \MWException
	 */
	protected function setupTemplateForOutput() {

		$template = parent::setupTemplateForOutput();

		$this->getComponentFactory()->setSkinTemplate( $template );

		$template->set( 'skin', $this );
		$this->addSkinModulesToOutput();

		return $template;
	}

	/**
	 * @return ComponentFactory
	 */
	public function getComponentFactory() {

		if ( ! isset( $this->componentFactory ) ) {
			$this->componentFactory = new ComponentFactory(
				$this->getLayoutFilePath()
			);
		}

		return $this->componentFactory;
	}

	/**
	 * @throws \MWException
	 */
	public function addSkinModulesToOutput() {
		// load Bootstrap scripts
		$output = $this->getOutput();
		$output->addModules( [ 'ext.bootstrap.scripts' ] );
		$output->addModules( $this->getComponentFactory()->getRootComponent()->getResourceLoaderModules() );

	}

	/**
	 * @param \Title $title
	 * @return string
	 */
	public function getPageClasses( $title ) {
		$layoutFilePath = $this->getLayoutFilePath();
		$layoutName = Sanitizer::escapeClass( 'layout-' . basename( $layoutFilePath, '.xml' ) );
		return implode( ' ', [ parent::getPageClasses( $title ), $layoutName ] );
	}

	/**
	 * Template method that can be overridden by subclasses
	 * @return string Path to layout file
	 */
	protected function getLayoutFilePath() {
		return $GLOBALS[ 'egChameleonLayoutFile' ];
	}
}
