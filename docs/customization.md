# Customization

The Chameleon skin can be highly customized. There are two main areas that you can change:

1. Layout (defined by a XML file)
2. Styles (defined by SCSS files and/or SCSS variables)

## Layout of page elements

The layout of the page elements (nav bar, logo, search bar, etc.) is defined in
an XML file. There are currently five [pre-defined layouts](layouts.md) available:
* [standard](../layouts/standard.xml)
* [navhead](../layouts/navhead.xml)
* [fixedhead](../layouts/fixedhead.xml)
* [stickyhead](../layouts/stickyhead.xml)
* [clean](../layouts/clean.xml)

They can be activated by setting the
variable `$egChameleonLayoutFile` in LocalSettings.php.

For example, to activate the `fixedhead` layout you could add
```php
$egChameleonLayoutFile= __DIR__ . '/skins/chameleon/layouts/fixedhead.xml';
```

### Selecting the layout from the browser address bar

To select a specific layout different from the one defined in
`$egChameleonLayoutFile` you can add the `uselayout` parameter to the URL.
However for some wikis it might not be desirable to have this feature. So to
make this work you have to define the available layouts in
LocalSettings.php. E.g. to include all layouts delivered with Chameleon add
```php
$egChameleonAvailableLayoutFiles = [
	'standard'   => __DIR__ . '/skins/chameleon/layouts/standard.xml',
	'navhead'    => __DIR__ . '/skins/chameleon/layouts/navhead.xml',
	'fixedhead'  => __DIR__ . '/skins/chameleon/layouts/fixedhead.xml',
	'stickyhead' => __DIR__ . '/skins/chameleon/layouts/stickyhead.xml',
	'clean'      => __DIR__ . '/skins/chameleon/layouts/clean.xml',
];
```

### Creating a custom layout

You can of course also define and use your own layout. To start have a look at
the [documentation of the components](components.md) and at the exisiting
[layout description files](../layouts).

## Changing styles: Themes

Requires Chameleon version 3.2.0 or later.

A theme is a collection of predefined styles and by default Chameleon comes
with a light theme. It is possible to override that by setting the
`$egChameleonThemeFile` variable. This can either be an empty string to
restore Bootstrap defaults or it can be an absolute path to a SCSS file.

This can be used to load an existing Bootstrap theme from somewhere like
[Bootswatch](https://bootswatch.com/4) or to totally replace the default
light styling with a project-specific theme.

### Example: Bootstrap defaults
To reset the theme back to Bootstrap defaults, set it to an empty string in
`LocalSettings.php`:
```php
$egChameleonThemeFile = '';
```

### Example: Bootswatch 4
Download the [United theme](https://bootswatch.com/4/united/) `_variables.scss`
file and save it in the MediaWiki directory under `themes/united.scss`

Add the following to `LocalSettings.php`:
```php
$egChameleonThemeFile = __DIR__ . '/themes/united.scss';
```
To also load the additional `_bootswatch.scss`, save it to 
`themes/united_bootswatch.scss` and add the following:
```php
$egChameleonExternalStyleModules = [
	__DIR__ . '/themes/united_bootswatch.scss' => 'afterMain',
];
```

## Changing styles: Fonts, Colors, Padding etc.

You can customize the styles of the skin by 
* importing additional SCSS files (for example existing Bootstrap themes)
* and/or by changing existing [SCSS variables](variables.md).

Regardless of the order of the calls, variables will always override imported
files.

### Importing additional SCSS files

To import additional SCSS files, add them to the array
`$egChameleonExternalStyleModules` in `LocalSettings.php`:
```php
$egChameleonExternalStyleModules = [
    $localPathToSCSSFile1 => $positionFile1,
    $localPathToSCSSFile2 => $positionFile2,
    ...
];
```

There are nine allowed values for the position of a file:
* `beforeFunctions`, `functions`, `afterFunctions`,
* `beforeVariables`, `variables`, `afterVariables`,
* `beforeMain`, `main`, `afterMain`,

These positions influence where a file appears among the compiled files. In
general variable definitions should go in the `afterVariables` position. This
way they come after and overrule the definitions of Bootstrap and Chameleon, but
come before and are therefore used for the actual style definitions.
Your own style definitions you want to put in the `afterMain` position to allow
them to overrule the styles of Bootstrap and Chameleon.    

If you don't care where in the order of files your file appears you may omit the
position. Just write:
```php
$egChameleonExternalStyleModules = [ $localPathToSCSSFile1, $localPathToSCSSFile2, ... ];
```

### Changing existing SCSS variables

Chameleon comes with many SCSS variables (see [this list](variables.md)). All of
them have a default value. To change those values you should not edit the style
files that come with Chameleon, because if you update Chameleon your changes
will be overwritten. Instead change the values of the variables in your
`LocalSettings.php` by adding them to the array
`$egChameleonExternalStyleVariables`:

```php
$egChameleonExternalStyleVariables = [
    'key1' => 'value1',
    'key2' => 'value2',
    ...
];
```

If you add variables to the array (to change them), make sure you omit the `$`
before the variable name.

Apart from the SCSS variables defined in Chameleon itself, you can of course
also change variables of style files that you
[imported yourself](#importing-additional-scss-files).

**Example:**

To change the window width at which the skin switches between desktop and mobile
view you could add
```php
$egChameleonExternalStyleVariables = [
    'cmln-collapse-point' => '960px',
];
```

### Triggering a cache update

Compiling the style files is time-consuming. For this reason the styles are
not compiled on every page request. Instead they are cached after being
compiled. For changes to the styles to become effective it is necessary to
trigger an update of the style cache. There are two ways to do that:

1. A cache update is triggered when the `LocalSettings.php` file has a
   modification time later than the last cache update time. So you have to
   resave the `LocalSettings.php` to trigger a cache update. This can be
   achieved by using the `touch` utility on UNIX and friends or by using
   `copy /b LocalSettings.php +,,` from the MediaWiki installation directory
   on Windows. Alternatively, just open the file and re-save it.

2. If the above becomes too cumbersome, you could add the following to your
   `LocalSettings.php`:
   `\Bootstrap\BootstrapManager::getInstance()->addCacheTriggerFile( __DIR__ . '/your-file.scss' );`.

3. Finally, you can set the following in your `LocalSettings.php` to disable
   caching of SCSS styles completely: `$egScssCacheType = CACHE_NONE;`. This
   should obviously never be done on a production site.    

## Enable external link icons

Requires Chameleon version 3.2.0 or later.

By default external links will not display the normal MediaWiki icons.
To enable this, set the following:
```php
$egChameleonEnableExternalLinkIcons = true;
```
