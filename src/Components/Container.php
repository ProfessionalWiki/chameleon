<?php
/**
 * File holding the Container class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Components;

/**
 * The Container class.
 *
 * It will wrap its content elements in a DIV.
 *
 * Supported attributes:
 * - class
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Container extends Structure {

	/**
	 * Builds the HTML code for the main container
	 *
	 * @return String the HTML code
	 */
	public function getHtml(){

		$ret = $this->indent() . \Html::openElement( 'div', array( 'class' => $this->getClassString() ) );
		$this->indent( 1 );

		$ret .= parent::getHtml();

		$ret .= $this->indent( -1 ) . '</div>';

		return $ret;
	}

}
