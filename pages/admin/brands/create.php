<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
    
        <div class="row">
            <h3>Merk</h3>
        </div>
        
        <div class="row">
            <?php require_component('admin.sidenav') ?>
            <div class="col s10">
                <div class="row">
                    
                    <form action="<?= route_link('/admin/brands/create') ?>" method="POST">
                        <?php require_component('admin.forms.brands'); ?>
                    </form>
                </div>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>