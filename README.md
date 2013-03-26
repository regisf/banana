Banana
======

Banana: The PHP framework that rocks

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

with(new Banana\Core\Router(), function($route) {
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

with(Banana\Conf\Config::getInstance(), function($conf) {
    $conf->templatesDir = array(
        BASE_DIR . 'templates'
    );
});

```

I will try to improve the documentation.