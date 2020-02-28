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
                    
                    <form action="<?= route_link('/admin/products/create') ?>" method="POST"
                          enctype="multipart/form-data">
                        <?php
                        require_component('admin.forms.products', [
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