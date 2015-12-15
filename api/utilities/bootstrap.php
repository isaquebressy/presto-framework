<?php
/**
 * This file has functionalitys 
 * start application bootstrap
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @version  GIT: 0.0.1
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 */

$action = $_SERVER['REQUEST_METHOD'];
$query = null;

if (isset($_REQUEST['load']))
{
    $params = array();
    $params = explode('/', $_REQUEST['load']);
    
    $singular = Inflect::singularize($params[0]);
    $controller = ucwords(($singular === $params[0]) ? null : $singular);
    $query = array_slice($params, 1);
    
    $modelName = $controller;
    $controller .= "Controller";
    $controllerFileName = HOME . DS . 'controllers' . DS 
        . strtolower($controller) . '.php';
    if (!file_exists($controllerFileName)) {
        http_response_code(404);
    } else {
        $load = new $controller($modelName, $action);
        
        if (method_exists($load, $action)) {
            $load->$action($query);
        } else {
            http_response_code(404);
        }
    }
}
