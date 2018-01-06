# Customization

The Chameleon skin can be highly customized. There are two main areas that you can change:

1. Layout (defined by a XML file)
2. Styles (defined by LESS files and/or LESS variables)

## Layout of page elements

The layout of the page elements (nav bar, logo, search bar, etc.) is defined in
an XML file. There are currently five pre-defined layouts available:
* [standard](../layouts/standard.xml)
* [navhead](../layouts/navhead.xml)
* [fixedhead](../layouts/fixedhead.xml)
* [stickyhead](../layouts/stickyhead.xml)
* [clean](../layouts/clean.xml)

They can be activated by setting the
variable `$egChameleonLayoutFile` in LocalSettings.php. E.g. to activate the
fixedhead layout you could add
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
$egChameleonAvailableLayoutFiles = array(
	'standard'   => __DIR__ . '/skins/chameleon/layouts/standard.xml',
	'navhead'    => __DIR__ . '/skins/chameleon/layouts/navhead.xml',
	'fixedhead'  => __DIR__ . '/skins/chameleon/layouts/fixedhead.xml',
	'stickyhead' => __DIR__ . '/skins/chameleon/layouts/stickyhead.xml',
	'clean'      => __DIR__ . '/skins/chameleon/layouts/clean.xml',
);
```

### Creating a custom layout

You can of course also define and use your own layout. To start have a look at the
[documentation of the components](components.md) and at the exisiting
[layout description files](../layouts).

## Changing styles: Fonts, Colors, Padding etc.

You can customize the styles of the skin by 
* importing additional LESS files (for example existing Bootstrap themes)
* and/or by changing existing [LESS variables](variables.md).

Regardless of the order of the calls, variables will always override imported files.

### Importing additional LESS files

To import additional LESS files, add them to the array
`$egChameleonExternalStyleModules` in `LocalSettings.php`:
```php
$egChameleonExternalStyleModules = array(
    $localPathToLESSFile1 => $remotePathToLESSFile1Directory,
    $localPathToLESSFile2 => $remotePathToLESSFile2Directory,
    ...
);
```

If your LESS file does not reference any other files (fonts, images, ...), you
may omit the remote path. Just write:
```php
$egChameleonExternalStyleModules = array( $localPathToLESSFile1, $localPathToLESSFile2, ... );
```

**Example:**

To use the Cyborg theme from [Bootswatch](http://bootswatch.com/3/) you could
download the `variables.less` and the `bootswatch.less` file to your MediaWiki
installation directory, rename them to `cyborg-variables.less` and
`cyborg-bootswatch.less` and then add the following code to your
`LocalSettings.php`:

```php
$egChameleonExternalStyleModules = array(
    __DIR__ . '/cyborg-variables.less' => $wgScriptPath,
    __DIR__ . '/cyborg-bootswatch.less' => $wgScriptPath,
);
```

You can of course define your own LESS file too: Just place it in your MediaWiki installation
directory and import it like shown above.

Remark: When downloading a theme from [Bootswatch](http://bootswatch.com/3/), make sure to
choose one that is compatible with Bootstrap 3. Themes for Bootstrap 2 or Bootstrap 4 will not work.

### Changing existing LESS variables

Chameleon comes with many LESS variables (see [this list](variables.md)). All of them have a default value. To change those values you should not edit the LESS files that come with Chameleon, because if you update Chameleon your changes will be overridden. Instead change the values of the LESS variables in your `LocalSettings.php` by adding them to the array
`$egChameleonExternalLessVariables`:

```php
$egChameleonExternalLessVariables = array(
    'key1' => 'value1',
    'key2' => 'value2',
    ...
);
```

If you add variables to the array (to change them), make sure you omit the `@` before the variable name.

Apart from the LESS variables defined in Chameleon itself, you can also change LESS variables of LESS files that you [imported yourself](#importing-additional-less-files).

**Example:**

To make the navigation bar a bit narrower you could add
```php
$egChameleonExternalLessVariables = array(
    'navbar-height' => '30px',
);
```

### Triggering a cache update

Compiling the style files is time-consuming. For this reason the styles are
not compiled on every page request. Instead they are cached after being
compiled. For changes to the styles to become effective it is necessary to
trigger an update of the style cache. There are two ways to do that:

1. A cache update is triggered when the `LocalSettings.php` file has a modification time later than the last cache update time. So you have to resave the `LocalSettings.php` to trigger a cache update. This can be achieved by using the `touch` utility on UNIX and friends or by using `copy /b LocalSettings.php +,,` from the MediaWiki installation directory on Windows. Alternatively, just open the file and re-save it.

2. If the above becomes to cumbersome, you could add the following to your `LocalSettings.php`:  
`\Bootstrap\BootstrapManager::getInstance()->addCacheTriggerFile( __DIR__ . '/your-less-file.less' );`.




