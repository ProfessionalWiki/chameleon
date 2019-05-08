<?php
/**
 * File holding the ChameleonTemplate class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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
 * @ingroup Skins
 */

namespace Skins\Chameleon;

use BaseTemplate;

/**
 * BaseTemplate class for the Chameleon skin
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class ChameleonTemplate extends BaseTemplate {

	/**
	 * Outputs the entire contents of the page
	 *
	 * @throws \MWException
	 */
	public function execute() {

		// output the head element
		// The headelement defines the <body> tag itself, it shouldn't be included in the html text
		// To add attributes or classes to the body tag override addToBodyAttributes() in SkinChameleon
		$this->html( 'headelement' );
		echo $this->getSkin()->getComponentFactory()->getRootComponent()->getHtml();
		$this->printTrail();
		echo "</body>\n</html>";

	}

	/**
	 * Overrides method in parent class that is unprotected against non-existent indexes in $this->data
	 *
	 * @param string $key
	 *
	 * @return string|void
	 */
	public function html( $key ) {
		echo $this->get( $key );
	}

	/**
	 * Get the Skin object related to this object
	 *
	 * @return \Skins\Chameleon\Chameleon
	 */
	public function getSkin() {
		return parent::getSkin();
	}

	/**
	 * @param \DOMElement $description
	 * @param int         $indent
	 * @param string      $htmlClassAttribute
	 *
	 * @deprecated since 1.6. Use getSkin()->getComponentFactory()->getComponent()
	 *
	 * @throws \MWException
	 * @return \Skins\Chameleon\Components\Container
	 */
	public function getComponent( \DOMElement $description, $indent = 0, $htmlClassAttribute = '' ) {
		return $this->getSkin()->getComponentFactory()->getComponent( $description, $indent, $htmlClassAttribute );
	}


	/**
	 * Makes a link with a unique id, usually used by makeListItem to generate a
	 * link for an item in a list used in navigation lists, portlets, portals,
	 * sidebars, etc...
	 *
	 * @param string $key Usually a key from the list you are generating this
	 * link from.
	 * @param array $item Contains some of a specific set of keys.
	 * @param array $options Can be used to affect the output of a link.
	 *
	 * @return string
	 */
	function makeLink( $key, $item, $options = [] ) {

		$item[ 'class' ] = isset( $item[ 'class' ] ) ? (array) $item[ 'class' ] : [];

		foreach ( [ 'id', 'single-id' ] as $attrib ) {

			if ( isset ( $item[ $attrib ] ) ) {
				$item[ 'class' ][] = $item[ $attrib ];
				$item[ $attrib ] = IdRegistry::getRegistry()->getId( $item[ $attrib ], $this );
			}

		}

		if ( isset( $options['link-class'] ) ) {
			$item['class'][] = $options['link-class'];
			unset( $options['link-class'] );
		}

		return parent::makeLink( $key, $item, $options );
	}


}
