<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Dashboard</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="row">
            <h3>Klanten</h3>
        </div>
        
        <div class="col ">
            <div class="card-panel bg-primary">
                <table style="color: white;">
                    <tr>
                        <td>Aantal bestellingen: <?= $total_orders ?></td>
                        <td>Omzet: &euro; <?= $total_revenue ?></td>
                        <td>Aantal actieve gebruikers: <?= $total_customers ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row">
            <?php require_component('admin.sidenav'); ?>
    
            <?php require_component('admin.searchbar', ['route' => '/admin']); ?>
            
            <div class="col s10">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Klant ID</th>
                            <th>Naam</th>
                            <th>E-mail</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($customers); $i++): ?>
                            <tr>
                                <td><?= sprintf('%03d', $customers[ $i ][ 'id' ]) ?></td>
                                <td><?= $customers[ $i ][ 'full_name' ] ?></td>
                                <td><?= $customers[ $i ][ 'email' ] ?></td>
                                <td>
                                    <a href="<?= route_link('/admin/customers/edit').'?id='.$customers[ $i ][ 'id' ] ?>"
                                               class="btn btn-small btn-action"><i class="fas fa-pencil-alt"></i></a>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                
                <br>
                
                <?= paginate_links($pageCount, $_GET[ 'page' ] ?? 1); ?>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>