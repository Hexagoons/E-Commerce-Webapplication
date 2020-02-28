<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Producten</title>
    </head>
    <body>
        <?php require_component('header', ['container' => false]); ?>
        
        <div class="row">
            <div class="col m3">
                <div class="sidenavo">
                    <?php if(isset($_GET['categories']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['brands'])): ?>
                    <i><a href="<?= route_link('/products') ?>" class="center-align bg-primary white-text" style="padding: 0;">Verwijder alle filters (x)</a></i>
                    <?php endif; ?>
                    
                    <h5>Categorieen</h5>
                    <hr>
                    <form method="get">
                        <?php
                        if(isset($_GET['query']) && !empty($_GET['query']))
                            echo "<input type='hidden' name='query' value='" . htmlspecialchars($_GET['query']) . "'/>";
                        ?>
                        
                        <?php foreach ($rijNaam as $categorie): ?>
                            <p>
                                <label>
                                    <input class="filled-in" name="categories[]" value="<?= $categorie[ 'id' ] ?>" type="checkbox"
                                        <?= ( in_array($categorie[ 'id' ], (isset($_GET['categories']) && is_array($_GET['categories'])) ? $_GET['categories'] : [])) ? "checked" : null ?>>
                                    <span class="black-text"><?= $categorie[ 'name' ] ?></span>
                                </label>
                            </p>
                        <?php endforeach; ?>
                        <hr>
                        <h5>Prijs</h5>
                        <table>
                            <tr>
                                <td>
                                    <input type="number" min="0" name="min" placeholder="0,00" step="0.01" value="<?= htmlspecialchars($_GET['min'] ?? null, ENT_QUOTES) ?>"/>
                                </td>
                                <td>
                                    <input type="number" min="0" name="max" placeholder="0,00" step="0.01" value="<?= htmlspecialchars($_GET['max'], ENT_QUOTES) ?? null ?>"/>
                                </td>
                            </tr>
                        </table>
                        <h5>Brands</h5>
                        <hr>
                        <?php
                        foreach ($rijTel as $brand): ?>
                            <p>
                                <label>
                                    <input type="checkbox" name="brands[]" value="<?= $brand[ 'id' ]?>" class="filled-in"
                                        <?= ( in_array($brand[ 'id' ], (isset($_GET['brands']) && is_array($_GET['brands'])) ? $_GET['brands'] : [])) ? "checked" : null ?>>
                                    <span class="black-text"><?= $brand[ 'name' ] ?></span>
                                </label>
                            </p>
                        <?php endforeach; ?>
                        <button type="submit" class="btn bg-primary pull-right"><i class="material-icons">arrow_forward</i></button><br><br>
                    </form>
                </div>
            </div>
            <div class="col m9">
                <h1>Producten</h1>
                <div class="row flex">
                    <?php if(empty($products)): ?>

                        <div class="col m12 s12">

                            <div class="card product-card">
                                <div class="card-content">
                                    <div class="center-align">
                                        <p>Geen zoekresultaten</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php endif; ?>

                    <?php foreach ($products as $product): ?>
            
                        <div class="col m4 s12">
                
                            <div class="card product-card">
                                <div class="card-image">
                                    <a href="<?= route_link('/products/show').'?id='.$product[ 'id' ] ?>">
                                        <img src="<?= route_link('/').'img/products/'.$product[ 'hash' ].'.jpg' ?>"
                                             width="540">
                                        <span class="card-title black-text">&euro; <?= number_format($product[ 'price' ], 2, ',', ''); ?></span>
                                    </a>
                                </div>
                                <div class="card-content">
                                    <div class="valign-wrapper">
                                        <a href="<?= route_link('/products/show').'?id='.$product[ 'id' ] ?>"><?= $product[ 'name' ] ?></a>
                                    </div>
                                </div>
                            </div>
            
                        </div>
        
                    <?php endforeach; ?>
                </div>
                <?= paginate_links($pageCount, $_GET[ 'page' ] ?? 1); ?>
            </div>
        </div>
        
        <?php require_component('footer', ['container' => false]); ?>
    </body>
</html>