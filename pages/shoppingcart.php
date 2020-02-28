<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <div class="content">
            <form action="<?= route_link('/order') ?>" method="post">
                <br>
                <br>
                
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Naam</th>
                            <th>Prijs</th>
                            <th>Aantal</th>
                            <th>Subtotaal prijs</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($shoppingCart)): ?>
                            <tr>
                                <td colspan="6">
                                    Uw shopping cart is leeg
                                </td>
                            </tr>
                        <?php else: ?>
                            
                            <?php
                            $i = 0;
                            $totaal = [];
                            
                            foreach ($shoppingCart as $id => $aantal): ?>
                                <tr>
                                    <td>
                                        <img src="<?= route_link('/').'img/products/'.$shoppingCarts[ $i ][ 'hash' ].'.jpg' ?>"
                                             width="150">
                                    </td>
                                    <td nowrap>
                                        <a href="<?= route_link('/products/show').'?id='.$shoppingCarts[ $i ][ 'id' ] ?>"><?= $shoppingCarts[ $i ][ 'name' ] ?>
                                            <br></a>
                                    </td>
                                    <td>
                                        &euro;&nbsp;<?= number_format($shoppingCarts[ $i ][ 'price' ], 2, ',', '') ?>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="<?= $aantal ?>" name="product_amount_<?= htmlspecialchars($shoppingCarts[ $i ][ 'id' ], ENT_QUOTES) ?>" style="width: 50px"/>
                                    </td>
                                    <td>
                                        <?php $totaal[] = $shoppingCarts[ $i ][ 'price' ] * $aantal ?>
                                        &euro;&nbsp;<?= number_format($shoppingCarts[ $i++ ][ 'price' ] * $aantal, 2,
                                            ',', '') ?>
                                    </td>
                                    <td>
                                        <a href="<?= route_link('/shoppingcart/delete/')."?id=".$id ?>"
                                           class="btn btn-action btn-small pull-right"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"></td>
                                <td><b>Totaal:</b></td>
                                <td>
                                    &euro;&nbsp;<?= number_format(array_sum($totaal), 2, ',', '') ?>
                                </td>
                                <td></td>
                                <td>
                            </tr>
                        
                        <?php endif; ?>
                    </tbody>
                </table>
                <br>
                <div class="row">
                    <div class="col m3">
                        <a href="<?= route_link('/products') ?>" class="btn">Verder winkelen</a>
                    </div>
                    <div class="col m7"></div>
                    <div class="col m2">
                        <input type="submit" class="btn btn-action" value="Verder naar bestellen"/>
                    </div>
                </div>
            </form>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>