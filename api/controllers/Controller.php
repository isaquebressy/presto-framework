<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller {
    protected $model;
    protected $modelName;
    protected $action;

    public function __construct($modelName, $action) {
        $this->modelName = $modelName;
        $this->model = new $this->modelName();
        $this->action = $action;
    }
}
