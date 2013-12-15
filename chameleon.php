<?php
/**
 * The Chameleon skin. A Mediawiki skin using Twitter Bootstrap.
 *
 * @see https://www.mediawiki.org/wiki/Skin:Chameleon
 *
 * @author Stephan Gambke
 * @version 0.1
 *
 */

/**
 * The main file of the Chameleon skin
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup Skins
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

if ( !defined( 'BS_VERSION' ) ) {
	die( '<b>Error:</b> The <a href="https://www.mediawiki.org/wiki/Skin:Chameleon">Chameleon</a> skin depends on the Bootstrap extension. You need to install the <a href="https://www.mediawiki.org/wiki/Extension:Bootstrap">Bootstrap</a> extension first.' );
}

// define the skin's version
define( 'CHAMELEON_VERSION', '0.2 alpha' );

// set extension credits
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Chameleon',
	'descriptionmsg' => 'chameleon-desc',
	'author' => '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Chameleon',
	'version' => CHAMELEON_VERSION,
);

// register skin
$wgValidSkinNames['chameleon'] = 'Chameleon';

// register skin class (must be 'Skin' . SkinName)
$wgAutoloadClasses['SkinChameleon'] = dirname( __FILE__ ) . '/Chameleon.skin.php';


$egChameleonLayoutFile= dirname( __FILE__ ) . '/layouts/standard.xml';

$chameleonComponents = array(
	'Component',
	'Structure',
	'Container',
	'Row',
	'Cell',
	'Grid',
	'NavbarHorizontal',
	'NavHead',
	'TabList',
	'NewtalkNotifier',
	'PersonalTools',
	'Logo',
	'SearchForm',
	'SiteNotice',
	'ToolbarHorizontal',
	'FooterInfo',
	'FooterPlaces',
	'FooterIcons',
	'MainContent',
	'Html',
);

foreach ( $chameleonComponents as $component ) {
	$wgAutoloadClasses['skins\\chameleon\\components\\' . $component] = dirname( __FILE__ ) . '/components/' . $component. '.php';
}

// register message file for i18n
$wgExtensionMessagesFiles['Chameleon'] = dirname( __FILE__ ) . '/Chameleon.i18n.php';

// register Bootstrap modules (for now, just register everything)
Bootstrap::getBootstrap()->addAllBootstrapModules();
Bootstrap::getBootstrap()->addExternalModule( __DIR__, '/css/screen.less' );
