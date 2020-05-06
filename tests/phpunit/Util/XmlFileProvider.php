<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke, mwjames
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
 * @ingroup Skins
 */

namespace Skins\Chameleon\Tests\Util;

use RuntimeException;

// @codingStandardsIgnoreStart
/**
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @author mwjames
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
// @codingStandardsIgnoreEnd
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

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	protected function readDirectory( $path ) {
		$path = str_replace( [ '\\', '/' ], DIRECTORY_SEPARATOR, $path );

		if ( is_readable( $path ) ) {
			return $path;
		}

		throw new RuntimeException( "Expected an accessible {$path} path" );
	}

	/**
	 * @param string $path
	 *
	 * @return array
	 */
	protected function loadXmlFiles( $path ) {
		$files = [];
		$directoryIterator = new \RecursiveDirectoryIterator( $path );

		foreach ( new \RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
			if ( strtolower( substr( $fileInfo->getFilename(), -4 ) ) === '.xml' ) {
				$files[] = $fileInfo->getPathname();
			}
		}

		return $files;
	}

}
