<?php 
/**
 * Library for handling routes.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Router
 * @since      1.0.0
 */

namespace Josantonius\Hook\Tests;

/**
 * Example class.
 *
 * @since 1.0.0
 */
class Example {

    /**
     * Instance.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private static $_instance = array();

    /**
     * Singleton pattern is used to create a single instance of the class.
     *
     * @since 1.0.0
     *
     * @return object → instance
     */
    public static function getInstance() {
        
        if (isset(self::$_instance)) {

            return self::$_instance;
        } 

        return self::$_instance = new self;
    }

    /**
     * Singleton pattern with custom name.
     *
     * @since 1.0.0
     *
     * @return object → instance
     */
    public static function newSingletonMethodName() {
        
        if (isset(self::$_instance)) {

            return self::$_instance;
        } 

        return self::$_instance = new self;
    }
    
    /**
     * Actions for css hook.
     *
     * @since 1.0.0
     */
    public function render() {

        ?>
        <<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>A title</title>
                <link rel="stylesheet" href="">
            </head>
            <body>
                <h1>Hello World</h1>
            </body>
        </html>
        <?php
    }
}
