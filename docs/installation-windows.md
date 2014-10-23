## Installation on Windows - Step by Step

Here is a step by step procedure for Windows:

1.  You first need to install Composer. On Windows just [download the
    installer][composer-installer] and run it.
2.  Open a Windows Explorer window and navigate to the root folder of
    your MediaWiki installation. That's the one with the
    `LocalSettings.php` file in it.
3.  For MediaWiki 1.22 and 1.23 you need to copy the file
    `composer.json.example` to `composer.json`. For this, select
    `composer.json.example`, press Ctrl+C, then Ctrl+V and then rename
    the copy to `composer.json`.
4.  Right-click on the new file and select *Use composer here*. A
    command line window will open.
5.  On the command line run the command
    `composer require "mediawiki/chameleon-skin:~1.0"`
6.  If there were no errors, close the command line window.
7.  Open `LocalSettings.php` in an editor capable to do UNIX style line
    endings (e.g. [Notepad++][] or [Kate][], but *not* the standard Notepad!)
    Include `$wgDefaultSkin='chameleon';` as
    the last line. Save the file and close the editor.
8.  Open your wiki in a browser. Chameleon should be installed.
9.  If not, force reload the page to
    [refresh your browser cache][cache-refresh]. (Press Ctrl+F5 on Firefox,
    Ctrl+Shift+F5 on Internet Explorer.)

[composer-installer]: https://getcomposer.org/Composer-Setup.exe
[Notepad++]: http://notepad-plus-plus.org/
[Kate]:http://kate-editor.org/
[cache-refresh]: http://www.refreshyourcache.com/en/home/
