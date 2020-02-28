<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Merken</h3>
        </div>
        <div class="row">
            <?php require_component('admin.sidenav') ?>
    
            <div class="col s10">
                <a href="<?= route_link('/admin/brands/create') ?>"
                   class="btn btn-action pull-right">Merk toevoegen</a>
            </div>
    
            <?php require_component('admin.searchbar', ['route' => '/admin/brands']); ?>
            
            <div class="col s10">
                <div class="row">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th width="100">Merk ID</th>
                                <th>Naam</th>
                                <th class="pull-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_link('/admin/brands/edit').'?id='.$brand[ 'id' ] ?>"><?= sprintf('%02d', $brand['id']) ?></a>
                                    </td>
                                    <td><?= $brand[ 'name' ] ?></td>
                                    <td class="pull-right">
                                        <a href="<?= route_link('/admin/brands/edit').'?id='.$brand[ 'id' ] ?>"
                                           class="btn btn-small btn-action"><i class="fas fa-pencil-alt"></i></a>
                                        
                                        <form action="<?= route_link('/admin/brands/delete') ?>" class="form-action" method="post">
                                            <input type="hidden" value="<?= $brand[ 'id' ] ?>" name="id">
                                            <button type="submit" class="btn btn-small btn-action"
                                                    onclick="return confirm('Weet u zeker dat u dit merk definitief wilt verwijderen')">
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