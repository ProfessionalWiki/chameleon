## Installation, Update, De-Installation

### Requirements

- PHP 7.1 or later
- MediaWiki 1.31 or later

### Installation

There are two methods for installing Chameleon: with or without [Composer][composer].

If you install Chameleon with Composer, further required software packages will be installed
automatically. In this case, it is *not* necessary to install any dependencies. Composer will
take care of that.

If you install Chameleon without Composer, you will need to install and enable the
[Bootstrap extension][bootstrap] before you install and enable Chameleon.

If unsure try the detailed installation instructions for
[Windows](installation-windows.md) or [Linux](installation-linux.md).

Here is the short version:

#### Installation with Composer

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

#### Installation without Composer

1. Install and enable the [Bootstrap][bootstrap] extension.

2. [Download][download] Chameleon and place the file(s) in a directory called Chameleon in your
    skins/ folder.

3. Add the following code at the bottom of your LocalSettings.php:

   ```php
   wfLoadSkin( 'Chameleon' );
	```

   To set Chameleon as the default skin, find `$wgDefaultSkin` and amend it:
   ```php
   $wgDefaultSkin='chameleon';
   ```

4. __Done:__ Navigate to _Special:Version_ on your wiki to verify that the skin
   is successfully installed.

### Update with Composer

From your MediaWiki installation directory run `composer update
"mediawiki/chameleon-skin"`

### De-installation with Composer

Before de-installation make sure you secure (move, backup) any custom files you
might want to retain.

Remove the Chameleon skin from the `composer.local.json` file. Then run
`composer update "mediawiki/chameleon-skin"` from the MediaWiki installation
directory.

[composer]: https://getcomposer.org/
[bootstrap]: https://www.mediawiki.org/wiki/Extension:Bootstrap
[download]: https://github.com/ProfessionalWiki/chameleon/archive/master.zip
