<?php

namespace Products\Models;

use System\BaseModel;

class ProductTypes extends BaseModel {
  protected static $instance;
  protected string $table = 'product_types';
  protected string $pk = 'id_type';
}