<?php

/**
 * Models functionalities
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 *  @version  GIT: 0.0.1
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

    public function set($key, $value) {
        $refObject = new ReflectionObject($this);
        $refProperty = $refObject->getProperty($key);
        $refProperty->setAccessible(true);
        $refProperty->setValue($this, $value);
    }

    public function getValue($reflection, $key) {
        $p = $reflection->getProperty($key);
        $p->setAccessible(true);

        return $p->getValue($this);
    }

    public function get($params = null, $limit = null) {
        $plurals = [];
        $this->getTable();

        $sql = "SELECT id,";

        foreach (array_keys($this->getChildVars()) as $key) {
            if (Inflect::pluralize($key) === $key) {
                $plurals[] = $key;
            } else {
                $sql .= "$key,";
            }
        }

        $sql = rtrim($sql, ',');
        $sql .= " FROM {$this->getTable()} WHERE 1=1";
        if (isset($this->id) && $this->id != null) {
            $sql .= " AND id=$this->id";
        }

        if ($params != null and is_array($params)) {
            foreach ($params as $key => $value) {
                // search for parameters...
                if (!is_numeric($value)) {
                    $sql .= " AND $key LIKE '%$value%'";
                } else {
                    $sql .= " AND $key=$value";
                }
            }
        }

        if ($limit != null and $limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if (isset($this->id) && $this->id != null) {
            $result = $stmt->fetch();
            if (!$result) {
                $result = null;
            }
            $array[] = &$result;
        } else {
            $result = $stmt->fetchAll();
            $array = &$result;
        }

        for ($i = 0; $i < count($array); $i++) {
            foreach ($plurals as $property) {
                $className = Inflect::singularize($property);
                $param = [Inflect::singularize($this->getTable()) . "_id" => $array[$i]['id']];
                $array[$i][$property] = (new $className)->get($param);
            }
        }

        return $result;
    }

    public function post() {
        $sql = "INSERT INTO {$this->getTable()} (";
        foreach (array_merge(array_keys($this->getChildVars()), array_keys($this->getPrivates())) as $key) {
            if (Inflect::pluralize($key) != $key) {
                $sql .= "$key,";
            }
        }

        $sql = rtrim($sql, ',');

        $sql .= ") VALUES (";
        foreach (array_merge($this->getChildVars(), $this->getPrivates()) as $key => $value) {
            if (Inflect::pluralize($key) != $key) {
                $sql .= "'$value',";
            }
        }

        $sql = rtrim($sql, ',');
        $sql .= ")";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();
    }

    public function put() {
        if ($this->is_empty()) {
            die("Error! Insufficient parameters!");
        }

        try {
            $reflection = new ReflectionClass($this);

            $sql = "UPDATE {$this->getTable()}";
            $sql .= " SET";

            foreach (array_merge(array_keys($this->getChildVars()), array_keys($this->getPrivates())) as $key) {
                if ($this->getValue($reflection, $key)) {
                    $sql .= " $key = :$key,";
                }
            }

            $sql = rtrim($sql, ",");
            $sql .= " WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            foreach (array_merge($this->getChildVars(), $this->getPrivates()) as $key => $value) {
                if ($this->getValue($reflection, $key)) {
                    $stmt->bindParam(":$key", $this->getValue($reflection, $key));
                }
            }

            $stmt->execute();
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
        }
    }

    public function delete() {
        if (!$this->id) {
            die("Errro! Id not specified!");
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
            $array[$pvt->name] = $this->getValue($reflection, $pvt->name);
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
        if (!count(array_filter(array_merge($this->getChildVars(), $this->getPrivates())))) {
            $empty = true;
        }
        return $empty;
    }

    /*
     * Return the table name. The class name in the plural
     */

    protected function getTable() {
        return Inflect::pluralize(strtolower(get_class($this)));
    }

}
