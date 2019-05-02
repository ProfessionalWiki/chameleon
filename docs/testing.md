## Testing

This skin provides unit tests that can be run by a [continuous integration
platform][travis] or manually using [`phpunit`][mw-testing] together with the
PHPUnit configuration file found in the root directory of the skin.

From the Chameleon installation directory run:
```sh
php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist [options]
```

Useful optional parameters:
```
--coverage-html ../../../report
--debug
```

To test against an external HTML validation service
(http://validator.w3.org/check) set the `USE_EXTERNAL_HTML_VALIDATOR` setting to
`true` in `phpunit.xml.dist`. Please be careful with their resources and use
this setting sparingly. If you do this, you may also want to set
`printerClass="Skins\Chameleon\Tests\Util\ColoringTextUIResultPrinter"` as an
additional attribute in the `phpunit` element to colorize then tests that
connect to the external service.

[travis]: https://travis-ci.org/cmln/chameleon
[mw-testing]: https://www.mediawiki.org/wiki/Manual:PHP_unit_testing

### By hand

Yes, really.

Some features are hard to test automatically and (at least for the moment) have
to be tested manually. This mostly concerns styling, where it is hard to specify
test results in a way that CI testing would pick up on failures (and more
importantly let deviations irrelevant for the test objective pass). 

Testing of the Chameleon styling is done in a two-dimensional test
space, the dimensions being

1. components and features:
	* see [Components](components.md)
	* features like Special pages, MediaWiki-specific form elements, but also
	  HTML elements etc.
2. viewport types: large screen, small screen, print, etc.

However, not all combinations need to be tested specifically, as many of them
will overlap. If the Logo looks good on a large screen, it will probably be
fine on a x-large screen. The standard collapse-point at which Chameleon switches
between collapsed and uncollapsed display of elements is at **1105 px**. The
proposed screen widths are therefore:

* XLarge: 1920px - typical desktop screen, well above the collapse point
* Large: 1150px - typical screen of a laptop or small desktop, above the collapse point
* Medium: 900px - below the collapse-point
* XSmall: 360px - phone size

| Component | xl screen (1920px) | lg screen (1150px)| md screen (900px) | xs screen (360px) | print (A4) |
|-----------------------------|--------|--------|--------|--------|--------|
| Component Container         |--------|--------|--------|--------|--------|
| Component FooterIcons       |--------|--------|--------|--------|--------|
| Component FooterInfo        |--------|--------|--------|--------|--------|
| Component FooterPlaces      |--------|--------|--------|--------|--------|
| Component Html              |--------|--------|--------|--------|--------|
| Component LangLinks         |--------|--------|--------|--------|--------|
| Component Logo              |--------|--------|--------|--------|--------|
| Component MainContent       |--------|--------|--------|--------|--------|
| Component Menu              |--------|--------|--------|--------|--------|
| Component NavbarHorizontal  |--------|--------|--------|--------|--------|
| SubComponent Logo           |--------|--------|--------|--------|--------|
| SubComponent Menu           |--------|--------|--------|--------|--------|
| SubComponent NavMenu        |--------|--------|--------|--------|--------|
| SubComponent PageTools      |--------|--------|--------|--------|--------|
| SubComponent PersonalTools  |--------|--------|--------|--------|--------|
| SubComponent PageToolsAdaptable |----|--------|--------|--------|--------|
| SubComponent SearchBar      |--------|--------|--------|--------|--------|
| Component NavMenu           |--------|--------|--------|--------|--------|
| Component NewtalkNotifier   |--------|--------|--------|--------|--------|
| Component PageTools         |--------|--------|--------|--------|--------|
| Component PageToolsAdaptable|--------|--------|--------|--------|--------|
| Component PersonalTools     |--------|--------|--------|--------|--------|
| Component SearchBar         |--------|--------|--------|--------|--------|
| Component Silent            |--------|--------|--------|--------|--------|
| Component SiteNotice        |--------|--------|--------|--------|--------|
| Component Toolbox           |--------|--------|--------|--------|--------|
| Modification HideFor        |--------|--------|--------|--------|--------|
| Modification ShowOnlyFor    |--------|--------|--------|--------|--------|
| Modification Sticky         |--------|--------|--------|--------|--------|
| Layout standard             |--------|--------|--------|--------|--------|
| Layout navhead              |--------|--------|--------|--------|--------|
| Layout fixedhead            |--------|--------|--------|--------|--------|
| Layout sticky               |--------|--------|--------|--------|--------|
| Layout clean                |--------|--------|--------|--------|--------|


| Special page | xl screen (1920px) | lg screen (1150px)| md screen (900px) | xs screen (360px) | print (A4) |
|-----------------------------|--------|--------|--------|--------|--------|
| TODO: List relevant Special pages |--------|--------|--------|--------|--------|

| MW/HTML Features | xl screen (1920px) | lg screen (1150px)| md screen (900px) | xs screen (360px) | print (A4) |
|-----------------------------|--------|--------|--------|--------|--------|
| Image (small, < 360px)      |--------|--------|--------|--------|--------|
| Image (large, > 1200px)     |--------|--------|--------|--------|--------|
| Table (general)             |--------|--------|--------|--------|--------|
| Table (infobox)             |--------|--------|--------|--------|--------|
| Heading H1                  |--------|--------|--------|--------|--------|
| Heading H2                  |--------|--------|--------|--------|--------|
| Heading H3                  |--------|--------|--------|--------|--------|
| List UL                     |--------|--------|--------|--------|--------|
| List OL                     |--------|--------|--------|--------|--------|
| Definition list             |--------|--------|--------|--------|--------|
| Indenting                   |--------|--------|--------|--------|--------|
| TODO: ... (see e.g. https://meta.wikimedia.org/wiki/Help:Advanced_editing)



