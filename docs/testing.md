## Testing

This skin provides unit tests that can be run by a [continues integration
platform][travis] or manually by executing the `mw-phpunit-runner.php` script or
[`phpunit`][mw-testing] together with the PHPUnit configuration file found in
the root directory of the skin.

```sh
php mw-phpunit-runner.php [options]
```

Useful optional parameters:
```
--coverage-html ../../../report
--debug
```

To test against an external HTML validation service
(http://validator.w3.org/check) set the `USE_EXTERNAL_HTML_VALIDATOR` setting to
`true` in `phpunit.xml.dist`. Please be careful with their resources and use
this setting sparingly.


[travis]: https://travis-ci.org/wikimedia/mediawiki-skins-chameleon
[mw-testing]: https://www.mediawiki.org/wiki/Manual:PHP_unit_testing
