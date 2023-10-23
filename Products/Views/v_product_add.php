
<header class="header">
  <h2 class="header_title"><?=$title?></h2>
  <div class="header_action">
    <input type="submit" form="product_form" class="btn btn-success" name="save" value="Save">
    <a href="<?=BASE_URL?>" class="btn btn-secondary">Cancel</a>
  </div>
</header>
<form method="POST" id="product_form">
  <div class="form_item">
    <div class="form_item-input">
      <label for="sku">SKU</label>
      <input type="text" name="sku" value="<?=$fields['sku']?>" id="sku" class="input">  
    </div>
    <p class="form_item-err text-danger"><?=isset($errors['sku']) ? $errors['sku'] : ''?></p>
  </div>
  <div class="form_item">
    <div class="form_item-input">
      <label for="name">Name</label>
      <input type="text" name="name" value="<?=$fields['name']?>" id="name" class="input"> 
    </div>
    <p class="form_item-err text-danger"><?=isset($errors['name']) ? $errors['name'] : ''?></p>
  </div>
  <div class="form_item">
    <div class="form_item-input">
      <label for="price">Price ($)</label>
      <input type="text" name="price" value="<?=$fields['price']?>" id="price" class="input"> 
    </div>
    <p class="form_item-err text-danger"><?=isset($errors['price']) ? $errors['price'] : ''?></p>
  </div>
  <div class="form_item">
    <div class="form_item-input">
      <label for="productType">Type Switcher</label>
      <select name="type" id="productType" onchange="this.form.submit()">
        <option disabled <?= empty($attrFields) ? 'selected' : ''?>></option>
        <?php foreach($productTypes as $type): ?>
          <option value="<?=$type['id_type']?>" <?= isset($_POST['type']) && $_POST['type'] == $type['id_type'] ? 'selected': ''?>><?=$type['name']?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <p class="form_item-err text-danger"><?=isset($errors['type']) ? $errors['type'] : ''?></p>
  </div>
  <?php if(isset($_POST['type']) && !empty($attributes['fields'])): ?>
    <?php foreach($attributes['fields'] as $field): ?>
    <div class="form_item">
      <div class="form_item-input">
        <label for="<?=$field?>"><?=ucfirst($field) . ' ('.$attributes['metric'].')'?></label>
        <input type="text" name="<?=$field?>" id="<?=$field?>" class="input">
      </div>
      <p class="form_item-err text-danger"><?=isset($errors[$field]) ? $errors[$field] : ''?></p>
    </div>
    <?php endforeach; ?>
    <p class="attr_desc"><?=$attributes['description']?></p>
  <?php endif; ?>
</form>