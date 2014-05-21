From the skin's dir run

```
php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist --group skins-chameleon
```

Optional parameters:
```
--coverage-html ../../../report
--debug
```

To call an external HTML validation service (http://validator.w3.org/check) set
the `USE_EXTERNAL_HTML_VALIDATOR` setting to `true` in `phpunit.xml.dist`.
Use this sparingly.
