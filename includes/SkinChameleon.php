<?php
/**
 * File holding the SkinChameleon class
 *
 * @copyright (C) 2014, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Chameleon.
 * The Chameleon extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon extension is distributed in the hope that it will be useful,
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


/**
 * SkinTemplate class for the Chameleon skin
 *
 * @ingroup Skins
 */
class SkinChameleon extends SkinTemplate {

	var $skinname = 'chameleon';
	var $stylename = 'chameleon';
	var $template = '\skins\chameleon\ChameleonTemplate';
	var $useHeadElement = true;

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {

		parent::setupSkinUserCss( $out );

		// load Bootstrap styles
		$out->addModuleStyles( 'ext.bootstrap' );
	}

	/**
	 * @param \OutputPage $out
	 */
	function initPage( OutputPage $out ) {

		parent::initPage( $out );

		// load Bootstrap scripts
		$out->addModules( array( 'ext.bootstrap' ) );

		// Enable responsive behaviour on mobile browsers
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );
	}
}
