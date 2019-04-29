# Migrating to Chameleon 2.0:

### Core items changed

* Move from Bootstrap 3 to Bootstrap 4
* Move from less to scss (sass)
* New way of setting style variables in LocalSettings.php 
* Component name change

### Move from Bootstrap 3 to Bootstrap 4
Chameleon 2.0 comes with Bootstrap 4, an upgraded version of Bootstrap 3 that comes with Chameleon 1.x. Class names as you know them in Bootstrap 3 could be different in Bootstrap 4. It is highly suggested to read Bootstraps's migration guide here: https://getbootstrap.com/docs/4.0/migration/. 

### Move from less to scss (sass)
The transition to Bootstrap 4 also mandates a transition from less to sass. If you have created your own less files, it is imported that these are adapted to sass. If you have been an advanced user of less (using mixins and such), it's recommended to look up a migration guide to sass.

###  New way of setting style variables in LocalSettings.php 
**Configuration variable name change:**
`$egChameleonExternalLessVariables` -> `$egChameleonExternalStyleVariables`

**Using sass variables instead of less variables:**
OLD style (1.x) example:
```
$egChameleonExternalLessVariables = array(    
    'font-size-base' 	=> '1rem',
    'font-size-h1' 		=> 'floor((@font-size-base * 2))', 		// originally 36px
    'font-size-h2' 		=> 'floor((@font-size-base * 1.7))',	// originally 30px
    'font-size-h3' 		=> 'ceil((@font-size-base * 1.3))',		// originally originally 18px
    'brand-color' 		=> '#e9e415';
    'headings-color'   	=> '@brand-color',
);
```

NEW style (2.x) example:
```
$egChameleonExternalStyleVariables = array(
    'font-size-base' 	=> '1rem',
    'font-size-h1' 		=> '$font-size-base * 1.5;', 			// originally 2.2
    'font-size-h2' 		=> '$font-size-base * 1.3;', 			// originally 1.7
    'font-size-h3' 		=> '$font-size-base * 1.2;', 			// originally 1.4
    'brand-color' 		=> '#e9e415 !default'; 					// setting '!default' will create a new variable
    'headings-color' 	=> '$brand-color',
);
```

### Component name change
If you're using a custom layout and the component 'ToolbarHorizontal', you will need to to change this to `Toolbox`:

ToolbarHorizontal -> [Toolbox](https://github.com/cmln/chameleon/blob/master/docs/components.md#component-toolbox)

Additionally, this component was added in Chameleon 2.x:

[LangLinks](https://github.com/cmln/chameleon/blob/master/docs/components.md#component-langlinks)






