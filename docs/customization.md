## Customization

### Fonts and Colors

You can customize the skin by loading additional LESS files and by setting [LESS variables](variables.md).

To import additional LESS files, add them to the array `$egChameleonExternalStyleModules` in `LocalSettings.php`:
```php
$egChameleonExternalStyleModules = array(
    $localPathToLESSFile1 => $remotePathToLESSFile1Directory,
    $localPathToLESSFile2 => $remotePathToLESSFile2Directory,
    ...
);
```

If your LESS file does not reference any other files (fonts, images, ...), you may omit the remote path. Just write:
```php
$egChameleonExternalStyleModules = array( $localPathToLESSFile1, $localPathToLESSFile2, ... );
```


To add or change LESS variables add them to the array `$egChameleonExternalLessVariables` in `LocalSettings.php`:
```php
$egChameleonExternalLessVariables = array(
    'key1' => 'value1',
    'key2' => 'value2',
    ...
);
```

Regardless of the order of the calls, variables will always override imported files.

#### Example

To use the Amelia theme from [http://bootswatch.com/ Bootswatch] you could download the `variables.less` and the `bootswatch.less` file to your MediaWiki installation directory and rename them to `amelia-variables.less` and `amelia-bootswatch.less`. You then add the following code to your `LocalSettings.php`:
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

The layout of the page elements (nav bar, logo, search bar, etc.) is defined inan XML file. There are currently four pre-defined layouts available: standard, navhead, fixedhead and stickyhead. They can be activated by setting the variable `$egChameleonLayoutFile` in LocalSettings.php. E.g. to activate the fixedhead layout you could add
```php
$egChameleonLayoutFile= __DIR__ . '/skins/chameleon/layouts/fixedhead.xml';
```

You can of course also define and use your own layout. Have a look at the available [XML files](../layouts) to see what is possible. (Better documentation to follow.)
