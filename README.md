# Chameleon skin
[![Build Status](https://travis-ci.org/wikimedia/mediawiki-skins-chameleon.svg?branch=master)](https://travis-ci.org/wikimedia/mediawiki-skins-chameleon)
[![Code Coverage](https://scrutinizer-ci.com/g/wikimedia/mediawiki-skins-chameleon/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/wikimedia/mediawiki-skins-chameleon/?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/wikimedia/mediawiki-skins-chameleon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wikimedia/mediawiki-skins-chameleon/?branch=master)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:chameleon-skin/badge.png)](https://www.versioneye.com/php/mediawiki:chameleon-skin)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/chameleon-skin/version.png)](https://packagist.org/packages/mediawiki/chameleon-skin)
[![Packagist download count](https://poser.pugx.org/mediawiki/chameleon-skin/d/total.png)](https://packagist.org/packages/mediawiki/chameleon-skin)

The [Chameleon skin][mw-chameleon] uses [Twitter's Bootstrap 3][twbs] to provide
a customizable MediaWiki skin.

## Requirements

- PHP 5.3.2 or later
- MediaWiki 1.22 or later
- [Composer][composer]

Further required software packages will be installed automatically.

## Installation

1. On a command line go to your MediaWiki installation directory
2. If necessary (on MediaWiki up to 1.23) copy the file `composer.json.example`
   to `composer.json`
3. With Composer installed, run
   `composer require "mediawiki/chameleon-skin:~1.0"`
4. To set Chameleon as the default skin, open `LocalSettings.php` in an editor,
   find `$wgDefaultSkin` and amend it: `$wgDefaultSkin='chameleon';`
5. __Done:__ Navigate to _Special:Version_ on your wiki to verify that the skin
   is successfully installed.

## Documentation

See the [Chameleon documentation](docs/index.md).

It may also be worthwhile to have a look at the [Chameleon site on
MediaWiki][mw-chameleon] and the related [talk page][mw-chameleon-talk]

## License

You can use the Chameleon skin under the [GNU General Public License, version
3][license] (or any later version).


[mw-chameleon]: https://www.mediawiki.org/wiki/Skin:Chameleon
[mw-chameleon-talk]: https://www.mediawiki.org/wiki/Skin_talk:Chameleon
[composer]: https://getcomposer.org/
[twbs]: http://getbootstrap.com/
[license]: https://www.gnu.org/copyleft/gpl.html
