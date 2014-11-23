## Customization

### Fonts and Colors

You can customize the skin by loading additional LESS files and by setting [LESS
variables](variables.md).

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


To add or change LESS variables add them to the array
`$egChameleonExternalLessVariables` in `LocalSettings.php`:
```php
$egChameleonExternalLessVariables = array(
    'key1' => 'value1',
    'key2' => 'value2',
    ...
);
```

Regardless of the order of the calls, variables will always override imported
files.

#### Example

To use the Amelia theme from [Bootswatch](http://bootswatch.com/) you could
download the `variables.less` and the `bootswatch.less` file to your MediaWiki
installation directory, rename them to `amelia-variables.less` and
`amelia-bootswatch.less` and then add the following code to your
`LocalSettings.php`:
```php
$egChameleonExternalStyleModules = array(
    __DIR__ . '/amelia-variables.less' => $wgScriptPath,
    __DIR__ . '/amelia-bootswatch.less' => $wgScriptPath,
);
```

To make the navigation bar a bit narrower you could add
```php
$egChameleonExternalLessVariables = array(
    'navbar-height' => '30px',
);
```

### Layout of page elements

The layout of the page elements (nav bar, logo, search bar, etc.) is defined in
an XML file. There are currently four pre-defined layouts available:
[standard](../layouts/standard.xml), [navhead](../layouts/navhead.xml),
[fixedhead](../layouts/fixedhead.xml) and
[stickyhead](../layouts/stickyhead.xml). They can be activated by setting the
variable `$egChameleonLayoutFile` in LocalSettings.php. E.g. to activate the
fixedhead layout you could add
```php
$egChameleonLayoutFile= __DIR__ . '/skins/chameleon/layouts/fixedhead.xml';
```

You can of course also define and use your own layout. Have a look at the
available [XML files](../layouts) to see what is possible. (Better documentation
to follow.)


### Triggering a cache update

Compiling the style files is time-consuming. For this reason the styles are
not compiled on every page request. Instead they are cached after being
compiled. For changes to the styles to become effective it is necessary to
trigger an update of the style cache. A cache update is triggered when the
`LocalSettings.php` file has a modification time later than the last cache
update time.

This can be achieved by using the `touch` utility on UNIX and friends or by
using `copy /b LocalSettings.php +,,` from the MediaWiki installation directory
on Windows. Alternatively, just open the file and re-save it.
