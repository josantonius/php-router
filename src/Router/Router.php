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

use Josantonius\Url\Url;

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
    public static $halts = false;

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
     * @var bool|int $errorCallback
     */
    public static $errorCallback = false;

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
     *
     * @return void
     */
    public static function __callstatic($method, $params) {

        $uri = $params[0];

        $callback = $params[1];

        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
    }

    /**
     * Set method name for use singleton pattern.
     *
     * @since 1.0.0
     *
     * @param string $method → singleton method name
     *
     * @return boolean
     */
    public static function setSingletonName($method) {

        if (!is_string($method) || empty($method)) {

            return false;
        }

        self::$_singleton = $method;

        return true;
    }

    /**
     * Add routes.
     *
     * @param array $route
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public static function addRoute($route) {

        return is_array(self::$routes = array_merge($route, self::$routes));
    }

    /**
     * Get routes.
     *
     * @param array $route
     *
     * @since 1.0.0
     *
     * @return array|false → route or false
     */
    public static function getRoute($route) {

         return isset(self::$routes[$route]) ? self::$routes[$route] : false;
    }

    /**
     * Defines callback if route is not found.
     *
     * @since 1.0.0
     *
     * @param callable $callback
     *
     * @return boolean true
     */
    public static function error($callback) {

        self::$errorCallback = $callback;

        return true;
    }

    /**
     * Continue processing after match (true) or stopping it (false).
     *
     * Also can specify the number of total routes to process (int).
     *
     * @since 1.0.4
     *
     * @param boolean|int $value
     *
     * @return boolean true
     */
    public static function keepLooking($value = true) {

        $value = (!is_bool($value) || !is_int($value)) ? false : true;

        $value = (is_int($value) && $value > 0) ? $value - 1 : $value;

        self::$halts = $value;

        return true;
    }

    /**
     * Runs the callback for the given request.
     *
     * @since 1.0.0
     *
     * @return call
     */
    public static function dispatch() {

        self::$uri = Url::getUriMethods();

        self::_parseUrl();

        self::$uri = Url::addBackslash(self::$uri);

        self::_routeValidator();

        self::$routes = str_replace('//', '/', self::$routes);

        self::$foundRoute = false;

        if (in_array(self::$uri, self::$routes)) {

            return self::_checkRoutes();
        }
            
        self::_getRegexRoutes();
            
        if ($response = self::_checkRegexRoutes()) {

            return $response;
        }

        if (!self::$foundRoute) {

            return self::_getErrorCallback();
        }
    }

    /**
     * Load routes with regular expressions if the route is not found.
     *
     * @since 1.0.3
     *
     * @return void
     */
    private static function _getRegexRoutes() {

        foreach (self::$routes as $key => $value) {
            
            unset(self::$routes[$key]);
            
            if (strpos($key, ':') !== false) {

                Router::any($key, $value);
            }
        }
    }

    /**
     * Parse query parameters.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private static function _parseUrl() {

        $query = '';

        $data = array();

        if (strpos(self::$uri, '&') > 0) {

            $query = substr(self::$uri, strpos(self::$uri, '&') + 1);

            self::$uri = substr(self::$uri, 0, strpos(self::$uri, '&'));

            $data = explode('&', $query);

            foreach ($data as $value) {

                $params = explode('=', $value);

                $data[] = array($params[0] => $params[1]);

                if (!isset($_GET[$params[0]])) {

                    $_GET[$params[0]] = $params[1];
                }
            }
        }
    }

    /**
     * Check if route is defined without regex.
     *
     * @since 1.0.0
     *
     * @return callable|false
     */
    private static function _checkRoutes() {

        $response = false;

        $method = $_SERVER['REQUEST_METHOD'];

        $route_pos = array_keys(self::$routes, self::$uri);

        foreach ($route_pos as $route) {

            self::$foundRoute = false;

            $methodRoute = self::$methods[$route];

            if ($methodRoute == $method || $methodRoute == 'ANY') {

                self::$foundRoute = true;

                if (!is_object(self::$callbacks[$route])) {

                    $response = self::invokeObject(self::$callbacks[$route]);

                } else {

                    $response = call_user_func(self::$callbacks[$route]);
                }

                if (!self::$halts && !self::$halts > 0) {

                    return $response;
                }

                self::$halts--;
            }
        }

        return $response;
    }

    /**
     * Check if route is defined with regex.
     *
     * @since 1.0.0
     *
     * @return callable|false
     */
    private static function _checkRegexRoutes() {

        $pos = 0;

        $response = false;

        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(self::$patterns);

        $replaces = array_values(self::$patterns);

        foreach (self::$routes as $route) {

            self::$foundRoute = false;

            $route = str_replace($searches, $replaces, $route);

            $route = Url::addBackslash($route);

            if (preg_match('#^' . $route . '$#', self::$uri, $matched)) {

                $methodRoute = self::$methods[$pos];

                if ($methodRoute == $method || $methodRoute == 'ANY') {
 
                    self::$foundRoute = true;

                    $matched = explode('/', trim($matched[0], '/'));

                    array_shift($matched);

                    if (!is_object(self::$callbacks[$pos])) {

                        $response = self::invokeObject(
                            self::$callbacks[$pos], 
                            $matched
                        );

                    } else {

                        $response = call_user_func_array(
                            self::$callbacks[$pos],
                            $matched
                        );
                    }

                    if (!self::$halts) {
                        
                        $response = false;
                    }

                    self::$halts--;
                }
            }

            $pos++;
        }

        return $response;
    }

    /**
     * Get error callback if route does not exists.
     *
     * @since 1.0.3
     *
     * @return callable
     */
    private static function _getErrorCallback() {

        if (!self::$errorCallback) {

            return false;
        }

        if (!is_object(self::$errorCallback)) {

            return self::invokeObject(self::$errorCallback);
        }

        return call_user_func(self::$errorCallback);
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
     *
     * @return callable|false
     */
    protected static function invokeObject($callback, $matched = null) {

        $last = explode('/', $callback);
        $last = end($last);

        $segments = explode('@', $last);

        $class   = $segments[0];
        $method  = $segments[1];
        $matched = $matched ? $matched : [];

        if (method_exists($class, self::$_singleton)) {

            $instance = call_user_func([$class, self::$_singleton]); 

            return call_user_func_array([$instance, $method], $matched);
        }

        if (class_exists($class)) {

            $instance = new $class;

            return call_user_func_array([$instance, $method], $matched);
        }

        return false;
    }

    /**
     * Validate route.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private static function _routeValidator() {

        if (self::getRoute(self::$uri)) {

            self::any(self::$uri, self::$routes[self::$uri]);
        }  
    }
}
