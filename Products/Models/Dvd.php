<?php

namespace Products\Models;

class Dvd extends Product {
  protected static $instance;
  protected array $attributes = [
    'attribute' => 'size',
    'fields' => [
      'size' => null,
    ],
    'metric' => 'MB',
  ];

  public function getCustomRules() {
    return ['size' => 'required|numeric'];
  }
  
  public function getAttribute() : string{
    return "Size: " . $this->attributes['fields']['size'] . ' ' . $this->attributes['metric'];
  }
}