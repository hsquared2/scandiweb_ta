<?php

namespace Products\Controllers;

use System\BaseController;
use Products\Models\Product;
use Products\Models\ProductTypes;
use Rakit\Validation\Validator;
use System\Template;
use System\UniqueRule;

class Index extends BaseController {
  protected Product $mProducts;
  protected ProductTypes $mProductTypes;
  protected Product $prTypeClass;
  protected Validator $validator;

  public function __construct(){
    $this->mProducts = Product::getInstance();
    $this->mProductTypes = ProductTypes::getInstance();
    $this->prTypeClass = Product::getInstance();
    $this->validator = new Validator();
    $this->validator->addValidator('unique', new UniqueRule());
  }

  public function index() {
    $products = $this->mProducts->all();

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['checked'])) {
      $this->mProducts->massDelete($_POST['checked']);
      header("Location: " . BASE_URL);
      exit();
    }

    $this->title = 'Product List';
    $this->content = Template::render(__DIR__ . '/../Views/v_product_list.php', [
      'title' => $this->title,
      'products' => $products,
    ]);
  }

  public function add() {
    $this->title = 'Product Add';
    $producTypes = $this->mProductTypes->all();

    $fields = [
      'sku' => '',
      'name' => '',
      'price' => '',
    ];

    $attributes = [];
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $fields = $this->extractFields($_POST);

      if(isset($_POST['type'])) {
        $type = $this->mProductTypes->get($_POST['type']);
        $prTypeClassStr = "\\Products\\Models\\" . ucfirst(strtolower($type['name']));
        $this->prTypeClass = $prTypeClassStr::getInstance();

        $attributes = [
          'fields' => $this->prTypeClass->getAttrFields(),
          'metric' => $this->prTypeClass->getMetric(),
          'description' => $this->prTypeClass->getDescription(),
        ];

        $this->mProducts->addValidationRules($this->prTypeClass->getCustomRules());
      }

      if(isset($_POST['save'])) {
        $fields = $this->extractFields($_POST);

        $validationRules = $this->mProducts->getValidationRules();
        $validation = $this->validator->validate($fields, $validationRules);

        if($validation->fails()) {
          $errors = $validation->errors()->firstOfAll();
        } else {
          $data = $this->packData($fields);
          $this->mProducts->add($data);
          header("Location: " . BASE_URL);
          exit();
        }
      }
    }

    $this->content = Template::render(__DIR__ . '/../Views/v_product_add.php', [
      'title' => $this->title,
      'fields' => $fields,
      'productTypes' => $producTypes,
      'attributes' => $attributes,
      'errors' => $errors,
    ]);
  }

  protected function extractFields(array $arrFields) {
    $fields = [];

    foreach($arrFields as $field => $val) {
      if($field !== 'save') {
        $fields[$field] = htmlspecialchars($val);
      }
    }

    return $fields;
  }

  protected function packData(array $fields) : array{
    $this->prTypeClass->setAttrValues($fields);

    foreach($fields as $field => $val) {
      if(in_array($field, $this->prTypeClass->getAttrFields())) {
        unset($fields[$field]);
      }
    }

    $fields['attributes'] = $this->prTypeClass->getAttribute();

    return $fields;
  }

  
}