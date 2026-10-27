## Installation, Update, De-Installation

### Requirements

- PHP 8.1.0 or later (tested up to PHP 8.5)
- MediaWiki 1.43 or later (tested up to MediaWiki 1.47)
- [Composer][composer]

### Installation

Further required software packages will be installed automatically. It is *not*
necessary to install any dependencies. Composer will take care of that.

If unsure try the detailed installation instructions for
[Windows](installation-windows.md) or [Linux](installation-linux.md).

Here is the short version:

#### Installation

On a command line go to your MediaWiki installation directory and run these two commands

```
COMPOSER=composer.local.json composer require --no-update mediawiki/chameleon-skin:~6.0
```
```
composer update mediawiki/chameleon-skin --no-dev -o
```

Then, open `LocalSettings.php` in an editor, and add the following lines:


```php
wfLoadExtension( 'Bootstrap' );
wfLoadSkin( 'chameleon' );
```

Optional: to set Chameleon as the default skin, find `$wgDefaultSkin` and amend it:

```php
$wgDefaultSkin='chameleon';
```

Save the file. To verifying Chameleon was installed correctly, navigate to _Special:Version_ on your wiki.

If you run into problems, try the
[troubleshooting](installation-troubleshooting.md).

### Update

From your MediaWiki installation directory run `composer update "mediawiki/chameleon-skin" --no-dev -o`

If you want to upgrade from Chameleon 5.x to 6.x, first read the [migration guide](migration.md), then edit
`composer.local.json`. Change `"mediawiki/chameleon-skin": "~5.0"` to `"mediawiki/chameleon-skin": "~6.0"`.

### De-installation

Before de-installation make sure you secure (move, backup) any custom files you
might want to retain.

Remove the Chameleon skin from the `composer.local.json` file. Then run
`composer update "mediawiki/chameleon-skin"` from the MediaWiki installation
directory.

[composer]: https://getcomposer.org/
