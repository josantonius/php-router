# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/router/v/stable)](https://packagist.org/packages/josantonius/router) [![Total Downloads](https://poser.pugx.org/josantonius/router/downloads)](https://packagist.org/packages/josantonius/router) [![Latest Unstable Version](https://poser.pugx.org/josantonius/router/v/unstable)](https://packagist.org/packages/josantonius/router) [![License](https://poser.pugx.org/josantonius/router/license)](https://packagist.org/packages/josantonius/router)

[English version](README-ES.md)

Librería para manejo de rutas.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Métodos disponibles](#métodos-disponibles)
- [Uso](#uso)
- [Tests](#tests)
- [Manejador de excepciones](#manejador-de-excepciones)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

### Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP Router library, simplemente escribe:

    $ composer require Josantonius/Router

### Requisitos

Esta ĺibrería es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

Para utilizar esta librería en HHVM (HipHop Virtual Machine) tendrás que activar los tipos escalares. Añade la siguiente ĺínea "hhvm.php7.scalar_types = true" en tu "/etc/hhvm/php.ini".

### Cómo empezar y ejemplos

Para utilizar esta librería, simplemente:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;
```
### Métodos disponibles

Métodos disponibles en esta librería:

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
### Uso

Ejemplo de uso para esta librería:

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

Para utilizar la clase de [pruebas](tests), simplemente:

```php
<?php
$loader = require __DIR__ . '/vendor/autoload.php';

$loader->addPsr4('Josantonius\\Router\\Tests\\', __DIR__ . '/vendor/josantonius/router/tests');

use Josantonius\Router\Tests\RouterTest;
```
Métodos de prueba disponibles en esta librería:

```php
RouterTest::testAddRoutes();
RouterTest::testSetSingletonName();
RouterTest::testExecuteRoutes();
```

### Manejador de excepciones

Esta librería utiliza [control de excepciones](src/Exception) que puedes personalizar a tu gusto.
### Contribuir
1. Comprobar si hay incidencias abiertas o abrir una nueva para iniciar una discusión en torno a un fallo o función.
1. Bifurca la rama del repositorio en GitHub para iniciar la operación de ajuste.
1. Escribe una o más pruebas para la nueva característica o expón el error.
1. Haz cambios en el código para implementar la característica o reparar el fallo.
1. Envía pull request para fusionar los cambios y que sean publicados.

Esto está pensado para proyectos grandes y de larga duración.

### Repositorio

Los archivos de este repositorio se crearon y subieron automáticamente con [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### Licencia

Este proyecto está licenciado bajo la **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil... ¡házmelo saber! Sígueme en [Twitter](https://twitter.com/Josantonius).
