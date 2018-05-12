<?php
/**
 * File holding the SkinChameleon class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

use MediaWiki\MediaWikiServices;
use OutputPage;
use Sanitizer;
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

	public static function init() {

		MediaWikiServices::getInstance()->getSkinFactory()->register( 'chameleon', 'Chameleon', function(){return new Chameleon;});

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

			$setupAfterCache = new \Skins\Chameleon\Hooks\SetupAfterCache(
				\Bootstrap\BootstrapManager::getInstance(),
				$GLOBALS,
				$GLOBALS['wgRequest']
			);

			$setupAfterCache->process();
		};

		// set default skin layout
		if ( $GLOBALS[ 'egChameleonLayoutFile' ][0] !== '/' ) {
			$GLOBALS[ 'egChameleonLayoutFile' ] = dirname( __DIR__ ) . '/' . $GLOBALS[ 'egChameleonLayoutFile' ];
		}

	}

	/**
	 * @param $out OutputPage object
	 */
	public function setupSkinUserCss( OutputPage $out ) {

		// load Bootstrap styles
		$out->addModuleStyles(
			array(
				'ext.bootstrap.styles'
			)
		);
	}

	/**
	 * @param \OutputPage $out
	 */
	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		// Enable responsive behaviour on mobile browsers
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no' );
	}

	/**
	 * @return \QuickTemplate
	 */
	protected function setupTemplateForOutput() {

		$tpl = parent::setupTemplateForOutput();

		$this->getComponentFactory()->setSkinTemplate( $tpl );

		$tpl->set( 'skin', $this );
		$this->addSkinModulesToOutput();

		return $tpl;
	}

	/**
	 * @return ComponentFactory
	 */
	public function getComponentFactory() {

		if ( ! isset( $this->componentFactory ) ) {
			$this->componentFactory = new \Skins\Chameleon\ComponentFactory(
				$this->getLayoutFilePath()
			);
		}

		return $this->componentFactory;
	}

	public function addSkinModulesToOutput() {
		// load Bootstrap scripts
		$out = $this->getOutput();
		$out->addModules( array( 'ext.bootstrap.scripts' ) );
		$out->addModules( $this->getComponentFactory()->getRootComponent()->getResourceLoaderModules() );

	}

	/**
	 * @param \Title $title
	 * @return string
	 */
	public function getPageClasses( $title ) {
		$layoutFilePath = $this->getLayoutFilePath();
		$layoutName = Sanitizer::escapeClass( 'layout-' . basename( $layoutFilePath, '.xml' ) );
		return implode( ' ', array( parent::getPageClasses( $title ), $layoutName ) );
	}

	/**
	 * Template method that can be overridden by subclasses
	 * @return string Path to layout file
	 */
	protected function getLayoutFilePath() {
		return $GLOBALS['egChameleonLayoutFile'];
	}
}
