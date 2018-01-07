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
        $route = ['services' => 'Josantonius\Router\Example@services'];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Add route with end backslash.
     */
    public function testAddRouteWithEndBackslash()
    {
        $route = ['services/' => 'Josantonius\Router\Example@services'];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Add routes.
     */
    public function testAddRoutes()
    {
        $routes = [
            'services' => 'Josantonius\Router\Example@services',
            'home' => 'Josantonius\Router\Example@home',
        ];

        $this->assertTrue($this->Router->add($routes));
    }

    /**
     * Add wrong routes.
     */
    public function testAddWrongRoutes()
    {
        $routes = 'services/';

        $this->assertFalse($this->Router->add($routes));
    }

    /**
     * Get method.
     */
    public function testGetMethod()
    {
        $this->assertContains(
            'Josantonius\Router\Example@services',
            $this->Router->getMethod('services')
        );
    }

    /**
     * Get method with end backslash.
     */
    public function testGetMethodWithEndBackslash()
    {
        $this->assertContains(
            'Josantonius\Router\Example@services',
            $this->Router->getMethod('services/')
        );
    }

    /**
     * Get method from wrong route.
     */
    public function testGetMethodFromWrongRoute()
    {
        $this->assertNull($this->Router->getMethod('?????'));
    }

    /**
     * Continue processing after match.
     */
    public function testKeepLooking()
    {
        $this->assertTrue($this->Router->keepLooking());
    }

    /**
     * Keep Lookin up to three coincidences.
     */
    public function testKeepLookingUpToThreeCoincidences()
    {
        $this->assertTrue($this->Router->keepLooking(3));
    }

    /**
     * Stopping processing after match.
     */
    public function testNotKeepLooking()
    {
        $this->assertTrue($this->Router->keepLooking(false));
    }

    /**
     * Execute route simulating the url http://localhost/services.
     */
    public function testExecuteRoute()
    {
        $_SERVER['REQUEST_URI'] = 'services';

        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertContains(
            'Response from services method',
            $this->Router->dispatch()
        );
    }

    /**
     * Execute wrong route simulating the url http://localhost/unknown.
     */
    public function testExecuteWrongRoute()
    {
        $_SERVER['REQUEST_URI'] = 'unknown';

        $this->assertFalse($this->Router->dispatch());
    }

    /**
     * Defines callback if route is not found.
     */
    public function testDefineErrorCallback()
    {
        $this->assertTrue(
            $this->Router->error('Josantonius\Router\Example@error')
        );
    }

    /**
     * Set method name for use singleton pattern.
     */
    public function testSetSingletonName()
    {
        $this->assertTrue($this->Router->setSingletonName('newSingleton'));
    }

    /**
     * Set method name wrong for use singleton pattern.
     */
    public function testSetSingletonNameError()
    {
        $this->assertFalse($this->Router->setSingletonName(''));
    }

    /**
     * Execute wrong routes with custom error callback.
     */
    public function testExecuteWrongRouteWithCustomErrorCallback()
    {
        $this->assertContains(
            'Response from error method',
            $this->Router->dispatch()
        );
    }

    /**
     * Add route with regular expressions (:all).
     */
    public function testAddRouteWithAllRegExp()
    {
        $route = [
            'blog/:all' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Execute route simulating the url http://localhost/language/PHP/.
     */
    public function testExecuteRouteWithAllRegExp()
    {
        $_SERVER['REQUEST_URI'] = 'blog/language/PHP/';

        $this->assertContains(
            'Response from blog method: language | PHP',
            $this->Router->dispatch()
        );
    }

    /**
     * Add route with regular expressions (:any) and params.
     */
    public function testAddRouteWithAnyRegExpAndParams()
    {
        $route = [
            'blog/:any/:any/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/games/Minecraft/.
     */
    public function testExecuteRouteWithAnyRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/games/Minecraft/';

        $this->assertContains(
            'Response from blog method: games | Minecraft',
            $this->Router->dispatch()
        );
    }

    /**
     * Add route with regular expressions (:num) and params.
     */
    public function testAddRouteWithNumRegExpAndParams()
    {
        $route = [
            'blog/:any/:num/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/development/1/.
     */
    public function testExecuteRouteWithNumRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/development/1/';

        $this->assertContains(
            'Response from blog method: development | 1',
            $this->Router->dispatch()
        );
    }

    /**
     * Add route with regular expressions (:hex) and params.
     */
    public function testAddRouteWithHexRegExpAndParams()
    {
        $route = [
            'blog/:any/:hex/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Execute route simulating url http://localhost/blog/color/e0a060/.
     */
    public function testExecuteRouteWithHexRegExpAndParams()
    {
        $_SERVER['REQUEST_URI'] = 'blog/color/e0a060/';

        $this->assertContains(
            'Response from blog method: color | e0a060',
            $this->Router->dispatch()
        );
    }

    /**
     * Add route with regular expressions (:uuidV4) and params.
     */
    public function testAddRouteWithUuidV4RegExpAndParams()
    {
        $route = [
            'blog/:any/:uuidV4/' => 'Josantonius\Router\Example@blog',
        ];

        $this->assertTrue($this->Router->add($route));
    }

    /**
     * Execute route simulating url:
     *
     * http://localhost/blog/uuid/11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000/
     */
    public function testExecuteRouteWithUuidV4RegExpAndParams()
    {
        $uuid = '11bf5b37-e0b8-42e0-8dcf-dc8c4aefc000';

        $_SERVER['REQUEST_URI'] = 'blog/uuid/' . $uuid;

        $this->assertContains(
            'Response from blog method: uuid | ' . $uuid,
            $this->Router->dispatch()
        );
    }
}
