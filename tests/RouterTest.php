<?php
/**
 * Library for handling routes.
 *
 * @author    Josantonius  - <hello@josantonius.com>
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.6
 */
namespace Josantonius\Router;

use PHPUnit\Framework\TestCase;

/**
 * Tests class for Router library.
 */
final class RouterTest extends TestCase
{
    /**
     * Router instance.
     *
     * @since 1.0.8
     *
     * @var object
     */
    protected $Router;

    /**
     * Set up.
     *
     * @since 1.0.8
     */
    public function setUp()
    {
        parent::setUp();

        $this->Router = new Router;
    }

    /**
     * Check if it is an instance of Router.
     *
     * @since 1.0.8
     */
    public function testIsInstanceOfRouter()
    {
        $this->assertInstanceOf('Josantonius\Router\Router', $this->Router);
    }

    /**
     * Add route.
     */
    public function testAddRoute()
    {
        $router = $this->Router;

        $route = ['services' => 'Josantonius\Router\Example@services'];

        $this->assertTrue($router::add($route));
    }

    /**
     * Add route with end backslash.
     */
    public function testAddRouteWithEndBackslash()
    {
        $router = $this->Router;

        $route = ['services/' => 'Josantonius\Router\Example@services'];

        $this->assertTrue($router::add($route));
    }

    /**
     * Add routes.
     */
    public function testAddRoutes()
    {
        $router = $this->Router;

        $routes = [
            'services' => 'Josantonius\Router\Example@services',
            'home' => 'Josantonius\Router\Example@home',
        ];

        $this->assertTrue($router::add($routes));
    }

    /**
     * Add wrong routes.
     */
    public function testAddWrongRoutes()
    {
        $router = $this->Router;

        $routes = 'services/';

        $this->assertFalse($router::add($routes));
    }

    /**
     * Get method.
     */
    public function testGetMethod()
    {
        $router = $this->Router;

        $this->assertContains(
            'Josantonius\Router\Example@services',
            $router::getMethod('services')
        );
    }

    /**
     * Get method with end backslash.
     */
    public function testGetMethodWithEndBackslash()
    {
        $router = $this->Router;

        $this->assertContains(
            'Josantonius\Router\Example@services',
            $router::getMethod('services/')
        );
    }

    /**
     * Get method from wrong route.
     */
    public function testGetMethodFromWrongRoute()
    {
        $router = $this->Router;

        $this->assertNull($router::getMethod('?????'));
    }

    /**
     * Continue processing after match.
     */
    public function testKeepLooking()
    {
        $router = $this->Router;

        $this->assertTrue($router::keepLooking());
    }

    /**
     * Keep Lookin up to three coincidences.
     */
    public function testKeepLookingUpToThreeCoincidences()
    {
        $router = $this->Router;

        $this->assertTrue($router::keepLooking(3));
    }

    /**
     * Stopping processing after match.
     */
    public function testNotKeepLooking()
    {
        $router = $this->Router;

        $this->assertTrue($router::keepLooking(false));
    }

    /**
     * Execute route simulating the url http://localhost/services.
     */
    public function testExecuteRoute()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'services';

        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertContains(
            'Response from services method',
            $router->dispatch()
        );
    }

    /**
     * Execute wrong route simulating the url http://localhost/unknown.
     */
    public function testExecuteWrongRoute()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'unknown';

        $this->assertFalse($router->dispatch());
    }

    /**
     * Defines callback if route is not found.
     */
    public function testDefineErrorCallback()
    {
        $router = $this->Router;

        $this->assertTrue(
            $router::error('Josantonius\Router\Example@error')
        );
    }

    /**
     * Set method name for use singleton pattern.
     */
    public function testSetSingletonName()
    {
        $router = $this->Router;

        $this->assertTrue($router::setSingletonName('newSingleton'));
    }

    /**
     * Set method name wrong for use singleton pattern.
     */
    public function testSetSingletonNameError()
    {
        $router = $this->Router;

        $this->assertFalse($router::setSingletonName(''));
    }

    /**
     * Execute wrong routes with custom error callback.
     */
    public function testExecuteWrongRouteWithCustomErrorCallback()
    {
        $router = $this->Router;

        $this->assertContains(
            'Response from error method',
            $router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:all).
     */
    public function testAddRouteWithAllRegExp()
    {
        $router = $this->Router;

        $route = [
            'blog/:all' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($router::add($route));
    }

    /**
     * Execute route simulating the url http://localhost/language/PHP/.
     */
    public function testExecuteRouteWithAllRegExp()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'blog/language/PHP/';

        $this->assertContains(
            'Response from blog method: language | PHP',
            $router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:any) and params.
     */
    public function testAddRouteWithAnyRegExpAndParams()
    {
        $router = $this->Router;

        $route = [
            'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/games/Minecraft/.
     */
    public function testExecuteRouteWithAnyRegExpAndParams()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'blog/games/Minecraft/';

        $this->assertContains(
            'Response from blog method: games | Minecraft',
            $router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:num) and params.
     */
    public function testAddRouteWithNumRegExpAndParams()
    {
        $router = $this->Router;

        $route = [
            'blog/:any/:num/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/development/1/.
     */
    public function testExecuteRouteWithNumRegExpAndParams()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'blog/development/1/';

        $this->assertContains(
            'Response from blog method: development | 1',
            $router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:hex) and params.
     */
    public function testAddRouteWithHexRegExpAndParams()
    {
        $router = $this->Router;

        $route = [
            'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/color/e0a060/.
     */
    public function testExecuteRouteWithHexRegExpAndParams()
    {
        $router = $this->Router;

        $_SERVER['REQUEST_URI'] = 'blog/color/e0a060/';

        $this->assertContains(
            'Response from blog method: color | e0a060',
            $router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:uuidV4) and params.
     */
    public function testAddRouteWithUuidV4RegExpAndParams()
    {
        $router = $this->Router;

        $route = [
            'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($router::add($route));
    }

    /**
     * Execute route simulating url:
     *
     * http://localhost/blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/
     */
    public function testExecuteRouteWithUuidV4RegExpAndParams()
    {
        $router = $this->Router;

        $uuid = '11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000';

        $_SERVER['REQUEST_URI'] = 'blog/uuid/' . $uuid;

        $this->assertContains(
            'Response from blog method: uuid | ' . $uuid,
            $router::dispatch()
        );
    }
}
