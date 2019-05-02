## Installation, Update, De-Installation

### Requirements

- PHP 7.0 or later
- MediaWiki 1.31 or later
- [Composer][composer]

Further required software packages will be installed automatically. It is *not*
necessary to install any dependencies. Composer will take care of that.

### Installation

If unsure try the detailed installation instructions for
[Windows](installation-windows.md) or [Linux](installation-linux.md).

Here is the short version:

1. On a command line go to your MediaWiki installation directory

2. Open the `composer.local.json` file in an editor and add the Chameleon skin
   to the `require` section:
   ```
   "require": {
       "mediawiki/chameleon-skin": "~2.0"
   }
   ```
   
   **Remark:** If you do not have a `composer.local.json` file, but a
   `composer.local.json-sample`, rename the `-sample` file and add the
   `"require"` section.
   
3. With Composer installed, run
   `composer update "mediawiki/chameleon-skin"`
   
4. Open `LocalSettings.php` in an editor, and add the following line:

   ```php
   wfLoadSkin( 'chameleon' );
	```

   To set Chameleon as the default skin, find `$wgDefaultSkin` and amend it:
   ```php
   $wgDefaultSkin='chameleon';
   ```
5. __Done:__ Navigate to _Special:Version_ on your wiki to verify that the skin
   is successfully installed.

**Remark:** It is _NOT_ necessary to install or load any extensions this skin
depends on.

If you run into problems, try the
[troubleshooting](installation-troubleshooting.md).

### Update

From your MediaWiki installation directory run `composer update
"mediawiki/chameleon-skin"`

### De-installation

Before de-installation make sure you secure (move, backup) any custom files you
might want to retain.

Remove the Chameleon skin from the `composer.local.json` file. Then run
`composer update "mediawiki/chameleon-skin"` from the MediaWiki installation
directory.

[composer]: https://getcomposer.org/
