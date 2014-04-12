<?php

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'MediaWiki is not available for the test environment' );
}

function registerAutoLoader( $path, $message ) {
	print( $message );
	return require $path;
}

function useTestAutoLoader() {

	$mwVendorPath = __DIR__ . '/../../../vendor/autoload.php';
	$localVendorPath = __DIR__ . '/../vendor/autoload.php';

	if ( is_readable( $localVendorPath ) ) {
		$autoLoader = registerAutoLoader( $localVendorPath, "\Using the local vendor class loader ...\n" );
	} elseif ( is_readable( $mwVendorPath ) ) {
		$autoLoader = registerAutoLoader( $mwVendorPath, "\nUsing the MediaWiki vendor class loader ...\n" );
	}

	if ( !$autoLoader instanceof \Composer\Autoload\ClassLoader ) {
		return false;
	}

	$autoLoader->addPsr4( 'Skins\\Chameleon\\Tests\\', __DIR__ . '/phpunit/' );

	return true;
}

if ( !useTestAutoLoader() ) {
	die( 'Required test class loader was not accessible' );
}
