<?php

namespace System;

use Database\Connection;
use Database\QuerySelect;
use Database\SelectBuilder;

abstract class BaseModel{
	protected static $instance;
	protected Connection $db;
	protected string $table;
	protected string $pk;
	protected array $validationRules;

	public static function getInstance() : static{
		if(static::$instance === null){
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function __construct(){
		$this->db = Connection::getInstance();
	}

	public function getConnection() : Connection {
		return $this->db;
	}

	public function getPK() {
		return $this->pk;
	}

	public function getTable() {
		return $this->table;
	}

	public function all() : array{
		return $this->selector()->get();
	}

	public function get(int $id) : ?array{
		$res = $this->selector()->where("{$this->pk} = :pk", ['pk' => $id])->get();
		return $res[0] ?? null;
	}

	public function selector() : QuerySelect{
		$builder = new SelectBuilder($this->table);
		return new QuerySelect($this->db, $builder);
	}

	public function add(array $fields) : int{
		$names = [];
		$masks = [];

		foreach($fields as $field => $val){
			$names[] = $field;
			$masks[] = ":$field";
		}

		$namesStr = implode(', ', $names);
		$masksStr = implode(', ', $masks);

		$query = "INSERT INTO {$this->table} ($namesStr) VALUES ($masksStr)";
		$this->db->query($query, $fields);
		return $this->db->lastInsertId();
	}
}