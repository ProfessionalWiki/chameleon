<?php
/**
 * File holding the FooterInfo class
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
 * @ingroup   Chameleon
 */

namespace skins\chameleon\components;


/**
 * The FooterInfo class.
 *
 * An list of footer items (last modified time, view count, number of watching users, credits, copyright)
 * Does not include so called places (about, privacy policy, and disclaimer links). They need to be added to the page elsewhere.
 *
 * This is an unstyled unordered list: <ul id="footer-info" >
 *
 * @ingroup Chameleon
 */
class FooterInfo extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- footer links -->' .
			   $this->indent() . '<ul class="list-unstyled footer-info small ' . $this->getClass() . '" id="footer-info" >';

		$footerlinks = $this->getSkinTemplate()->getFooterLinks();
		$this->indent( 1 );
		foreach ( $footerlinks as $category => $links ) {

			if ( $category !== 'places' ) {

				$ret .= $this->indent() . '<!-- ' . htmlspecialchars( $category ) . ' -->';
				foreach ( $links as $key ) {
					$ret .= $this->indent() . '<li>' . $this->getSkinTemplate()->get( $key ) . '</li>';
				}

			}
		}

		$ret .= $this->indent( -1 ) . '</ul>' . "\n";

		return $ret;
	}
}
