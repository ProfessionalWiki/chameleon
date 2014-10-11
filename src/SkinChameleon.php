<?php
/**
 * File holding the SkinChameleon class
 *
 * @copyright (C) 2014, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Skins
 */
use Skins\Chameleon\ComponentFactory;

/**
 * SkinTemplate class for the Chameleon skin
 *
 * @ingroup Skins
 */
class SkinChameleon extends SkinTemplate {

	public $skinname = 'chameleon';
	public $stylename = 'chameleon';
	public $template = '\Skins\Chameleon\ChameleonTemplate';
	public $useHeadElement = true;

	private $componentFactory;
	private $output;

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {

		// do not use non-standard MW less files anymore
//		parent::setupSkinUserCss( $out );

		$this->output = $out;

		// load Bootstrap styles
		$out->addModuleStyles( 'ext.bootstrap.styles' );
	}

	/**
	 * @param \OutputPage $out
	 */
	function initPage( OutputPage $out ) {

		parent::initPage( $out );

		// Enable responsive behaviour on mobile browsers
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );
	}

	/**
	 * @return ComponentFactory
	 */
	public function getComponentFactory() {

		if ( ! isset( $this->componentFactory ) ) {
			$this->componentFactory = new \Skins\Chameleon\ComponentFactory( $GLOBALS['egChameleonLayoutFile'] );
		}

		return $this->componentFactory;
	}

	public function addSkinModulesToOutput() {
		// load Bootstrap scripts
		$out = $this->output;
		$out->addModules( array( 'ext.bootstrap.scripts' ) );
		$out->addModules( $this->getComponentFactory()->getRootComponent()->getResourceLoaderModules() );

	}
}
