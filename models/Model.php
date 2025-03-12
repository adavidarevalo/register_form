<?php

abstract class Model {
    protected $db;
    protected $table;
    protected $attributes = [];

    public function __construct() {
        global $connect;
        $this->db = $connect;
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function save() {
        if (isset($this->attributes['id'])) {
            return $this->update();
        }
        return $this->insert();
    }

    protected function insert() {
        $columns = implode(', ', array_keys($this->attributes));
        $values = implode(', ', array_fill(0, count($this->attributes), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(array_values($this->attributes));
    }

    protected function update() {
        $id = $this->attributes['id'];
        unset($this->attributes['id']);
        
        $set = implode('=?, ', array_keys($this->attributes)) . '=?';
        $sql = "UPDATE {$this->table} SET {$set} WHERE id = ?";
        
        $values = array_values($this->attributes);
        $values[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->attributes = $result;
            return $this;
        }
        return null;
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete() {
        if (!isset($this->attributes['id'])) {
            return false;
        }
        
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->attributes['id']]);
    }
}
