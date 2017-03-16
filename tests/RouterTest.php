<?php 
/**
 * Library for handling routes.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Router
 * @since      1.0.0
 */


namespace Josantonius\Router\Tests;

use Josantonius\Router\Router;

/**
 * Tests class for Router library.
 *
 * @since 1.0.0
 */
class RouterTest { 

    /**
     * Add routes.
     *
     * By default it will look for the 'getInstance' method to use singleton 
     * pattern and create a single instance of the class. If it does not
     * exist it will create a new object.
     *
     * You can change the method name using Router::setSingletonName().
     *
     * @since 1.0.0
     */
    public static function testAddRoutes() {

        $routes = [
            '/'        => 'Josantonius\Router\Tests\Example@render',
            'home/'    => 'Josantonius\Router\Tests\Example@render',
            'contact/' => 'Josantonius\Router\Tests\Example@render',
        ];

        Router::addRoute($routes);
    }

    /**
     * Add routes.
     *
     * By default it will look for the 'getInstance' method to use singleton 
     * pattern and create a single instance of the class. If it does not
     * exist it will create a new object.
     *
     * You can change the method name using Router::setSingletonName(),
     *
     * @since 1.0.0
     */
    public static function testSetSingletonName() {

        Router::setSingletonName('newSingletonMethodName');

        $routes = [
            '/'        => 'Josantonius\Router\Tests\Example@render',
            'home/'    => 'Josantonius\Router\Tests\Example@render',
            'contact/' => 'Josantonius\Router\Tests\Example@render',
        ];

        Router::addRoute($routes);
    }

    /**
     * Execute routes.
     *
     * @since 1.0.0
     */
    public static function testExecuteRouters() {

        self::testAddRoutes();

        Router::dispatch();
    }
}
