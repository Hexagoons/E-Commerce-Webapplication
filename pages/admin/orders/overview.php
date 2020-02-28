<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Bestellingen</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Bestellingen</h3>
        </div>
        <div class="row">
            <?php require_component('admin.sidenav') ?>
    
            <?php require_component('admin.searchbar', ['route' => '/admin/orders']); ?>
            
            <div class="col s10">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Bestelling ID</th>
                            <th>Klant</th>
                            <th>Aantal producten</th>
                            <th>Totaal prijs in €</th>
                            <th>Status</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $key => $value): ?>
                            <tr>
                                <td><?= $value[ 'id' ] ?></td>
                                <td>
                                    <a href="<?= route_link('/admin/customers/edit')."?id=".$value[ 'customer_id' ] ?>"><?= $value[ 'customer_name' ] ?></a>
                                </td>
                                <td><?= $value[ 'total_items' ] ?></td>
                                <td><?= '&euro; ' . number_format($value[ 'total_price' ], 2, ',', '') ?></td>
                                <td><?= $value['status'] ?></td>
                                <td>
                                    <a class="btn btn-action btn-small"
                                       href="<?= route_link('/admin/orders/show').'?id='.$value[ 'id' ] ?>">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    
                                    <form action="<?= route_link('/admin/orders/delete') ?>" class="form-action"
                                          method="post">
                                        <input type="hidden" value="<?= $value[ 'id' ] ?>" name="id">
                                        <button type="submit" class="btn btn-small btn-action"
                                                onclick="return confirm('Weet u zeker dat u deze bestelling definitief wilt verwijderen')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <br>
                
                <?= paginate_links($pageCount, $_GET[ 'page' ] ?? 2); ?>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>