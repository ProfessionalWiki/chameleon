## Release Notes

### Chameleon 4.3.0

Released on November 26, 2023.

* Fixed deprecated Hooks usage for MediaWiki 1.40 (thanks @malberts)
* Added `showActive` parameter for highlighting the current page in the `NavMenu` component (thanks @malberts)

### Chameleon 4.2.1

Released on January 30, 2023.

* Fixed deprecated external link icons for MediaWiki 1.39 (thanks @malberts)
* Fixed deprecated ResourceLoaderSkinModule features for MediaWiki 1.39 (thanks @malberts)

### Chameleon 4.2.0

Released on January 26, 2023.

Note: This release improves compatibility with MediaWiki 1.39, however some deprecated MediaWiki CSS resources are missing and will be addressed in a future release.

* Extracted `Indicators`, `ContentHeader`, `ContentBody` and `CategoryLinks` sub-components from `MainContent` component (thanks @gesinn-it-wam)
* Fixed navbar whitespace issue (thanks @mdoggydog)
* For `PersonalTools` component used within `NavbarHorizontal`, changed the set of allowed values to `none`, `try-realname`, and `username-only` (new).  `no` and `yes` are deprecated but still accepted for backwards compatibility. (thanks @mdoggydog)
* Added `NavMenu` component dropdown classes and title attribute (thanks @mdoggydog)
* Fixed navbar link alignment (thanks @mdoggydog)
* Added `ChameleonNavbarHorizontalPersonalToolsLinkInnerHtml` hook, which allows customizing the inner HTML of the dropdown link of the `PersonalTools` component (thanks @mdoggydog)
* Added `promoteLoneItems` parameter for showing a single link instead of a dropdown in the `PersonalTools` component (thanks @mdoggydog)
* Added `include` and `exclude` parameters for displaying only specific menu sections in the `NavMenu` component (thanks @mdoggydog)
* Added `xxl` breakpoint (thanks @gesinn-it-gea)
* Fixed a MediaWiki 1.39 deprecation (thanks @jdlrobson)

### Chameleon 4.1.0

Released on March 30, 2022.

* Added support for responsive containers on the `Grid` component (thanks @chrisrishel)
* Fixed Mediawiki 1.38 hard deprecations (thanks @malberts)
* Fixed Bootstrap 4.6.1 compatibility (thanks @malberts)
* Updated FontAwesome to 5.15.4 (thanks @malberts)

### Chameleon 4.0.1

Released on March 18, 2022.

* Added PHP 8.1 compatibility (thanks @JeroenDeDauw)
* Fixed WikiEditor sizing (thanks Laurent Mischler)
* Translation updates for system messages (thanks @translatewiki and its translator community)

### Chameleon 4.0.0

Released on January 18, 2022.

* Raised minimum Bootstrap extension version from 4.2 to 4.5
* Raised minimum MediaWiki version from 1.31 to 1.35
* Raised minimum PHP version from 7.1 to 7.4.3
* Fixed MediaWiki 1.37 compatibility issues (thanks @malberts)
* Added `ChameleonGetLayoutXml` hook, which allows altering the layout XML (thanks @JeroenDeDauw)
* Added `CategoryLinks` component to display category links separate from the `MainContent` component (thanks @malberts)

### Chameleon 3.4.3

Released on March 30, 2022.

* Fixed Bootstrap 4.6.1 compatibility (thanks @malberts)

### Chameleon 3.4.2

Released on March 18, 2022.

* Fixed WikiEditor sizing (thanks Laurent Mischler)
* Translation updates for system messages (thanks @translatewiki and its translator community)

### Chameleon 3.4.1

Released on September 16, 2021.

* Fixed scssphp 1.7.0 compatibility (@thanks malberts)

### Chameleon 3.4.0

Released on August 7, 2021.

* Added `Message` component to display system messages (thanks @malberts)
* Added `PersonalTools` component user name display support via the new `showUserName` attribute (thanks @malberts)
* Fixed `Toolbox` component PHP notice (thanks @WouterRademaker and @malberts)
* Translation updates for system messages (thanks @translatewiki and its translator community)

### Chameleon 3.3.0

Released on June 20, 2021.

* Fixed MediaWiki 1.31 compatibility
* Added `NavbarHorizontal` component toggler text support via the new `showTogglerText` attribute (thanks @malberts)
* Added `id` attribute to structure components: `Grid`, `Row`, `Cell` and `Container` (thanks @malberts)

### Chameleon 3.2.1

Released on June 3, 2021.

Warning: This release contains a regression that causes incompatibility with MediaWiki 1.31.

* Fixed `LangLinks` component PHP notice (thanks @WouterRademaker)

### Chameleon 3.2.0

Released on June 2, 2021.

Warning: This release contains a regression that causes incompatibility with MediaWiki 1.31.

* Improved Echo support in the `PersonalTools` components (thanks @malberts)
* Added theme support via the new `ChameleonThemeFile` setting (thanks @malberts)
* Added grid breakpoint override support via the new `$cmln-grid-breakpoints` SCSS variable (thanks @malberts)
* Improved MultimediaViewer extension support (requires [cache update](https://github.com/malberts/chameleon/blob/issue-178/docs/customization.md#triggering-a-cache-update)) (thanks @malberts)
* Added external link icons support via the new `ChameleonEnableExternalLinkIcons` setting (thanks @malberts)
* Fixed layout and scroll issues when using the sticky menu and clicking anchor links (thanks @vedmaka)
* Fixed display of some icons (thanks @malberts and @WouterRademaker)
* Updated Font Awesome and hc-sticky libraries (thanks @malberts)
* Fixed Mediawiki 1.35 deprecations (thanks @jdlrobson and @malberts)
* Fixed Mediawiki 1.35 missing menu icons (thanks @WouterRademaker)

### Chameleon 3.1.0

Released on September 24, 2020.

* Fixed deprecation notice about `Sanitizer::escapeId` occuring on recent MediaWiki versions (thanks @JeroenDeDauw)
* Fixed formatting of definition lists (thanks @kghbln)
* Added `ChameleonSkinTemplateOutputPageBeforeExec` hook (thanks @jdlrobson)
* Translation updates for system messages (thanks @translatewiki and its translator community)

### Chameleon 3.0.1

Released on June 12, 2020.

* Fixed dependency error with Bootstrap 4.2.1 and later (thanks @JeroenDeDauw)

### Chameleon 3.0.0

Released on May 20, 2020.

* Breaking change: the Bootstrap extension now needs to be enabled manually (`wfLoadExtension` in `LocalSettings.php`)
* Added support for installation without Composer (thanks @cicalese)
* Added `placeholder` option to the `SearchBar` component (thanks @JeroenDeDauw)
* Added toolbox icon for Special:RecentChanges (thanks @JeroenDeDauw)

### Chameleon 2.3.0

Released on May 5, 2020.

* Fixed text color issue in the navbar (thanks @bertvandepoel)
* Fixed spacing issue in the `Menu` component (thanks @JeroenDeDauw)
* Added edit icon to the Visual Editor edit action in the navbar (thanks @JeroenDeDauw)
* Added `hideDiscussionLink` option to the `PageTools` component (thanks @JeroenDeDauw)

### Chameleon 2.2.0

Released on March 25, 2020.

* Raised minimum PHP version from 7.0 to 7.1

### Chameleon 2.1.0

Released on July 16, 2019.

Changes:
* Add Font-Awesome Brands font

Fixes:
* ([#87](https://github.com/ProfessionalWiki/chameleon/issues/87)) Show formedit button on the navbar
* ([#89](https://github.com/ProfessionalWiki/chameleon/issues/89)) Show default icon for unknown page tools on the navbar
* ([#91](https://github.com/ProfessionalWiki/chameleon/issues/91)) Ensure mediawiki.skinning.content module is loadable

### Chameleon 2.0

Released on May 9, 2019.

Changes:
* Support
  * MediaWiki 1.31.0 and later
  * PHP 7.0 and later
* Use [Bootstrap 4](https://getbootstrap.com/docs/4.3)
* Use [SCSS](https://sass-lang.com/) for styling
* Use [Font-Awesome](https://fontawesome.com/) instead of Glyphicons
* Use MediaWiki's new skin registration mechanism (i.e. `wfLoadSkin`)
* Add [Toolbox] component, which allows to add the toolbox links (e.g. What
  links here, Related changes, ...) to a [NavbarHorizontal].
* Add [LangLinks] component, which allows to add language links to a
  [NavbarHorizontal].
* Remove [ToolbarHorizontal] component. You can use [NavbarHorizontal] instead
  with the new components [Toolbox] and [LangLinks].
* Remove the [PageToolsAdaptable]() component. It's functionality is now
  available from the regular [PageTools] component.
* Add _buttons_ attribute to the [PageTools] component.
* Remove attributes _showTools_ and _showLanguages_ from the [NavMenu]
  component. You can use the new components [Toolbox] and [LangLinks] instead.
* Improve the [Menu] component to allow setting a class string on the menu item
  link. This can be used to show an icon in front of a menu item.
* Remove button for fulltext search from [Searchbar].
* Rename `$egChameleonExternalLessVariables` to `$egChameleonExternalStyleVariables`
* New variable `$egScssCacheType`

[ToolBox]: components.md#component-toolbox
[LangLinks]: components.md#component-langlinks
[PageTools]: components.md#component-pagetools
[Menu]: components.md#component-menu
[NavbarHorizontal]: components.md#component-NavbarHorizontal
[ToolbarHorizontal]: components.md#component-ToolbarHorizontal
[Searchbar]: components.md#component-searchbar
[NavMenu]: components.md#component-navmenu

### Chameleon 1.7.1

Released on May 10, 2018.

Fixes the reported version in Special:Version.

### Chameleon 1.7

Released on April 29, 2018.

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

Released on October 8, 2017.

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

Released on November 23, 2016.

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

Released on September 20, 2016.

Changes:
* Logo: add *addLink* attribute to Logo component

Fixes:
* Restore "Edit with form" link for Semantic Forms 3.5 and later
* Show dropdown menus of NavBar in front of maps (Maps extension)

### Chameleon 1.3

Released on March 8, 2016.

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

Released on January 16, 2016.

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

Released on May 27, 2015.

Fixes:
* Do not show mw-headline-anchor
* Fix Message icon linking to non-existent page
  ([Bug: T100550](https://phabricator.wikimedia.org/T100550))

### Chameleon 1.1.3

Released on March 1, 2015.

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

Released on November 19, 2014.

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

Released on November 8, 2014.

Fixes:
* Fix styles for Special pages
  ([Bug: 72872](https://bugzilla.wikimedia.org/72872))
* Include dataAfterContent in bodyContent
  ([Bug: 72869](https://bugzilla.wikimedia.org/72869))

Other changes:
* Some refactoring of the MainContent component

### Chameleon 1.1

Released on November 6, 2014.

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

Released on October 22, 2014.

Fixes:
* Fix TOC layout

Other changes:
* Add basic testing for Menu component (and fix a small bug)
* Update documentation

### Chameleon 1.0

Released on October 19, 2014.

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
  just [ask](../README.md).
* Many of the lesser used page elements are not properly styled yet.

Compatibility:
* Tests have been run against MediaWiki 1.22 and 1.25
