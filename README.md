[![Latest Stable Version](https://poser.pugx.org/3f/eoc-cli/v/stable.png)](https://packagist.org/packages/3f/eoc-cli)
[![Latest Unstable Version](https://poser.pugx.org/3f/eoc-cli/v/unstable.png)](https://packagist.org/packages/3f/eoc-cli)
[![License](https://poser.pugx.org/3f/eoc-cli/license.svg)](https://packagist.org/packages/3f/eoc-cli)
[![Total Downloads](https://poser.pugx.org/3f/eoc-cli/downloads.png)](https://packagist.org/packages/3f/eoc-cli)


Elephant on Couch Command-Line Interface
========================================
EoC CLI is a CouchDB's Command-Line Interface (CLI) made in PHP programming language.


Composer Installation
---------------------

To install EoC Server, you first need to install [Composer](http://getcomposer.org/), a Package Manager for
PHP, following those few [steps](http://getcomposer.org/doc/00-intro.md#installation-nix):

``` sh
curl -s https://getcomposer.org/installer | php
```

You can run this command to easily access composer from anywhere on your system:

``` sh
sudo mv composer.phar /usr/local/bin/composer
```


EoC CLI Installation
-----------------------
Once you have installed Composer, it's easy install Elephant on Couch CLI.

1. Move into the directory where you prefer install EoC CLI:
``` sh
cd /usr/local
```

2. Create a project for EoC CLI:
``` sh
sudo composer create-project 3f/eoc-cli
```

3. For your convenience create a symbolic link for the couch executable in your `/usr/local/bin` directory:
``` sh
sudo ln -s /user/local/eoc-cli/bin/couch.php /usr/local/bin/couch
```


Requirements
------------
PHP 5.4.7 or above. Shmop library is also required.


Authors
-------
Filippo F. Fadda - <filippo.fadda@programmazione.it> - <http://www.linkedin.com/in/filippofadda>


License
-------
Elephant on Couch Server is licensed under the Apache License, Version 2.0 - see the LICENSE file for details.