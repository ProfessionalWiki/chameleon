<?php
// @codingStandardsIgnoreFile
/**
 * Validates layout files.
 *
 * @copyright (C) 2013 - 2019, Stephan Gambke
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

function libxml_display_error( $error ) {
	$return = '';

	switch ( $error->level ) {
		case LIBXML_ERR_WARNING:
			$return .= "Warning $error->code: ";
			break;
		case LIBXML_ERR_ERROR:
			$return .= "Error $error->code: ";
			break;
		case LIBXML_ERR_FATAL:
			$return .= "Fatal Error $error->code: ";
			break;
	}

	$return .= trim( $error->message );

	if ( $error->file ) {
		$return .= " in $error->file";
	}

	$return .= " on line $error->line\n";

	return $return;
}

function libxml_display_errors() {
	$errors = libxml_get_errors();

	print "\n";

	foreach ( $errors as $error ) {
		print libxml_display_error( $error );
	}

	print "\n";

	libxml_clear_errors();
}

function validateFile( $filename ) {
	print $filename . ': ';

	if ( !file_exists( $filename ) ) {
		print "File not found.\n";
		return;
	}

	if ( !is_file( $filename ) ) {
		print "Not a file.\n";
		return;
	}

	$xml = new DOMDocument();
	$xml->load( $filename );

	if ( !$xml->relaxNGValidate( 'https://ProfessionalWiki.github.io/chameleon/schema/3.6/layout.rng' ) ) {
		libxml_display_errors();
	} else {
		print "Ok!\n";
	}
}

libxml_use_internal_errors( true );

$files = $argv;
array_shift( $files );
foreach ( $files as $file ) {
	validateFile( $file );
}
