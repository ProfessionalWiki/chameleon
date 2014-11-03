<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke, mwjames
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

namespace Skins\Chameleon\Tests\Util;

use DOMDocument;
use DOMElement;

use RuntimeException;

/**
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @author mwjames
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class DocumentElementFinder {

	protected $file = null;
	protected $document = null;

	/**
	 * @since 1.0
	 *
	 * @param string $file
	 */
	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $type
	 *
	 * @return DOMElement|null
	 */
	public function getComponentByTypeAttribute( $type ) {

		$elements = $this->getComponentsByTypeAttribute( $type );

		if ( count( $elements ) > 0 ) {
			return array_shift( $elements );
		}

		return null;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $type
	 *
	 * @return DOMElement[]
	 */
	public function getComponentsByTypeAttribute( $type ) {

		$elements = array();

		$elementList = $this->getDocument()->getElementsByTagName( strtolower( $type ) );
		foreach( $elementList as $element ){
			$elements[] = $element;
		}

		$elementList = $this->getDocument()->getElementsByTagName( '*' );
		foreach ( $elementList as $element ) {
			if ( $element instanceOf DOMElement && $element->hasAttribute( 'type' ) && $element->getAttribute( 'type' ) === $type ) {
				$elements[] = $element;
			}
		}

		return $elements;
	}

	protected function getDocument() {

		if ( $this->document !== null ) {
			return $this->document;
		}

		$file = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $this->file );

		if ( !is_readable( $file ) ) {
			throw new RuntimeException( "Expected an accessible {$file} path" );
		}

		$document = new DOMDocument;
		$document->validateOnParse = true;

		if ( !$document->load( $file ) ) {
			throw new RuntimeException( "Unable to load {$file} file" );
		}

		$document->normalizeDocument();

		return $document;
	}

}
