<?php
/**
 * Library for handling routes.
 *
 * @author    Josantonius  - <hello@josantonius.com>
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.7
 */
namespace Josantonius\Router;

/**
 * Example class.
 */
class Example
{
    /**
     * Instance.
     *
     * @var object
     */
    public static $instance;

    /**
     * @return object
     */
    public static function getInstance()
    {
        return new self;
    }

    /**
     * @return object
     */
    public static function newSingleton()
    {
        return self::getInstance();
    }

    /**
     * @return string
     */
    public function services()
    {
        return 'Response from services method';
    }

    /**
     * @return string
     */
    public function error()
    {
        return 'Response from error method';
    }

    /**
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
