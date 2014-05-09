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
 * The main file of the Chameleon skin
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Skins
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
	define( 'CHAMELEON_VERSION', '1.0-alpha' );

	// set extension credits
	$GLOBALS[ 'wgExtensionCredits' ][ 'skin' ][ ] = array(
		'path'           => __FILE__,
		'name'           => 'Chameleon',
		'descriptionmsg' => 'chameleon-desc',
		'author'         => '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
		'url'            => 'https://www.mediawiki.org/wiki/Skin:Chameleon',
		'version'        => CHAMELEON_VERSION,
	);

	// register skin
	$GLOBALS[ 'wgValidSkinNames' ][ 'chameleon' ] = 'Chameleon';

	// register message file for i18n
	$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'Chameleon' ] = __DIR__ . '/Chameleon.i18n.php';
    $GLOBALS[ 'wgMessagesDirs' ][ 'Chameleon' ] = __DIR__ . '/i18n';

	$chameleonComponents = array(
		'Component',
		'Structure',
		'Container',
		'Row',
		'Cell',
		'Grid',
		'NavbarHorizontal',
		'NavMenu',
		'PageTools',
		'NewtalkNotifier',
		'PersonalTools',
		'Logo',
		'SearchBar',
		'SiteNotice',
		'ToolbarHorizontal',
		'FooterInfo',
		'FooterPlaces',
		'FooterIcons',
		'MainContent',
		'Html',
	);

	foreach ( $chameleonComponents as $component ) {
		$GLOBALS[ 'wgAutoloadClasses' ][ 'Skins\\Chameleon\\Components\\' . $component ] = __DIR__ . '/src/Components/' . $component . '.php';
	}

	$GLOBALS[ 'wgAutoloadClasses' ][ 'SkinChameleon' ] = dirname( __FILE__ ) . '/src/SkinChameleon.php'; // register skin class (must be 'Skin' . SkinName)
	$GLOBALS[ 'wgAutoloadClasses' ][ 'Skins\Chameleon\ChameleonTemplate' ] = dirname( __FILE__ ) . '/src/ChameleonTemplate.php';
	$GLOBALS[ 'wgAutoloadClasses' ][ 'Skins\Chameleon\IdRegistry' ] = dirname( __FILE__ ) . '/src/IdRegistry.php';
	$GLOBALS[ 'wgAutoloadClasses' ][ 'Skins\Chameleon\Hooks\SetupAfterCache' ] = __DIR__ . '/src/Hooks/SetupAfterCache.php';

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

		$configuration = array(
			'egChameleonExternalStyleModules'  => isset( $GLOBALS[ 'egChameleonExternalStyleModules' ] ) ? $GLOBALS[ 'egChameleonExternalStyleModules' ] : array(),
			'egChameleonExternalLessVariables' => isset( $GLOBALS[ 'egChameleonExternalLessVariables' ] ) ? $GLOBALS[ 'egChameleonExternalLessVariables' ] : array(),
			'wgStyleDirectory'                 => $GLOBALS['wgStyleDirectory'],
			'wgStylePath'                      => $GLOBALS['wgStylePath']
		);

		$setupAfterCache = new \Skins\Chameleon\Hooks\SetupAfterCache(
			\Bootstrap\BootstrapManager::getInstance(),
			$configuration
		);

		$setupAfterCache->process();
	};

	// set default skin layout
	$GLOBALS[ 'egChameleonLayoutFile' ] = dirname( __FILE__ ) . '/layouts/standard.xml';

} );
