<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model {
    protected $id;
    protected $db;
    protected $sql;

    public function __construct() {
        $this->db = Db::init();
    }
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    
    public function get() {
        $this->getTable();
        
        $sql = "SELECT id,";
        
        foreach (array_keys($this->getChildVars()) as $key) {
            $sql .= "$key,";
        }
        
        $sql = rtrim($sql, ',');
        $sql .= " FROM {$this->getTable()} WHERE 1=1";
        if (isset($this->id) && $this->id != null) {
            $sql .= " AND id=$this->id";
        } 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if (isset($this->id) && $this->id != null) {
            $result = $stmt->fetch();
            if(!$result) {
                $result = null;
            }
        } else {
            $result = $stmt->fetchAll();
        }
        
        return $result;
    }
    
    public function post() {
        $sql = "INSERT INTO {$this->getTable()} (";
        foreach (array_merge(array_keys($this->getChildVars()),array_keys($this->getPrivates())) as $key) {
            $sql .= "$key,";
        }
        
        $sql = rtrim($sql, ',');
        
        $sql .= ") VALUES (";
        foreach (array_merge($this->getChildVars(),$this->getPrivates()) as $value) {
            $sql .= "'$value',";
        }
        
        $sql = rtrim($sql, ',');
        $sql .=")";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute();
    }
    
    public function put() {
        if ($this->is_empty()) {
            die("Erro! Parâmetros insuficientes");
        }
        
        try {
            $sql  = "UPDATE {$this->getTable()}";
            $sql .= " SET";

            foreach (array_merge(array_keys($this->getChildVars()),array_keys($this->getPrivates())) as $key) {
                $method = "get".ucwords($key);
                if ($this->$method()) {
                    $sql .= " $key = :$key,";
                }
            }

            $sql = rtrim($sql, ",");
            $sql .= " WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            foreach (array_merge($this->getChildVars(),$this->getPrivates()) as $key => $value) {
                $method = "get".ucwords($key);
                if ($this->$method()) {
                    $stmt->bindParam(":$key", $this->$method());
                }
            }

            $stmt->execute();
        } catch (Exception $e){
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
    
     public function delete() {
        if (!$this->id) {
            die("Erro! Identificador não informado!");
        }
        
        $sql = "DELETE FROM {$this->getTable()} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        
        $stmt->execute();
    }
    
    /*
     * Get the private properties from Child Class Instance. 
     * Wee need use private fields to do not expose 
     * same fields.
     * OBS: Privates fields will not exposed 
     */
    private function getPrivates() {
        $reflection = new ReflectionClass($this);
        $vars = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        $array = [];
        foreach ($vars as $pvt) {
            $method = "get".ucwords($pvt->name);
            $array[$pvt->name] = $this->$method();
        }
        
        return $array;
    }
    
    /*
     * Get the protected properties from Child Class Instance. 
     *  */
    private function getChildVars() {
        $vars = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (!array_key_exists($key, get_class_vars(self::class))) {
                $vars[$key] = $value;
            }
        }
        return $vars;
    }
    
    /*
     * Check if the instance properties are empty
     *  */
    private function is_empty() {
        $empty = false;
        if (!count(array_filter(array_merge($this->getChildVars(),$this->getPrivates())))) {
            $empty = true;
        }
        return $empty;
    }
    
    /*
     * Return the table name. The class name in the plural
     */
    private function getTable() {
        return strtolower(get_class($this))."s";
    }
}