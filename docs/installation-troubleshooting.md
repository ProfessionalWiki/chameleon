## Installation Troubleshooting

* To actually activate Chameleon as the default skin of your wiki, include
  `$wgDefaultSkin='chameleon'` in your `LocalSettings.php`
* It is not necessary to install any dependencies anymore. Composer will take
  care of that.
* If instead of a proper installation you end up with a `mediawiki` subdirectory
  in the `vendor` directory of your MediaWiki installation,
  * remove that `mediawiki` subdirectory and all its contents from the `vendor`
    directory
  * run `composer update` from the MediaWiki installation directory again
