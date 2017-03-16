# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/router/v/stable)](https://packagist.org/packages/josantonius/router) [![Total Downloads](https://poser.pugx.org/josantonius/router/downloads)](https://packagist.org/packages/josantonius/router) [![Latest Unstable Version](https://poser.pugx.org/josantonius/router/v/unstable)](https://packagist.org/packages/josantonius/router) [![License](https://poser.pugx.org/josantonius/router/license)](https://packagist.org/packages/josantonius/router)

[Versión en español](README-ES.md)

Library for handling routes.

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)
- [Available Methods](#available-methods)
- [Usage](#usage)
- [Tests](#tests)
- [Exception Handler](#exception-handler)
- [Contribute](#contribute)
- [Repository](#repository)
- [Licensing](#licensing)
- [Copyright](#copyright)

---

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install PHP Router library, simply:

    $ composer require Josantonius/Router

### Requirements

This library is supported by PHP versions 5.6 or higher and is compatible with HHVM versions 3.0 or higher.

To use this library in HHVM (HipHop Virtual Machine) you will have to activate the scalar types. Add the following line "hhvm.php7.scalar_types = true" in your "/etc/hhvm/php.ini".

### Quick Start and Examples

To use this class, simply:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;
```
### Available Methods

Available methods in this library:

```php
Router::__callstatic();
Router::setSingletonName();
Router::addRoute();
Router::getRoute();
Router::loadRegexRoutes();
Router::error();
Router::haltOnMatch();
Router::dispatch();
Router::getUriMethods();
Router::invokeObject();
```
### Usage

Example of use for this library:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;

$routes = [
    '/'        => 'Namespace\Class\Example@render',
    'home/'    => 'Namespace\Class\Example@render',
    'contact/' => 'Namespace\Class\Example@render',
];

Router::addRoute($routes);

Router::dispatch();
```

### Tests 

To use the [test](tests) class, simply:

```php
<?php
$loader = require __DIR__ . '/vendor/autoload.php';

$loader->addPsr4('Josantonius\\Router\\Tests\\', __DIR__ . '/vendor/josantonius/router/tests');

use Josantonius\Router\Tests\RouterTest;

```
Available test methods in this library:

```php
RouterTest::testAddRoutes();
RouterTest::testSetSingletonName();
RouterTest::testExecuteRoutes();
```

### Exception Handler

This library uses [exception handler](src/Exception) that you can customize.
### Contribute
1. Check for open issues or open a new issue to start a discussion around a bug or feature.
1. Fork the repository on GitHub to start making your changes.
1. Write one or more tests for the new feature or that expose the bug.
1. Make code changes to implement the feature or fix the bug.
1. Send a pull request to get your changes merged and published.

This is intended for large and long-lived objects.

### Repository

All files in this repository were created and uploaded automatically with [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### Licensing

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you found this release useful please let the author know! Follow on [Twitter](https://twitter.com/Josantonius).