## Installation on Linux - Step by Step

Here is a step by step procedure for Linux, that should work for other unixy
operating systems as well:

1. Open a command line window (Konsole, XTerm) and navigate to the root folder
   of your MediaWiki installation. That's the one with the `LocalSettings.php`
   file in it.
2. [Install Composer][]:

    ``` sh
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```

3. For MediaWiki 1.23.5 you need to copy the file `composer.json.example` to
   `composer.json`. For this, run `cp composer.json.example composer.json`.
4. To actually install Chameleon run the command
   `composer require "mediawiki/chameleon-skin:~1.0"`
5. If there were no errors, close the command line window.
6. Open `LocalSettings.php` in an editor (e.g. Kate). Include
   `$wgDefaultSkin='chameleon';` as the last line. Save the file and close the
   editor.
7. Open your wiki in a browser. Chameleon should be installed.
8. If not, force reload the page to [refresh your browser cache][cache-refresh].
   (On Firefox or Chrome press Ctrl+F5)

[Install Composer]: https://getcomposer.org/doc/00-intro.md#installation-nix
[cache-refresh]: http://www.refreshyourcache.com/en/home/
