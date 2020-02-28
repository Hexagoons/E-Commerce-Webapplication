<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Producten</h3>
        </div>
        
        <div class="row">
            <?php require_component('admin.sidenav') ?>
    
            <div class="col s10">
                <a href="<?= route_link('/admin/products/create') ?>"
                   class="btn btn-action pull-right">Product toevoegen</a>
            </div>
    
            <?php require_component('admin.searchbar', ['route' => '/admin/products']); ?>
            
            <div class="col s10">
                <br>
                <div class="row">
                    
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Naam</th>
                                <th>Categorie</th>
                                <th>Merk</th>
                                <th>Prijs</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_link('/admin/products/edit').'?id='.$product[ 'id' ] ?>"><?= sprintf('%03d', $product['id']) ?></a>
                                    </td>
                                    <td><?= $product[ 'name' ] ?></td>
                                    <td>
                                        <a href="<?= route_link('/admin/categories/edit').'?id='.$product[ 'category_id' ] ?>"><?= $product[ 'category' ] ?></a>
                                    </td>
                                    <td>
                                        <a href="<?= route_link('/admin/brands/edit').'?id='.$product[ 'brand_id' ] ?>"><?= $product[ 'brand' ] ?></a>
                                    </td>
                                    <td>&euro; <?= number_format($product[ 'price' ], 2, ',', '') ?></td>
                                    <td>
                                        <a href="<?= route_link('/admin/products/edit').'?id='.$product[ 'id' ] ?>"
                                           class="btn btn-small btn-action"><i class="fas fa-pencil-alt"></i></a>
                                        
                                        <form action="<?= route_link('/admin/products/delete') ?>" class="form-action"
                                              method="post">
                                            <input type="hidden" value="<?= $product[ 'id' ] ?>" name="id">
                                            <button type="submit" class="btn btn-small btn-action"
                                                    onclick="return confirm('Weet u zeker dat u dit product definitief wilt verwijderen')">
                                                <i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <br>
                
                <?= paginate_links($pageCount, $_GET[ 'page' ] ?? 1); ?>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>