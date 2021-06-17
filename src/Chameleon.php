<?php
/**
 * File holding the SkinChameleon class
 *
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

namespace Skins\Chameleon;

use Bootstrap\BootstrapManager;
use OutputPage;
use QuickTemplate;
use ResourceLoader;
use Sanitizer;
use Skin;
use Skins\Chameleon\Hooks\SetupAfterCache;
use SkinTemplate;
use Hooks;

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

	private $componentFactory;

	/**
	 * @throws \Exception
	 */
	public static function init() {
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
		$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][ ] = function () {
			$setupAfterCache = new SetupAfterCache(
				BootstrapManager::getInstance(),
				$GLOBALS,
				$GLOBALS['wgRequest']
			);

			$setupAfterCache->process();
		};

		// FIXME: Put this in a proper class, so it can be tested
		$GLOBALS[ 'wgHooks' ][ 'ResourceLoaderRegisterModules' ][ ] = function ( ResourceLoader $rl ) {
			$rl->register( 'zzz.ext.bootstrap.styles',
				$GLOBALS['wgResourceModules']['ext.bootstrap.styles'] );
		};

		// set default skin layout
		if ( DIRECTORY_SEPARATOR === '/' && $GLOBALS[ 'egChameleonLayoutFile' ][0] !== '/' ) {
			$GLOBALS[ 'egChameleonLayoutFile' ] = $GLOBALS[ 'wgStyleDirectory' ] . '/chameleon/' .
				$GLOBALS[ 'egChameleonLayoutFile' ];
		}
	}

	/**
	 * @return array Array of modules
	 */
	public function getDefaultModules() {
		global $wgVersion;

		$modules = parent::getDefaultModules();

		if ( version_compare( $wgVersion, '1.32', '>=' ) && version_compare( $wgVersion, '1.35', '<' ) ) {
			// Not necessary in 1.35 (see #110)
			$modulePos = array_search( 'mediawiki.legacy.shared', $modules[ 'styles' ][ 'core' ] );

			if ( $modulePos !== false ) {
				// we have our own version of these styles
				unset( $modules[ 'styles' ][ 'core' ][ $modulePos ] );
			}

			// These are added in SetupAfterCache::registerSkinWithMW in >= 1.35
			$modules[ 'styles' ][ 'content' ][] = 'mediawiki.skinning.content';
			$modules[ 'styles' ][ 'content' ][] = 'mediawiki.ui.button';
			$modules[ 'styles' ][ 'content' ][] = 'zzz.ext.bootstrap.styles';
			$modules[ 'styles' ][ 'content' ][] = 'mediawiki.legacy.commonPrint';

			$out = $this->getOutput();
			if ( $out->isSyndicated() ) {
				$modules[ 'styles' ][ 'content' ][] = 'mediawiki.feedlink';
			}
		}

		return $modules;
	}

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		global $wgVersion;

		// Add styles for MediaWiki 1.31
		if ( version_compare( $wgVersion, '1.32', '<' ) ) {
			$moduleStyles = [
				'mediawiki.skinning.content',
				'mediawiki.legacy.commonPrint',
				'mediawiki.ui.button',
				'zzz.ext.bootstrap.styles'
			];

			if ( $out->isSyndicated() ) {
				$moduleStyles[] = 'mediawiki.feedlink';
			}

			if ( $GLOBALS[ 'egChameleonEnableExternalLinkIcons' ] === true ) {
				$moduleStyles[] = 'mediawiki.skinning.content.externallinks';
			}

			$out->addModuleStyles( $moduleStyles );
		}

		// Enable responsive behaviour on mobile browsers
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no' );
	}

	/**
	 * @inheritDoc
	 */
	protected function prepareQuickTemplate() {
		$tpl = parent::prepareQuickTemplate();
		Hooks::run( 'ChameleonSkinTemplateOutputPageBeforeExec', [ $this, $tpl ] );
		return $tpl;
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
		if ( !isset( $this->componentFactory ) ) {
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
		$output->addModules(
			$this->getComponentFactory()->getRootComponent()->getResourceLoaderModules() );
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

	/**
	 * Template method that can be overridden by subclasses
	 * @return string Path to theme file
	 */
	protected function getThemeFilePath() {
		return $GLOBALS[ 'egChameleonThemeFile' ];
	}
}
