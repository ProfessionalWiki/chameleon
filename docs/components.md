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
- [Component `Container`](#component-container)
- [Component `FooterIcons`](#component-footericons)
- [Component `FooterInfo`](#component-footerinfo)
- [Component `FooterPlaces`](#component-footerplaces)
- [Component `Html`](#component-html)
- [Component `Logo`](#component-logo)
- [Component `MainContent`](#component-maincontent)
- [Component `Menu`](#component-menu)
- [Component `NavbarHorizontal`](#component-navbarhorizontal)
- [Component `NavMenu`](#component-navmenu)
- [Component `NewtalkNotifier`](#component-newtalknotifier)
- [Component `PageTools`](#component-pagetools)
- [Component `PageToolsAdaptable`](#component-pagetoolsadaptable)
- [Component `PersonalTools`](#component-personaltools)
- [Component `SearchBar`](#component-searchbar)
- [Component `Silent`](#component-silent)
- [Component `SiteNotice`](#component-sitenotice)
- [Component `ToolbarHorizontal`](#component-toolbarhorizontal)
- [Modification `HideFor`](#modification-hidefor)
- [Modification `ShowOnlyFor`](#modification-showonlyfor)
- [Modification `Sticky`](#modification-sticky)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

### `Structure`

The root element of any layout.

#### Example usage

``` xml
<structure xmlns="https://github.com/cmln/chameleon/layout/1.0">
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
  * Allowed values: String (`fixedwidth`|`fluid`)
  * Default: `fixedwidth`
  * Optional.

  Use `fixedwidth` for a responsive fixed width layout. Use `fluid` for a full
  width layout, spanning the entire width of the viewport.

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
None.

#### Allowed Parent Elements:
* [Grid](#grid)

#### Allowed Child Elements:
* [Cell](#cell)
* Any modification

-------------------------------------------------------------------------------
### `Cell`

Holds components. 

For each cell specify the number of columns you wish to span.

#### Example usage

``` xml
<cell span="12">
  ...
</cell>
```

#### Attributes:
* `span`:
  * Allowed values: Numbers (1 ... 12)
  * Default: `12`
  
  The number of columns this cell shall span. All cells of a row should together
  span 12 columns. If more than 12 columns are placed within a single row, each
  group of extra columns will, as one unit, wrap onto a new line.

#### Allowed Parent Elements:
* [Row](#row)

#### Allowed Child Elements:
* [Row](#row)
* Any component
* Any modification

-------------------------------------------------------------------------------
### Component `Container`

This component will wrap its content elements in a `<div>`. It may be used to
assign a CSS class for styling purposes.

#### Example usage

``` xml
<component type="container" class="foo bar">
  ...
</component>
```

#### Attributes:
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
sidebar](https://www.mediawiki.org/wiki/Manual:Interface/Sidebar).

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
  * Foo
  ** FooBar
  * Test | Bar
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

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.
  
  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `fixed`:
  * **Deprecated.** Use the [Sticky](#modification-sticky) modification instead.
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

#### Allowed Child Elements:
* Component [`Logo`](#component-logo)
* Component [`Menu`](#component-menu)
* Component [`NavMenu`](#component-navmenu)
* Component [`PageTools`](#component-pagetools)
* Component [`PersonalTools`](#component-personaltools)
* Component [`PageToolsAdaptable`](#component-pagetoolsadaptable)
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
<component type="NavMenu" flatten="navigation" showTools="no" showLanguages="no" />
```

#### Attributes:
* `flatten`
  * Allowed values: String
  * Default: -
  * Optional.
  
  A semicolon separated list of section names that are to be flattened, i.e.
  whose menu items should appear not in a submenu, but as elements of the top
  structure.
  
  This list may also be given in the message
  _MediaWiki:skin-chameleon-navmenu-flatten_ instead. If both the message and
  the attribute are used, the message takes precedence.

* `showTools`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.
  
  If set to `yes` the toolbox will be included in the NavMenu. It is usually not
  included here, but shown in a dedicated
  [ToolbarHorizontal](#component-toolbarhorizontal) instead.
  
  The MediaWiki toolbox contains various links. Some are general links like a
  link to a list of Special Pages so a user always has a way to access them.
  Others are page-sensitive links like permalinks, printable links, block links,
  feed links, and a link to a list of pages linking to the current page.

* `showLanguages`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.
  
  A MediaWiki page may have links to the same page in other languages on the
  wiki when inter-language links are added to the page. If the attribute is set
  to `yes` the language links will be included in the NavMenu. They are usually
  not included here, but shown in a dedicated
  [ToolbarHorizontal](#component-toolbarhorizontal) instead.

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
<component type="PageTools"/>
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

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)
* [NavbarHorizontal](#component-navbarhorizontal)

#### Allowed Child Elements:
* Any modification

-------------------------------------------------------------------------------
### Component `PageToolsAdaptable`

- [Component `PageToolsAdaptable`](#component-pagetoolsadaptable)


Renders the same component as [Component `PageTools`](#component-pagetools), except
you can define in your structure file which actions are shown directly in the navbar
before the ... pop-down.
 
#### Example usage

``` xml
<component type="PageToolsAdaptable" show="edit,ve-edit,history"/>
```

#### Attributes:
Same as [Component `PageTools`](#component-pagetools). Additionally:
* `show`
  * Allowed values: String
  * Default: -
  * Optional.
  
  The actions that will be shown in the navbar directly and also removed from the PageTools drop-down.
  Among other, possible actions are:
  
    * delete
    * edit
    * formedit
    * history
    * move
    * protect
    * purge
    * undelete
    * unprotect
    * unwatch
    * ve-edit
    * view
    * watch
    
  Note that button for actions, that are not valid for a given page will be omitted automatically.
  So in the above example, the visual-editor edit action button will only be shown for pages in a valid
  visual-editor namespace.
  Note also, that the valid buttons will be shown in the order you provided in the show attribute of
  your structure.xml. In the example above, history would be last action right before the ellipsis.

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
  [NavbarHorizontal](#component-navbar-horizontal) component.
  
  This attribute was introduced to keep backwards compatibility. If the
  PersonalTools component is used, it is recommended to always set this
  attribute to *yes* and use an independent
  [NewtalkNotifier](#component-newtalknotifier) component.

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
### Component `ToolbarHorizontal`

A horizontal toolbar containing standard sidebar items (toolbox, language links).
 
The MediaWiki toolbox contains various links. Some are general links like a link
to a list of Special Pages so a user always has a way to access them. Others are
page-sensitive links like permalinks, printable links, block links, feed links,
and a link to a list of pages linking to the current page.

[Language links](https://www.mediawiki.org/wiki/Interlanguage_links) are links
to the same page in other languages on the wiki that are available when
inter-language links are added to the page.

#### Example usage

``` xml
<component type="ToolbarHorizontal" hideTools="no" hideLanguages="no"/>
```

#### Attributes:
* `class`:
  * Allowed values: String
  * Default: -
  * Optional.
  
  The class (or classes) that should be assigned to the top-level html element
  of this component.

* `hideTools`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.
  
  If set to `yes` the toolbox links will be hidden.
  
* `hideLanguages`
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `no`
  * Optional.
  
  If the attribute is set to `yes` the language links will be hidden.

#### Allowed Parent Elements:
* [Structure](#structure)
* [Cell](#cell)

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
