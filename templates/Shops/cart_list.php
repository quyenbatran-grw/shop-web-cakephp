            <?=$this->Html->link(
                'Categories',
                ['controller' => 'Pages', 'action' => 'index']
            );?>
            <div class="content">
                <?php
                ?>

                <div class="">
                    <?php
                    if(empty($products)) {
                        echo 'Don\'t have product';
                    } else {
                        foreach ($products as $product) {
                            # code...
                        $image_products = $product->image_products;
                        $image_url = '/img/noImage.svg';
                        if(count($product->image_products)) {
                            $image_product = $product->image_products[0];
                            $image_url = '/img/products/'.$image_product['file_name'];
                        }

                    ?>
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <img src="<?=$image_url?>" style="width: 100px" alt="">
                        </div>
                        <div class="p-2 bd-highlight">
                            <h2><?=$product->name?></h2>
                            <div class="row">
                                <div class="col">Price</div>
                                <div class="col text-end"><?=$product->unit_price?></div>
                            </div>

                            <div class="row">
                                <div class="col">Quantity</div>
                                <div class="col text-end"><?=$product->quantity?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">Total</div>
                                <div class="col text-end"><?=$product->unit_price * $product->quantity?></div>
                            </div>
                        </div>

                    </div>



                    <?php
                        }
                    }
                    ?>
                </div>



            </div>
