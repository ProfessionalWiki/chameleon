<?php

namespace Skins\Tests\Chameleon;

use DOMDocument;
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
class XmlLayoutFileValidityTest extends \PHPUnit_Framework_TestCase {

	public function testXmlValidityOfLayoutFiles() {

		$listOfLayoutXmlFiles = $this->loadXmlFiles( $this->readDirectory( __DIR__ . '/../../layouts' ) );

		$this->assertNotEmpty( $listOfLayoutXmlFiles );
		$this->assertXmlFiles( $listOfLayoutXmlFiles );
	}

	protected function assertXmlFiles( $files ) {
		foreach ( $files as $file ) {
			$this->assertXmlDocumentLoad( $file );
		}
	}

	protected function assertXmlDocumentLoad( $file ) {
		$document = new DOMDocument();
		$document->validateOnParse = false;
		$this->assertTrue( $document->load( $file ) );
	}

	protected function readDirectory( $path ) {

		$path = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $path );

		if ( is_readable( $path ) ) {
			return $path;
		}

		throw new RuntimeException( "Expected an accessible {$path} path" );
	}

	protected function loadXmlFiles( $path ) {

		$files = array();
		$directoryIterator = new \RecursiveDirectoryIterator( $path );

		foreach ( new \RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
			if ( strtolower( substr( $fileInfo->getFilename(), -4 ) ) === '.xml' ) {
				$files[] = $fileInfo->getPathname();
			}
		}

		return $files;
	}

}
