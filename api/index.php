<?php
/**
 * Startup the application
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 *  @version  GIT: 0.0.1
 */
define('DS', DIRECTORY_SEPARATOR);
define('HOME', __DIR__);
define('VERSION', '0.1');

if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
    define('ENVIROMENT', 'DESE');
    ini_set('display_errors', 1);
} else {
    define('ENVIROMENT', 'PROD');
}
 

require_once HOME . DS . 'config.php';
require_once HOME . DS . 'utilities' . DS . 'bootstrap.php';

/**
 * Automatically load files that contains required class
 *
 * @param $class The name of the class required
 * @return 
 */
function __autoload($class)
{
    if (file_exists(HOME . DS . 'utilities' . DS . strtolower($class) . '.php')) {
        include HOME . DS . 'utilities' . DS 
            . strtolower($class) . '.php';
    } else if (file_exists(HOME . DS . 'models' . DS . strtolower($class) . '.php')) {
        include HOME . DS . 'models' . DS 
            . strtolower($class) . '.php';
    } else if (file_exists(HOME . DS . 'controllers' . DS . strtolower($class) . '.php')) {
        include HOME . DS . 'controllers'  . DS 
            . strtolower($class) . '.php';
    } else {
        http_response_code(500);
    }
}