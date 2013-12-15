<?php
/**
 * File holding the Container class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup   Skins
 */


namespace skins\chameleon\components;


/**
 * The Container class.
 *
 * @ingroup Skins
 */
class Container extends Structure {

	/**
	 * Builds the HTML code for the main container
	 *
	 * @return String the HTML code
	 */
	public function getHtml(){

		$ret = $this->indent() . '<div class="' . $this->getClass() . '" >';

		$ret .= parent::getHtml();

		$ret .= $this->indent( -1 ) . '</div>';

		return $ret;
	}

}
