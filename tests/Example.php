<?php
/**
 * Library for handling routes.
 *
 * @author    Josantonius  - <hello@josantonius.com>
 * @copyright 2017 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.7
 */

namespace Josantonius\Router;

/**
 * Example class.
 *
 * @since 1.0.7
 */
class Example
{
    /**
     * Instance.
     *
     * @since 1.0.7
     *
     * @var object
     */
    public static $instance;

    /**
     * @since 1.0.7
     *
     * @return object
     */
    public static function getInstance()
    {
        return new self;
    }

    /**
     * @since 1.0.7
     *
     * @return object
     */
    public static function newSingleton()
    {
        return self::getInstance();
    }

    /**
     * @since 1.0.7
     *
     * @return string
     */
    public function services()
    {
        return 'Response from services method';
    }

    /**
     * @since 1.0.7
     *
     * @return string
     */
    public function error()
    {
        return 'Response from error method';
    }

    /**
     * @since 1.0.7
     *
     * @param string $category
     * @param string $item
     *
     * @return string
     */
    public function blog($category, $item)
    {
        return "Response from blog method: $category | $item";
    }
}
