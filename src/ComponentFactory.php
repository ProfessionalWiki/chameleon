<?php
/**
 * File containing the ComponentFactory class
 *
 * @copyright (C) 2014, Stephan Gambke
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

namespace Skins\Chameleon;

use DOMDocument;
use RuntimeException;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Components\Container;

/**
 * Class ComponentFactory
 *
 * @package Skins\Chameleon
 * @ingroup Skins
 */
class ComponentFactory {

	// the root component of the page; should be of type Container
	private $mRootComponent = null;

	private $layoutFile;
	private $skinTemplate;

	function __construct( $file ) {
		$this->setLayoutFile( $file );
	}

	/**
	 * @return Container
	 * @throws \MWException
	 */
	public function getRootComponent() {

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

		$component = new $class( $this->getSkinTemplate(), $description, $indent, $htmlClassAttribute );

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
	 * @return string
	 */
	protected function getLayoutFile() {

		return $this->layoutFile;
	}

	/**
	 * @throws RuntimeException
	 */
	public function setLayoutFile( $file ) {

		$file = $this->sanitizeFileName( $file );

		if ( !is_readable( $file ) ) {
			throw new RuntimeException( "Expected an accessible {$file} layout file" );
		}

		$this->layoutFile = $file;
	}

	public function sanitizeFileName( $fileName ) {
		return str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $fileName );
	}

	/**
	 * @return mixed
	 */
	public function getSkinTemplate() {
		return $this->skinTemplate;
	}

	/**
	 * @param mixed $skinTemplate
	 */
	public function setSkinTemplate( $skinTemplate ) {
		$this->skinTemplate = $skinTemplate;
	}


}
