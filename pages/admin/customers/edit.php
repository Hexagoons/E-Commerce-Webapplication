<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Overzicht</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Klant</h3>
        </div>
        
        <div class="row">
            <?php require_component('admin.sidenav') ?>
            <div class="col s10">
                <div class="row">
                    <form action="<?= route_link('/admin/customer/edit') . '?id='. $customer['id'] ?>" method="post">
                        <?php
                            require_component('admin.forms.customer', [
                                "customer" => $customer
                            ]);
                        ?>
                    </form>
                </div>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>