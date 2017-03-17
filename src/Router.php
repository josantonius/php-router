<?php 
/**
 * Library for handling routes.
 * 
 * @author     Daveismyname - dave@daveismyname.com
 * @author     Josantonius  - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Router
 * @since      1.0.0
 */

namespace Josantonius\Router;

use Josantonius\Url\Url,
    Josantonius\Router\Exception\RouterException;

/**
 * Route handler.
 *
 * @since 1.0.0
 */
class Router {

    /**
     * If true - do not process other routes when match is found.
     *
     * @since 1.0.0
     *
     * @var boolean $halts
     */
    public static $halts = true;

    /**
     * Array of routes.
     *
     * @since 1.0.0
     *
     * @var array $routes
     */
    public static $routes = [];

    /**
     * Array of methods.
     *
     * @since 1.0.0
     *
     * @var array $methods
     */
    public static $methods = [];

    /**
     * Array of callbacks.
     *
     * @since 1.0.0
     *
     * @var array $callbacks
     */
    public static $callbacks = [];

    /**
     * Set an error callback.
     *
     * @since 1.0.0
     *
     * @var null $errorCallback
     */
    public static $errorCallback;

    /**
     * Requested route status.
     *
     * @since 1.0.0
     *
     * @var bool $foundRoute
     */
    public static $foundRoute = false;

    /**
     * Set an uri.
     *
     * @since 1.0.0
     *
     * @var null $uri
     */
    public static $uri;

    /**
     * Method name to use the singleton pattern and just create an instance.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private static $_singleton = 'getInstance';

    /**
     * Set route patterns.
     *
     * @since 1.0.0
     *
     * @var null $uri
     */
    public static $patterns = [
        ':any' => '[^/]+',
        ':num' => '-?[0-9]+',
        ':all' => '.*',
        ':hex' => '[[:xdigit:]]+',
        ':uuidV4' => '\w{8}-\w{4}-\w{4}-\w{4}-\w{12}'
    ];

    /**
     * Defines a route with or without callback and method.
     *
     * @since 1.0.0
     *
     * @param string $method
     * @param array  $params
     */
    public static function __callstatic($method, $params) {

        $uri = $params[0];
        $callback = $params[1];
               
        array_push(static::$routes, $uri);
        array_push(static::$methods, strtoupper($method));
        array_push(static::$callbacks, $callback);
    }

    /**
     * Set method name for use singleton pattern.
     *
     * @since 1.0.0
     *
     * @param string $method → singleton method name
     */
    public static function setSingletonName($method) {

        self::$_singleton = $method;
    }

    /**
     * Add routes.
     *
     * @param array $route
     *
     * @since 1.0.0
     */
    public static function addRoute($route) {

        self::$routes = array_merge($route, self::$routes);
    }

    /**
     * Get routes.
     *
     * @param array $route
     *
     * @since 1.0.0
     */
    public static function getRoute($route) {

         return isset(self::$routes[$route]) ? self::$routes[$route] : null;
    }

    /**
     * Load routes with regular expressions if the route is not found.
     *
     * @since 1.0.0
     */
    public static function loadRegexRoutes() {

        foreach (self::$routes as $key => $value) {
                
            if (strpos($key, ':') !== false) {

                Router::any($key, $value);
            }
        }
    }

    /**
     * Defines callback if route is not found.
     *
     * @since 1.0.0
     *
     * @param string $callback
     */
    public static function error($callback) {

        static::$errorCallback = $callback;
    }

    /**
     * Don't load any further routes on match.
     *
     * @since 1.0.0
     *
     * @param boolean $flag
     */
    public static function haltOnMatch($flag = true) {

        static::$halts = $flag;
    }

    /**
     * Runs the callback for the given request.
     *
     * @since 1.0.0
     */
    public static function dispatch() {

        static::$uri = Url::addBackslash(Url::getUriMethods());

        static::_parseUrl();

        static::_routeValidator();

        static::$routes = str_replace('//', '/', static::$routes);

        $found_route = false;

        if (in_array(static::$uri, static::$routes)) {

            static::_checkRoutes();

        } else {
            
            self::loadRegexRoutes();
            
            static::_checkRegexRoutes();
        }

        if (!static::$foundRoute) {

            if (!static::$errorCallback) {

                static::$errorCallback = function () {

                    /* Error page */
                };
            }

            if (!is_object(static::$errorCallback)) {

                static::invokeObject(
                    static::$errorCallback, null, 'No routes found.'
                );

                if (static::$halts) {

                    return;
                }

            } else {

                call_user_func(static::$errorCallback);

                if (static::$halts) {

                    return;
                }
            }
        }
    }

    /**
     * Parse query parameters.
     *
     * @since 1.0.0
     */
    private static function _parseUrl() {

        $query = '';

        $q_arr = array();

        if (strpos(static::$uri, '&') > 0) {

            $query = substr(static::$uri, strpos(static::$uri, '&') + 1);

            static::$uri = substr(static::$uri, 0, strpos(static::$uri, '&'));

            $q_arr = explode('&', $query);

            foreach ($q_arr as $q) {

                $qobj = explode('=', $q);

                $q_arr[] = array($qobj[0] => $qobj[1]);

                if (!isset($_GET[$qobj[0]])) {

                    $_GET[$qobj[0]] = $qobj[1];
                }
            }
        }
    }

    /**
     * Check if route is defined without regex.
     *
     * @since 1.0.0
     *
     * @return 
     */
    private static function _checkRoutes() {

        $method = $_SERVER['REQUEST_METHOD'];

        $route_pos = array_keys(static::$routes, static::$uri);

        foreach ($route_pos as $route) {

            $methodRoute = static::$methods[$route];

            if ($methodRoute == $method || $methodRoute == 'ANY') {

                static::$foundRoute = true;

                if (!is_object(static::$callbacks[$route])) {

                    static::invokeObject(static::$callbacks[$route]);

                } else {

                    call_user_func(static::$callbacks[$route]);
                }

                if (static::$halts) {

                    return;
                }
            }
        }
    }

    /**
     * Check if route is defined with regex.
     *
     * @since 1.0.0
     *
     * @return 
     */
    private static function _checkRegexRoutes() {

        $pos = 0;

        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(static::$patterns);

        $replaces = array_values(static::$patterns);

        foreach (static::$routes as $route) {

            $route = str_replace($searches, $replaces, $route);

            if (preg_match('#^' . $route . '$#', static::$uri, $matched)) {

                $methodRoute = static::$methods[$pos];

                if (!$methodRoute == $method || !$methodRoute == 'ANY') {

                    $pos++;

                    continue;
                }

                static::$foundRoute = true;

                array_shift($matched);

                if (!is_object(static::$callbacks[$pos])) {

                    static::invokeObject(static::$callbacks[$pos], $matched);

                } else {

                    call_user_func_array(static::$callbacks[$pos], $matched);
                }

               if (static::$halts) {

                    return;
                }
            }

            $pos++;
        }
    }

    /**
     * Call object and instantiate.
     *
     * By default it will look for the 'getInstance' method to use singleton 
     * pattern and create a single instance of the class. If it does not
     * exist it will create a new object.
     *
     * @see setSingletonName() for change the method name.
     *
     * @since 1.0.0
     *
     * @param object $callback
     * @param array  $matched  → array of matched parameters
     * @param string $msg
     */
    public static function invokeObject($callback, $matched=null, $msg=null) {

        $last = explode('/', $callback);
        $last = end($last);

        $segments = explode('@', $last);

        $class   = $segments[0];
        $method  = $segments[1];
        $matched = $matched ? $matched : [];

        $instance = $class::getInstance();

        if (method_exists($class, self::$_singleton)) {

            $instance = call_user_func([$class, self::$_singleton]); 

            return call_user_func_array([$instance, $method], $matched);
        }

        $instance = new $class;

        return call_user_func_array([$instance, $method], $matched);
    }

    /**
     * Validate route.
     *
     * @since 1.0.0
     */
    private static function _routeValidator() {

        if (!is_null(self::getRoute(static::$uri))) {

            static::any(static::$uri, self::$routes[static::$uri]);
        }  
    }
}
