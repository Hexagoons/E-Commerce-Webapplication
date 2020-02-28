<!doctype html>
<html lang="nl" xmlns="http://www.w3.org/1999/html">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Document</title>
        <style>
            .main {
                margin: 0 auto;
                min-width: 320px;
            }
            
            .content {
                background: #fff;
                color: #000;
            }
            
            .content > div {
                display: none;
                padding: 20px 25px 5px;
            }
            
            .input {
                display: block;
            }
            
            .label {
                display: inline-block;
                padding: 15px 25px;
                font-weight: 600;
                text-align: center;
            }
            
            .label:hover {
                color: #000;
                cursor: pointer;
            }
            
            .input:checked + .label {
                background: #ed5a6a;
                color: #fff;
            }
            
            #tab1:checked ~ .content #content1,
            #tab2:checked ~ .content #content2 {
                display: block;
            }
            
            @media screen and (max-width: 400px) {
                .label {
                    padding: 15px 10px;
                }
            }
            
            #slider {
                overflow: hidden;
            }
            
            #slider figure {
                position: relative;
                width: 500%;
                margin: 0;
                left: 0;
                animation: 15s slider infinite;
            }
            
            #slider figure img {
                width: 20%;
                float: left;
            }
            
            @keyframes slider {
                0% {
                    left: 0;
                }
                20% {
                    left: 0;
                }
                40% {
                    left: -100%;
                }
                60% {
                    left: -100%;
                }
                80% {
                    left: -200%;
                }
                100% {
                    left: -200%;
                }
            }
        
        </style>
    </head>
    <body>
        <?php require_component('header'); ?>
        <!--Image slider deel-->
        
        <div class="container m-tb-1em">
            <div class="row flex">
                <div class="col s12">
                    <h1 class="product-title"><?= $product[ "name" ] ?></h1><br>
                </div>
                
                <div class="col s12 m4 l6">
                    <?php if (count($productImages) >= 3): ?>
                        <div id="slider">
                            <figure>
                                <?php foreach ($productImages as $image): ?>
                                    <img src="<?= route_link('/').'img/products/'.$image[ 'hash' ].'.jpg' ?>"
                                         width="400">
                                <?php endforeach; ?>
                            </figure>
                        </div>
                    <?php else: ?>
                        <img src="<?= route_link('/').'img/products/'.$productImages[ 0 ][ 'hash' ].'.jpg' ?>" class="product-image"/>
                    <?php endif; ?>
                </div>
                
                <div class="col s12 m6 l6 product-price">
                    <p class="price">&euro; <?= $product[ 'price' ] ?></p>
                    <form method="post" action="<?= route_link('/shoppingcart') ?>" class="product-form">
                        <div class="row">
                            <div class="col m3">
                                <input type="hidden" name="id" value="<?= $product[ 'id' ] ?>">
                                <input type="number" name="aantal" value="1">
                            </div>
                            <div class="col m9">
                                <button type="submit" class="btn"><i class="fas fa-plus" style="font-size: 14px"></i> in winkelmand</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            
            <!--Omschrijving/Product Informatie Deel-->
            <div class="main">
                
                <input id="tab1" type="radio" name="tabs" checked class="input">
                <label for="tab1" class="label">Omschrijving</label>
                
                <input id="tab2" type="radio" name="tabs" class="input">
                <label for="tab2" class="label">Product Informatie</label>
                
                <div class="content">
                    <div id="content1">
                        <p>
                            <?php echo($product[ "description" ]); ?>
                        </p>
                    </div>
                    <div id="content2">
                        <table>
                            <thead>
                                <tr>
                                    <th>Productinformatie</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Merk</td>
                                    <td><a href="<?= route_link('/products') . '?brands[]=' . $product['brand_id'] ?>"><?= $product[ "brand" ] ?></a></td>
                                </tr>
                                <tr>
                                    <td>Categorie</td>
                                    <td><a href="<?= route_link('/products') . '?categories[]=' . $product['category_id'] ?>"><?= $product[ "category" ] ?></a></td>
                                </tr>
                                <?php foreach ($specs as $spec): ?>
                                <tr>
                                    <td><?= ucwords($spec['attribute']) ?></td>
                                    <td><?= ucwords($spec['value']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>EAN</td>
                                    <td><?= sprintf('%013d', $product[ "ean" ]) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php require_component('footer'); ?>
    </body>
</html>