<?php 
/**
 * Library for handling routes.
 * 
 * @author     Josantonius  - hello@josantonius.com
 * @author     Daveismyname - dave@daveismyname.com
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
     * @var string $_singleton
     */
    private static $_singleton = 'getInstance';

    /**
     * Response from called method.
     *
     * @since 1.0.6
     *
     * @var callable $response
     */
    public static $response;

    /**
     * Set route patterns.
     *
     * @since 1.0.0
     *
     * @var array $patterns
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
     * @since 1.0.0
     *
     * @param array $route
     *
     * @uses string Url::addBackslash → add backslash if it doesn't exist
     *
     * @link https://github.com/Josantonius/PHP-Url
     *
     * @return boolean
     */
    public static function addRoute($routes) {

        if (!is_array($routes)) { return false; }

        foreach($routes as $route => $value) {
            
            self::$routes[Url::addBackslash($route)] = $value;
        }

        return true;
    }

    /**
     * Get routes.
     *
     * @since 1.0.0
     *
     * @param string $route
     *
     * @uses string Url::addBackslash → add backslash if it doesn't exist
     *
     * @return array|false → route or false
     */
    public static function getRoute($route) {

        $route = Url::addBackslash($route);

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

        self::_routeValidator();

        self::$routes = str_replace('//', '/', self::$routes);

        if (in_array(self::$uri, self::$routes)) {

            return self::_checkRoutes();
        }
            
        return self::_checkRegexRoutes() ?: self::_getErrorCallback();
    }

    /**
     * Clean resources.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private static function _cleanResources() {
        
        self::$callbacks = [];
        self::$methods   = [];
        self::$halts     = false;
        self::$response  = false;
    }

    /**
     * Validate route.
     *
     * @since 1.0.0
     *
     * @uses string Url::getUriMethods → remove subdirectories & get methods
     * @uses string Url::setUrlParams  → return url without url params
     * @uses string Url::addBackslash  → add backslash if it doesn't exist
     *
     * @return void
     */
    private static function _routeValidator() {

        self::$uri = Url::getUriMethods();

        self::$uri = Url::setUrlParams(self::$uri);

        self::$uri = Url::addBackslash(self::$uri);

        self::_cleanResources();
        
        if (self::getRoute(self::$uri)) {

            self::any(self::$uri, self::$routes[self::$uri]);
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

        $method = $_SERVER['REQUEST_METHOD'];

        $route_pos = array_keys(self::$routes, self::$uri);

        foreach ($route_pos as $route) {

            $methodRoute = self::$methods[$route];

            if ($methodRoute == $method || $methodRoute == 'ANY') {

                if (!is_object($callback = self::$callbacks[$route])) {

                    self::$response = self::invokeObject($callback);

                } else {

                    self::$response = call_user_func($callback);
                }

                if (!self::$halts) {

                    return self::$response;
                }

                self::$halts--;
            }
        }

        return self::$response;
    }

    /**
     * Check if route is defined with regex.
     *
     * @since 1.0.0
     *
     * @uses string Url::addBackslash → add backslash if it doesn't exist
     *
     * @return callable|false
     */
    private static function _checkRegexRoutes() {

        $pos = 0;
        
        self::_getRegexRoutes();

        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(self::$patterns);

        $replaces = array_values(self::$patterns);

        foreach (self::$routes as $route) {

            $route = str_replace($searches, $replaces, $route);

            $route = Url::addBackslash($route);

            if (preg_match('#^' . $route . '$#', self::$uri, $matched)) {

                $methodRoute = self::$methods[$pos];

                if ($methodRoute == $method || $methodRoute == 'ANY') {

                    $matched = explode('/', trim($matched[0], '/'));

                    array_shift($matched);

                    if (!is_object(self::$callbacks[$pos])) {

                        self::$response = self::invokeObject(
                            self::$callbacks[$pos], 
                            $matched
                        );

                    } else {

                        self::$response = call_user_func_array(
                            self::$callbacks[$pos],
                            $matched
                        );
                    }

                    if (!self::$halts) {
                        
                        return self::$response;
                    }

                    self::$halts--;
                }
            }

            $pos++;
        }

        return self::$response;
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
     * Get error callback if route does not exists.
     *
     * @since 1.0.3
     *
     * @return callable
     */
    private static function _getErrorCallback() {

        $errorCallback = self::$errorCallback;

        self::$errorCallback = false;

        if (!$errorCallback) {

            return false;
        }

        if (!is_object($errorCallback)) {

            return self::invokeObject($errorCallback);
        }

        return call_user_func($errorCallback);
    }
}
