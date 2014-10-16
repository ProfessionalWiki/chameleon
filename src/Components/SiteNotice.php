<?php
/**
 * File holding the SiteNotice class
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
 * The SiteNotice class.
 *
 * A simple div containing the site notice text: <div id="siteNotice" >
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class SiteNotice extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$data = $this->getSkinTemplate()->data;

		if ( array_key_exists( 'sitenotice', $data ) && $data[ 'sitenotice' ] ) {

			return $this->indent() . '<!-- sitenotice -->' .
				   $this->indent() . '<div id="siteNotice" class="siteNotice ' . $this->getClassString() . '" >' . $data[ 'sitenotice' ] . '</div>'
				   . "\n";
		} else {
			return "\n";
		}
	}

}
