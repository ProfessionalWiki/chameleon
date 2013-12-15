<?php
/**
 * File holding the Logo class
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

use Linker;

/**
 * The Logo class.
 *
 * The logo image as a link to the wiki main page wrapped in a div: <div id="p-logo" role="banner">
 *
 * @ingroup Skins
 */
class Logo extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$attribs  = array( 'href' => $this->getSkinTemplate()->data[ 'nav_urls' ][ 'mainpage' ][ 'href' ] ) + Linker::tooltipAndAccesskeyAttribs( 'p-logo' );
		$contents = \Html::element( 'img', array( 'src' => $this->getSkinTemplate()->data[ 'logopath' ], 'alt' => $GLOBALS[ 'wgSitename' ] ) );

		return $this->indent() . '<!-- logo and main page link -->' .
			   $this->indent() . '<div id="p-logo" class="p-logo ' . $this->getClass() . '" role="banner">' .
			   $this->indent( 1 ) . \Html::rawElement( 'a', $attribs, $contents ) .
			   $this->indent( -1 ) . '</div>' . "\n";
	}

}
