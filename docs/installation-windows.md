## Installation on Windows - Step by Step

Here is a step by step procedure for Windows:

1.  You first need to install Composer. On Windows just [download the
    installer][composer-installer] and run it.
    
2.  Open a Windows Explorer window and navigate to the root folder of
    your MediaWiki installation. That's the one with the `LocalSettings.php`
    file in it.

3.  Open `composer.local.json` in an editor capable to do UNIX style line
    endings (e.g. [Notepad++][] or [Kate][], but *not* the standard Notepad!)
    and add the Chameleon skin to the `require` section:
    ```json
    "require": { 
        "mediawiki/chameleon-skin": "~3.0"
    },
    ```
   
    **Remark:** If you do not have a `composer.local.json` file, but a
    `composer.local.json-sample`, rename the `-sample` file and add the
    `"require"` section. It should then look like this:
    ```json
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

    Save the file and close the editor.

4.  Shift right-click in an empty space in the Windows Explorer window and
    select *Open Command Prompt here* or *Open Powershell window here*. A
    command line window will open.
    
5.  On the command line run the command
    `composer require "mediawiki/chameleon-skin:~3.0"`
    
6.  If there were no errors, close the command line window.

7.  Open `LocalSettings.php` in an editor capable to do UNIX style line
    endings (e.g. [Notepad++][] or [Kate][], but *not* the standard Notepad!)
    Include
    ```php
    wfLoadSkin( 'chameleon' );
    ```
    as the last line.
   
    To set Chameleon as the default skin, find `$wgDefaultSkin` and amend it:
    ```php
    $wgDefaultSkin='chameleon';
    ```

    Save the file and close the editor.
    
8.  __Done:__ Open your wiki in a browser and navigate to the _Special:Version_
    page to verify that the skin is successfully installed. (If you have set
    Chameleon as default skin it should also be obvious that the skin has
    changed.)

9.  If not, force reload the page to
    [refresh your browser cache][cache-refresh]. (Press Ctrl+F5 on Firefox,
    Ctrl+Shift+F5 on Internet Explorer.)

[composer-installer]: https://getcomposer.org/Composer-Setup.exe
[Notepad++]: http://notepad-plus-plus.org/
[Kate]:http://kate-editor.org/
[cache-refresh]: http://www.refreshyourcache.com/en/home/
