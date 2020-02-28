<?php

function overview()
{
    $db = database_connect();
    
    $sql = "SELECT p.id, p.name, p.ean, p.price, p.tax_rate,
                   c.id AS `category_id`, c.name AS `category`,
                   b.id AS `brand_id`, b.name AS `brand`
            FROM products AS p
                   JOIN categories AS c ON p.`category_id` = c.`id`
                   JOIN brands AS b ON p.`brand_id` = b.`id`";
    
    if(isset($_GET['query'])) {
        $query = database_escape($db, $_GET['query']);
        $sql .= " WHERE p.name LIKE '%{$query}%' OR b.name LIKE '%{$query}%' OR c.name LIKE '%{$query}%' OR p.id = " . (int) $query . " OR p.id = " . sprintf('%03d', $query);
    }
    
    $products = database_paginate($db, $sql, $_GET['page'] ?? 1);
    
    mysqli_close($db);
    
    require_page('admin.products.overview', [
        'products' => $products['result'],
        'pageCount' => $products['pageCount']
    ]);
}

function create()
{
    $db = database_connect();
    
    $categories = database_query($db, "SELECT id, name FROM categories");
    $brands     = database_query($db, "SELECT id, name FROM brands");
    
    mysqli_close($db);
    
    require_page('admin.products.create', [
        'categories' => $categories,
        'brands' => $brands
    ]);
}

function store()
{
    $db = database_connect();
    
    $request = _validation();
    
    if($request === false)
        return route_link('/admin/products/create');
    
    extract($request);
    
    // Escape all variables
    $name           = database_escape($db, $name);
    $price          = database_escape($db, floatval($price));
    $ean            = database_escape($db, $ean);
    $tax_rate       = database_escape($db, $tax_rate);
    $category       = database_escape($db, $category);
    $brand          = database_escape($db, $brand);
    $description    = database_escape($db, $description);
    $specifications = database_escape($db, $specifications);
    
    // Insert product into products table
    $result = mysqli_query($db, "INSERT INTO `products`
                                        (name, price, category_id, brand_id, description, ean, tax_rate)
                                        VALUES ('$name', $price, $category, $brand, '$description', $ean, $tax_rate)");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het toevoegen van het product');
        return route_link('/admin/products/create');
    }
    
    $id = mysqli_insert_id($db);
    
    if(!_syncSpecifications($db, $id, $specifications))
        alert('error', 'Oeps er ging iets mis tijdens het bewerken van de product specificaties');
    
    _uploadSubmittedImages($db, $id);
    
    if(!isset_alert('error'))
        alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/products');
}

function edit()
{
    $db = database_connect();
    
    $id = database_escape($db, $_GET['id']);
    
    $product = database_query($db, "SELECT p.id, p.name, p.description, p.ean, p.price, p.tax_rate,
                                                 c.id AS `category_id`, c.name AS `category`,
                                                 b.id AS `brand_id`, b.name AS `brand`
                                          FROM products AS p
                                             JOIN categories AS c ON p.`category_id` = c.`id`
                                             JOIN brands AS b ON p.`brand_id` = b.`id`
                                          WHERE p.id=$id");
    
    // If no rows are returned
    if(!isset($product[0]))
        return route_link('/admin/products');
    
    $product         = $product[0];
    $images          = database_query($db, "SELECT id, hash FROM product_images WHERE product_id=$id");
    $characteristics = database_query($db, "SELECT `attribute`, `value` FROM product_characteristics WHERE product_id=$id");
    $categories      = database_query($db, "SELECT id, name FROM categories");
    $brands          = database_query($db, "SELECT id, name FROM brands");
    
    $product['specifications'] = implode('|', array_map(function($array) {
        return $array['attribute'] . ':' . $array['value'];
    }, $characteristics));
    
    mysqli_close($db);
    
    require_page('admin.products.edit', [
        'product' => $product,
        'images' => $images,
        'characteristics' => $characteristics,
        'categories' => $categories,
        'brands' => $brands
    ]);
    
    return null;
}

function update()
{
    $db = database_connect();
    
    $request = _validation(true);
    
    if($request === false)
        return previous_url();
    
    extract($request);
    
    $id             = database_escape($db, $id);
    $name           = database_escape($db, $name);
    $price          = database_escape($db, floatval($price));
    $ean            = database_escape($db, $ean);
    $tax_rate       = database_escape($db, $tax_rate);
    $category       = database_escape($db, $category);
    $brand          = database_escape($db, $brand);
    $description    = database_escape($db, $description);
    $specifications = database_escape($db, $specifications);
    
    $result = mysqli_query($db, "UPDATE `products`
                                        SET `name` = '$name', `price` = $price, `category_id` = $category, `brand_id` = $brand, `description` = '$description', `ean` = $ean, `tax_rate` = $tax_rate
                                        WHERE `id` = $id");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het bewerken van het product');
        return previous_url();
    }
    
    if(!_syncSpecifications($db, $id, $specifications))
        alert('error', 'Oeps er ging iets mis tijdens het bewerken van de product specificaties');
        
    _uploadSubmittedImages($db, $id);
    
    if (isset($_POST['destroyImages'])) {
        if(!_deleteImages($db, database_escape($db, $_POST['destroyImages'])))
            alert('error', 'Oeps er ging iets mis tijdens het verwijderen van een of meerdere afbeeldingen');
    }
    
    if(!isset_alert('error'))
        alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/products');
}

function delete()
{
    $db = database_connect();
    
    $id = database_escape($db, $_POST['id']);
    
    // Delete product images from file system
    $productImages = database_query($db, "SELECT hash FROM product_images WHERE product_id=$id");
    foreach ($productImages as $productImage) {
         unlink(public_path() . "/img/products/{$productImage['hash']}.jpg");
    }
    
    // Delete product from database
    $result_images          = mysqli_query($db, "DELETE FROM product_images WHERE product_id=$id");
    $result_characteristics = mysqli_query($db, "DELETE FROM product_characteristics WHERE product_id=$id");
    $result                 = mysqli_query($db, "DELETE FROM products WHERE id=$id");
    
    if($result_images && $result_characteristics && $result)
        alert('success','Het product is succesvol verwijderd');
    else
        alert('error','Oeps er ging iets mis tijdens het verwijderen');
    
    mysqli_close($db);
    
    return previous_url();
}

/**
 * @param bool $isUpdate
 *
 * @return array|bool
 */
function _validation($isUpdate = false)
{
    if(empty($_POST)) {
        // PHP discarded POST data because of request exceeding post_max_size.
        alert('error', "U heeft te veel data verstuurd, dit kan veroorzakt zijn door het uploaden van een te groot bestand");
        return [];
    }
    
    $request = array(
        'name'           => $_POST[ 'name' ] ?? null,
        'price'          => $_POST[ 'price' ] ?? null,
        'ean'            => $_POST[ 'ean' ] ?? null,
        'tax_rate'       => $_POST[ 'tax_rate' ] ?? null,
        'category'       => $_POST[ 'category' ] ?? null,
        'brand'          => $_POST[ 'brand' ] ?? null,
        'description'    => $_POST[ 'description' ] ?? null,
        'specifications' => $_POST[ 'specifications' ] ?? null,

        // Only on update
        'id'            => $_POST['id'] ?? null,
        'destroyImages' => $_POST['destroyImages'] ?? null,
    );
    
    $rules = [
        'name'           => 'string|max:255|min:1',
        'price'          => 'numeric|price',
        'ean'            => 'numeric|max:13',
        'tax_rate'       => 'numeric|in_array:6,21',
        'category'       => 'numeric',
        'brand'          => 'numeric',
        'description'    => 'string|min:1',
        'specifications' => 'nullable|chips',
    ];
    
    if($isUpdate) {
        $rules['id']            = 'numeric';
        $rules['destroyImages'] = 'nullable|numeric';
    }
    
    return validate($request, $rules);
}

/**
 * @param $db
 * @param $productId
 */
function _uploadSubmittedImages($db, $productId)
{
    foreach (reorder_files_array($_FILES['images']) as $file) {
        if($file['size'] > 0) {
            // Try to upload image
            $fileHash = upload_image($file, public_path() . "/img/products");
            
            if($fileHash !== false) {
                // Add image hash to database
                mysqli_query($db, "INSERT INTO `product_images` (hash, product_id)
                                          VALUES ('$fileHash', $productId)");
            }
        }
    }
}

/**
 * @param $db
 * @param $destroyImages
 *
 * @return string
 */
function _deleteImages($db, $destroyImages)
{
    $destroyImages = implode(',', $destroyImages);
    
    // Select product images
    $productImages = database_query($db, "SELECT `hash` FROM product_images WHERE id IN ({$destroyImages})");
    
    if(empty($productImages))
        return false;
    
    // Delete from database
    if (!mysqli_query($db, "DELETE FROM product_images WHERE id IN ({$destroyImages})"))
        return false;
    
    // Delete file from file system
    foreach ($productImages as $productImage) {
        $file = public_path()."/img/products/{$productImage['hash']}.jpg";
        
        if (is_file($file)) unlink($file);
    }
    
    return true;
}

/**
 * @param $db
 * @param $id
 * @param $characteristics
 *
 * @return bool
 */
function _syncSpecifications($db, $id, $characteristics)
{
    if(is_null($characteristics))
        return true;
    
    // Delete all characteristics
    if (!mysqli_query($db, "DELETE FROM product_characteristics WHERE product_id = $id"))
        return false;
    
    // Insert all characteristics
    $characteristics = str_getcsv($characteristics, '|');
    
    foreach ($characteristics as $characteristic) {
        $characteristic = explode(':', $characteristic);
        $sql = "INSERT INTO product_characteristics (product_id, attribute, value)
                VALUES ({$id}, '{$characteristic[0]}', '{$characteristic[1]}')";
        
        if(!mysqli_query($db, $sql))
            return false;
    }
    
    return true;
}