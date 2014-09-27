<?php

namespace Skins\Chameleon;

use BaseTemplate;
use DOMDocument;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Components\Container;
use RuntimeException;

/**
 * File holding the ChameleonTemplate class
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
 * BaseTemplate class for the Chameleon skin
 *
 * @ingroup Skins
 */
class ChameleonTemplate extends BaseTemplate {

	// the root component of the page; should be of type Container
	private $mRootComponent = null;

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {

		// output the head element
		// The headelement defines the <body> tag itself, it shouldn't be included in the html text
		// To add attributes or classes to the body tag override addToBodyAttributes() in SkinChameleon
		$this->html( 'headelement' );
		echo $this->getRootComponent()->getHtml();
		$this->printTrail();
		echo "</body>\n</html>";

	}

	/**
	 * Overrides method in parent class that is unprotected against non-existent indexes in $this->data
	 *
	 * @param $key
	 *
	 * @return string|void
	 */
	function html( $key ) {
		echo $this->get( $key );
	}

	/**
	 * @return Container
	 * @throws \MWException
	 */
	protected function getRootComponent() {

		if ( $this->mRootComponent === null ) {

			$doc = new DOMDocument();

			$doc->load( $this->getLayoutFile() );

			$doc->normalizeDocument();

			$roots = $doc->getElementsByTagName( 'structure' );

			if ( $roots->length > 0 ) {

				$this->mRootComponent = $this->getComponent( $roots->item( 0 ) );

			} else {
				// TODO: catch other errors, e.g. malformed XML
				throw new \MWException( sprintf( '%s: XML description is missing an element: structure.', $this->getLayoutFile() ) );
			}
		}

		return $this->mRootComponent;

	}

	/**
	 * @param \DOMElement $description
	 * @param int         $indent
	 * @param string      $htmlClassAttribute
	 *
	 * @throws \MWException
	 * @return \Skins\Chameleon\Components\Container
	 */
	public function getComponent( \DOMElement $description, $indent = 0, $htmlClassAttribute = '' ) {

		$class = 'Skins\\Chameleon\\Components\\';

		$nodeName = strtolower( $description->nodeName );

		switch ( $nodeName ) {
			case 'structure':
			case 'grid':
			case 'row':
			case 'cell':
				$class .= ucfirst( $nodeName );
				break;
			case 'component':
				if ( $description->hasAttribute( 'type' ) ) {
					$class .= $description->getAttribute( 'type' );
				} else {
					$class .= 'Container';
				}
				break;
			default:
				throw new \MWException( sprintf( '%s (line %d): XML element not allowed here: %s.', $this->getLayoutFile(), $description->getLineNo(), $description->nodeName ) );
		}

		if ( ! class_exists( $class ) || !is_subclass_of( $class, 'Skins\\Chameleon\\Components\\Component' ) ) {
			throw new \MWException( sprintf( '%s (line %d): Invalid component type: %s.', $this->getLayoutFile(), $description->getLineNo(), $description->getAttribute( 'type' ) ) );
		}

		$component = new $class( $this, $description, $indent, $htmlClassAttribute );

		$children = $description->childNodes;

		foreach ( $children as $child ) {
			if ( is_a( $child, 'DOMElement' ) && strtolower( $child->nodeName ) === 'modification' ) {
				$component = $this->getModifiedComponent( $child, $component );
			}
		}

		return $component;
	}

	/**
	 * @param \DOMElement $description
	 * @param Component   $component
	 *
	 * @return mixed
	 * @throws \MWException
	 */
	protected function getModifiedComponent( \DOMElement $description, Component $component ) {

		if ( !$description->hasAttribute( 'type' ) ) {
			throw new \MWException( sprintf( '%s (line %d): Modification element missing an attribute: type.', $this->getLayoutFile(), $description->getLineNo() ) );
		}

		$className = 'Skins\\Chameleon\\Components\\Modifications\\' . $description->getAttribute( 'type' );

		if ( !class_exists( $className ) || !is_subclass_of( $className, 'Skins\\Chameleon\\Components\\Modifications\\Modification' ) ) {
			throw new \MWException( sprintf( '%s (line %d): Invalid modification type: %s.', $this->getLayoutFile(), $description->getLineNo(), $description->getAttribute( 'type' ) ) );
		}

		return new $className( $component, $description );

	}

	/**
	 * Generates a list item for a navigation, portlet, portal, sidebar... list
	 *
	 * Overrides the parent function to ensure ids are unique.
	 *
	 * @param $key     string, usually a key from the list you are generating this link from.
	 * @param $item    array, of list item data containing some of a specific set of keys.
	 *
	 * The "id" and "class" keys will be used as attributes for the list item,
	 * if "active" contains a value of true a "active" class will also be appended to class.
	 *
	 * @param $options array
	 *
	 * @return string
	 */
	function makeListItem( $key, $item, $options = array() ) {

		foreach ( array( 'id', 'single-id') as $attrib ) {

			if ( isset ( $item[ $attrib ] ) ) {
				$item[ $attrib ] = IdRegistry::getRegistry()->getId( $item[ $attrib ], $this );
			}

		}

		return parent::makeListItem( $key, $item, $options );
	}

	/**
	 * @return string
	 * @throws RuntimeException
	 */
	protected function getLayoutFile() {

		$file = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $GLOBALS['egChameleonLayoutFile'] );

		if ( !is_readable( $file ) ) {
			throw new RuntimeException( "Expected an accessible {$file} layout file" );
		}

		return $file;
	}

}
