<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Categorieën</h3>
        </div>
        <div class="row">
            <?php require_component('admin.sidenav') ?>
    
            <div class="col s10">
                <a href="<?= route_link('/admin/categories/create') ?>"
                   class="btn btn-action pull-right">Categorie toevoegen</a>
            </div>
    
            <?php require_component('admin.searchbar', ['route' => '/admin/categories']); ?>
            
            <div class="col s10">
                <div class="row">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th width="100">Categorie ID</th>
                                <th>Naam</th>
                                <th class="pull-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_link('/admin/categories/edit').'?id='.$category[ 'id' ] ?>"><?= sprintf('%02d', $category['id']) ?></a>
                                    </td>
                                    <td><?= $category[ 'name' ] ?></td>
                                    <td class="pull-right">
                                        <a href="<?= route_link('/admin/categories/edit').'?id='.$category[ 'id' ] ?>"
                                           class="btn btn-small btn-action"><i class="fas fa-pencil-alt"></i></a>
                                        
                                        <form action="<?= route_link('/admin/categories/delete') ?>" class="form-action" method="post">
                                            <input type="hidden" value="<?= $category[ 'id' ] ?>" name="id">
                                            <button type="submit" class="btn btn-small btn-action"
                                                    onclick="return confirm('Weet u zeker dat u deze categorie definitief wilt verwijderen')">
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