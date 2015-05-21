<?php

$controller = "books";
$action = $_SERVER['REQUEST_METHOD'];
$query = null;

if (isset($_REQUEST['load'])) {
    $params = array();
    $params = explode("/", $_REQUEST['load']);
    
    $controller = ucwords($params[0]);
    $query = array_slice($params, 1);
    
    $modelName = $controller;
    $controller .= "Controller";
    $load = new $controller($modelName, $action);
    
    $load->$action($query);
}

