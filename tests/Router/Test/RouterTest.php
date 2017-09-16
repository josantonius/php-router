<?php 
/**
 * Library for handling routes.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Router
 * @since      1.0.6
 */

namespace Josantonius\Router\Test;

use Josantonius\Router\Router,
    PHPUnit\Framework\TestCase;

/**
 * Tests class for Router library.
 *
 * @since 1.0.6
 */
final class RouterTest extends TestCase { 

    /**
     * Add route.
     *
     * @since 1.0.6
     */
    public function testAddRoute() {

        $route = ['/' => 'Josantonius\Router\Test\Example@render'];

        $this->assertTrue(Router::addRoute($route));
    }

    /**
     * Add routes.
     *
     * @since 1.0.6
     */
    public function testAddRoutes() {

        $routes = [

            'services/'      => 'Josantonius\Router\Test\Example@services',
            'contact/:all/'  => 'Josantonius\Router\Test\Example@contact',
        ];

        $this->assertTrue(Router::addRoute($routes));
    }



    /**
     * Execute route simulating the url https://localhost/contact/any.
     *
     * @since 1.0.6
     */
    public function testExecuteRegExpRoute() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'contact/anss';
        
        $this->assertContains( 

            'Response from contact method',
            Router::dispatch() 
        );
    }
}

class Example {

    public static $instance;

    public static function getInstance() { return new self; }

    public static function newSingleton() { return self::getInstance(); }
    
    public function services() { return 'Response from services method'; }

    public function contact() { return 'Response from contact method'; }

    public function error() { return 'Response from error method'; }
}
