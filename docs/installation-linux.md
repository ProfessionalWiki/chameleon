## Installation on Linux - Step by Step

Here is a step by step procedure for Linux, that should work for other unixy
operating systems as well:

1. Open a command line window (e.g. using Konsole or XTerm).
2. If necessary [install Composer][]:
    ``` sh
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```
3. Navigate to the root folder of your MediaWiki installation. That's the one
   with the `LocalSettings.php` file in it.
4. Open the `composer.local.json` file in an editor and add the Chameleon skin
   to the `require` section:
   `require` section:
   ```
   "require": {
       "mediawiki/chameleon-skin": "~1.0"
   }
   ```
   * Remark 1: If you do not have a `composer.local.json` file (MediaWiki <1.25),
     use `composer.json` instead.
   
   * Remark 2: If you do not have a `composer.json` file (MediaWiki <1.23.5),
     copy `composer.json.example` to `composer.json` first.
5. To actually install Chameleon run the command
   `composer update "mediawiki/chameleon-skin"`
6. If there were no errors, close the command line window.
7. Open `LocalSettings.php` in an editor (e.g. Kate). Include
   `$wgDefaultSkin='chameleon';` as the last line. Save the file and close the
   editor.
8. Open your wiki in a browser. Chameleon should be installed.
9. If not, force reload the page to [refresh your browser cache][cache-refresh].
   (On Firefox or Chrome press Ctrl+F5)

[Install Composer]: https://getcomposer.org/doc/00-intro.md#installation-nix
[cache-refresh]: http://www.refreshyourcache.com/en/home/
