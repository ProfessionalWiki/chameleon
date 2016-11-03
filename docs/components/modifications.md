## Modifications

Modifications can be added to components to change their general behavior.

Currently three modifications are available:
* [`HideFor`](#Modification `HideFor`): Hide the parent component for the specified conditions
* [`ShowOnlyFor`](#Modification `ShowOnlyFor`): Show the parent component only for the specified conditions
* [`Sticky`](#Modification `Sticky`): Make the parent component always stay visible on the page.

## Modification `HideFor`

A modification that allows to hide the parent component if the condition
specified by the attributes is fulfilled.

This is a restrictive filter. It will hide the component if _all_ of the
attributes match. However, the attributes containing lists of values will match,
if one of the values matches.

### Example usage

`<modification type="HideFor" permission="edit" namespace="NS_MAIN, NS_TALK" ></modification>`

This will hide the parent component of the modification if the user has the
_edit_ right and the current page is in the 'Main' or 'Talk' namespace. 

### Attributes

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
  
  ## Modification `ShowOnlyFor`
  
  A modification that allows to show the parent component only if the condition
  specified by the attributes is fulfilled.
  
  This is a permissive filter. It will show the component if _any_ of the
  attributes match.
  
  ### Example usage
  
  `<modification type="ShowOnlyFor" permission="edit" namespace="NS_TALK" ></modification>`
  
  This will show the parent component of the modification if the user has the
  _edit_ right or if the current page is in the 'Talk' namespace (or both). 
  
  ### Attributes
  
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
    
## Modification `Sticky`

A modification that will ensure that the parent component stays always visible
when the user scrolls.

### Example usage

`<modification type="Sticky" ></modification>`

This will make the parent component of the modification stick to the page. 

### Attributes

None.