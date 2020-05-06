<?php
/**
 * File holding the FooterInfo class
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
 * @ingroup   Chameleon
 */

namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

/**
 * The FooterInfo class.
 *
 * A list of footer items (last modified time, view count, number of watching users, credits,
 * copyright)
 *
 * Does not include so called places (about, privacy policy, and disclaimer links). They need to
 * be added to the page elsewhere.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class FooterInfo extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		return $this->indent() . '<!-- footer links -->' .
			IdRegistry::getRegistry()->element(
				'div',
				[ 'id' => 'footer-info', 'class' => $this->getClassString() ],
				implode( $this->getFooterLines() ),
				$this->indent()
			);
	}

	/**
	 * @return string[]
	 * @throws \MWException
	 */
	private function getFooterLines() {
		$footerlinks = $this->getSkinTemplate()->getFooterLinks();

		$this->indent( 1 );

		$lines = [];
		foreach ( $footerlinks as $category => $msgKeys ) {

			if ( $category !== 'places' ) {

				$lines[] = $this->indent() . '<!-- ' . htmlspecialchars( $category ) . ' -->';
				foreach ( $msgKeys as $key ) {
					$lines[] = $this->indent() . '<div>' . $this->getSkinTemplate()->get( $key ) . '</div>';
				}
			}
		}

		$this->indent( -1 );
		return $lines;
	}
}
