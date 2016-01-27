<?php

namespace app\classes;


abstract class AbstractModel {

    protected static $table;
    protected static $idFieldName = 'id';
    protected $data;

    public function __set($attr, $value) {
        $this->data[$attr] = $value;
    }

    public function __get($attr) {
        return $this->data[$attr];
    }
    public function __unset($attr) {
        unset($this->data[$attr]);
    }

    public function __isset($attr) {
        return isset($this->data[$attr]);
    }

    public function load(array $data) {
        foreach($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    // Ex: selectAll('ORDER BY id DESC')
    public static function selectAll($order = '') {
        $db = new Db;
        $sql = 'SELECT * FROM ' . static::$table . ' ' . $order;
        $db->setClassName(get_called_class());
        return $db->query($sql);
    }

    public static function selectOneByPk($id) {
        $db = new Db;
        $db->setClassName(get_called_class());
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . static::$idFieldName . '=:id';

        $result = $db->query($sql, [':id' => $id]);
        if (!empty($result)) {
            //return first row
            return $result[0];
        }
        return false;
    }

    public static function selectByColumn($column, $value) {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' .$column. '=:value';
        $db = new Db;
        $db->setClassName(get_called_class());
        $result = $db->query($sql, [':value' => $value]);
        if (!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function searchByColumn($column, $value) {
        $sql = "SELECT * FROM " . static::$table . " WHERE " .$column. " LIKE :value ORDER BY " .$column;
        $db = new Db;
        $db->setClassName(get_called_class());
        $result = $db->query($sql, [':value' => "%" . $value . "%"]);
        if (!empty($result)) {
            return $result;
        }
        return false;
    }

    public function save() {
        $idFieldName = static::$idFieldName;
        if (!isset($this->$idFieldName)) {
            $this->$idFieldName = $this->insert();
        }
        else {
            $this->update();
        }
    }

    protected function insert() {
        //columns of table
        $cols = array_keys($this->data);
        // refactor $this->data keys with ':key'
        $data =[];
        foreach ($cols as $col) {
            $data[':' . $col] = $this->data[$col];
        }
        //generating query: INSERT INTO table (col1, col2) VALUES (:col1, :col2)
        $sql = 'INSERT INTO ' . static::$table . '
                 (' . implode(', ', $cols) . ')
                 VALUES
                 (' . implode(', ', array_keys($data)) . ')';
        $db = new Db;
        if ($db->exec($sql, $data)) {
            return $db->lastInsertId();
        }
        return false;
    }

    protected function update() {
        $data =[];
        $cols = [];
        foreach ($this->data as $col => $value) {
            $data[':' . $col] = $value;
            if ($col == static::$idFieldName) {
                continue;
            }
            $cols[] = $col . '=:' . $col;
        }
        //generating query: UPDATE table SET col1=:col1, col2=:col2 WHERE id=:id
        $sql = 'UPDATE ' . static::$table . '
                SET ' . implode(', ', $cols) . '
                WHERE ' . static::$idFieldName . '=:id';
        $db = new Db;
        $db->exec($sql, $data);
    }

    public function delete() {
        $sql = 'DELETE FROM ' . static::$table . ' WHERE ' . static::$idFieldName . '=:id';
        $db = new Db;
        $idFieldName = static::$idFieldName;
        $db->exec($sql, [':id' => $this->$idFieldName]);
    }
}