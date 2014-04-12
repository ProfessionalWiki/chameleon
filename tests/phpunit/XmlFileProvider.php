<?php

namespace Skins\Chameleon\Tests;

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
class XmlFileProvider {

	protected $path = null;

	/**
	 * @since 1.0
	 *
	 * @param string $path
	 */
	public function __construct( $path ) {
		$this->path = $path;
	}

	/**
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getFiles() {
		return $this->loadXmlFiles( $this->readDirectory( $this->path ) );
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
