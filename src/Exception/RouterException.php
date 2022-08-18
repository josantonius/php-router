<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - PHP-Router
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Router
 * @since     1.0.0
 */
namespace Josantonius\Router\Exception;

/**
 * Exception class for Router library.
 *
 * You can use an exception and error handler with this library.
 *
 * @link https://github.com/Josantonius/PHP-ErrorHandler
 */
class RouterException extends \Exception
{
    public function __construct(string $message, int $code = 0, int $httpCode = 400)
    {
        $this->message = $message;
        $this->code = $code ?? $this->code;
        $this->httpCode = $httpCode;
    }
}
