## Component `Logo`

The Logo component displays the logo of the wiki as defined in `$wgLogo`.

The alternative text of the image is set to the sitename of the wiki as defined
in `$wgSitename`. Depending on the `addLink` attribute the logo may link to the
main page of the wiki. The name of the main page of the wiki is defined in the
`mainpage` message and can thus be modified on the `Mediawiki:Mainpage` page of
the wiki.

### Example usage

```
<component type="Logo" addLink="yes"></component>
```

#### Attributes:
* `addLink`:
  * Allowed values: Boolean (`yes`|`no`)
  * Default: `yes`

#### Allowed Parent Elements:
* [Cell](Cell.md)
* [NavbarHorizontal](NavbarHorizontal.md)

#### Allowed Child Elements:
* all [Modifications](modifications)