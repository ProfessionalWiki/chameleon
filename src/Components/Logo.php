<?php
/**
 * File holding the Logo class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2016, Stephan Gambke
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

use Linker;
use Skins\Chameleon\IdRegistry;

/**
 * The Logo class.
 *
 * The logo image as a link to the wiki main page wrapped in a div: <div id="p-logo" role="banner">
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Logo extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$attribs = NULL;
		if ( $this->addLink() ) {
			$attribs = array_merge(
				array( 'href' => $this->getSkinTemplate()->data[ 'nav_urls' ][ 'mainpage' ][ 'href' ] ),
				Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
			);
		}

		$contents = \Html::element( 'img',
			array(
				'src' => $this->getSkinTemplate()->data[ 'logopath' ],
				'alt' => $this->getSkinTemplate()->data[ 'sitename' ],
			)
		);

		return
			$this->indent() . '<!-- logo and main page link -->' .
			$this->indent() . \Html::openElement( 'div',
				array(
					'id'    => IdRegistry::getRegistry()->getId( 'p-logo' ),
					'class' => 'p-logo ' . $this->getClassString(),
					'role'  => 'banner'
				)
			) .
			$this->indent( 1 ) . \Html::rawElement( 'a', $attribs, $contents ) .
			$this->indent( -1 ) . '</div>' . "\n";
	}

	/**
	 * Return true if addLink attribute is unset or set to 'yes' in the Logo
	 * component description. Clicking on the logo should redirect to Main Page
	 * in that case. Else the logo should just display an inactive image.
	 *
	 * @return bool
	 */
	private function addLink() {
		if ( $this->getDomElement() === null ) {
			return true;
		}

		$addLink = $this->getDomElement()->getAttribute( 'addLink' );

		if ( $addLink === '' ) {
			return true;
		}

		return filter_var( $addLink, FILTER_VALIDATE_BOOLEAN );
	}
}
