<div class="col s2">
    <h6>Welkom, <?= $_SESSION['user']['name'] ?? '' ?></h6>
    <hr>
    <div class="collection">
        <a href="<?= route_link('/admin'); ?>" class="collection-item">Dashboard</a>
        <a href="<?= route_link('/admin/products'); ?>" class="collection-item">Producten</a>
        <a href="<?= route_link('/admin/orders'); ?>" class="collection-item">Bestellingen</a>
        <a href="<?= route_link('/admin/categories'); ?>" class="collection-item">Categorieën</a>
        <a href="<?= route_link('/admin/brands'); ?>" class="collection-item">Merken</a>
    </div>
</div>
