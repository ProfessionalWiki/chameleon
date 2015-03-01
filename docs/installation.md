## Installation, Update, De-Installation

### Requirements

- PHP 5.3.2 or later (*)
- MediaWiki 1.22 or later
- [Composer][composer]

Further required software packages will be installed automatically.

(*) To use the 'Html' component in custom layouts you need at least PHP 5.3.6. 

### Installation

If unsure try the detailed installation instructions for
[Windows](installation-windows.md) or [Linux](installation-linux.md).

Here is the short version:

1. On a command line go to your MediaWiki installation directory
2. If necessary (on MediaWiki up to 1.23) copy the file `composer.json.example`
   to `composer.json`
3. With Composer installed, run
   `composer require "mediawiki/chameleon-skin:~1.0"`
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

From your MediaWiki installation directory run `composer remove
"mediawiki/chameleon-skin"`

[composer]: https://getcomposer.org/
