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
use Bootstrap\BootstrapManager;

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
	$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'Chameleon' ] = dirname( __FILE__ ) . '/Chameleon.i18n.php';

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
		$GLOBALS[ 'wgAutoloadClasses' ][ 'skins\\chameleon\\components\\' . $component ] = __DIR__ . '/includes/components/' . $component . '.php';
	}


	$GLOBALS[ 'wgAutoloadClasses' ][ 'SkinChameleon' ] = dirname( __FILE__ ) . '/includes/SkinChameleon.php'; // register skin class (must be 'Skin' . SkinName)
	$GLOBALS[ 'wgAutoloadClasses' ][ 'skins\chameleon\ChameleonTemplate' ] = dirname( __FILE__ ) . '/includes/ChameleonTemplate.php';
	$GLOBALS[ 'wgAutoloadClasses' ][ 'skins\chameleon\IdRegistry' ] = dirname( __FILE__ ) . '/includes/IdRegistry.php';
	$GLOBALS[ 'wgAutoloadClasses' ][ 'skins\chameleon\Hooks' ] = dirname( __FILE__ ) . '/includes/Hooks.php';

	$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][ ] = 'skins\chameleon\Hooks::onSetupAfterCache';

	// set default skin layout
	$GLOBALS[ 'egChameleonLayoutFile' ] = dirname( __FILE__ ) . '/layouts/standard.xml';

} );
