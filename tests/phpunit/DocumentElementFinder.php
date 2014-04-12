<?php

namespace Skins\Chameleon\Tests;

use DOMDocument;
use DOMElement;

use RuntimeException;

/**
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @licence GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class DocumentElementFinder {

	protected $file = null;

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

		foreach ( $this->getDocument()->getElementsByTagName( 'component' ) as $elements ) {

			if ( $elements instanceOf DOMElement && $elements->hasAttribute( 'type' ) && $elements->getAttribute( 'type' ) === $type ) {
				return $elements;
			}
		}

		return null;
	}

	protected function getDocument() {

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
