## Release Notes

### Chameleon 1.7.1

Released on 10-May-2018

Fixes the reported version in Special:Version.

### Chameleon 1.7

Released on 29-Apr-2018

Changes:
* (#49) Allows skins that build on top of Chameleon to set a specific layout
  file without the need to manipulate the global config variables.
  ([Robert Vogel (HalloWelt)](https://github.com/osnard)
* (#60) Add PageToolsAdaptable, an adaptable NavbarHorizontal/PageTools
  component ([Tobias Oetterer](https://github.com/oetterer))

Fixes:
* Create a stacking context on the main content to avoid elements with `z-index`
  messing up the nav elements (e.g. being shown in front of a sticky navbar
  instead of going behind it)
* (#65) Fix z-index for Echo notifications
* Remove usage of functions deprecated in MediaWiki 1.31

### Chameleon 1.6

Released on 08-Oct-2017

Changes:
* Grid: Add `mode` attribute. This allows to switch the grid to fluid mode.
  ([Robert Vogel (HalloWelt)](https://github.com/osnard)
* Allow full qualified class names as component type. This allows to use custom
  components. ([Robert Vogel (HalloWelt)](https://github.com/osnard)
* Searchbar: Add 'buttons' attribute. This allows to hide one of the Searchbar
  buttons. Allowed values are `search`, `go` and `search go`.
* Initial integration of the Echo extension. Mostly styles fixes to avoid
  breaking the skin.
* Improve documentation

Fixes:
* (#2) Fix font size and z-index of Echo popup
* (#31) The Pencil button triggers "Edit with form" when
  `$wgPageFormsRenameEditTabs` of PageForms is set
* (#32) Sticky elements now appear on top of MW Indicators
* (#34) Some MediaWiki styles (mw-headline and mw-body) interfered with
  Bootstrap styles ([Dennis Groenewegen](https://github.com/D-Groenewegen))
* (#35) Subcomponents of NavbarHorizontal have dedicated classes now and use
  the central component factory now. This allows to us Modifications on them.

### Chameleon 1.5

Released on 23-Nov-2016

Changes:
* Move from WMF server to GitHub: Updates of documentation, some scripts,
  registration with [translatewiki](https://translatewiki.net)
* Improve documentation
* Replace [jquery-sticky](https://github.com/garand/sticky) by
  [sticky-kit](http://leafo.net/sticky-kit/)
* Use sticky for the navbar of the fixedhead layout
* NavbarHorizontal: Allow custom types and classes for Navbar elements
* PersonalTools: Add attribute *hideNewtalkNotifier*
* Standard layout: Use separate NewtalkNotifier and PersonalTools components
* Add schema description for layout files: [layout.rng](../layouts/layout.rng)
* Add validation script for layout files:<br>
  Call `php maintenance/validateLayout.php <layout.xml>`
* Add composer scripts: test, phpunit, build
* Add JS linting for better code quality

Fixes:
* Javascript modules were not loading in MW 1.28+
* Logo: Link to main page when *addLink* attribute is not present

### Chameleon 1.4

Released on 20-Sep-2016

Changes:
* Logo: add *addLink* attribute to Logo component

Fixes:
* Restore "Edit with form" link for Semantic Forms 3.5 and later
* Show dropdown menus of NavBar in front of maps (Maps extension)

### Chameleon 1.3

Released on 08-Mar-2016

Changes:
* Add URL parameter 'uselayout'
* Add attributes 'showTools' and 'showLanguages' for the NavMenu
* Add attributes 'hideTools' and 'hideLanguages' for the ToolbarHorizontal
* Add support for [Page status indicators]
  (https://www.mediawiki.org/wiki/Help:Page_status_indicators)

Fixes:
* Correctly follow symlinks
  ([Bug: T124714](https://phabricator.wikimedia.org/T124714))
* Provide correct box-sizing model and z-index for VisualEditor components
* Float the VisualEditor UI toolbar below a fixed or sticky navbar

### Chameleon 1.2

Released on 16-Jan-2016

This release may break customized styles for the NavbarHorizontal component.

Changes:
* Restructured the Page Tools on Navbars: The 'Edit' action and the Page Tools'
  menu button got icons and were offset from the rest of the menus.
* 'Edit' link links to the proper Visual Editor action if the
  [VE extension](https://www.mediawiki.org/wiki/VisualEditor) is present
* 'Edit' link links to the proper Semantic Forms action if the
  [SF extension](https://www.mediawiki.org/wiki/Extension:Semantic_Forms) is
  present and `$sfgRenameEditTabs` is set
* Improve styleability of tool buttons in NavbarHorizontal (wrap the button
  label in a span) and rework styling of the buttons
* Add ChameleonNavbarHorizontalPersonalToolsLinkText hook
* Add ChameleonNavbarHorizontalNewTalkLinkText hook
* New less style variables @toolbar-height, @toolbar-padding-vertical,
  @toolbar-padding-horizontal

Fixes:
* Use variable @hr-border for color of lower border of first heading
* Some style issues for VisualEditor
* The 'Page' link was not shown in Edit mode
* Some themes (e.g. spacelab, cerulian) overrode the toolbar padding when the
  mouse hovered over links

### Chameleon 1.1.4

Released on 27-May-2015

Fixes:
* Do not show mw-headline-anchor
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
