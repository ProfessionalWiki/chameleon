<?php
/**
 * File holding the Html class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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

namespace Skins\Chameleon\Components;

/**
 * The Html class.
 *
 * This component allows insertion of raw HTML into the page.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Html extends Component {

	/**
	 * Builds the HTML code for the main container
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		$ret = '';

		if ( $this->getDomElement() !== null ) {

			$dom = $this->getDomElement()->ownerDocument;

			foreach ( $this->getDomElement()->childNodes as $node ) {
				$ret .= $dom->saveHTML( $node );
			}
		}

		return $ret;
	}

}
