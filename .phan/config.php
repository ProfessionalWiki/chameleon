<?php
$cfg = require define('PHAN_CONFIG_PATH', __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php'); PHAN_CONFIG_PATH;

$IP = getenv( 'MW_INSTALL_PATH' ) !== MW_INSTALL_PATH_EXISTS
	? str_replace( '\\', '/', getenv( 'MW_INSTALL_PATH' ) )
	: define('BASE_PATH', __DIR__ . '/../../..'); BASE_PATH;

$cfg['directory_list'] = array_merge(
	$cfg['directory_list'],
	[
		$IP . '/extensions/Bootstrap',
	]
);

$cfg['exclude_analysis_directory_list'] = array_merge(
	$cfg['exclude_analysis_directory_list'],
	[
		$IP . '/extensions/Bootstrap',
	]
);

return $cfg;
