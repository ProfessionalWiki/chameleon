## Installation, Update, De-Installation

### Requirements

- PHP 5.3.2 or later (*)
- MediaWiki 1.22 or later
- [Composer][composer]

Further required software packages will be installed automatically. It is *not*
necessary to install any dependencies anymore. Composer will take care of that.

(*) To use the *[Html](components.md#component-html)* component in [custom
layouts](customization.md#creating-a-custom-layout) you need at least PHP 5.3.6.

### Installation

If unsure try the detailed installation instructions for
[Windows](installation-windows.md) or [Linux](installation-linux.md).

Here is the short version:

1. On a command line go to your MediaWiki installation directory
4. Open the `composer.local.json` file in an editor and add the Chameleon skin
   to the `require` section:
   ```
   "require": {
       "mediawiki/chameleon-skin": "~1.0"
   }
   ```
   * Remark 1: If you do not have a `composer.local.json` file (MediaWiki <1.25),
     use `composer.json` instead.
   
   * Remark 2: If you do not have a `composer.json` file (MediaWiki <1.23.5),
     copy `composer.json.example` to `composer.json` first.
3. With Composer installed, run
   `composer update "mediawiki/chameleon-skin"`
4. To set Chameleon as the default skin, open `LocalSettings.php` in an editor,
   find `$wgDefaultSkin` and amend it: `$wgDefaultSkin='chameleon';`
5. __Done:__ Navigate to _Special:Version_ on your wiki to verify that the skin
   is successfully installed.

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
