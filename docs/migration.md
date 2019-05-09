# Migrating to Chameleon 2.0:

## Core items changed

* Move from Bootstrap 3 to [Bootstrap 4](https://getbootstrap.com/docs/4.3)
* Move from Less to [SCSS](https://sass-lang.com/) (Sass)
* New way of setting style variables in LocalSettings.php 
* Component name changes

Please also see the [release notes](release-noted.md).

## New minimum version requirements

Chameleon 2 supports
* MediaWiki 1.31.0 and later
* PHP 7.0 and later

The PHP extensions [DOM](https://www.php.net/manual/en/book.dom.php) and [Filter](https://www.php.net/manual/en/book.filter.php)
are required.

## Update/Installation

See the [installation instructions](installation.md).

It should be enough to update `composer.local.json`, run `composer update` and add `wfLoadSkin( 'chameleon' );` to LocalSettings.php. If it does not work right away, try to completely uninstall and then re-install the skin.

## Move from Bootstrap 3 to Bootstrap 4

Chameleon 2.0 comes with [Bootstrap 4](https://getbootstrap.com/docs/4.3), an upgraded version of Bootstrap 3 that came with Chameleon 1.x. Class names from Bootstrap 3 could be different in Bootstrap 4. It is highly recommended to read Bootstrap's migration guide here: https://getbootstrap.com/docs/4.0/migration/. 

## Move from Less to SCSS (Sass)

The transition to Bootstrap 4 also mandates a transition from Less to SCSS, a variant of the Sass styling language. If you have created your own Less files, it is important that these are adapted to SCSS. If you have been an advanced user of Less (using mixins and such), it is recommended to look up a migration guide to SCSS.

Various Less-to-SCSS online converters are available on the web. However, depending on the complexity of your stylesheets some
manual rework may be necessary.

Please be aware that the PHP SCSS compiler is only capable of working with the SCSS language variant. It can not process the
Sass variant.

##  New way of setting style variables in LocalSettings.php 

**Configuration variable name change:**
`$egChameleonExternalLessVariables` -> `$egChameleonExternalStyleVariables`

**Using sass variables instead of less variables:**
OLD style (1.x) example:
```
$egChameleonExternalLessVariables = array(    
    'font-size-base' 	=> '1rem',
    'font-size-h1' 		=> 'floor((@font-size-base * 2))', 		// originally 36px
    'font-size-h2' 		=> 'floor((@font-size-base * 1.7))',	// originally 30px
    'font-size-h3' 		=> 'ceil((@font-size-base * 1.3))',		// originally originally 18px
    'brand-color' 		=> '#e9e415';
    'headings-color'   	=> '@brand-color',
);
```

NEW style (2.x) example:
```
$egChameleonExternalStyleVariables = array(
    'font-size-base' 	=> '1rem',
    'font-size-h1' 		=> '$font-size-base * 1.5;', 			// originally 2.2
    'font-size-h2' 		=> '$font-size-base * 1.3;', 			// originally 1.7
    'font-size-h3' 		=> '$font-size-base * 1.2;', 			// originally 1.4
    'brand-color' 		=> '#e9e415 !default'; 					// setting '!default' will create a new variable
    'headings-color' 	=> '$brand-color',
);
```

## Component changes

### ToolbarHorizontal, Toolbox, LangLinks
In Chameleon 1.x the **ToolbarHorizontal** component generated a Navbar containing the toolbox and language links.
This component has been removed, as well as the attributes _showTools_ and _showLanguages_ from the **NavMenu** component.

To achieve the same effect you will have to use the new components [Toolbox] and [LangLinks].

A ToolbarHorizontal-like component is now built like this:
```xml
<component type="NavbarHorizontal" collapsible="no" class="small mb-2" >
	<component type="Toolbox" flatten="no" class="dropup"/>
	<component type="LangLinks" flatten="no" class="dropup"/>
</component>
```

To show the Toolbox and LangLinks next to the NavMenu, just add the newly available components after it:
```xml
<component type="NavMenu" flatten="navigation" />
<component type="Toolbox" />
<component type="LangLinks" />
```

### PageToolsAdaptable

The **PageToolsAdaptable** component has been removed. It's functionality is now available from the regular [PageTools]
component. Just add the _buttons_ attribute, e.g.:
``` xml
<component type="PageTools" buttons="edit,talk"/>
```

### Menu

The Menu component now understands a third parameter for each menu entry, that can contain a class that should be set on
the link for the menu item. The idea is to use it to show an icon in front of the menu item, e.g.:
```xml
<component type="Menu" >
  * SomeMenuLabel
  ** SomeMenuItem
  * # | AnotherMenuLabel | fas fa-egg
  ** SomeURL | SomeMenuItemLabel | fas fa-splotch
</component>
```

Note the difference in the above example between _SomeMenuLabel_ and _AnotherMenuLabel_. In order to have the class parameter recognized, there has to be exactly three parameters, i.e. a link target, a link label and a link class. To satisfy this requirement, the link target for _AnotherMenuLabel_ has been set to `#`.

To find icons, search on https://fontawesome.com/icons?d=gallery. Be aware that Chameleon 2 only ships the free icons.

## Getting help

For general questions, comments or suggestions you might use the [Chameleon skin talk page on MediaWiki.org][chameleon-talk].

For direct contact please use the [Email functionality on MediaWiki.org][mw-mail].

Finally the MediaWiki IRC channel (Server: [freenode.net][irc], Channel: #mediawiki) might be worth a try.


[ToolBox]: components.md#component-toolbox
[LangLinks]: components.md#component-langlinks
[chameleon-talk]: https://www.mediawiki.org/wiki/Skin_talk:Chameleon
[mw-mail]: https://www.mediawiki.org/wiki/Special:EmailUser/F.trott
[irc]: http://webchat.freenode.net/

