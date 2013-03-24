banana
======

Banana: The PHP framework that rocks

Banana is in active development for a personal project.
This is the 0.0.1 version.

Installation
------------

Clone for fork the repos or download the zip. That's all.

Using
-----

Create two files: `index.php` and `configuration.php`.

Example for `index.php`:

```php

<?php

include_once 'banana/banana.php';

with(new BananaRouter(), function($route) {
    // the url is a regular expression. The closure function must return
    // a string.
    $route->addRoute('/^\/$/', function() {
        return 'Hello world !!';
    });

    // Do the job
    $route->process();
});

// Do not close the php
```

Example for `configuration.php`:

```php
<?php

with(BananaConfig::getInstance(), function($conf) {
    $conf->templatesDir = array(
        BASE_DIR . 'templates'
    );
});

```

I will try to improve the documentation.