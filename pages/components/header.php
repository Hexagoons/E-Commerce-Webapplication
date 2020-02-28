<nav class="bg-primary">
    <div class="nav-wrapper">
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="full-width hide-on-med-and-down">
            <!-- Left -->
            <li><a href="<?= route_link('/'); ?>">Sportshop.nl</a></li>
            <li><a href="<?= route_link('/products'); ?>">Winkel</a></li>
            <li><a href="<?= route_link('/about'); ?>">Over ons</a></li>
            
            <!-- Center -->
            <li>
                <div class="center row center-outer half-width">
                    <div class="col s12 center-inner">
                        <div class="row white">
                            <div class="input-field col s6 s12 white-text">
                                <form action="<?= route_link('/products') ?>" method="GET">
                                    <input type="text" name="query" placeholder="Zoeken..." class="black-text" <?= (isset($_GET['query'])) ? 'value="' . htmlspecialchars($_GET['query']) . '"' : null ?>>
                                </form>
                                <i class="black-text material-icons suffix">search</i>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            
            <!-- Right -->
            <?php if(is_user()): ?>
                <li class="pull-right"><a href="<?= route_link('/logout') ?>">Log uit</a></li>
                <li class="pull-right"><a href="<?= route_link('/my-account') ?>">Mijn account</a></li>
            <?php else: ?>
                <li class="pull-right"><a href="<?= route_link('/login') ?>">Inloggen/Registreren</a></li>
            <?php endif; ?>
            <li class="pull-right"><a href="<?= route_link('/shoppingcart') ?>"><i class="fa fa-shopping-cart badge" data-amount="<?= count($_SESSION['shopping-cart']) ?>"></i></a></li>
        </ul>
    </div>
</nav>
<?php if(is_admin() && strpos($_SERVER['REQUEST_URI'], '/admin') === false): ?>
    <nav class="bg-primary-darker admin-nav">
        <div class="nav-wrapper">
            <ul class="full-width hide-on-med-and-down">
                <li><a href="#!">Admin ></a></li>
                <li><a href="<?= route_link('/admin'); ?>">Dashboard</a></li>
            </ul>
        </div>
    </nav>
<?php endif; ?>

<ul class="sidenav" id="mobile-demo">
    <li>
        <div class="row white">
            <div class="input-field col s6 s12 white-text">
                <form action="<?= route_link('/products') ?>" method="GET">
                    <input type="search" name="query" placeholder="Zoeken..." class="black-text">
                </form>
                <i class="black-text material-icons suffix">search</i>
            </div>
        </div>
    </li>
    <li><a href="<?= route_link('/products') ?>">Winkel</a></li>
    <li><a href="<?= route_link('/about') ?>">Over ons</a></li>
    <li><a href="<?= route_link('/shoppingcart') ?>">Uw winkelmand</a></li>
    <?php if(is_user()): ?>
        <li><a href="<?= route_link('/logout') ?>">Log uit</a></li>
        <li><a href="<?= route_link('/my-account') ?>">Mijn account</a></li>
    <?php else: ?>
        <li><a href="<?= route_link('/login') ?>">Inloggen/Registreren</a></li>
    <?php endif; ?>
</ul>

<?php if(!isset($container) || ($container === true)): ?>
<div class="container">
<?php endif; ?>

<?php show_alerts() ?>