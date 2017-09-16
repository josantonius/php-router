# CHANGELOG

## 1.0.6 - 2017-09-14

* Unit tests supported by `PHPUnit` were added.

* The repository was synchronized with Travis CI to implement continuous integration.
 
* Added `Router/src/bootstrap.php` file

* Added `Router/tests/bootstrap.php` file.

* Added `Router/phpunit.xml.dist` file.
* Added `Router/_config.yml` file.
* Added `Router/.travis.yml` file.

* Deleted `Josantonius\Router\Tests\RouterTest` class.
* Deleted `Josantonius\Router\Tests\RouterTest::testAddRoutes()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testSetSingletonName()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testExecuteRouters()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testGetRoute()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testkeepLooking1()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testkeepLooking2()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testkeepLooking3()` method.
* Deleted `Josantonius\Router\Tests\RouterTest::testDefineErrorCallback()` method.

* Added `Josantonius\Router\Test\RouterTest` class.
* Added `Josantonius\Router\Test\RouterTest::testAddRoutes()` method.

## 1.0.5 - 2017-07-16

* Deleted `Josantonius\Router\Exception\RouterException` class.
* Deleted `Josantonius\Router\Exception\Exceptions` abstract class.
* Deleted `Josantonius\Router\Exception\RouterException->__construct()` method.

## 1.0.4 - 2017-05-15

* Deleted `Josantonius\Router\Router::haltOnMatch()` method.
* Added   `Josantonius\Router\Router::keepLooking()` method.

* Added `Josantonius\Router\Tests\RouterTest::testGetRoute()` method.
* Added `Josantonius\Router\Tests\RouterTest::testkeepLooking1()` method.
* Added `Josantonius\Router\Tests\RouterTest::testkeepLooking2()` method.
* Added `Josantonius\Router\Tests\RouterTest::testkeepLooking3()` method.
* Added `Josantonius\Router\Tests\RouterTest::testDefineErrorCallback()` method.

* Bugs fixed in dispatch() method.
* Bugs fixed in _checkRoutes() method.
* Bugs fixed in _checkRegexRoutes() method.

* Now from the keepLooking() method, in addition to establishing whether to continue processing routes, it will be possible to indicate the number of routes to be processed.

## 1.0.3 - 2017-05-09

* Deleted `Josantonius\Router\Router::loadRegexRoutes()` method.
* Added   `Josantonius\Router\Router::_getRegexRoutes()` method.
* Added   `Josantonius\Router\Router::_getErrorCallback()` method.

* Bugs fixed in dispatch() and _checkRegexRoutes() methods.

## 1.0.2 - 2017-03-18

* Some files were excluded from download and comments and readme files were updated.

## 1.0.1 - 2017-03-17

* Added   `Josantonius/Url` library.
* Deleted `Josantonius\Router\Router::getUriMethods()` method.

## 1.0.0 - 2017-03-16

* Added `Josantonius\Router\Router` class.
* Added `Josantonius\Router\Router::__callstatic()` method.
* Added `Josantonius\Router\Router::setSingletonName()` method.
* Added `Josantonius\Router\Router::addRoute()` method.
* Added `Josantonius\Router\Router::getRoute()` method.
* Added `Josantonius\Router\Router::loadRegexRoutes()` method.
* Added `Josantonius\Router\Router::error()` method.
* Added `Josantonius\Router\Router::haltOnMatch()` method.
* Added `Josantonius\Router\Router::dispatch()` method.
* Added `Josantonius\Router\Router::getUriMethods()` method.
* Added `Josantonius\Router\Router::_parseUrl()` method.
* Added `Josantonius\Router\Router::_checkRoutes()` method.
* Added `Josantonius\Router\Router::_checkRegexRoutes()` method.
* Added `Josantonius\Router\Router::invokeObject()` method.
* Added `Josantonius\Router\Router::_routeValidator()` method.

## 1.0.0 - 2017-03-16

* Added `Josantonius\Router\Exception\RouterException` class.
* Added `Josantonius\Router\Exception\Exceptions` abstract class.
* Added `Josantonius\Router\Exception\RouterException->__construct()` method.

## 1.0.0 - 2017-03-16

* Added `Josantonius\Router\Tests\RouterTest` class.
* Added `Josantonius\Router\Tests\RouterTest::testAddRoutes()` method.
* Added `Josantonius\Router\Tests\RouterTest::testSetSingletonName()` method.
* Added `Josantonius\Router\Tests\RouterTest::testExecuteRouters()` method.
