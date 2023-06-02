
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $image_url = '';
        foreach ($image_products as $key => $image_product) {
            $image_url = '/img/products/'.$image_product['file_name'];
        ?>
        <div class="carousel-item <?=$key ? '' : 'active'?>">
        <img src="<?=$image_url?>" class="d-block w-100 fix-img-size" alt="...">
        </div>
        <?php
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
</div>
<div class="content">
    <div class="row-sm">
        <?php
        $image_url = '';
        foreach ($categories as $key => $category) {
            if(empty($category)) continue;
            $image_product = null;
            foreach ($category->products as $product) {
                if(count($product->image_products)) {
                    $image_product = $product->image_products[0];
                    break;
                }
            }
            $image_url = '/img/products/'.$image_product['file_name'];
        ?>
        <?=$this->Form->create($category->products, ['url' => ['controller' => 'Shops', 'action' => 'category', 'id' => $category->id]])?>
            <div class="card mb-3 category-card">
                <div class="row-sm g-0">
                    <div class="col-md-2">
                    <img src="<?=$image_url?>" class="fix-img-size" alt="...">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title fw-bold"><?=$category->name?></h2>
                        <p class="card-text"><?=$category->description?></p>
                        <p class="card-text"><small class="bg-danger text-white rounded p-2">New Arrival</small></p>
                    </div>
                    </div>
                </div>
            </div>
        <?=$this->Form->end()?>
        <?php
        }
        ?>
    </div>



</div>
