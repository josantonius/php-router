# PHP Router library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Router/v/stable)](https://packagist.org/packages/josantonius/Router) [![Latest Unstable Version](https://poser.pugx.org/josantonius/Router/v/unstable)](https://packagist.org/packages/josantonius/Router) [![License](https://poser.pugx.org/josantonius/Router/license)](LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c2721e75cb664951864a53122c6d035b)](https://www.codacy.com/app/Josantonius/PHP-Router?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Josantonius/PHP-Router&amp;utm_campaign=Badge_Grade) [![Total Downloads](https://poser.pugx.org/josantonius/Router/downloads)](https://packagist.org/packages/josantonius/Router) [![Travis](https://travis-ci.org/Josantonius/PHP-Router.svg)](https://travis-ci.org/Josantonius/PHP-Router) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![CodeCov](https://codecov.io/gh/Josantonius/PHP-Router/branch/master/graph/badge.svg)](https://codecov.io/gh/Josantonius/PHP-Router)

[English version](README.md)

Biblioteca para manejo de rutas.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Métodos disponibles](#métodos-disponibles)
- [Cómo empezar](#cómo-empezar)
- [Uso](#uso)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

## Requisitos

Esta clase es soportada por versiones de **PHP 5.6** o superiores y es compatible con versiones de **HHVM 3.0** o superiores.

## Instalación 

La mejor forma de instalar esta extensión es a través de [Composer](http://getcomposer.org/download/).

Para instalar **PHP Router library**, simplemente escribe:

    $ composer require Josantonius/Router

El comando anterior sólo instalará los archivos necesarios, si prefieres **descargar todo el código fuente** puedes utilizar:

    $ composer require Josantonius/Router --prefer-source

También puedes **clonar el repositorio** completo con Git:

  $ git clone https://github.com/Josantonius/PHP-Router.git

O **instalarlo manualmente**:

[Descargar Router.php](https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php):

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Router/master/src/Router.php

[Descargar Url.php](https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php):

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Url/master/src/Url.php

## Métodos disponibles

Métodos disponibles en esta biblioteca:

### - Definir el nombre del método que se usará para aplicar el patrón singleton:

```php
Router::setSingletonName($method);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $method | Nombre del método singleton. | string | Sí | |

**# Return** (boolean)

### - Añadir ruta/s:

```php
Router::add($routes);
```

| Atributo | Clave | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- | --- |
| $routes | | Ruta/s a agregar. | array | Sí | |
|  | 0 | Ruta. | string | Sí | |
|  | 1 | Método 'class@method'. | string | Sí | |

**# Return** (boolean)

### - Obtener método a llamar desde URI:

```php
Router::getMethod($route);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $route | Ruta. | string | Sí | |

**# Return** (string|null) → ruta o null

### - Definir método de llamada si no se encuentra la ruta:

```php
Router::error($callback);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $callback | Callback. | callable | Sí | |

**# Return** (boolean true)

### - Establecer si se continúa procesando después de encontrar coincidencia:

También se puede especificar el número de rutas totales a procesar.

```php
Router::keepLooking($value);
```

| Atributo | Descripción | Tipo | Requerido | Predeterminado
| --- | --- | --- | --- | --- |
| $value | Valor. | boolean|int | Sí | true |

**# Return** (boolean true)

### - Ejecutar llamada de retorno para la ruta:

```php
Router::dispatch();
```

**# Return** (respuesta de la llamada|false)

## Cómo empezar

Para utilizar esta biblioteca con **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Router\Router;
```

Si la instalaste **manualmente**, utiliza:

```php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Url.php';

use Josantonius\Router\Router;
```

## Uso

[Ejemplo](tests/Example.php) de uso para esta biblioteca:

### - Agregar ruta:

```php
Router::add([
    'services' => 'Josantonius\Router\Example@services'
]);
```

### - Agregar rutas:

```php
$routes = [
    'services' => 'Josantonius\Router\Example@services',
    'home'     => 'Josantonius\Router\Example@home',
];

Router::add($routes);
```

### - Ejecutar ruta simulando 'services':

```php
Router::dispatch(); // Response from services method
```

### - Añadir ruta con expresiones regulares (:all):

```php
Router::add([
    'blog/:all' => 'Josantonius\Router\Example@blog'
]);
```

### - Ejecutar ruta simulando 'language/PHP/':

```php
Router::dispatch(); // Response from services method
```

### - Añadir ruta con expresiones regulares (:any) y parámetros:

```php
Router::add([
    'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
]);
```

### - Ejecutar ruta simulando 'blog/games/Minecraft/':

```php
Router::dispatch(); // Response from blog method: games | Minecraft
```

### - Añadir ruta con expresiones regulares (:num) y parámetros:

```php
Router::add([
    blog/:any/:num/' => 'Josantonius\Router\Example@blog',
]);
```

### - Ejecutar ruta simulando 'blog/development/1/':

```php
Router::dispatch(); // Response from blog method: development | 1
```

### - Añadir ruta con expresiones regulares (:hex) y parámetros:

```php
Router::add([
    'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
]);
```

### - Ejecutar ruta simulando 'blog/color/e0a060/':

```php
Router::dispatch(); // Response from blog method: color | e0a060
```

### - Añadir ruta con expresiones regulares (:uuidV4) y parámetros:

```php
Router::add([
    'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
]);
```

### - Ejecutar ruta simulando 'blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/':

```php
Router::dispatch(); // Response from blog method: uuid | 11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000
```

### - Definir el nombre del método para usar el patrón singleton:

```php
Router::setSingletonName('newSingleton');
```

### - Obtener método desde ruta:

```php
Router::getMethod('services'); // Josantonius\Router\Example@services
```

### - Defines callback if route is not found:

```php
Router::error('Josantonius\Router\Example@error');
```

### - Ejecutar ruta incorrecta con método de error personalizado:

```php
Router::Router::dispatch('unknown'); // Response from error method
```

### - Continuar procesando después de encontrar coincidencia:

```php
Router::keepLooking();
```

### - Continuar procesando hasta encontrar 3 coincidencias:

```php
Router::keepLooking(3);
```

### - No seguir procesando después de encontrar coincidencia:

```php
Router::keepLooking(false);
```

## Tests 

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/) y seguir los siguientes pasos:

    $ git clone https://github.com/Josantonius/PHP-Router.git
    
    $ cd PHP-Router

    $ composer install

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Ejecutar pruebas de estándares de código [PSR2](http://www.php-fig.org/psr/psr-2/) con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias en el estilo de codificación:

    $ composer phpmd

Ejecutar todas las pruebas anteriores:

    $ composer tests

## ☑ Tareas pendientes

- [ ] Añadir nueva funcionalidad.
- [ ] Mejorar pruebas.
- [ ] Mejorar documentación.
- [ ] Refactorizar código para las reglas de estilo de código deshabilitadas. Ver [phpmd.xml](phpmd.xml) y [.php_cs.dist](.php_cs.dist).

## Contribuir

Si deseas colaborar, puedes echar un vistazo a la lista de
[issues](https://github.com/Josantonius/PHP-Router/issues) o [tareas pendientes](#-tareas-pendientes).

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Ejecuta el comando `composer install` para instalar dependencias.
  Esto también instalará las [dependencias de desarrollo](https://getcomposer.org/doc/03-cli.md#install).
* Ejecuta el comando `composer fix` para estandarizar el código.
* Ejecuta las [pruebas](#tests).
* Crea una nueva rama (**branch**), **commit**, **push** y envíame un
  [pull request](https://help.github.com/articles/using-pull-requests).

## Repositorio

La estructura de archivos de este repositorio se creó con [PHP-Skeleton](https://github.com/Josantonius/PHP-Skeleton).

## Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

## Copyright

2016 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).