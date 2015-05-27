<?php
/**
 * The Chameleon skin. A Mediawiki skin using Twitter Bootstrap.
 *
 * @see     https://www.mediawiki.org/wiki/Skin:Chameleon
 *
 * @author  Stephan Gambke
 * @version 1.0-alpha
 *
 */

/**
 * This is the main file of the Chameleon skin
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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
 *
 * @codeCoverageIgnore
 */

call_user_func( function () {

	if ( !defined( 'MEDIAWIKI' ) ) {
		die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
	}

	if ( !defined( 'BS_VERSION' ) ) {
		die( '<b>Error:</b> The <a href="https://www.mediawiki.org/wiki/Skin:Chameleon">Chameleon</a> skin depends on the Bootstrap extension. You need to install the <a href="https://www.mediawiki.org/wiki/Extension:Bootstrap">Bootstrap</a> extension first.' );
	}

	// define the skin's version
	define( 'CHAMELEON_VERSION', '1.1.4' );

	// set credits
	$GLOBALS[ 'wgExtensionCredits' ][ 'skin' ][ ] = array(
		'path'           => __FILE__,
		'name'           => 'Chameleon',
		'descriptionmsg' => 'chameleon-desc',
		'author'         => '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
		'url'            => 'https://www.mediawiki.org/wiki/Skin:Chameleon',
		'version'        => CHAMELEON_VERSION,
		'license-name'   => 'GPLv3+',
	);

	// register skin
	$GLOBALS[ 'wgValidSkinNames' ][ 'chameleon' ] = 'Chameleon';

	// register message file for i18n
	$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'Chameleon' ] = __DIR__ . '/Chameleon.i18n.php';
    $GLOBALS[ 'wgMessagesDirs' ][ 'Chameleon' ] = __DIR__ . '/resources/i18n';

	/**
	 * Using callbacks for hook registration
	 *
	 * The hook registry should contain as less knowledge about a process as
	 * necessary therefore a callback is used as Factory/Builder that instantiates
	 * a business / domain object.
	 *
	 * GLOBAL state should be encapsulated by the callback and not leaked into
	 * a instantiated class
	 */

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/SetupAfterCache
	 */
	$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][ ] = function() {

		$setupAfterCache = new \Skins\Chameleon\Hooks\SetupAfterCache(
			\Bootstrap\BootstrapManager::getInstance(),
			$GLOBALS
		);

		$setupAfterCache->process();
	};

	// set default skin layout
	$GLOBALS[ 'egChameleonLayoutFile' ] = dirname( __FILE__ ) . '/layouts/standard.xml';

	// enable the VisualEditor for this skin
	$GLOBALS[ 'egChameleonEnableVisualEditor' ] = true;

} );
