## Release Notes

### Chameleon 1.1.4

Released on 27-May-2015

Fixes:
* Remove mw-headline-anchor
* Fix Message icon linking to non-existent page
  ([Bug: T100550](https://phabricator.wikimedia.org/T100550))

### Chameleon 1.1.3

Released on 01-Mar-2015

Bump minimum Bootstrap extension version to 1.1

Fixes:
* Set @navbar-default-link-active-bg to @navbar-default-bg color
* Bullets for ULs respond to list-style:none again 
* Align personal tools drop-down with lower edge of navbar
* Let .tleft float left 
* Let jumped-to section heads appear below fixed/sticky header 
* Add mediawiki.sectionAnchor module (for compatibility with MW 1.25)
* Fix i18n for page tools link 

Other changes:
* Minor doc fixes
* Add integration test StylesCompileTest
* Restructure test file layout 

### Chameleon 1.1.2

Released on 19-Nov-2014

Fixes:
* Load shared.css with correct remote base path, so ref'd images are found
* Display lists in File namespace without bullets
* Set padding for td.mw-label and td.mw-input to have more space in between
* Enable mw-phpunit-runner.php when started from outside dir
* Use an
  [spdx-compliant license identifier](https://getcomposer.org/doc/04-schema.md#license)
  in composer.json
* Set padding of mw-ui-input and -button on Special:Search so they have the
  same height ([Bug: 73509](https://bugzilla.wikimedia.org/73509))
* Remove table positioning from personal tools.
  ([Bug: 73514](https://bugzilla.wikimedia.org/73514))

Other changes:
* Add [detailed installation instructions for Linux](installation-linux.md)
* Introduce relative file paths throughout the skin to enable installation in
  other directories then the standard .../skins. However it still expects some
  layout assumptions to be true.
* Reorganize directories
* Refactor several components and helper classes
* Refactor Menu package (+ add some testing)

### Chameleon 1.1.1

Released on 08-Nov-2014

Fixes:
* Fix styles for Special pages
  ([Bug: 72872](https://bugzilla.wikimedia.org/72872))
* Include dataAfterContent in bodyContent
  ([Bug: 72869](https://bugzilla.wikimedia.org/72869))

Other changes:
* Some refactoring of the MainContent component

### Chameleon 1.1

Released on 06-Nov-2014

New layouts:
* __clean__: This is a minimalist layout intended for wikis that are not open
  for general editing. A use case might be a blogging platform. For users, that
  do not have edit rights, the layout will show only the main content of a wiki
  page (and the site notice, if set). For users that do have edit rights it will
  additionally show a sticky full-width navbar above, and a toolbar and an info
  footer below the main content.

New components and modifications:
* __Silent__: Does nothing. Mainly intended for internal purposes, but may also
  be used in custom layouts, e.g. as a placeholder during layout development
* __HideFor__: Modification that allows to hide the parent component if the
  condition specified by the attributes is fulfilled.
  See its [description](Components/Modifications/HideFor.md)
* __ShowOnlyFor__: Modification that allows to show the parent
  component only if the condition specified by the attributes is fulfilled.
  See its [description](Components/Modifications/ShowOnlyFor.md)

Other changes:
* Update CI test setup
* Update localisation
* Update documentation

Known issues:
* This version will identify as 1.1-alpha on Special:Version

### Chameleon 1.0.1

Released on 22-Oct-2014

Fixes:
* Fix TOC layout

Other changes:
* Add basic testing for Menu component (and fix a small bug)
* Update documentation

### Chameleon 1.0

Released on 19-Oct-2014

After nearly 1.5 years in development status, this is the first official version
of the Chameleon skin for MediaWiki.

It contains the following layouts:
* __standard__ features a big logo, a horizontal nav bar containing the
  sidebar navigation links to Main Page, Recent changes, etc. The personal tools
  (user page, preferences, etc.) and the page tools (discussion, edit, history)
  are kept as textual links above and below the nav bar. Same goes for the
  search bar, it is kept above the nav bar on the right side of the page.
* __navhead__ integrates the (now smaller) logo, page tools, personal tools,
  and the search bar in the nav bar, leading to a more content oriented look.
* __fixedhead__ takes the nav bar out of the content grid and puts it at the
  top of the page over the full width of the browser window. The nav bar stays
  fixed at its position when the page is scrolled.
* __stickyhead__ is similar to fixedhead, only it has a secondary menu bar on
  top of the main nav bar. When the page is scrolled, the secondary menu will
  scroll with the page, while the main menu will scroll only up to the upper
  window border and then stay there.

This version contains the following components:
* Cell
* Container
* FooterIcons
* FooterInfo
* FooterPlaces
* Grid
* Html
* Logo
* MainContent
* Menu
* NavbarHorizontal
* NavMenu
* NewtalkNotifier
* PageTools
* PersonalTools
* Row
* SearchBar
* SiteNotice
* Structure
* ToolbarHorizontal

Known Issues:
* The available documentation is insufficient. For now, if you have questions,
  just [ask](contact.md).
* Many of the lesser used page elements are not properly styled yet.

Compatibility:
* Tests have been run against MediaWiki 1.22 and 1.25
