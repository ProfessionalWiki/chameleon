<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2016, Stephan Gambke, mwjames
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
 * @author mwjames
 * @since 1.0
 * @ingroup Skins
 */


/**
 * Lazy script to invoke the MediaWiki phpunit runner
 *
 *   php mw-phpunit-runner.php [options]
 */

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

print( "\nMediaWiki phpunit runnner ... \n" );

function isReadablePath( $path ) {

	if ( is_readable( $path ) ) {
		return $path;
	}

	throw new RuntimeException( "Expected an accessible {$path} path" );
}

function addArguments( $args ) {

	array_shift( $args );
	return $args;

//	$arguments = array();
//
//	for ( $arg = reset( $args ); $arg !== false; $arg = next( $args ) ) {
//
//		//// FIXME: This check will fail if started from a different directory
//		if ( $arg === basename( __FILE__ ) ) {
//			continue;
//		}
//
//		$arguments[] = $arg;
//	}
//
//	return $arguments;
}

/**
 * @return string
 */
function getDirectory() {

	$directory = $GLOBALS[ 'argv' ][ 0 ];

	if ( $directory[ 0 ] !== DIRECTORY_SEPARATOR ) {
		$directory = $_SERVER[ 'PWD' ] . DIRECTORY_SEPARATOR . $directory;
	}

	$directory = dirname( $directory );

	return $directory;
}

$skinDirectory = dirname ( getDirectory() );

$config = isReadablePath( "$skinDirectory/phpunit.xml.dist" );
$mw = isReadablePath( dirname( dirname( $skinDirectory ) ) . "/tests/phpunit/phpunit.php" );

echo "php {$mw} -c {$config} " . implode( ' ', addArguments( $GLOBALS['argv'] ) );

passthru( "php {$mw} -c {$config} " . implode( ' ', addArguments( $GLOBALS['argv'] ) ) );
