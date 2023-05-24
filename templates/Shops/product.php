            <?=$this->Html->link(
                'Categories',
                ['controller' => 'Pages', 'action' => 'index']
            );?>>>
            <?=$this->Html->link(
                'Product List',
                ['controller' => 'Shops', 'action' => 'index', 'id' => 1]
            );?>
            <div class="content">
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

                    <div>
                        <?=nl2br($product->description)?>
                    </div>

                    <hr>

                    <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $product->category_id, $product->id]])?>
                    <div class="add-cart-group d-flex mt-3" role="group" aria-label="Basic example">
                        <div>Quantity</div>

                        <div class="w-25">
                            <?=$this->Form->control('quantity', [
                                'type' => 'select',
                                'label' => false,
                                'class' => 'form-control text-center ms-2',
                                'options' => [1 => 1,2 => 2, 3 => 3, 4 => 4]
                            ])?>
                        </div>


                        <?= $this->Form->button('<i class="bi bi-cart3"></i>Add To Card', [
                            'type' => 'submit',
                            'class' => 'btn btn-primary ms-4',
                            'escapeTitle' => false,
                            'onClick' => 'addItemToCart(this)'
                        ]); ?>
                    </div>
                    <?=$this->Form->end();?>
                    <?php } ?>
                </div>



            </div>
