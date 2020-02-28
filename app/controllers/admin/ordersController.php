<?php
    // Show all orders
    function overview()
    {
        $db = database_connect();
        
        $sql = "SELECT o.id, o.customer_id, CONCAT(c.first_name, ' ', c.last_name) AS `customer_name`,
                       (SELECT SUM(amount) FROM orders_has_products GROUP BY order_id HAVING order_id = id) as `total_items` ,
                       (SELECT SUM(price * amount) FROM orders_has_products JOIN products as p ON orders_has_products.product_id = p.id GROUP BY order_id HAVING order_id = id) as 'total_price',
                       o.status
                FROM orders o
                  JOIN customers c on o.customer_id = c.id";
    
        if(isset($_GET['query'])) {
            $query = database_escape($db, $_GET['query']);
            $sql .= " WHERE CONCAT(first_name, ' ', last_name) LIKE '%{$query}%'";
        }

        $orders = database_paginate($db, $sql, $_GET['page'] ?? 1);

        require_page('admin.orders.overview', ['orders' => $orders['result'], 'pageCount' => $orders['pageCount']]);
    }

    // show single order
    function show()
    {
        if (!isset($_GET['id']))
            return route_link('/admin/orders');

        $db = database_connect();

        $order_id = database_escape($db, $_GET['id']);

        $order = database_query($db, "SELECT o.id, o.status FROM orders as o
                                            JOIN orders_has_products as ohp
                                            ON o.id = ohp.order_id
                                            WHERE o.id = {$order_id}")[0];

        $customer = database_query($db, "SELECT c.id, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.email, 
                                               CONCAT(o.streetname, ' ', o.house_number) as `address`,
                                               o.city, o.country
                                               FROM orders as `o` 
                                               JOIN customers as `c`
                                               ON o.customer_id = c.id
                                               JOIN addresses as `a`
                                               ON c.address_id = a.id
                                               WHERE o.id = {$order_id}")[0];

        $products = database_query($db, "SELECT p.id, p.name, b.name as `brand`, ohp.amount, p.price
                                               FROM orders_has_products as `ohp`
                                               JOIN products as `p`
                                               ON ohp.product_id = p.id
                                               JOIN brands as `b`
                                               ON p.brand_id = b.id
                                               WHERE ohp.order_id = {$order_id}");

        require_page('admin.orders.show', [
            "order" => $order,
            "customer" => $customer,
            "products" => $products
        ]);
    }

    // show create form
    function create()
    {

    }

    // show edit form
    function edit()
    {

    }

    // store in databse
    function store()
    {

    }

    // update in database
    function update()
    {
        $db = database_connect();

        $request = _validation();

        if ($request === false)
            return route_link('/admin/orders');

        extract($request);

        $status = database_escape($db, $status);
        $order = database_escape($db, $order);

        $result = mysqli_query($db, "UPDATE orders SET status = '{$status}' WHERE id = {$order}");

        if (!$result)
            alert('error', 'De status kon niet worden veranderd!');
        else
            alert('succes', 'Status van de bestelling is succesvol gewijzigd.');

        return route_link('/admin/orders/show') . '?id=' . $order;
    }

    function _validation()
    {
        if(empty($_POST)) {
            return [];
        }

        $request = array(
            'order'  => $_POST['order'] ?? null,
            'status' => $_POST['status'] ?? null,
        );

        $rules = [
            'order'  => 'numeric',
            'status' => 'string|in_array:New,In Progress,Complete',
        ];

        return validate($request, $rules);
    }