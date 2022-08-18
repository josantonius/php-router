# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Router/v/stable)](https://packagist.org/packages/josantonius/Router)
[![License](https://poser.pugx.org/josantonius/Router/license)](LICENSE)

[Versión en español](README-ES.md)

Library for handling routes.

> This documentation refers to version [1.1.1](https://github.com/josantonius/php-router/tree/1.1.1).
> Changes made in version 1.1.2 (which archived the repository) were not documented or tested.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Methods](#available-methods)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Tests](#tests)
- [Sponsor](#Sponsor)
- [License](#license)

---

## Requirements

This library is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP Router library**, simply:

    composer require Josantonius/Router

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    composer require Josantonius/Router --prefer-source

You can also **clone the complete repository** with Git:

  $ git clone <https://github.com/Josantonius/PHP-Router.git>

Or **install it manually**:

Download [Router.php](https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php) and [Url.php](https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php):

    wget https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php

    wget https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php

## Available Methods

Available methods in this library:

### - Set method name for use singleton pattern

```php
Router::setSingletonName($method);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $method | Singleton method name. | string | Yes | |

**# Return** (boolean)

### - Add route/s

```php
Router::add($routes);
```

| Attribute | Key | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| $routes | | Route/s to add. | array | Yes | |
|  | 0 | Route. | string | Yes | |
|  | 1 | Method 'class@method'. | string | Yes | |

**# Return** (boolean)

### - Get method to call from URI

```php
Router::getMethod($route);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $route | Route. | string | Yes | |

**# Return** (string|null) → route or null

### - Defines callback if route is not found

```php
Router::error($callback);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $callback | Callback. | callable | Yes | |

**# Return** (boolean true)

### - Continue processing after match or stop it

Also can specify the number of total routes to process.

```php
Router::keepLooking($value);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $value | Value. | boolean|int | Yes | true |

**# Return** (boolean true)

### - Runs the callback for the given request

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

### - Add route

```php
Router::add([
    'services' => 'Josantonius\Router\Example@services'
]);
```

### - Add routes

```php
$routes = [
    'services' => 'Josantonius\Router\Example@services',
    'home'     => 'Josantonius\Router\Example@home',
];

Router::add($routes);
```

### - Execute route simulating 'services'

```php
Router::dispatch(); // Response from services method
```

### - Add route with regular expressions (:all)

```php
Router::add([
    'blog/:all' => 'Josantonius\Router\Example@blog'
]);
```

### - Execute route simulating 'language/PHP/'

```php
Router::dispatch(); // Response from services method
```

### - Add route with regular expressions (:any) and params

```php
Router::add([
    'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/games/Minecraft/'

```php
Router::dispatch(); // Response from blog method: games | Minecraft
```

### - Add route with regular expressions (:num) and params

```php
Router::add([
    blog/:any/:num/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/development/1/'

```php
Router::dispatch(); // Response from blog method: development | 1
```

### - Add route with regular expressions (:hex) and params

```php
Router::add([
    'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/color/e0a060/'

```php
Router::dispatch(); // Response from blog method: color | e0a060
```

### - Add route with regular expressions (:uuidV4) and params

```php
Router::add([
    'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
]);
```

### - Execute route simulating 'blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/'

```php
Router::dispatch(); // Response from blog method: uuid | 11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000
```

### - Set method name for use singleton pattern

```php
Router::setSingletonName('newSingleton');
```

### - Get method

```php
Router::getMethod('services'); // Josantonius\Router\Example@services
```

### - Defines callback if route is not found

```php
Router::error('Josantonius\Router\Example@error');
```

### - Execute wrong routes with custom error callback

```php
Router::dispatch('unknown'); // Response from error method
```

### - Continue processing after match

```php
Router::keepLooking();
```

### - Keep Lookin up to three coincidences

```php
Router::keepLooking(3);
```

### - Stopping processing after match

```php
Router::keepLooking(false);
```

## Tests

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

    git clone https://github.com/Josantonius/PHP-Router.git
    
    cd PHP-Router

    composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    composer phpunit

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    composer phpcs

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

    composer phpmd

Run all previous tests:

    composer tests

## Sponsor

If this project helps you to reduce your development time,
[you can sponsor me](https://github.com/josantonius#sponsor) to support my open source work :blush:

## License

This repository is licensed under the [MIT License](LICENSE).

Copyright © 2016-2022, [Josantonius](https://github.com/josantonius#contact)
