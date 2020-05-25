<?php
$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php';

$IP = getenv( 'MW_INSTALL_PATH' ) !== false
	? str_replace( '\\', '/', getenv( 'MW_INSTALL_PATH' ) )
	: __DIR__ . '/../../..';

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
