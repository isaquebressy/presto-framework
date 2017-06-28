<?php
/**
 * Controllers functionalitys
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


/** 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller {
    protected $model;
    protected $modelName;
    protected $action;

    public function __construct($modelName, $action) 
    {
        $this->modelName = $modelName;
        $this->model = new $this->modelName();
        $this->action = $action;
    }

    /**
     * Write a assoc array as json to cliente includin the header 'Content-Type application/json;charset=utf-8
     *
     * @parameter $assoc_array Object or assoc array to result
     */
    private function response_as_json($assoc_array)
    {
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($assoc_array);
    }
    
    public function GET($query) {
        if (isset($query) && isset($query[0])) {
            /* o id nao pode ser texto ? como um UUID ? */
            if (count($query) == 1 && is_numeric($query[0])) {
                $this->model->setId($query[0]);
            }
        }
        
        $result = $this->model->get();

        $this->response_as_json($result);
    }
    
    public function POST() {
        /* read the post data as json text */
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
