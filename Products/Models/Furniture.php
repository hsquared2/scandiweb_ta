<?php


namespace Products\Models;

class Furniture extends Product {
  protected static $instance;
  protected array $attributes = [
    'attribute' => 'dimensions',
    'fields' => [
      'height' => null, 
      'width' => null, 
      'length' => null,
    ],
    'metric' => 'CM',
  ];

  public function getCustomRules() {
    $rules = [];

    foreach(array_keys($this->attributes['fields']) as $field) {
      $rules[$field] = 'required|numeric';
    }

    return $rules;
  }

  public function getDescription() : string {
    return "Please provide " . ucfirst($this->attributes['attribute']) . ' in ' . ' HxWxL format';
  }

  public function getAttribute() : string{
    return "Dimensions: "
          .$this->attributes['fields']['height']
          .'x'.$this->attributes['fields']['width']
          .'x'.$this->attributes['fields']['length'];
  }
}