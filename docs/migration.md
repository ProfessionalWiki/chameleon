# Migrating to Chameleon 6.0

## Core items changed

* Move from Bootstrap 4 to [Bootstrap 5](https://getbootstrap.com/docs/5.3)
* Bundled Font Awesome updated from 5 to 6

See the [release notes](release-notes.md).

## New minimum version requirements

Chameleon 6 supports
* MediaWiki 1.43.0 and later
* PHP 8.1 and later
* Extension:Bootstrap 6.0 and later (which bundles Bootstrap 5.3)

## Move from Bootstrap 4 to Bootstrap 5

Chameleon 6.0 comes with [Bootstrap 5](https://getbootstrap.com/docs/5.3), an upgraded version of Bootstrap 4 that came with Chameleon 2.x to 5.x. Class names and utilities from Bootstrap 4 may be renamed or removed in Bootstrap 5. If you use Bootstrap classes in your wikitext, templates, layouts or custom stylesheets, review them against Bootstrap's own migration guide: https://getbootstrap.com/docs/5.3/migration/. Common examples include `.ml-*` / `.mr-*` becoming `.ms-*` / `.me-*`, `.text-left` / `.text-right` becoming `.text-start` / `.text-end`, and `.sr-only` becoming `.visually-hidden`.

## Custom styles (SCSS)

If you customize Chameleon's styling through `$egChameleonExternalStyleVariables` or a custom theme file (`$egChameleonThemeFile`), a few Bootstrap 5 changes affect the SCSS you provide:

* The Bootstrap 4 SCSS functions `theme-color()`, `color()` and `theme-color-level()` no longer exist in Bootstrap 5. A custom theme file or style variable that calls them will fail to compile. Read colors from the Bootstrap maps instead, for example `map-get( $theme-colors, "danger" )`.
* `$enable-responsive-font-sizes` has been replaced by `$enable-rfs`. Responsive font sizes stay on by default, so this only matters if you set the variable to turn them off: use `$enable-rfs: false` instead.
* The search bar's button border now follows `$input-border-color` rather than `$input-group-addon-border-color`. Set `$input-border-color` if you restyle it.

The theme file's color and breakpoint maps (`$colors`, `$grays`, `$theme-colors`, `$grid-breakpoints`) keep the same structure as in Chameleon 5, so an existing custom theme file continues to work apart from the points above.

### Bootswatch themes

A Bootswatch theme's `_variables.scss` and `_bootswatch.scss` are built against a specific Bootstrap major version, and the Bootstrap 4 and Bootstrap 5 builds of a theme are not necessarily interchangeable. A Bootstrap 4 Bootswatch theme loaded through `$egChameleonThemeFile` or `$egChameleonExternalStyleModules` may render incorrectly under Chameleon 6. It can also fail to compile if it, or a stylesheet you load alongside it, uses a construct that Bootstrap 5 removed, such as `theme-color()`. Use the Bootstrap 5 build of the same Bootswatch theme instead.

## Changes to Chameleon's own markup and behaviour

Beyond the classes you write yourself, the move to Bootstrap 5 also changed some of the markup and JavaScript that Chameleon emits. If you have custom CSS or JavaScript targeting the skin's rendered output, note:

* The `.pull-left` / `.pull-right` compatibility classes (previously emitted by `resources/styles/utilities/_float.scss`) are removed; use Bootstrap 5's `.float-start` / `.float-end`.
* The search bar no longer wraps its buttons in a `.input-group-append` element (Bootstrap 5 removed `.input-group-*-append`); the buttons now sit directly inside `.input-group`.
* Navigation dropdowns now use Bootstrap 5's `data-bs-*` attributes (for example `data-bs-toggle`) instead of the Bootstrap 4 `data-*` equivalents (`data-toggle`).
* The Table of Contents (`Toc`) script now drives its collapsible sections with Bootstrap 5's `bootstrap.Collapse` API instead of the jQuery Bootstrap plugin.

## Font Awesome 5 to 6

The bundled Font Awesome is updated from version 5 to version 6. Font Awesome 6 retains the version 5 class aliases, so existing `fa-*` icon usage generally keeps working. If you reference an icon directly in wikitext or via the `$cmln-icons` SCSS variable and it no longer appears as expected, check its current name in the [Font Awesome 6 icon gallery](https://fontawesome.com/icons). Only the free icons are bundled.

---

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

Finally the MediaWiki IRC channel (Server: [libera.chat][irc], Channel: #mediawiki) might be worth a try.


[ToolBox]: components.md#component-toolbox
[LangLinks]: components.md#component-langlinks
[chameleon-talk]: https://www.mediawiki.org/wiki/Skin_talk:Chameleon
[mw-mail]: https://www.mediawiki.org/wiki/Special:EmailUser/F.trott
[irc]: https://web.libera.chat/?channel=#mediawiki

