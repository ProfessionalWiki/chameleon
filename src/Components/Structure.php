<?php
/**
 * File holding the Structure class
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
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Components;
use DOMElement;

/**
 * The Structure class represents top level element of the layout.
 *
 * It will simply take the HTML of its subcomponents and concatenate it.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Structure extends Component {

	private $subcomponents;

	/**
	 * Builds the HTML code for the component
	 *
	 * @return string the HTML code
	 * @throws \MWException
	 */
	public function getHtml(){
		$ret = '';

		foreach ( $this->getSubcomponents() as $component ) {
			$ret .= $component->getHtml();
		}

		return $ret;
	}

	/**
	 * @return string[] the resource loader modules needed by this component
	 * @throws \MWException
	 */
	public function getResourceLoaderModules() {
		$modules = [];

		foreach ( $this->getSubcomponents() as $component ) {
			$modules = array_merge( $modules, $component->getResourceLoaderModules() );
		}

		return $modules;
	}

	/**
	 * @return Component[]
	 * @throws \MWException
	 */
	protected function getSubcomponents() {

		if ( !isset ( $this->subcomponents ) ) {

			$this->subcomponents = [];

			$domElement = $this->getDomElement();

			if ( $domElement !== null && $domElement instanceof DOMElement ) {

				$children = $this->getDomElement()->childNodes;

				foreach ( $children as $child ) {
					if ( $child instanceof DOMElement ) {
						$this->subcomponents[] = $this->getSkin()->getComponentFactory()->getComponent( $child, $this->getIndent() + 1 );
					}
				}

			}
		}

		return $this->subcomponents;
	}

}
