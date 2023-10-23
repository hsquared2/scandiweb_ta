<header class="header">
  <h2 class="header_title"><?=$title?></h2>
  <div class="header_action">
    <a href="<?=BASE_URL . 'add-product'?>" class="btn btn-primary"">ADD</a>
    <input type="submit" form="products_form" value="MASS DELETE" class="btn btn-danger">
  </div>
</header>
<form method="POST" id="products_form">
    <div class="product_list">
      <?php foreach($products as $product): ?>
        <div class="item">
          <div class="item_checkbox">
            <input type="checkbox" class="delete-checkbox" name="checked[]" value="<?=$product['id_product']?>">
          </div>
          <div class="item_content">
            <p><?=$product['sku']?></p>
            <p><?=$product['name']?></p>
            <p><?=$product['price']?> $</p>
            <p>
              <?=$product['attributes']?></span>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
</form>