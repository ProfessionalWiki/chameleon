<?php
/**
 * File holding the FooterIcons class
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
 * The FooterIcons class.
 *
 * A inline list containing the footer icons.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class FooterIcons extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		return $this->indent() . '<!-- footer icons -->' .
			IdRegistry::getRegistry()->element(
				'div',
				[ 'id' => 'footer-icons', 'class' => $this->getClassString() ],
				implode( $this->getIcons() ),
				$this->indent()
			);
	}

	/**
	 * @return string[]
	 * @throws \MWException
	 */
	private function getIcons() {
		$this->indent( 1 );

		$lines = [];
		$blocks = $this->getSkinTemplate()->getFooterIconsWithImage() ?? [];

		foreach ( $blocks as $blockName => $footerIcons ) {

			$lines[] = $this->indent() . '<!-- ' . htmlspecialchars( $blockName ) . ' -->';

			foreach ( $footerIcons as $icon ) {
				$lines[] = $this->indent() . '<div>' .
					$this->getSkinTemplate()->getSkin()->makeFooterIcon( $icon ) . '</div>';
			}

		}

		$this->indent( -1 );
		return $lines;
	}
}
