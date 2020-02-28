<?php
    function overview()
    {
        $db = database_connect();
        
        $sql = 'SELECT id, CONCAT(first_name, \' \', last_name) as full_name, email FROM customers';
        
        if(isset($_GET['query'])) {
            $query = database_escape($db, $_GET['query']);
            $sql .= " WHERE email LIKE '%{$query}%' OR CONCAT(first_name, ' ', last_name) LIKE '%{$query}%'";
        }
        
        $customers = database_paginate($db, $sql, $_GET['page'] ?? 1);

        $total_orders = total_orders();
        $total_revenue = total_revenue();
        $total_customers = total_customers();

        require_page('admin.dashboard', [
            "customers" => $customers['result'],
            "pageCount" => $customers['pageCount'],
            "total_orders" => $total_orders,
            "total_revenue" => $total_revenue,
            "total_customers" => $total_customers
        ]);
    }

    function total_orders()
    {
        $db = database_connect();
        $result = database_query($db, 'SELECT count(*) as `total` from orders');

        return $result[0]['total'];
    }

    function total_revenue()
    {
        $db = database_connect();
        $result = database_query($db, 'SELECT SUM(o.amount * p.price) AS `total_price`
                                             FROM orders_has_products AS o
                                             JOIN products AS p 
                                             ON o.product_id = p.id');

        return $result[0]['total_price'] ?? 0;
    }

    function total_customers()
    {
        $db = database_connect();
        $result = database_query($db, 'SELECT COUNT(*) as `total` FROM customers');

        return $result[0]['total'];
    }