            <?=$this->Html->link(
                'Categories',
                ['controller' => 'Pages', 'action' => 'index']
            );?>
            <div class="content cart-list">
                <?php
                ?>

                <div class="">
                    <?php
                    $total_amount = 0;
                    if(empty($products)) {
                        echo 'Don\'t have product';
                    } else {
                        foreach ($products as $product) {
                            $image_products = $product->image_products;
                            $image_url = '/img/noImage.svg';
                            if(count($product->image_products)) {
                                $image_product = $product->image_products[0];
                                $image_url = '/img/products/'.$image_product['file_name'];
                            }
                            $amount = $product->unit_price * $product->quantity;
                            $total_amount += $amount;
                    ?>
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <img src="<?=$image_url?>" style="width: 100px" alt="">
                        </div>
                        <div class="p-2 bd-highlight w-100">
                            <h2><?=$product->name?></h2>
                            <div class="row">
                                <div class="col">Price</div>
                                <div class="col text-end"><?=$product->unit_price?></div>
                            </div>

                            <div class="row">
                                <div class="col">Quantity</div>
                                <div class="col">
                                <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                                <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                                <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                                <?=$this->Form->control('quantity', [
                                    'type' => 'select',
                                    'label' => false,
                                    'class' => 'form-control text-center ms-2 w-50 float-end',
                                    'value' => $product->quantity,
                                    'options' => [1 => 1,2 => 2, 3 => 3, 4 => 4],
                                ])?>
                                <?=$this->Form->end();?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">Amount</div>
                                <div class="col text-end"><?=$amount?></div>
                            </div>
                            <div class="row">
                                <?=$this->Form->create($product, ['type' => 'delete', 'url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                                <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                                <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                                <?=$this->Form->button('Remove', [
                                    'type' => 'submit',
                                    'label' => false,
                                    'class' => 'btn btn-link text-center float-end',
                                ])?>
                                <?=$this->Form->end();?>

                            </div>
                        </div>

                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <hr>
                <div class="d-flex flex-row">
                <div class="p-2 bd-highlight">
                            Total
                        </div>
                        <div class="p-2 bd-highlight w-100">
                            <div class="row">
                                <div class="col"></div>
                                <div class="col text-end"><?=$total_amount?></div>
                            </div>
                        </div>
                </div>

                <div class="d-flex flex-row justify-content-center">
                    <div class="row">
                        <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'cart-confirm']]);?>
                        <?=$this->Form->button('Next', [
                            'class' => 'btn btn-primary'
                        ]);?>
                        <?=$this->Form->end();?>
                    </div>
                </div>



            </div>
