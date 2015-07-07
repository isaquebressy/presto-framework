<?php
/**
 * File: utilities/bootstrap.php
 *
 *
 *
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
    $load = new $controller($modelName, $action);
    
    $load->$action($query);
}

