<?php

function overview()
{

    require_page('order');
}

function store()
{
    if (!isset($_SESSION['user'])) {
        alert('error', 'U moet in gelogd zijn om een bestelling te kunnen plaatsen');
        return route_link('/login');
    }

    if ($_SESSION['shopping-cart'] == [])
        return route_link('/shoppingcart');
    
    $errors = 0;
    
    foreach($_SESSION['shopping-cart'] as $key => $value) {
        if(!isset($_POST['product_amount_' . $key])) $errors = 1;
        $amount = $_POST['product_amount_' . $key];
        $amount = (int) $amount;
        
        if(!is_numeric($amount) || $amount <= 0) $errors = 1;
    }
    
    if($errors == 1) {
        alert('error', 'Oeps er ging iets mis tijden het bestellen');
        return route_link('/shoppingcart');
    }
    
    $db = database_connect();

    // Get user info and address
    $user = database_query($db, "SELECT c.id, a.zipcode, a.house_number, a.streetname, a.country, a.city 
                                       FROM customers as c
                                       JOIN addresses as a
                                       ON c.address_id = a.id
                                       WHERE c.id = {$_SESSION['user']['id']}")[0];

    // Create the new order with the right info
    mysqli_query($db, "INSERT INTO orders VALUES(NULL, NOW(), 'New', '{$user['zipcode']}', 
                             '{$user['house_number']}', '{$user['streetname']}', '{$user['city']}', 
                             '{$user['country']}', {$user['id']})");

    $new_order_id = mysqli_insert_id($db);

    // Insert all the ordered items in the orders_has_products table
    foreach($_SESSION['shopping-cart'] as $key => $value) {
        $amount = $_POST['product_amount_' . $key];
        $amount = database_escape($db, (int) $amount);
        
        if(is_numeric($amount) && $amount > 0)
            mysqli_query($db, "INSERT INTO orders_has_products VALUES({$new_order_id}, {$key}, {$amount}, 21)");
    }

    alert('success', "Bedankt voor uw bestelling!");

    $_SESSION['shopping-cart'] = [];

    return route_link('/shoppingcart');
}