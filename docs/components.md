## Components & Modifications

Components are the building blocks of any layout. They are the functional units
of the website, like the logo or the navigation bar. There are also four special
component types - structure, grid, row and cell - that define the general layout
of the page and assign the other components their place on the page.
Modifications can be added to most components to change their general behavior.

The following components and modifications are available:
<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [`Structure`](#structure)
- [`Grid`](#grid)
- [`Row`](#row)
- [`Cell`](#cell)
- [Component `CategoryLinks`](#component-categorylinks)
- [Component `Container`](#component-container)
- [Component `ContentBody`](#component-contentbody)
- [Component `ContentHeader`](#component-contentheader)
- [Component `FooterIcons`](#component-footericons)
- [Component `FooterInfo`](#component-footerinfo)
- [Component `FooterPlaces`](#component-footerplaces)
- [Component `Html`](#component-html)
- [Component `Indicators`](#component-indicators)
- [Component `LangLinks`](#component-langlinks)
- [Component `Logo`](#component-logo)
- [Component `MainContent`](#component-maincontent)
- [Component `Menu`](#component-menu)
- [Component `Message`](#component-message)
- [Component `NavbarHorizontal`](#component-navbarhorizontal)
- [Component `NavMenu`](#component-navmenu)
- [Component `NewtalkNotifier`](#component-newtalknotifier)
- [Component `PageTools`](#component-pagetools)
- [Component `PersonalTools`](#component-personaltools)
- [Component `SearchBar`](#component-searchbar)
- [Component `Silent`](#component-silent)
- [Component `SiteNotice`](#component-sitenotice)
- [Component `Toolbox`](#component-toolbox)
- [Modification `HideFor`](#modification-hidefor)
- [Modification `ShowOnlyFor`](#modification-showonlyfor)
- [Modification `Sticky`](#modification-sticky)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

### `Structure`

The root element of any layout.

#### Example usage

``` xml
<structure xmlns="https://github.com/ProfessionalWiki/chameleon/layout/1.0">
  ...
</structure>
```

#### Attributes:
* `xmlns`:
  * Allowed values: URI of XML namespace definition
  * Optional.

  Ignored by the skin itself, but may be specified to validate the layout. See
  [Layouts](layouts.md).

#### Allowed Parent Elements:
None.

#### Allowed Child Elements:
* [Grid](#grid)
* Any component

-------------------------------------------------------------------------------
### `Grid`

The grid system is used for creating page layouts through a series of rows and
cells. While it is possible to place components outside of a grid it is not
recommended.

#### Example usage

``` xml
<grid>
  ...
</grid>
```

#### Attributes:
* `mode`:
  * Allowed values: String (`fixedwidth`|`fluid`|`sm`|`md`|`lg`|`xl`|`xxl`)
  * Default: `fixedwidth`
  * Optional.

  Use `fixedwidth` for a responsive fixed width layout. Use `fluid` for a full
  width layout, spanning the entire width of the viewport.

  Use a breakpoint name for a responsive container (since Chameleon 4.1.0).

* `id`:
  * Since Chameleon 3.3.0
  * Allowed values: Any string
  * Default: -
  * Optional.

  The id that should be assigned to the grid element.

* `class`:
  * Allowed values: Any string
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the grid element.


#### Allowed Parent Elements:
* [Structure](#structure)

#### Allowed Child Elements:
* [Row](#row)
* Any modification

-------------------------------------------------------------------------------
### `Row`

Use rows to create horizontal groups of cells. Content should be placed within
cells, and only cells may be immediate children of rows.

#### Example usage

``` xml
<row>
  ...
</row>
```

#### Attributes:
* `id`:
  * Since Chameleon 3.3.0
  * Allowed values: Any string
  * Default: -
  * Optional.

  The id that should be assigned to the row element.

* `class`:
  * Allowed values: Any string
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the row element.


#### Allowed Parent Elements:
* [Grid](#grid)

#### Allowed Child Elements:
* [Cell](#cell)
* Any modification

-------------------------------------------------------------------------------
### `Cell`

Holds components.

#### Example usage

``` xml
<cell>
  ...
</cell>
```

#### Attributes:
* `id`:
  * Since Chameleon 3.3.0
  * Allowed values: Any string
  * Default: -
  * Optional.

  The id that should be assigned to the cell element.

* `class`:
  * Allowed values: Any string
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the cell element.


#### Allowed Parent Elements:
* [Row](#row)

#### Allowed Child Elements:
* [Row](#row)
* Any component
* Any modification

-------------------------------------------------------------------------------
### Component `CategoryLinks`

Displays category links.

Since Chameleon 4.0.0

#### Example usage

Hide category links on the `MainContent` component and add the `Categorylinks`
component separately:

``` xml
<component type="MainContent" hideCatLinks="yes" />
<!-- other components -->
<component type="CategoryLinks" />
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Container`

This component will wrap its content elements in a `<div>`. It may be used to
assign a CSS id or class for styling purposes.

#### Example usage

``` xml
<component type="Container" class="foo bar">
  ...
</component>
```

#### Attributes:
* `id`:
  * Since Chameleon 3.3.0
  * Allowed values: Any string
  * Default: -
  * Optional.

  The id that should be assigned to the `<div>` element.

* `class`:
  * Allowed values: Any string
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the `<div>` element.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any component
* Any modification

-------------------------------------------------------------------------------
### Component `ContentBody`

Allows to display the content body independently of the [MainContent](#component-maincontent).

Since Chameleon 4.2.0

#### Example usage

``` xml
<component type="ContentBody" />
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `ContentHeader`

Allows to display the content header independently of the [MainContent](#component-maincontent).

Since Chameleon 4.2.0

#### Example usage

``` xml
<component type="ContentHeader" />
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `FooterIcons`

A list containing the "powered by" icons.

#### Example usage

``` xml
<component type="FooterIcons"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `FooterInfo`

A list of footer items (last modified time, view count, number of watching
users, credits, copyright). Does not include so called places (about, privacy
policy, and disclaimer links).

#### Example usage

``` xml
<component type="FooterInfo"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `FooterPlaces`

A list containing links to places (about, privacy policy, and disclaimer links).

#### Example usage

``` xml
<component type="FooterPlaces"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Html`

This component allows insertion of raw HTML into the page.

#### Example usage


``` xml
<component type="Html"><![CDATA[
  <b>Hello World!</b>
]]></component>
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Indicators`

Allows to display the indicators independently of the [MainContent](#component-maincontent).

Since Chameleon 4.2.0

#### Example usage

``` xml
<component type="Indicators" />
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `LangLinks`

[Language links](https://www.mediawiki.org/wiki/Interlanguage_links) are links
which connect an article with related articles in other languages within the
same Wiki family.

See also: [Manual:Interwiki](https://www.mediawiki.org/wiki/Manual:Interwiki#Interwiki_links_to_other_languages)

#### Example usage

``` xml
<component type="LangLinks" />
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `flatten`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Whether the list of languages should be flattened, i.e. its items should
  appear not in a submenu, but as elements of the top structure.


#### Allowed Parent Elements:
<!-- * [Structure](#structure) -->
<!-- * [Cell](#cell) -->
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Logo`

The Logo component displays the logo of the wiki as defined in `$wgLogo`.

The alternative text of the image is set to the sitename of the wiki as defined
in `$wgSitename`. Depending on the `addLink` attribute the logo may link to the
main page of the wiki. The name of the main page of the wiki is defined in the
`mainpage` message and can thus be modified on the `Mediawiki:Mainpage` page of
the wiki.

#### Example usage

``` xml
<component type="Logo" addLink="yes" />
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `addLink`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `yes`
  * Optional.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `MainContent`

The main content of the page, the wiki article itself.

Includes:
* Title: title of the page
* Subtitle: used for various things like the subpage hierarchy
* Tagline: usually something like "From WikiName", hidden by default, used for printing
* Undelete message
* [Page status indicators](https://www.mediawiki.org/wiki/Help:Page_status_indicators):  icons that provide quick information about the status of the article
* Article text
* Data after content: Additional text block useable by extensions
* Category links

#### Example usage

``` xml
<component type="MainContent"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.
* `hideIndicators`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Hide the indicators. Use in conjunction with the [Indicators](#component-indicators)
  component to display the indicators elsewhere.
* `hideContentHeader`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Hide the content header. Use in conjunction with the [ContentHeader](#component-contentheader)
  component to display the header elsewhere.
* `hideContentBody`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Hide the content body. Use in conjunction with the [ContentBody](#component-contentbody)
  component to display the body elsewhere.
* `hideCatLinks`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Hide the category links. Use in conjunction with the [CategoryLinks](#component-categorylinks)
  component to display the links elsewhere.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Menu`

An additional menu.

The structure of the menu can be specified either in a [MediaWiki
message](https://www.mediawiki.org/wiki/Help:System_message) or directly in the
layout file. The format is the same as that of the [MediaWiki
sidebar](https://www.mediawiki.org/wiki/Manual:Interface/Sidebar), except that a
third component is allowed that can contain a class string that should be set on
the menu item link. This can be used to show an icon in front of the menu item.

This component is intended to be used inside a
[NavbarHorizontal](#component-navbarhorizontal) component. It will work in other
places, but will require additional styling effort.

#### Example usage

Using the message _MediaWiki:Secondary-menu_:
``` xml
<component type="Menu" message="secondary-menu" />
```

Using an inline description:
``` xml
<component type="Menu" >
  * SomeMenuLabel
  ** SomeMenuItem
  * # | AnotherMenuLabel | fas fa-egg
  ** SomeURL | SomeMenuItemLabel | fas fa-splotch
</component>
```

#### Attributes:
* `message`
  * Allowed values: String
  * Default: -
  * Optional.

  The name of the MediaWiki message that holds the menu description.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Message`

Displays a [MediaWiki message](https://www.mediawiki.org/wiki/Help:System_message).

Since Chamaleon 3.4.0

#### Example usage

To display the message _MediaWiki:MyMessage_:

``` xml
<component type="Message" name="MyMessage" />
```

#### Attributes:
* `name`:
  * Allowed values: String
  * Default: -

  The message name without the _MediaWiki:_ prefix.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `NavbarHorizontal`

A horizontal navbar that takes its contents from its child elements.

#### Example usage

From [navhead.xml](../layouts/navhead.xml):
``` xml
<component type="NavbarHorizontal">
	<component type="Logo" position="head"/>
	<component type="NavMenu" flatten="navigation" showTools="no" showLanguages="no"/>
	<component type="PageTools" position="right" hideSelectedNameSpace="yes"/>
	<component type="SearchBar" position="right"/>
	<component type="PersonalTools" position="right"/>
</component>
```

Add "Menu" text next to the toggler button:
``` xml
<component type="NavbarHorizontal" showTogglerText="yes">
	<!-- ... -->
</component>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `collapsible`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `yes`

  If the navbar shall collapse on small screens.

* `fixed`:
  * **Deprecated.** Use the [Sticky](#modification-sticky) modification instead.
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`

* `showTogglerText`:
  * Since Chameleon 3.3.0
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Displays text next to the toggler icon. The text is defined in the system message `chameleon-toggler`.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Component [`Logo`](#component-logo)
* Component [`Menu`](#component-menu)
* Component [`NavMenu`](#component-navmenu)
* Component [`PageTools`](#component-pagetools)
* Component [`PersonalTools`](#component-personaltools)
* Component [`SearchBar`](#component-searchbar)
* Any modification

-------------------------------------------------------------------------------
### Component `NavMenu`

A menu containing the
[sidebar](https://www.mediawiki.org/wiki/Manual:Interface/Sidebar) items.

Does not include the search bar. Toolbox and language links can be included
optionally.

This component is intended to be used inside a
[NavbarHorizontal](#component-navbarhorizontal) component. It will work in other
places, but will require additional styling effort.

#### Example usage

Using the message _MediaWiki:Secondary-menu_:
``` xml
<component type="NavMenu" flatten="navigation"/>
```

#### Attributes:
* `flatten`
  * Allowed values: String
  * Default: -
  * Optional.

  A semicolon-separated list of section names that are to be flattened, i.e.
  whose menu items should appear not in a submenu, but as elements of the top
  structure.

  A comma-separated list may also be given in the message
  _MediaWiki:skin-chameleon-navmenu-flatten_ instead. If both the message and
  this attribute are found, the message takes precedence.

* `include`
  * Allowed values: String
  * Default: -
  * Optional.

  A semicolon-separated list of section names that are to be included exclusively;
  i.e., if this parameter is supplied, then only the sections in this list will be
  rendered.

* `exclude`
  * Allowed values: String
  * Default: -
  * Optional.

  A semicolon-separated list of section names that are to be excluded;
  i.e., if this parameter is supplied, then the sections in this list will not
  be rendered.

  `exclude` takes priority over `include`.  It does not make much sense to use
  both attributes in the same `NavMenu` instance, but it can make sense to use
  them separately in complementary instances.

* `showActive`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  If set the menu link for the current page will be highlighted.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `NewtalkNotifier`

A message to a user about new messages on their talkpage. Usually goes something
like "You have [a new message]() ([last change]())."

#### Example usage

``` xml
<component type="NewtalkNotifier"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `PageTools`

A component containing content navigation links (Page, Discussion, Edit,
History, Move, ...)

#### Example usage

``` xml
<component type="PageTools" buttons="ve-edit,history"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `hideSelectedNameSpace`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  If set the link to the current page will not be shown among the page tools.

* `hideDiscussionLink`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  If set the link to the discussion page will not be shown among the page tools.

* `buttons`
  * Allowed values: String
  * Default: `edit`
  * Optional.

  The actions that will be shown as a button on the navbar directly. They will
  also be removed from the PageTools drop-down.

  This attribute will be ignored if the PageTools are not a child element of a
  NavbarHorizontal.

  Among others, possible actions are:

    * delete
    * edit
    * formedit
    * history
    * move
    * protect
    * purge
    * talk
    * undelete
    * unprotect
    * unwatch
    * ve-edit
    * view
    * watch

  Note that button for actions, that are not valid for a given page will be
  omitted automatically. So in the above example, the visual-editor edit action
  button will only be shown for pages in a valid visual-editor namespace.

  Note also, that the buttons will be shown in the order provided in
  the `buttons` attribute. In the example above, history would
  be the last action right before the ellipsis.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

#### Integration with VisualEditor
Visual Editor has a late-executed javascript function, that replaces the content of certain page tool
action links. Unfortunately, that also concerns corresponding buttons, you indicated to show.

The solution is to remove the corresponding tab messages from the Visual Editor configuration in your
LocalSettings.php. So for example:
```$php
    wfLoadExtension( 'VisualEditor' );
    $wgVisualEditorTabMessages['editsource'] = null;
    $wgVisualEditorTabMessages['createsource'] = null;
```

-------------------------------------------------------------------------------
### Component `PersonalTools`

A component containing the personal tools like link to user page and user's talk
page, preferences, watchlist, etc. Also shows the new talk notifier, when
applicable.

#### Example usage

``` xml
<component type="PersonalTools"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `hideNewtalkNotifier`
  * **Deprecated.**
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  If set the newtalk notifier will not be shown.

  This attribute has no effect when used inside the
  [NavbarHorizontal](#component-navbarhorizontal) component.

  This attribute was introduced to keep backwards compatibility. If the
  PersonalTools component is used, it is recommended to always set this
  attribute to *yes* and use an independent
  [NewtalkNotifier](#component-newtalknotifier) component.

* `showEcho`:
  * Since Chameleon 3.2.0
  * Allowed values: String (`icons`|`links`)
  * Default: `icons`
  * Optional.

  Use `icons` to render Echo links as icons that trigger popups (default Echo behavior).
  When the parent is `NavbarHorizontal` the Echo icons will be displayed next to the dropdown.
  Use `links` to render Echo links as normal links without popups.

* `showUserName`:
  * Since Chameleon 3.4.0
  * Allowed values: String (`none`|`username-only`|`try-realname`)
  * Default: `none`
  * Optional.

  If set to `username-only`, the logged-in user's username will be shown next to the dropdown icon
  (since Chameleon 4.2.0).

  If set to `try-realname`, the logged-in user's real name will be shown next to the dropdown icon,
  if it is non-empty. If the real name is empty, the user's username will be shown.

  This attribute applies only when used inside the
  [NavbarHorizontal](#component-navbarhorizontal) component.

* `promoteLoneItems`:
  * Since Chameleon 4.2.0
  * Allowed values: String
  * Default: -
  * Optional.

  A semicolon-separated list of menu items that are candidates for promotion
  to the navbar.  If the personal tools menu contains a single, lone item,
  and if that item is in this list, then that menu item will be rendered
  in the navbar directly, instead of the dropdown toggle and single-item menu.

  This is particularly useful for the `"login"` item in semi-private wikis.

  This attribute applies only when used inside the
  [NavbarHorizontal](#component-navbarhorizontal) component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `SearchBar`

The search bar.

#### Example usage

``` xml
<component type="SearchBar"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `buttons`:
  * Allowed values: String (`search`|`go`|`search go`)
  * Default: `search go`
  * Optional.

  The buttons that should be shown with the search bar.

* `placeholder`:
  * Allowed values: String
  * Default: using the MediaWiki search text
  * Optional

  The placeholder to show in the search field when the user has not enetered anything yet

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Silent`

This component does not output anything. It may be used as a placeholder during development.

#### Example usage

``` xml
<component type="Silent"/>
```

#### Attributes:
None.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `SiteNotice`

The wiki's [site notice](https://www.mediawiki.org/wiki/Manual:Interface/Sitenotice).

#### Example usage

``` xml
<component type="SiteNotice"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `Toolbox`

The MediaWiki toolbox contains various links. Some are general links like a link
to a list of Special Pages so a user always has a way to access them. Others are
page-sensitive links like permalinks, printable links, block links, feed links,
and a link to a list of pages linking to the current page.

#### Example usage

``` xml
<component type="Toolbox" />
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.

  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `flatten`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.

  Whether the list of tools should be flattened, i.e. its items should
  appear not in a submenu, but as elements of the top structure.

#### Allowed Parent Elements:
<!-- * [Structure](#structure) -->
<!-- * [Cell](#cell) -->
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Modification `HideFor`

A modification that allows to hide the parent component if the condition
specified by the attributes is fulfilled.

This is a restrictive filter. It will hide the component if _all_ of the
attributes match. However, the attributes containing lists of values will match,
if one of the values matches.

#### Example usage

``` xml
<modification type="HideFor" permission="edit" namespace="NS_MAIN, NS_TALK" />
```

This will hide the parent component of the modification if the user has the
_edit_ right and the current page is in the 'Main' or 'Talk' namespace.

#### Attributes

* group
  * Allowed values: String value
  * Example: `group="emailconfirmed, autoconfirmed"`

  A comma-separated list of [user
  groups](https://www.mediawiki.org/wiki/Manual:User_rights#List_of_groups) for
  which the component should be hidden.

  It is generally not advised to use the _group_ attribute, as it
  bypasses the permission system. Use _permission_ instead.

* permission
  * Allowed values: String value
  * Example: `permission="createpage, createtalk"`

  A comma-separated list of [user
  permissions](https://www.mediawiki.org/wiki/Manual:User_rights#List_of_permissions)
  for which the component should be hidden.

* namespace
  * Allowed values: String value
  * Example: `group="NS_MAIN, NS_TALK"`

  A comma-separated list of
  [namespaces](https://www.mediawiki.org/wiki/Manual:Namespace_constants) for
  which the component should be hidden. The namespaces may be specified as
  namespace constants or as namespace index numbers.

-------------------------------------------------------------------------------
### Modification `ShowOnlyFor`

A modification that allows to show the parent component only if the condition
specified by the attributes is fulfilled.

This is a permissive filter. It will show the component if _any_ of the
attributes match.

#### Example usage

``` xml
<modification type="ShowOnlyFor" permission="edit" namespace="NS_TALK" />
```

This will show the parent component of the modification if the user has the
_edit_ right or if the current page is in the 'Talk' namespace (or both).

#### Attributes

* group
  * Allowed values: Any string
  * Example: `group="emailconfirmed, autoconfirmed"`

  A comma-separated list of [user
  groups](https://www.mediawiki.org/wiki/Manual:User_rights#List_of_groups) for
  which the component should be shown.

  It is generally not advised to use the _group_ attribute, as it bypasses the
  permission system. Use _permission_ instead.

* permission
  * Allowed values: Any string
  * Example: `permission="createpage, createtalk"`

  A comma-separated list of [user
  permissions](https://www.mediawiki.org/wiki/Manual:User_rights#List_of_permissions)
  for which the component should be shown.

* namespace
  * Allowed values: Any string
  * Example: `group="NS_MAIN, NS_TALK"`

  A comma-separated list of
  [namespaces](https://www.mediawiki.org/wiki/Manual:Namespace_constants) for
  which the component should be shown. The namespaces may be specified as
  namespace constants or as namespace index numbers.

-------------------------------------------------------------------------------
### Modification `Sticky`

A modification that will ensure that the parent component stays always visible
when the user scrolls.

#### Example usage

``` xml
<modification type="Sticky" />
```

This will make the parent component of the modification stick to the page.

#### Attributes
None.
