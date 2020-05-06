<?php
/**
 * File holding the Logo class
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
	 * @throws \MWException
	 */
	public function getHtml() {
		$logo = $this->indent( 1 ) . $this->getLogo();

		return $this->indent( -1 ) . '<!-- logo and main page link -->' .

			IdRegistry::getRegistry()->element( 'div',
				[ 'id' => 'p-logo', 'class' => $this->getClassString(), 'role' => 'banner', ],
				$logo,
				$this->indent()
			);
	}

	/**
	 * @return string
	 */
	protected function getLogo() {
		$logo = IdRegistry::getRegistry()->element( 'img',
			[
				'src' => $this->getSkinTemplate()->get( 'logopath', '' ),
				'alt' => $this->getSkinTemplate()->get( 'sitename', '' ),
			]
		);

		return $this->getLinkedLogo( $logo );
	}

	/**
	 * @param string $logo
	 *
	 * @return string
	 */
	protected function getLinkedLogo( $logo ) {
		if ( $this->shallLink() ) {

			$linkAttributes = array_merge(
				[ 'href' => $this->getLogoLink() ],
				Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
			);

			return IdRegistry::getRegistry()->element( 'a', $linkAttributes, $logo );
		}

		return $logo;
	}

	/**
	 * @return string
	 */
	private function getLogoLink(): string {
		$navUrls = $this->getSkinTemplate()->get( 'nav_urls', [ 'mainpage' => [ 'href' => '#' ] ] );
		$mainPage = $navUrls['mainpage'] ?? [ 'href' => '#' ];
		return $mainPage['href'];
	}

	/**
	 * Return true if addLink attribute is unset or set to 'yes' in the Logo
	 * component description. Clicking on the logo should redirect to Main Page
	 * in that case. Else the logo should just display an inactive image.
	 *
	 * @return bool
	 */
	private function shallLink() {
		$domElement = $this->getDomElement();

		if ( $domElement === null ) {
			return true;
		}

		$attribute = $domElement->getAttribute( 'addLink' );

		return $attribute === '' || filter_var( $attribute, FILTER_VALIDATE_BOOLEAN );
	}
}
