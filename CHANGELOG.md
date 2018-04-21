# CHANGELOG

## 1.1.1 - 2018-04-22

* Fixed a bug in the `dispatch` method. The error callback will only be executed in the case of return false. This will prevent possible errors if the route method returns void.

## 1.1.0 - 2018-04-17

* Fixed a bug in the `checkRegexRoutes` method. Now routes with regular expressions will return only the parameters and not the entire segmented route.

## 1.0.9 - 2018-01-07

* The tests were fixed.

* Changes in documentation.

## 1.0.8 - 2017-11-09

* Implemented `PHP Mess Detector` to detect inconsistencies in code styles.

* Implemented `PHP Code Beautifier and Fixer` to fixing errors automatically.

* Implemented `PHP Coding Standards Fixer` to organize PHP code automatically according to PSR standards.

## 1.0.7 - 2017-11-02

* Implemented `PSR-4 autoloader standard` from all library files.

* Implemented `PSR-2 coding standard` from all library PHP files.

* Implemented `PHPCS` to ensure that PHP code complies with `PSR2` code standards.

* Implemented `Codacy` to automates code reviews and monitors code quality over time.

* Implemented `Codecov` to coverage reports.

* Added `Router/phpcs.ruleset.xml` file.

* Deleted `Router/src/bootstrap.php` file.

* Deleted `Router/tests/bootstrap.php` file.

* Deleted `Router/vendor` folder.

* Changed `Josantonius\Router\Test\RouterTest` class to  `Josantonius\Router\RouterTest` class.

* Deleted `Josantonius\Router\Router::addRoute()` method.
* Added `Josantonius\Router\Router::add()` method.

* Deleted `Josantonius\Router\Router::getRoute()` method.
* Added `Josantonius\Router\Router::getMethod()` method.

## 1.0.6 - 2017-09-14

* Unit tests supported by `PHPUnit` were added.

* The repository was synchronized with `Travis CI` to implement continuous integration.
 
* Added `Router/src/bootstrap.php` file

* Added `Router/tests/bootstrap.php` file.

* Added `Router/phpunit.xml.dist` file.
* Added `Router/_config.yml` file.
* Added `Router/.travis.yml` file.

* Added   `Josantonius\Router\Router::_cleanResources()` method.

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
* Added `Josantonius\Router\Test\RouterTest::testAddRoute()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithEndBackslash()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRoutes()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddWrongRoutes()` method.
* Added `Josantonius\Router\Test\RouterTest::testGetRoute()` method.
* Added `Josantonius\Router\Test\RouterTest::testGetRouteWithEndBackslash()` method.
* Added `Josantonius\Router\Test\RouterTest::testGetWrongRoute()` method.
* Added `Josantonius\Router\Test\RouterTest::testKeepLooking()` method.
* Added `Josantonius\Router\Test\RouterTest::testKeepLookingUpToThreeCoincidences()` method.
* Added `Josantonius\Router\Test\RouterTest::testNotKeepLooking()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRoute()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteWrongRoute()` method.
* Added `Josantonius\Router\Test\RouterTest::testDefineErrorCallback()` method.
* Added `Josantonius\Router\Test\RouterTest::testSetSingletonName()` method.
* Added `Josantonius\Router\Test\RouterTest::testSetSingletonNameError()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteWrongRouteWithCustomErrorCallback()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithAllRegExp()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRouteWithAllRegExp()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithAnyRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRouteWithAnyRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithNumRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRouteWithNumRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithHexRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRouteWithHexRegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testAddRouteWithUuidV4RegExpAndParams()` method.
* Added `Josantonius\Router\Test\RouterTest::testExecuteRouteWithUuidV4RegExpAndParams()` method.

* Added `Josantonius\Router\Test\Example` class.
* Added `Josantonius\Router\Test\Example::getInstance()` method.
* Added `Josantonius\Router\Test\Example::newSingleton()` method.
* Added `Josantonius\Router\Test\Example::services()` method.
* Added `Josantonius\Router\Test\Example::error()` method.
* Added `Josantonius\Router\Test\Example::blog()` method.

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

* Bugs fixed in `dispatch()` and `_checkRegexRoutes()` methods.

* Deleted `Josantonius\Router\Router::loadRegexRoutes()` method.
* Added   `Josantonius\Router\Router::_getRegexRoutes()` method.
* Added   `Josantonius\Router\Router::_getErrorCallback()` method.


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
