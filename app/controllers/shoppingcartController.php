<?php
function overview()
{
    $shoppingCarts = array();
    while ( ($id = current($_SESSION['shopping-cart'])) !== FALSE ) {
        $conn = database_connect();
        $ide = key($_SESSION['shopping-cart']);
        $shoppingCarts[] = database_query($conn, "SELECT p.id, p.name, p.price, i.hash FROM products p JOIN product_images i ON p.id=i.product_id WHERE p.id=" . $ide)[0];
        next($_SESSION['shopping-cart']);
    }
    
    require_page('shoppingcart', [
        'shoppingCart' => $_SESSION['shopping-cart'],
        'shoppingCarts' => $shoppingCarts
    ]);
}

function add()
{
    // validation
    if(!isset($_POST['aantal']) || !isset($_POST['id'])) {
        return route_link('/products');
    }

    // define
    $aantal = $_POST['aantal'];
    $id = $_POST['id'];

    // if shopping cart doesn't exist
    if(!isset($_SESSION['shopping-cart'])) {
        $_SESSION['shopping-cart'] = [];
    }

    if (array_key_exists($id, $_SESSION['shopping-cart'])) {
        $_SESSION['shopping-cart'][$id] = $_SESSION['shopping-cart'][$id] + $aantal;
    } else {
        $_SESSION['shopping-cart'][$id] = $aantal;
    }
    
    alert('success', 'Product succesvol toegevoegd aan uw winkelwagen');

    // return to product page
    return route_link('/products/show') . '?id=' . $id;
}

function delete()
{
    unset($_SESSION['shopping-cart'][$_GET['id']]);
    return route_link('/shoppingcart');
}