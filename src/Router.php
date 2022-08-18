<?php

/**
 * Library for handling routes.
 *
 * @author    Josantonius - <hello@josantonius.com>
 * @copyright 2017 - 2019 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.0
 */

namespace Josantonius\Router;

use Josantonius\Url\Url;
use Josantonius\Router\Exception\RouterException;

/**
 * Route handler.
 */
class Router
{
    /**
     * Number of matching routes to run.
     *
     * @since 2.0.0
     *
     * @var int
     */
    private static $processingLimit = 1;

    /**
     * Array of routes.
     *
     * @var array
     */
    private static $routes = [];

    /**
     * URI that is accessed.
     *
     * @var null
     */
    private static $uri;

    /**
     * Set a route error callback.
     *
     * @since 2.0.0
     *
     * @var array
     */
    private static $routeErrorHook;

    /**
     * Before call route method callback.
     *
     * @since 2.0.0
     *
     * @var array
     */
    private static $beforeCallMethodHook;

    /**
     * Method name to use the singleton pattern and just create an instance.
     *
     * @var string
     */
    private static $singletonMethod = 'getInstance';

    /**
     * Set route patterns.
     *
     * @var array
     */
    private static $patterns = [
        ':any' => '[^/]+',
        ':word' => '[a-zA-Z]+',
        ':num' => '-?[0-9]+',
        ':all' => '.*',
        ':hex' => '[[:xdigit:]]+',
        ':uuidV4' => '\w{8}-\w{4}-\w{4}-\w{4}-\w{12}',
    ];

    /**
     * Add route/s.
     */
    public static function add(array $routes): bool
    {
        self::$routes = $routes;

        foreach (self::$routes as $index => &$route) {
            self::validateRequiredParams($route, $index);
            self::normalizeParams($route);
        }

        self::sortRoutes();

        return true;
    }

    /**
     * Runs the callback/s for the given request.
     *
     * @return mixed → call method response
     */
    public static function dispatch()
    {
        self::setUri();

        $matches = self::getMatches();

        foreach ($matches as $index) {
            $route = self::$routes[$index];

            $class = $route['class'];
            $method = $route['method'];
            $params = $route['params'];

            self::runBeforeCallMethodHook($route);

            $response = self::callMethod($class, $method, $params);
        }

        return $response ?? self::runRouteErrorHook();
    }

    /**
     * Set method name for use singleton pattern.
     *
     * @since 2.0.0
     */
    public static function setSingletonMethod(string $method): bool
    {
        self::$singletonMethod = $method;

        return true;
    }

    /**
     * Set route error hook.
     *
     * @since 2.0.0
     */
    public static function setRouteErrorHook($class, string $method): bool
    {
        self::$routeErrorHook = [
            'class' => $class,
            'method' => $method
        ];

        return true;
    }

    /**
     * Set before call method hook.
     *
     * @since 2.0.0
     */
    public static function setBeforeCallMethodHook($class, string $method): bool
    {
        self::$beforeCallMethodHook = [
            'class' => $class,
            'method' => $method
        ];

        return true;
    }

    /**
     * Set the number of routes to run.
     *
     * @since 2.0.0
     */
    public static function setProcessingLimit(int $value = 999): bool
    {
        self::$processingLimit = $value;

        return true;
    }

    /**
     * Get the number of routes to run.
     *
     * @since 2.0.0
     */
    public static function getProcessingLimit(): int
    {
        return self::$processingLimit;
    }

    /**
     * Set URI.
     *
     * @since 2.0.0
     *
     * @uses string Url::getUriMethods → remove subdirectories & get methods
     * @uses string Url::setUrlParams  → return url without url params
     * @uses string Url::addBackSlash  → add backslash if it doesn't exist
     */
    private static function setUri(): void
    {
        $uri = Url::setUrlParams(Url::getUriMethods());

        self::$uri = Url::addBackSlash($uri);
    }

    /**
     * Validate the required parameters for the route.
     *
     * @since 2.0.0
     *
     * @throws RouterException → if the required parameters for the route aren't received
     */
    private static function validateRequiredParams(array $route, int $index): void
    {
        $required = array('name', 'path', 'class', 'method');

        if (count(array_intersect_key(array_flip($required), $route)) !== 4) {
            throw new RouterException(
                "Route with index $index doesn't contain the required parameters: " .
                    implode($required, ', ') . '.'
            );
        }
    }

    /**
     * Normalize route parameters.
     *
     * @since 2.0.0
     */
    private static function normalizeParams(array &$route): void
    {
        $route['path'] = Url::addBackSlash($route['path']);
        $route['order'] = $route['order'] ?? 8;
        $route['params'] = $route['params'] ?? [];
    }

    /**
     * Sort routes.
     *
     * @since 2.0.0
     */
    private static function sortRoutes(): void
    {
        usort(self::$routes, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });
    }

    /**
     * Get matches for the received route.
     *
     * @since 2.0.0
     */
    private static function getMatches(): array
    {
        $matches = array_keys(array_column(self::$routes, 'path'), self::$uri);

        if (self::getProcessingLimit() > count($matches)) {
            self::setRegexMatches($matches);
        }

        return array_slice($matches, 0, self::getProcessingLimit());
    }

    /**
     * Set regular expression matches for the received route.
     *
     * @since 2.0.0
     */
    private static function setRegexMatches(array &$matches): void
    {
        $searches = array_keys(self::$patterns);
        $replaces = array_values(self::$patterns);

        foreach (self::$routes as $index => &$route) {
            if (self::getProcessingLimit() === count($matches)) {
                break;
            }

            if (self::hasRegexMatch($route, $searches, $replaces)) {
                self::setRouteParams($route, $searches);
                $matches[] = $index;
            }
        }
    }

    /**
     * Check if route is defined with regular expression.
     *
     * @since 2.0.0
     */
    private static function hasRegexMatch(array $route, array $searches, array $replaces): bool
    {
        $path = $route['path'];

        if (strpos($path, ':') !== false) {
            $path = str_replace($searches, $replaces, $path);
            return preg_match('#^' . $path . '$#', self::$uri, $matched);
        }

        return false;
    }

    /**
     * Extract the parameters from the route and save them.
     *
     * @since 2.0.0
     */
    private static function setRouteParams(array &$route, array $searches): void
    {
        $uriSegments = explode('/', trim(self::$uri, '/'));
        $pathSegments = explode('/', str_replace($searches, '', $route['path']));

        $route['params'] = array_values(array_diff($uriSegments, $pathSegments));
    }

    /**
     * Run route error hook.
     *
     * @since 2.0.0
     *
     * @return callable|null
     */
    private static function runRouteErrorHook()
    {
        return self::$routeErrorHook ? self::callMethod(
            self::$routeErrorHook['class'],
            self::$routeErrorHook['method'],
            [self::$uri]
        ) : null;
    }

    /**
     * Run before call method hook.
     *
     * @since 2.0.0
     *
     * @return callable|null
     */
    private static function runBeforeCallMethodHook(array $route)
    {
        return self::$beforeCallMethodHook ? self::callMethod(
            self::$beforeCallMethodHook['class'],
            self::$beforeCallMethodHook['method'],
            [$route]
        ) : null;
    }

    /**
     * Instantiate and call the method.
     *
     * By default it will look for the 'getInstance' method to use singleton
     * pattern and create a single instance of the class. If it doesn't
     * exist it'll create a new object.
     *
     * @since 2.0.0
     *
     * @see setSingletonMethod() for change the singleton method name.
     *
     * @return callable|null
     */
    private static function callMethod($class, string $method, array $params = [])
    {
        if (is_object($class)) {
            $instance = $class;
        } elseif (method_exists($class, self::$singletonMethod)) {
            $instance = call_user_func([$class, self::$singletonMethod]);
        } elseif (class_exists($class)) {
            $instance = new $class;
        }

        if (method_exists($instance ?? '', $method)) {
            return call_user_func_array([$instance, $method], $params);
        }

        return null;
    }
}
