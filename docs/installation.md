## Installation, Update, De-Installation

### Requirements

- PHP 5.3.2 or later
- MediaWiki 1.22 or later
- [Composer][composer]

Further required software packages will be installed automatically.

### Installation

1. Go to your MediaWiki installation directory
2. If necessary (on MediaWiki up to 1.23) copy the file `composer.json.example` to `composer.json`  
3. With Composer installed, run `composer require "mediawiki/chameleon-skin:~1.0"`
4. __Done:__ Navigate to _Special:Version_ on your wiki to verify that the skin is successfully installed.

If you run into problems, try the
[troubleshooting](installation-troubleshooting.md).

There is also a longer, step-by-step instruction available for [installation on
Windows](installation-windows.md).

### Update

From your MediaWiki installation directory run `composer update
"mediawiki/chameleon-skin"`

To trigger a cache update it is necessary that the `LocalSettings.php` file has
a modification time later than the last cache update time. This can be achieved
by using the `touch` utility on UNIX and friends or by using
`copy /b LocalSettings.php +,,` from the MediaWiki installation directory on
Windows. Alternatively, just open the file and re-save it.

### De-installation

Before de-installation make sure you secure (move, backup) any custom files you
might want to retain.

From your MediaWiki installation directory run `composer remove
"mediawiki/chameleon-skin"`


[composer]: https://getcomposer.org/
