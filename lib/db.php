<?php

class DBConnection {
	private $pdo;
	
	public function __construct($dbpath) {
		$this->pdo = new PDO("sqlite:$dbpath");  
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

    public function insert($table, array $params = array()) {
        $keys = array_keys($params);
        $values = array_map(function($e) { return ':'.$e; }, $keys);
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($values);
        return $result ? $this->pdo->lastInsertId() : 0;
    }

    public function update($table, $id, array $params = array()) {
        $keys = array_map(function($e) { return $e.'=?'; }, array_keys($params));
        $values = array_values($params);
        $values[] = $id;
        $sql = "UPDATE $table SET " . implode(',', $keys) . " WHERE id=?";
        return $this->prepare($sql, $values)->execute();
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id=?";
        $stmt = $this->prepare($sql, array($id));
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

	public function execute($sql, $params) {
		$sth = $this->pdo->prepare($sql);
		return $sth->execute($params);		
	}

}
