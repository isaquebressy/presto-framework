<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends Model{
    protected $name;
    protected $email;
    private $pass;

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getPass() {
        return $this->pass;
    }
    public function setPass($pass) {
        $this->pass = $pass;
    }

//    public function get() {
//        $sql = "SELECT id, name, email FROM users WHERE 1=1";
//        if (isset($this->id) && $this->id != null) {
//            $sql .= " AND id=$this->id";
//        } 
//
//        $stmt = $this->db->prepare($sql);
//        $stmt->execute();
//
//        if (isset($this->id) && $this->id != null) {
//            $result = $stmt->fetch();
//            if(!$result) {
//                $result = null;
//            }
//        } else {
//            $result = $stmt->fetchAll();
//        }
        
//        return $result;
//        return $this->vars();
//    }
    
//    public function post() {
//        $sql = "INSERT INTO users (name, email, pass) VALUES (:name, :email, :pass)";
//        
//        $stmt = $this->db->prepare($sql);
//        $stmt->bindParam(':name', $this->name);
//        $stmt->bindParam(':email', $this->email);
//        $stmt->bindParam(':pass', $this->pass);
//        
//        $stmt->execute();;
//    }
    
//    public function put() {
//        if (!$this->name && !$this->email && !$this->pass) {
//            die("Erro! Parâmetros insuficientes");
//        }
//        
//        $sql  = "UPDATE users";
//        $sql .= " SET";
//        if ($this->name) {
//            $sql .= "   name = :name,";
//        }
//        if ($this->email) {
//            $sql .= "   email = :email,";
//        }
//        if ($this->pass) {
//            $sql .= "   pass = :pass,";
//        }
//        
//        $sql = rtrim($sql, ",");
//        $sql .= " WHERE id = :id";
//        
//        $stmt = $this->db->prepare($sql);
//        $stmt->bindParam(':id', $this->id);
//        if ($this->name) {
//            $stmt->bindParam(':name', $this->name);
//        }
//        if ($this->email) {
//            $stmt->bindParam(':email', $this->email);
//        }
//        if ($this->pass) {
//            $stmt->bindParam(':pass', $this->pass);
//        }
//       
//        $stmt->execute();
//    }
    
    public function delete() {
        if (!$this->id) {
            die("Erro! Identificador não informado!");
        }
        
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        
        $stmt->execute();
    }
}