<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Bestellingen</title>
    </head>
    <body>
        <?php require_component('header'); ?>

        <h3>Bestelling</h3>

        <div class="row">
            <?php require_component('admin.sidenav') ?>
            <div class="col s10">
                <div class="row">
                    <h3>Producten</h3>
                    <table>
                        <thead>
                            <th>Product ID</th>
                            <th>Naam</th>
                            <th>Merk</th>
                            <th>Aantal</th>
                            <th>Prijs</th>
                        </thead>
                        <tbody>
                            <?php foreach($products as $key => $value): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_link('/admin/products/edit') . '?id=' . $value['id'] ?>"><?= sprintf('%03d', $value['id']); ?></a>
                                    </td>
                                    <td><?= $value['name'] ?></td>
                                    <td><?= $value['brand'] ?></td>
                                    <td><?= $value['amount'] ?></td>
                                    <td><?= '&euro; ' . number_format(($value['price'] * $value['amount']), '2', ',', '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"></td>
                                <td><b>Totaal</b></td>
                                <td>
                                    <?php
                                        $total = 0;

                                        foreach ($products as $key => $value)
                                            $total += $value['price'] * $value['amount'];

                                        echo('&euro; ' . number_format($total, 2, ',', ''));
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <h3>Klantgegevens</h3>
                    <table>
                        <thead>
                            <th>Klant ID</th>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Adres</th>
                            <th>Plaats</th>
                            <th>Land</th>
                        </thead>
                        <tbody>
                            <td><a href="<?= route_link('/admin/customers/edit'  . '?id=' . $customer['id'])?>"><?= $customer['id'] ?></a></td>
                            <td><?= $customer['name'] ?></td>
                            <td><?= $customer['email'] ?></td>
                            <td><?= $customer['address'] ?></td>
                            <td><?= $customer['city'] ?></td>
                            <td><?= $customer['country'] ?></td>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <form action="<?= route_link('/admin/orders/update') ?>" method="post">
                        <input type="number" value="<?= $order['id'] ?>" name="order" hidden>

                        <div class="input-field">
                            <select title="Status" class="browser-default" name="status" required>
                                <?= select_options('status',
                                    $order['status'] ?? null, [
                                        ['id' => 'New', 'name' => 'New'],
                                        ['id' => 'In Progress', 'name' => 'In Progress'],
                                        ['id' => 'Complete', 'name' => 'Complete'],
                                    ],'Status');
                                ?>
                            </select>
                        </div>

                        <input class="btn btn-action" type="submit" value="Wijzig">
                    </form>
                </div>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>