# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Router/v/stable)](https://packagist.org/packages/josantonius/Router) [![Latest Unstable Version](https://poser.pugx.org/josantonius/Router/v/unstable)](https://packagist.org/packages/josantonius/Router) [![License](https://poser.pugx.org/josantonius/Router/license)](LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c2721e75cb664951864a53122c6d035b)](https://www.codacy.com/app/Josantonius/PHP-Router?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Josantonius/PHP-Router&amp;utm_campaign=Badge_Grade) [![Total Downloads](https://poser.pugx.org/josantonius/Router/downloads)](https://packagist.org/packages/josantonius/Router) [![Travis](https://travis-ci.org/Josantonius/PHP-Router.svg)](https://travis-ci.org/Josantonius/PHP-Router) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![CodeCov](https://codecov.io/gh/Josantonius/PHP-Router/branch/master/graph/badge.svg)](https://codecov.io/gh/Josantonius/PHP-Router)

[Versión en español](README-ES.md)

Library for handling routes.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Methods](#available-methods)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Tests](#tests)
- [TODO](#-todo)
- [Contribute](#contribute)
- [Repository](#repository)
- [Licensing](#licensing)
- [Copyright](#copyright)

---

## Requirements

This library is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP Router library**, simply:

    $ composer require Josantonius/Router

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    $ composer require Josantonius/Router --prefer-source

You can also **clone the complete repository** with Git:

  $ git clone https://github.com/Josantonius/PHP-Router.git

Or **install it manually**:

Download [Router.php](https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php) and [Url.php](https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php):

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php

## Available Methods

Available methods in this library:

### - Set method name for use singleton pattern:

```php
Router::setSingletonName($method);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $method | Singleton method name. | string | Yes | |

**# Return** (boolean)

### - Add route/s:

```php
Router::add($routes);
```

| Attribute | Key | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| $routes | | Route/s to add. | array | Yes | |
|  | 0 | Route. | string | Yes | |
|  | 1 | Method 'class@method'. | string | Yes | |

**# Return** (boolean)

### - Get method to call from URI:

```php
Router::getMethod($route);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $route | Route. | string | Yes | |

**# Return** (string|null) → route or null

### - Defines callback if route is not found:

```php
Router::error($callback);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $callback | Callback. | callable | Yes | |

**# Return** (boolean true)

### - Continue processing after match or stop it:

Also can specify the number of total routes to process.

```php
Router::keepLooking($value);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $value | Value. | boolean|int | Yes | true |

**# Return** (boolean true)

### - Runs the callback for the given request:

```php
Router::dispatch();
```

**# Return** (call response|false)

## Quick Start

To use this library with **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;
```

Or If you installed it **manually**, use it:

```php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Url.php';

use Josantonius\Router\Router;
```

## Usage

[Example](tests/Example.php) of use for this library:

### - Add route:

```php
Router::add([
    'services' => 'Josantonius\Router\Example@services'
]);
```

### - Add routes:

```php
$routes = [
    'services' => 'Josantonius\Router\Example@services',
    'home'     => 'Josantonius\Router\Example@home',
];

Router::add($routes);
```

### - Execute route simulating 'services':

```php
Router::dispatch(); // Response from services method
```

### - Add route with regular expressions (:all):

```php
Router::add([
    'blog/:all' => 'Josantonius\Router\Example@blog'
]);
```

### - Execute route simulating 'language/PHP/':

```php
Router::dispatch(); // Response from services method
```

### - Add route with regular expressions (:any) and params:

```php
Router::add([
    'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/games/Minecraft/':

```php
Router::dispatch(); // Response from blog method: games | Minecraft
```

### - Add route with regular expressions (:num) and params:

```php
Router::add([
    blog/:any/:num/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/development/1/':

```php
Router::dispatch(); // Response from blog method: development | 1
```

### - Add route with regular expressions (:hex) and params:

```php
Router::add([
    'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/color/e0a060/':

```php
Router::dispatch(); // Response from blog method: color | e0a060
```

### - Add route with regular expressions (:uuidV4) and params:

```php
Router::add([
    'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/':

```php
Router::dispatch(); // Response from blog method: uuid | 11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000
```

### - Set method name for use singleton pattern:

```php
Router::setSingletonName('newSingleton');
```

### - Get method:

```php
Router::getMethod('services'); // Josantonius\Router\Example@services
```

### - Defines callback if route is not found:

```php
Router::error('Josantonius\Router\Example@error');
```

### - Execute wrong routes with custom error callback:

```php
Router::Router::dispatch('unknown'); // Response from error method
```

### - Continue processing after match:

```php
Router::keepLooking();
```

### - Keep Lookin up to three coincidences:

```php
Router::keepLooking(3);
```

### - Stopping processing after match:

```php
Router::keepLooking(false);
```

## Tests 

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

    $ git clone https://github.com/Josantonius/PHP-Router.git
    
    $ cd PHP-Router

    $ composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

    $ composer phpmd

Run all previous tests:

    $ composer tests

## ☑ TODO

- [ ] Add new feature.
- [ ] Improve tests.
- [ ] Improve documentation.
- [ ] Refactor code for disabled code style rules. See [phpmd.xml](phpmd.xml) and [.php_cs.dist](.php_cs.dist).

## Contribute

If you would like to help, please take a look at the list of
[issues](https://github.com/Josantonius/PHP-Router/issues) or the [To Do](#-todo) checklist.

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Run the command `composer install` to install the dependencies.
  This will also install the [dev dependencies](https://getcomposer.org/doc/03-cli.md#install).
* Run the command `composer fix` to excute code standard fixers.
* Run the [tests](#tests).
* Create a **branch**, **commit**, **push** and send me a
  [pull request](https://help.github.com/articles/using-pull-requests).

## Repository

The file structure from this repository was created with [PHP-Skeleton](https://github.com/Josantonius/PHP-Skeleton).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

2016 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).