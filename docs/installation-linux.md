## Installation on Linux - Step by Step

Here is a step by step procedure for Linux, that should work for other unixy
operating systems as well:

1. Open a command line window (e.g. using Konsole or XTerm).
2. If necessary [install Composer][]:
    ``` sh
    wget -cO - https://getcomposer.org/composer-1.phar > composer.phar
    sudo mv composer.phar /usr/local/bin/composer
    ```
3. Navigate to the root folder of your MediaWiki installation. That's the one
   with the `LocalSettings.php` file in it.
4. Open the `composer.local.json` file in an editor and add the Chameleon skin
   to the `require` section:
   ``` json
   "require": {
       "mediawiki/chameleon-skin": "~3.0"
   },
   ```
   
   **Remark:** If you do not have a `composer.local.json` file, but a
   `composer.local.json-sample`, rename the `-sample` file and add the
   `"require"` section. It should then look like this:
   ``` json
   {
       "require": {
           "mediawiki/chameleon-skin": "~3.0"
       },
       "extra": {
           "merge-plugin": {
               "include": [
                   "extensions/example/composer.json"
               ]
           }
       }
   }
   ```
   
5. To actually install Chameleon run the command
   ```bash
   COMPOSER=composer.local.json composer require --no-update mediawiki/chameleon-skin:~3.0
   composer update mediawiki/chameleon-skin --no-dev -o```
6. If there were no errors, close the command line window.
7. Open `LocalSettings.php` in an editor (e.g. Kate). Include
   ```php
   wfLoadSkin( 'chameleon' );
   ```
   as the last line.
   
   To set Chameleon as the default skin, find `$wgDefaultSkin` and amend it:
   ```php
   $wgDefaultSkin='chameleon';
   ```

   Save the file and close the editor.

8. __Done:__ Open your wiki in a browser and navigate to the _Special:Version_
   page to verify that the skin is successfully installed. (If you have set
   Chameleon as default skin it should also be obvious that the skin has
   changed.)

9. If not, force reload the page to [refresh your browser cache][cache-refresh].
   (On Firefox or Chrome press Ctrl+F5)

[Install Composer]: https://getcomposer.org/doc/00-intro.md#installation-nix
[cache-refresh]: http://www.refreshyourcache.com/en/home/
