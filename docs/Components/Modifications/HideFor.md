## HideFor

A modification that allows to hide the parent component if the condition
specified by the attributes is fulfilled.

This is a restrictive filter. It will hide the component if _all_ of the
attributes match. However, the attributes containing lists of values will match,
if one of the values matches.

### Example

`<modification type="HideFor" permission="edit" namespace="NS_MAIN, NS_TALK" ></modification>`

This will hide the parent component of the modification if the user has the
_edit_ right and the current page is in the 'Main' or 'Talk' namespace. 

### Attributes

#### group

* Type: String value
* Description: A comma-separated list of user groups for which the component should be hidden.
* Example: `group="emailconfirmed, autoconfirmed"`

It is generally not advised to use the _group_ attribute, as it bypasses the
permission system. Use [#permission] instead.

#### permission

* Type: String value
* Description: A comma-separated list of user permissions for which the component should be hidden.
* Example: `permission="createpage, createtalk"`

#### namespace

* Type: String value
* Description: A comma-separated list of namespaces for which the component should be hidden.
* Example: `group="NS_MAIN, NS_TALK"`

The namespaces may be specified as namespace constants or as namespace numbers.
See [Namespace constants on mediawiki.org](https://www.mediawiki.org/wiki/Manual:Namespace_constants).