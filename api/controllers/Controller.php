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
    
    public function GET($query) {
        if (isset($query) && isset($query[0])) {
            if (count($query) == 1 && is_numeric($query[0])) {
                $this->model->setId($query[0]);
            }
        }
        
        $result = $this->model->get();
        echo json_encode($result);
    }
    
    public function POST() {
        $data = file_get_contents("php://input");
        $array = json_decode($data,true);
        $error = json_last_error();
        
        if (!$error) {
            foreach ($array as $key => $value) {
                $set = "set".ucfirst($key);
                $this->model->$set($value);
            }
            
            $result = $this->model->post();
        }
    }
    
    public function PUT($query) {
        if (isset($query) && isset($query[0])) {
            $this->model->setId($query[0]);
        } else {
            die("Erro! Identificador não informado!");
        }
        
        $data = file_get_contents("php://input");
        $array = json_decode($data,true);
        $error = json_last_error();
        
        if (!$error) {
            foreach ($array as $key => $value) {
                $set = "set".ucfirst($key);
                $this->model->$set($value);
            }
            
            $result = $this->model->put();
        }
    }
    
    public function DELETE($query) {
        if (isset($query) && isset($query[0])) {
            $this->model->setId($query[0]);
        } else {
            die("Erro! Identificador não informado!");
        }
        
        $result = $this->model->delete();
    }
}
