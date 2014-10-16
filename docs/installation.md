## Installation, Update, De-Installation

### Requirements

- PHP 5.3.2 or later
- MediaWiki 1.22 or later
- [Composer][composer]

Further required software packages will be installed automatically.

### Installation

1. Got to your MediaWiki installation directory
2. If necessary (on MediaWiki up to 1.23) copy the file `composer.json.example` 
   to `composer.json`  
3. With Composer installed, run
   `composer require "mediawiki/chameleon-skin:~1.0"`
4. Navigate to _Special:Version_ on your wiki to verify that the skin is
   successfully installed.

### Update

From your MediaWiki installation directory run
`composer update "mediawiki/chameleon-skin"`

### De-installation

Before de-installation make sure you secured (moved, backup'ed) any custom files
you might want to retain.

From your MediaWiki installation directory run
`composer remove "mediawiki/chameleon-skin"`


[composer]: https://getcomposer.org/
