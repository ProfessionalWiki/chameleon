## ShowOnlyFor

A modification that allows to show the parent component only if the condition
specified by the attributes is fulfilled.

This is a permissive filter. It will show the component if _any_ of the
attributes match.

### Example

`<modification type="ShowOnlyFor" permission="edit" namespace="NS_TALK" ></modification>`

This will show the parent component of the modification if the user has the
_edit_ right or if the current page is in the 'Talk' namespace (or both). 

### Attributes

#### group

* Type: String value
* Description: A comma-separated list of user groups for which the component should be shown.
* Example: `group="emailconfirmed, autoconfirmed"`

It is generally not advised to use the _group_ attribute, as it bypasses the
permission system. Use [#permission] instead.

#### permission

* Type: String value
* Description: A comma-separated list of user permissions for which the component should be shown.
* Example: `permission="createpage, createtalk"`

#### namespace

* Type: String value
* Description: A comma-separated list of namespaces for which the component should be shown.
* Example: `group="NS_MAIN, NS_TALK"`

The namespaces may be specified as namespace constants or as namespace numbers.
See [Namespace constants on mediawiki.org](https://www.mediawiki.org/wiki/Manual:Namespace_constants).