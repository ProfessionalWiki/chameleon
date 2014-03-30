<?php
/**
 * File containing the Component class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup   Skins
 */

namespace skins\chameleon\components;

use skins\chameleon\ChameleonTemplate;

/**
 * Component class
 *
 * @ingroup Skins
 */
abstract class Component {

	private $mSkinTemplate;
	private $mIndent = 0;
	private $mClasses = array();
	private $mDomElement = null;

	/**
	 * @param ChameleonTemplate $template
	 * @param \DOMElement|null  $domElement
	 * @param int               $indent
	 */
	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null, $indent = 0 ) {

		$this->mSkinTemplate = $template;
		$this->mIndent       = $indent;
		$this->mDomElement   = $domElement;

		if ( $domElement !== null ) {
			$this->setClasses( $domElement->getAttribute( 'class' ) );
		}
	}

	/**
	 * @return ChameleonTemplate
	 */
	public function getSkinTemplate() {

		return $this->mSkinTemplate;
	}

	/**
	 * Returns the current indentation level
	 *
	 * @return int
	 */
	public function getIndent() {

		return $this->mIndent;
	}

	/**
	 * Returns the class string that should be assigned to the top-level html element of this component
	 *
	 * @return string
	 */
	public function getClassString() {

		return implode( ' ', $this->mClasses );
	}

	/**
	 * Sets the class string that should be assigned to the top-level html element of this component
	 *
	 * @param $classes
	 *
	 */
	public function setClasses( $classes ) {

		$this->mClasses = array();
		$this->addClasses( $classes );

	}

	/**
	 * Removes the given class from the class string that should be assigned to the top-level html element of this component
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public function removeClasses( $classes ) {

		if ( empty( $classes ) ) {
			return;
		}

		if ( is_string( $classes ) ) {
			$classesArray = explode( ' ', $classes );
		} else {
			$classesArray = $classes;
		}


		$this->mClasses = array_diff( $this->mClasses, $classesArray );
	}

	/**
	 * Adds the given class to the class string that should be assigned to the top-level html element of this component
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public function addClasses( $classes ) {

		if ( empty( $classes ) ) {
			return;
		}

		if ( is_string( $classes ) ) {
			$classesArray = explode( ' ', $classes );
		} else {
			$classesArray = $classes;
		}

		$classesArray = array_combine( $classesArray, $classesArray );

		$this->mClasses = array_merge( $this->mClasses, $classesArray );
	}

	/**
	 * Returns the DOMElement from the description XML file associated with this element.
	 *
	 * @return \DOMElement
	 */
	public function getDomElement() {
		return $this->mDomElement;
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	abstract public function getHtml();

	/**
	 * Adds $indent to (or subtracts from if negative) the current indentation level.
	 * Inserts a new line and a number of tabs according to the new indentation level.
	 *
	 * @param int $indent
	 *
	 * @return string
	 */
	protected function indent( $indent = 0 ) {

		$this->mIndent += $indent;

		return "\n" . str_repeat( "\t", $this->mIndent );
	}

	/**
	 * Calls the handler for each child element of this components DOM element.
	 *
	 * Signature of the handler: function handler( DOMElement $element )
	 *
	 * @param $handler
	 */
	protected function eachChild( $handler ) {

		if ( is_callable( $handler ) ) {

			$children = $this->getDomElement()->childNodes;

			foreach ( $children as $child ) {

				if ( is_a( $child, 'DOMElement' ) ) {
					call_user_func( $handler, $child );
				}

			}

		}

	}
}
