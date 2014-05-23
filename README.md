# Chameleon skin
[![Build Status](https://travis-ci.org/wikimedia/mediawiki-skins-chameleon.svg?branch=master)](https://travis-ci.org/wikimedia/mediawiki-skins-chameleon)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/chameleon-skin/version.png)](https://packagist.org/packages/mediawiki/chameleon-skin)
[![Packagist download count](https://poser.pugx.org/mediawiki/chameleon-skin/d/total.png)](https://packagist.org/packages/mediawiki/chameleon-skin)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:chameleon-skin/badge.png)](https://www.versioneye.com/php/mediawiki:chameleon-skin)

The [Chameleon skin][mw-chameleon-skin] uses Twitter's Bootstrap to provide a customizable mediawiki skin.

## Requirements

- PHP 5.3.2 or later
- MediaWiki 1.22 or later
- [Bootstrap extension][mw-bootstrap] 1.0 or later

## Installation

The recommended way to install this skin is by using [Composer][composer]. Just add the following to the MediaWiki `composer.json` file and run the `php composer.phar install/update` command.

```json
{
	"require": {
		"mediawiki/chameleon-skin": "~1.0"
	}
}
```

## Tests

This extension provides unit tests that can be run by a [continues integration platform][travis] or manually by executing the `mw-phpunit-runner.php` script or [`phpunit`][mw-testing] together with the PHPUnit configuration file found in the root directory.

```sh
php mw-phpunit-runner.php [options]
```

## License

[GNU General Public License 3.0][license].

[mw-chameleon-skin]: https://www.mediawiki.org/wiki/Skin:Chameleon
[mw-bootstrap]: https://www.mediawiki.org/wiki/Extension:Bootstrap
[mw-testing]: https://www.mediawiki.org/wiki/Manual:PHP_unit_testing
[composer]: https://getcomposer.org/
[travis]: https://travis-ci.org/wikimedia/mediawiki-skins-chameleon
[license]: https://www.gnu.org/copyleft/gpl.html
