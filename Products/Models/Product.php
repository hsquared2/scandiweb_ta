<?php

namespace Products\Models;

use System\BaseModel;


class Product extends BaseModel {
  protected static $instance;
	protected string $table = 'products';
	protected string $pk = 'id_product';
	protected string $metric;
	protected array $attributes;

	protected array $validationRules = [
		'sku' => "required|min:8|max:32|unique:products,sku",
		'name' => 'required|min:3|max:128',
		'price' => 'required|numeric',
		'type' => 'required',
	];

	public function addValidationRules(array $rules) {
		$this->validationRules += $rules;
	} 

	public function getValidationRules() {
		return $this->validationRules;
	}

	public function all() : array {
		$query = "SELECT * FROM {$this->table}";
		$data = $this->db->query($query)->fetchAll();

		return $data;
	}

	public function massDelete(array $fields) : bool {
		$query = "DELETE FROM {$this->table} WHERE {$this->pk} IN('". implode("','", $fields) . "')";
		$this->db->query($query);
		return true;
	}

	public function getAttrFields() : ?array {
		if(array_key_exists('fields', $this->attributes)){
			return array_keys($this->attributes['fields']);
		}
		return null;
	}

	public function setAttrValues(array $fields) {
		foreach($fields as $field => $val) {
			if(array_key_exists($field, $this->attributes['fields'])) {
				$this->attributes['fields'][$field] = $val;
			}
		}
	}

	public function getMetric() : ?string {
		if(array_key_exists('metric', $this->attributes)) {
			return $this->attributes['metric'];
		}
		return null;
	}

	public function getDescription() : string {
		return "Please provide " . ucfirst($this->attributes['attribute']) . ' in ' . $this->attributes['metric'];
	}

	public function getAttribute() {
		return null;
	}
}