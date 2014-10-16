<?php
/**
 * File holding the FooterInfo class
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

use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\IdRegistry;

/**
 * The FooterInfo class.
 *
 * An list of footer items (last modified time, view count, number of watching users, credits, copyright)
 * Does not include so called places (about, privacy policy, and disclaimer links). They need to be added to the page elsewhere.
 *
 * This is an unstyled unordered list: <ul id="footer-info" >
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class FooterInfo extends Component {

	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null, $indent = 0 ) {
		parent::__construct( $template, $domElement , $indent );
		$this->addClasses( 'list-unstyled small' );
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- footer links -->' .
			$this->indent() .
			\Html::openElement( 'ul', array(
					'class' =>  'footer-info ' . $this->getClassString(),
					'id' => IdRegistry::getRegistry()->getId( 'footer-info' ),
				)
			);

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
