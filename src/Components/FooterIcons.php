<?php
/**
 * File holding the FooterIcons class
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
 * @ingroup   Chameleon
 */

namespace Skins\Chameleon\Components;

/**
 * The FooterIcons class.
 *
 * A inline list containing icons: <ul id="footer-icons" >
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
	 */
	public function getHtml() {

		$ret   = '';
		$icons = $this->getSkinTemplate()->getFooterIcons( 'icononly' );

		if ( $icons !== null && count( $icons ) > 0 ) {

			$ret = $this->indent() . '<!-- footer icons -->' .
				   $this->indent() . '<ul class="list-inline pull-right footer-icons ' . $this->getClassString() . '" id="footer-icons" >';

			$this->indent( 1 );
			foreach ( $icons as $blockName => $footerIcons ) {

				$ret .= $this->indent() . '<!-- ' . htmlspecialchars( $blockName ) . ' -->';

				foreach ( $footerIcons as $icon ) {
					$ret .= $this->indent() . '<li>' .
							$this->getSkinTemplate()->getSkin()->makeFooterIcon( $icon ) . '</li>';
				}

			}

			$ret .= $this->indent( -1 ) . '</ul>' . "\n";
		}

		return $ret;

	}
}
