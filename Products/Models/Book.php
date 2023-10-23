<?php

namespace Products\Models;

class Book extends Product {
  protected static $instance;
  protected array $attributes = [
    'attribute' => 'weight',
    'fields' => [
      'weight' => null,
    ],
    'metric' => 'KG',
  ];

  public function getCustomRules() {
    return ['weight' => 'required|numeric'];
  }

  public function getAttribute() : string{
    return "Weight: " . $this->attributes['fields']['weight'] . ' ' . $this->attributes['metric'];
  }


}