<?php
/**
 * Library for handling routes.
 *
 * @author    Josantonius  - <hello@josantonius.com>
 * @copyright 2017 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.6
 */

namespace Josantonius\Router;

use PHPUnit\Framework\TestCase;

/**
 * Tests class for Router library.
 *
 * @since 1.0.6
 */
final class RouterTest extends TestCase
{
    /**
     * Add route.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRoute()
    {
        $route = ['services' => 'Josantonius\Router\Example@services'];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Add route with end backslash.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithEndBackslash()
    {
        $route = ['services/' => 'Josantonius\Router\Example@services'];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Add routes.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRoutes()
    {
        $routes = [

            'services' => 'Josantonius\Router\Example@services',
            'home'     => 'Josantonius\Router\Example@home',
        ];

        $this->assertTrue(Router::add($routes));
    }

    /**
     * Add wrong routes.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddWrongRoutes()
    {
        $routes = 'services/';

        $this->assertFalse(Router::add($routes));
    }

    /**
     * Get method.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testGetMethod()
    {
        $this->assertContains(

            'Josantonius\Router\Example@services',
            Router::getMethod('services')
        );
    }

    /**
     * Get method with end backslash.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testGetMethodWithEndBackslash()
    {
        $this->assertContains(

            'Josantonius\Router\Example@services',
            Router::getMethod('services/')
        );
    }

    /**
     * Get method from wrong route.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testGetMethodFromWrongRoute()
    {
        $this->assertNull(Router::getMethod('?????'));
    }

    /**
     * Continue processing after match.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testKeepLooking()
    {
        $this->assertTrue(Router::keepLooking());
    }

    /**
     * Keep Lookin up to three coincidences.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testKeepLookingUpToThreeCoincidences()
    {
        $this->assertTrue(Router::keepLooking(3));
    }

    /**
     * Stopping processing after match.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testNotKeepLooking()
    {
        $this->assertTrue(Router::keepLooking(false));
    }

    /**
     * Execute route simulating the url http://localhost/services.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRoute()
    {
        $_SERVER['REQUEST_URI'] = 'services';

        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertContains(
            'Response from services method',
            Router::dispatch()
        );
    }

    /**
     * Execute wrong route simulating the url http://localhost/unknown.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteWrongRoute()
    {
        $_SERVER['REQUEST_URI'] = 'unknown';

        $this->assertFalse(Router::dispatch());
    }

    /**
     * Defines callback if route is not found.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testDefineErrorCallback()
    {
        $this->assertTrue(

            Router::error('Josantonius\Router\Example@error')
        );
    }

    /**
     * Set method name for use singleton pattern.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testSetSingletonName()
    {
        $this->assertTrue(Router::setSingletonName('newSingleton'));
    }

    /**
     * Set method name wrong for use singleton pattern.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testSetSingletonNameError()
    {
        $this->assertFalse(Router::setSingletonName(''));
    }

    /**
     * Execute wrong routes with custom error callback.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteWrongRouteWithCustomErrorCallback()
    {
        $this->assertContains(
            'Response from error method',
            Router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:all).
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithAllRegExp()
    {
        $route = [
            'blog/:all' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Execute route simulating the url http://localhost/language/PHP/.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRouteWithAllRegExp()
    {
        $_SERVER['REQUEST_URI'] = 'blog/language/PHP/';

        $this->assertContains(
            'Response from blog method: language | PHP',
            Router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:any) and params.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithAnyRegExpAndParams()
    {
        $route = [
            'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/games/Minecraft/.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRouteWithAnyRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/games/Minecraft/';

        $this->assertContains(
            'Response from blog method: games | Minecraft',
            Router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:num) and params.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithNumRegExpAndParams()
    {
        $route = [
            'blog/:any/:num/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/development/1/.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRouteWithNumRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/development/1/';

        $this->assertContains(
            'Response from blog method: development | 1',
            Router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:hex) and params.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithHexRegExpAndParams()
    {
        $route = [
            'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/color/e0a060/.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRouteWithHexRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/color/e0a060/';

        $this->assertContains(
            'Response from blog method: color | e0a060',
            Router::dispatch()
        );
    }

    /**
     * Add route with regular expressions (:uuidV4) and params.
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testAddRouteWithUuidV4RegExpAndParams()
    {
        $route = [
            'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue(Router::add($route));
    }

    /**
     * Execute route simulating url:
     *
     * http://localhost/blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/
     *
     * @since 1.0.6
     *
     * @return void
     */
    public function testExecuteRouteWithUuidV4RegExpAndParams()
    {
        $uuid = '11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000';

        $_SERVER['REQUEST_URI'] = 'blog/uuid/' . $uuid;

        $this->assertContains(
            'Response from blog method: uuid | ' . $uuid,
            Router::dispatch()
        );
    }
}
