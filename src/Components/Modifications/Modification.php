<?php

namespace Skins\Chameleon\Components\Modifications;

use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\Components\Component;

/**
 * File containing the Modification class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Skins
 */

/**
 * Modification class
 *
 * This is the abstract base class of all modifications.
 *
 * Follows the Decorator pattern (Decorator role).
 *
 * @ingroup Skins
 */
abstract class Modification extends Component {

	private $component = null;
	private $domElement = null;

	/**
	 * @param Component   $component
	 * @param \DOMElement $domElement
	 */
	public function __construct( Component $component, \DOMElement $domElement = null ) {
		$this->component = $component;
		$this->domElement   = $domElement;
	}

	abstract protected function applyModification();

	/**
	 * @return \DOMElement|null
	 */
	public function getDomElementOfModification() {
		return $this->domElement;
	}

	/**
	 * @return \DOMElement
	 */
	public function getDomElementOfComponent() {
		return $this->getDomElement();
	}

	/**
	 * Sets the class string that should be assigned to the top-level html element of this component
	 *
	 * @param string | array | null $classes
	 *
	 */
	public function setClasses( $classes ) {
		$this->getComponent()->setClasses( $classes );
	}

	/**
	 * @return Component
	 */
	public function getComponent() {
		return $this->component;
	}

	/**
	 * Adds the given class to the class string that should be assigned to the top-level html element of this component
	 *
	 * @param string | array | null $classes
	 *
	 * @return string | array
	 */
	public function addClasses( $classes ) {
		$this->getComponent()->addClasses( $classes );
	}

	/**
	 * @return ChameleonTemplate
	 */
	public function getSkinTemplate() {
		return $this->getComponent()->getSkinTemplate();
	}

	/**
	 * Returns the current indentation level
	 *
	 * @return int
	 */
	public function getIndent() {
		return $this->getComponent()->getIndent();
	}

	/**
	 * Returns the class string that should be assigned to the top-level html element of this component
	 *
	 * @return string
	 */
	public function getClassString() {
		return $this->getComponent()->getClassString();
	}

	/**
	 * Removes the given class from the class string that should be assigned to the top-level html element of this component
	 *
	 * @param string | array | null $classes
	 *
	 * @return string
	 */
	public function removeClasses( $classes ) {
		$this->getComponent()->removeClasses( $classes );
	}

	/**
	 * Returns the DOMElement from the description XML file associated with this element.
	 *
	 * @return \DOMElement
	 */
	public function getDomElement() {
		return $this->getComponent()->getDomElement();
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		$this->applyModification();
		return $this->getComponent()->getHtml();
	}

	/**
	 * @return array the resource loader modules needed by this component
	 */
	public function getResourceLoaderModules() {
		return $this->getComponent()->getResourceLoaderModules();
	}
}
