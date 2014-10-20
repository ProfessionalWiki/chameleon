## Release Notes

### Chameleon 1.0

After nearly 1.5 years in development status, this is the first official version
of the Chameleon skin for MediaWiki.

It contains the following layouts:
* __standard__ feature a big logo, a horizontal nav bar containing the 
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

Notable Issues:
* The available documentation is insufficient. For now, if you have questions,
  just [ask](contact.md).
* Many of the lesser used page elements are not properly styled yet.

Compatibility:
* Tests have been run against MediaWiki 1.22 and 1.25
