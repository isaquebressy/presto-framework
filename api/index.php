<?php
/**
 * File: index.php
 *
 *
 *
 */
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', __DIR__);

if(in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))
{
    define('ENVIROMENT', 'DESE');
    ini_set ('display_errors', 1);
}else
{
    define('ENVIROMENT', 'PROD');
}
 

require_once HOME . DS . 'config.php';
require_once HOME . DS . 'utilities' . DS . 'bootstrap.php';

function __autoload($class)
{
    if (file_exists(HOME . DS . 'utilities' . DS . strtolower($class) . '.php'))
    {
        require_once HOME . DS . 'utilities' . DS . strtolower($class) . '.php';
    }
    else if (file_exists(HOME . DS . 'models' . DS . strtolower($class) . '.php'))
    {
        require_once HOME . DS . 'models' . DS . strtolower($class) . '.php';
    }
    else if (file_exists(HOME . DS . 'controllers' . DS . strtolower($class) . '.php'))
    {
        require_once HOME . DS . 'controllers'  . DS . strtolower($class) . '.php';
    }
}
