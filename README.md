Banana
======

Banana: The PHP framework that tastes good

Since 5.3 PHP is now functionnal which means we may pass a function as an
argument.

Banana try to digg this way of development in PHP.

Banana is in active development for a personal project.

It is inspired by Django, Node.js and other frameworks.

This is a very early release do not use it in production.

Installation
------------

Clone for fork the repos or download the zip. That's all.

Using
-----

Banana doesn't work out the box. You have to create two files: `index.php`
and `configuration.php`.

Example for `index.php`:

```php

<?php

include_once 'banana/banana.php';

use Banana\Core\Router;

with(Router::getInstance(), function($route) {
    // the url is a regular expression. The closure function must return
    // a string.
    $route->with('MainController')                          // With the main controller
        ->addRoute('#^/$#', 'index' )                       // Call the index method
        ->addNamedRoute('aroute', '#^/aroute/$', 'aroute'); // Call the aroute method.

    // Do the job
    $route->process();
});

// Do not close the php
```

Example for `configuration.php`:

```php
<?php

with(Banana\Conf\Config::getInstance(), function($conf) {
    $conf->templatesDir = array(
        BASE_DIR . 'templates'
    );
});

```

I will try to improve the documentation.