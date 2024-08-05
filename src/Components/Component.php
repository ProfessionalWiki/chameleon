<?php
/**
 * File containing the Component class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

use Skins\Chameleon\ChameleonTemplate;

/**
 * Component class
 *
 * This is the base class of all components.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
abstract class Component {

	private $mSkinTemplate;
	private $mIndent = 0;

	/** @var $array */
	private $mClasses = [];

	private $mDomElement = null;

	/**
	 * @param ChameleonTemplate $template
	 * @param \DOMElement|null $domElement
	 * @param int $indent
	 *
	 * @throws \MWException
	 */
	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null,
		$indent = 0 ) {
		$this->mSkinTemplate = $template;
		$this->mIndent       = (int)$indent;
		$this->mDomElement   = $domElement;

		if ( $domElement !== null ) {
			$this->addClasses( $domElement->getAttribute( 'class' ) );
		}
	}

	/**
	 * Sets the class string that should be assigned to the top-level html element of this component
	 *
	 * @param string | array | null $classes
	 *
	 * @throws \MWException
	 */
	public function setClasses( $classes ) {
		$this->mClasses = [];
		$this->addClasses( $classes );
	}

	/**
	 * Adds the given class to the class string that should be assigned to the top-level html
	 * element of this component
	 *
	 * @param string | array | null $classes
	 *
	 * @throws \MWException
	 */
	public function addClasses( $classes ) {
		$classesArray = $this->transformClassesToArray( $classes );

		if ( !empty( $classesArray ) ) {
			$classesArray   = array_combine( $classesArray, $classesArray );
			$this->mClasses = array_merge( $this->mClasses, $classesArray );
		}
	}

	/**
	 * @param string | array | null $classes
	 *
	 * @return array
	 * @throws \MWException
	 */
	protected function transformClassesToArray( $classes ) {
		if ( empty( $classes ) ) {
			return [];
		} elseif ( is_array( $classes ) ) {
			return $classes;
		} elseif ( is_string( $classes ) ) {
			return explode( ' ', $classes );
		} else {
			throw new \MWException( __METHOD__ . ': Expected String or Array; ' . gettype( $classes ) .
				' given.' );
		}
	}

	/**
	 * @return ChameleonTemplate
	 */
	public function getSkinTemplate() {
		return $this->mSkinTemplate;
	}

	/**
   * @param ChameleonTemplate $tpl
   * @return void
   */
     public function setSkinTemplate( $tpl ) {
         $this->mSkinTemplate = $tpl;
     }

	/**
	 * @since 1.1
	 * @return \Skins\Chameleon\Chameleon
	 */
	public function getSkin() {
		return $this->mSkinTemplate->getSkin();
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
	 * Returns the class string that should be assigned to the top-level html element of this
	 * component
	 *
	 * @return string
	 */
	public function getClassString() {
		return implode( ' ', $this->mClasses );
	}

	/**
	 * Removes the given class from the class string that should be assigned to the top-level html
	 * element of this component
	 *
	 * @param string | array | null $classes
	 *
	 * @throws \MWException
	 */
	public function removeClasses( $classes ) {
		$classesArray = $this->transformClassesToArray( $classes );

		$this->mClasses = array_diff( $this->mClasses, $classesArray );
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
	 * @param ChameleonTemplate $tpl
	 * @return String the HTML code
	 */
	abstract public function getHtml( $tpl );

	/**
	 * @return string[] the resource loader modules needed by this component
	 */
	public function getResourceLoaderModules() {
		return [];
	}

	/**
	 * Adds $indent to (or subtracts from if negative) the current indentation level.
	 * Inserts a new line and a number of tabs according to the new indentation level.
	 *
	 * @param int $indent
	 * @return string
	 * @throws \MWException
	 */
	protected function indent( $indent = 0 ) {
		$this->mIndent += (int)$indent;

		if ( $this->mIndent < 0 ) {
			throw new \MWException( 'Attempted HTML indentation of ' . $this->mIndent );
		}

		return "\n" . str_repeat( "\t", $this->mIndent );
	}

	/**
	 * @param string $attributeName
	 * @param null | string $default
	 * @return null | string
	 */
	protected function getAttribute( $attributeName, $default = '' ) {
		$element = $this->getDomElement();

		if ( is_a( $element, 'DOMElement' ) && $element->hasAttribute( $attributeName ) ) {
			return $element->getAttribute( $attributeName );
		}

		return $default;
	}
}
