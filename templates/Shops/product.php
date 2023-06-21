<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Categories',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false]
);?>
<?=$this->Html->link(
    '<i class="bi bi-chevron-left fs-6"></i>Product List',
    ['controller' => 'Shops', 'action' => 'category', 'id' => 1],
    ['escape' => false, 'escapeTitle' => false, 'class' => '']
);?>
</div>

<div class="content produc-detail mt-3">
    <?php
    ?>

    <div class="row">
        <?php
        if(empty($product)) {
            echo 'Don\'t have product';
        } else {
            $image_products = $product->image_products;

        ?>
        <h2 class="fw-bold"><?=$product->name?></h2>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active rounded-circle" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <?php
                $image_url = '/img/noImage.svg';
                foreach ($image_products as $key => $image_product) {
                    $image_url = '/img/products/'.$image_product['file_name'];
                ?>
                <div class="carousel-item <?=$key ? '' : 'active'?>">
                <img src="<?=$image_url?>" class="d-block w-100" alt="...">
                </div>
                <?php
                }
                ?>

            </div>

        </div>

        <div class="fw-bold">Price: <?=$product->product_inventories[0]->price;?></div>

        <div>
            <?=nl2br($product->description)?>
        </div>

        <hr>

        <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $product->category_id, $product->id]])?>
        <div class="add-cart-group d-flex mt-3" role="group" aria-label="Basic example">
            <!-- <div>Quantity</div> -->

            <div class="w-25">
                <?=$this->Form->control('quantity', [
                    'type' => 'select',
                    'label' => 'Quantity',
                    'class' => 'form-control text-center ms-2',
                    'options' => $stock_quantity
                ])?>
            </div>


            <?= $this->Form->button('<i class="bi bi-cart3"></i>Add To Card', [
                'type' => 'submit',
                'class' => 'btn btn-primary ms-4 mt-4',
                'escapeTitle' => false,
                'onClick' => 'addItemToCart(this)'
            ]); ?>
        </div>
        <?=$this->Form->end();?>
        <?php } ?>
    </div>
    <button type="button" class="btn btn-primary" id="liveToastBtn">
  Show live toast
</button>

<div class="position-fixed bottom-0 end-0 p-3 position-relative top-0 end-0 mt-5 text-white" style="z-index: 5">
  <div
    id="liveToast"
    class="toast hide bg-success"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
  >
    <!-- <div class="toast-header"> -->
      <!-- <img src="..." class="rounded me-2" alt="..." /> -->
      <!-- <strong class="me-auto">Adding Product</strong> -->
      <!-- <small>11 mins ago</small> -->
      <!-- <button
        type="button"
        class="btn-close"
        data-bs-dismiss="toast"
        aria-label="Close"
      ></button> -->
    <!-- </div> -->
    <div class="d-flex">
        <div class="toast-body">
        Product is added to cart
        </div>
        <button type="button" class="btn-close me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="閉じる"></button>
    </div>
    <!-- <div class="toast-body">Product is added to cart.<button
        type="button"
        class="btn-close"
        data-bs-dismiss="toast"
        aria-label="Close"
      ></button></div> -->
  </div>
</div>


</div>
<script>
    document.querySelectorAll('.toast')
  .forEach(toastNode => {
    let add_to_cart = <?=json_encode($add_to_cart);?>;
    console.log(add_to_cart)
    const toast = new bootstrap.Toast(toastNode, {
      autohide: true,
    //   delay: 2000
    })

    if(add_to_cart) toast.show()
  })


</script>
