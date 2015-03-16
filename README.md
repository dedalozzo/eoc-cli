[![Latest Stable Version](https://poser.pugx.org/3f/eoc-cli/v/stable.png)](https://packagist.org/packages/3f/eoc-cli)
[![Latest Unstable Version](https://poser.pugx.org/3f/eoc-cli/v/unstable.png)](https://packagist.org/packages/3f/eoc-cli)
[![License](https://poser.pugx.org/3f/eoc-cli/license.svg)](https://packagist.org/packages/3f/eoc-cli)
[![Total Downloads](https://poser.pugx.org/3f/eoc-cli/downloads.png)](https://packagist.org/packages/3f/eoc-cli)


Elephant on Couch Command-Line Interface
========================================
EoC CLI is a CouchDB's Command-Line Interface (CLI) made in PHP programming language.


Composer Installation
---------------------

To install EoC CLI, you first need to install [Composer](http://getcomposer.org/), a Package Manager for
PHP, following those few [steps](http://getcomposer.org/doc/00-intro.md#installation-nix):

``` sh
curl -s https://getcomposer.org/installer | php
```

You can run this command to easily access composer from anywhere on your system:

``` sh
sudo mv composer.phar /usr/local/bin/composer
```


EoC CLI Installation
--------------------
Once you have installed Composer, it's easy install Elephant on Couch CLI.

1.  Move into the directory where you prefer install EoC CLI:
  ``` sh
  cd /usr/local
  ```

2.  Create a project for EoC CLI:
  ``` sh
  sudo composer create-project 3f/eoc-cli
  ```
  
3.  For your convenience create a symbolic link for the couch executable in your `/usr/local/bin` directory:
  ``` sh
  sudo ln -s /user/local/eoc-cli/bin/couch.php /usr/local/bin/couch
  ```


Supported Commands
------------------
Lists commands. 
``` sh
couch list [--xml] [--raw] [--format="..."] [namespace]
```

Displays help for a command. 
``` sh
couch help [--xml] [--format="..."] [--raw] [command_name]
```

Connects to CouchDB server. 
``` sh
couch connect [-s|--server[="..."]] user
```

Uses the specified database. 
``` sh
couch use database
```

Alias of `use`.
``` sh
couch select database
```

Creates a new database.
``` sh
couch create database
```

Deletes the specified database, if not in use. 
``` sh
couch delete database
```

Displays information about the selected database.
``` sh
couch info
```

Starts a compaction for the current selected database or just a set of views.
``` sh
couch compact [--design-doc="..."]
```

Removes all outdated view indexes.
``` sh
couch compact [--design-doc="..."]
```

Makes sure all uncommited database changes are written and synchronized to the disk.
``` sh
couch commit
```

Returns the tail of the server's log file.
``` sh
couch log [--bytes[="..."]]
```

Restarts CouchDB server. 
``` sh
couch restart
```

Gets the list of active tasks. 
``` sh
couch status
```

Returns a list of generated UUIDs.
``` sh
couch uuids [--count[="..."]]
```

Displays CouchDB server and client versions. 
``` sh
couch version
```

Returns a list of all databases on this server. 
``` sh
couch alldbs
```


Queries a view and outputs the result. 
``` sh
couch query [--key="..."] [--startkey="..."] [--endkey="..."] [--startkey-docid="..."] 
[--endkey-docid="..."] [--limit="..."] [--group-results] [--group-level="..."] 
[--do-not-reduce] [--include-docs] [--exclude-results] [--exclude-endkey] 
[--reverse-order] [--skip="..."] [--include-conflicts] [--include-missing-keys] 
[--map="..."] [--reduce="..."] [--language="..."] design-doc/view-name [keys1] ... [keysN]
```


Requirements
------------
PHP 5.4.7 or above. Shmop library is also required.


Authors
-------
Filippo F. Fadda - <filippo.fadda@programmazione.it> - <http://www.linkedin.com/in/filippofadda>


License
-------
Elephant on Couch Command-Line Interface is licensed under the Apache License, Version 2.0 - see the LICENSE file for details.