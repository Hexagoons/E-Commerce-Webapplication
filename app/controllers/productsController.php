<?php
    function overview() {
        $db = database_connect();

        $brands = database_query($db, 'SELECT name, id FROM brands ORDER BY name');
        $categories = database_query($db, 'SELECT name, id FROM categories ORDER BY name');
        
        $sql = "SELECT DISTINCT p.id, p.name, p.price, (SELECT hash FROM product_images WHERE product_id = p.id LIMIT 1) as `hash` FROM products as `p`
                       JOIN product_images as `pi` ON p.id=pi.product_id WHERE 1 = 1";

        if (isset($_GET['categories']) && is_array($_GET['categories']) && !empty($_GET['categories'])){
            $categoryIds = implode(',', $_GET['categories']);
            $categoryIds = database_escape($db, $categoryIds);
    
            $sql .= " AND p.category_id IN ($categoryIds)";
        }
        if ( trim($_GET['min'] ?? '') !== '' && trim($_GET['max'] ?? '') == '' ){
            $min = database_escape($db, $_GET['min']);
            $sql .= " AND p.price >= $min";
        }
        if ( trim($_GET['min'] ?? '') == '' && trim($_GET['max'] ?? '') !== '' ){
            $max = database_escape($db, $_GET['max']);
            $sql .= " AND p.price <= $max";
        }
        if (trim($_GET['min'] ?? '') !== '' && trim($_GET['max'] ?? '') !== ''){
            $min = database_escape($db, $_GET['min']);
            $max = database_escape($db, $_GET['max']);
            $sql .= " AND p.price BETWEEN $min AND $max";
        }
        if (isset($_GET['query']) && !empty($_GET['query'])){
            $query = database_escape($db, $_GET['query']);
            $sql .= " AND (p.name LIKE '%{$query}%' OR p.ean LIKE '%".sprintf("%013d", $query)."%')";
        }
        if(isset($_GET['brands']) && is_array($_GET['brands']) && !empty($_GET['brands'])) {
            $brandIds = implode(',', $_GET['brands']);
            $brandIds = database_escape($db, $brandIds);

            $sql .= " AND p.brand_id IN ($brandIds)";
        }
        
        $sql .= ' ORDER BY p.name';
        
        $products = database_paginate($db, $sql, $_GET['page'] ?? 1);
        mysqli_close($db);

        require_page('products', [
            'products' => $products['result'],
            'pageCount' => $products['pageCount'],
            'rijTel' => $brands,
            'rijNaam' => $categories
        ]);
    }

    function show() {
        if(!isset($_GET['id'])) {
            return route_link('/products');
        }

        $db = database_connect();
        $id = database_escape($db, $_GET['id']);
        $product = database_query($db, "SELECT p.id, p.name, p.description, p.ean, p.price, p.tax_rate,
                                                 c.id AS `category_id`, c.name AS `category`,
                                                 b.id AS `brand_id`, b.name AS `brand`
                                          FROM products AS p
                                             JOIN categories AS c ON p.`category_id` = c.`id`
                                             JOIN brands AS b ON p.`brand_id` = b.`id`
                                          WHERE p.id=$id");

        if(empty($product)) {
            return route_link('/products');
        }

        $product = $product[0];

        $productImages = database_query($db, "SELECT * FROM product_images WHERE product_id=". $product['id']);
        $specs = database_query($db, "SELECT * FROM product_characteristics WHERE product_id=". $product['id']);

        require_page('product', [
            'product' => $product,
            'specs' => $specs,
            'productImages' => $productImages
        ]);
    }