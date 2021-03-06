<?php

class DBConnection {

    private $pdo;
    
    public function __construct($dbpath) {
        $this->pdo = new PDO("sqlite:$dbpath");  
    }

    public function get_record($table, array $conditions = array()) {
        $keys = array_keys($conditions);
        $args = array_map(function($e) { return "$e = :$e"; }, $keys);
        $sql = "SELECT * FROM $table WHERE " . implode(' AND ', $args);
        $sth = $this->pdo->prepare($sql);
        $sth->execute($conditions);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function get_records($table, array $conditions = array()) {
        $keys = array_keys($conditions);
        $args = array_map(function($e) { return "$e = :$e"; }, $keys);
        $sql = "SELECT * FROM $table WHERE " . implode(' AND ', $args);
        $sth = $this->pdo->prepare($sql);
        $sth->execute($conditions);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_records_sql($sql, array $params = array()) {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function get_record_sql($sql, array $params = array()) {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function insert_record($table, array $params = array()) {
        $keys = array_keys($params);
        $values = array_map(function($e) { return ":$e"; }, $keys);
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        return $result ? $this->pdo->lastInsertId() : 0;
    }

    public function update_record($table, $id, array $params = array()) {
        $keys = array_map(function($e) { return "$e = ?"; }, array_keys($params));
        $values = array_values($params);
        $values[] = $id;
        $sql = "UPDATE $table SET " . implode(',', $keys) . " WHERE id = ?";
        $sth =  $this->pdo->prepare($sql);
        return $sth->execute($values);
    }

    public function delete_record($table, $id) {
        $sql = "DELETE FROM $table WHERE id = ?";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array($id));
        return $sth->rowCount() > 0;
    }

    public function execute($sql, $params) {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($params);		
    }

    public function quote($string) {
        return $this->pdo->quote($string);
    }

}
