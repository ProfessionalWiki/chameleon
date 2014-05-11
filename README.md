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

The extension provides unit tests that covers core-functionality normally run by a continues integration platform. Tests can also be executed manually using the [PHPUnit][mw-testing] configuration file found in the root directory:

Due to an existing Mediawiki dependency, the deployed `phpunit.php` should be used to ensure proper autoloading of classes during testing.
```sh
php <MW-path>/tests/phpunit/phpunit.php -c <MW-path>/skins/chameleon/phpunit.xml.dist
```

[mw-chameleon-skin]: https://www.mediawiki.org/wiki/Skin:Chameleon
[mw-bootstrap]: https://www.mediawiki.org/wiki/Extension:Bootstrap
[mw-testing]: https://www.mediawiki.org/wiki/Manual:PHP_unit_testing
[composer]: https://getcomposer.org/
