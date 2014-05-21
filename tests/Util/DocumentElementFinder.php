<?php

namespace Skins\Chameleon\Tests\Util;

use DOMDocument;
use DOMElement;

use RuntimeException;

/**
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
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

		$elementList = $this->getDocument()->getElementsByTagName( 'component' );
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
