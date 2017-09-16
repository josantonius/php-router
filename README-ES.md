# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/router/v/stable)](https://packagist.org/packages/josantonius/router) [![Total Downloads](https://poser.pugx.org/josantonius/router/downloads)](https://packagist.org/packages/josantonius/router) [![Latest Unstable Version](https://poser.pugx.org/josantonius/router/v/unstable)](https://packagist.org/packages/josantonius/router) [![License](https://poser.pugx.org/josantonius/router/license)](https://packagist.org/packages/josantonius/router) [![Travis](https://travis-ci.org/Josantonius/PHP-Router.svg)](https://travis-ci.org/Josantonius/PHP-Router)

[English version](README.md)

Biblioteca para manejo de rutas.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Métodos disponibles](#métodos-disponibles)
- [Uso](#uso)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

### Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP Router library, simplemente escribe:

    $ composer require Josantonius/Router

El comando anterior sólo instalará los archivos necesarios, si prefieres descargar todo el código fuente (incluyendo tests, directorio vendor, excepciones no utilizadas, documentos...) puedes utilizar:

    $ composer require Josantonius/Router --prefer-source

También puedes clonar el repositorio completo con Git:

	$ git clone https://github.com/Josantonius/PHP-Router.git

### Requisitos

Esta biblioteca es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

Para utilizar esta biblioteca en HHVM (HipHop Virtual Machine) tendrás que activar los tipos escalares. Añade la siguiente ĺínea "hhvm.php7.scalar_types = true" en tu "/etc/hhvm/php.ini".

### Cómo empezar y ejemplos

Para utilizar esta biblioteca, simplemente:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;
```
### Métodos disponibles

Métodos disponibles en esta biblioteca:

```php
Router::__callstatic();
Router::setSingletonName();
Router::addRoute();
Router::getRoute();
Router::error();
Router::keepLooking();
Router::dispatch();
```
### Uso

Ejemplo de uso para esta biblioteca:

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

Para ejecutar las [pruebas](tests/Router/Test) simplemente:

    $ git clone https://github.com/Josantonius/PHP-Router.git
    
    $ cd PHP-Router

    $ phpunit

### ☑ Tareas pendientes

- [x] Completar tests
- [ ] Mejorar la documentación

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

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).