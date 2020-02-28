<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Product</h3>
        </div>
        
        <div class="row">
            <?php require_component('admin.sidenav') ?>
            <div class="col s10">
                <div class="row">
                    
                    <form action="<?= route_link('/admin/products/edit') ?>" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $product[ 'id' ] ?>">
                        
                        <?php
                        require_component('admin.forms.products', [
                            'product'    => $product,
                            'images'     => $images,
                            'categories' => $categories,
                            'brands'     => $brands
                        ]); ?>
                    </form>
                </div>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>