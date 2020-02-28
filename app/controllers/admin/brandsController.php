<?php
function overview()
{
    $db = database_connect();
    
    $sql = "SELECT `id`, `name` FROM brands";
    
    if(isset($_GET['query'])) {
        $query = database_escape($db, $_GET['query']);
        $sql .= " WHERE name LIKE '%{$query}%' OR id = " . (int) $query . " OR id = " . sprintf('%03d', $query);
    }
    
    $brands = database_paginate($db, $sql, $_GET['page'] ?? 1);
    
    mysqli_close($db);
    
    require_page('admin.brands.overview', [
        'brands' => $brands['result'],
        'pageCount' => $brands['pageCount']
    ]);
}

function create()
{
    require_page('admin.brands.create');
}

function store()
{
    $db = database_connect();
    
    $request = _validation();
    
    if($request === false)
        return route_link('/admin/brands/create');
    
    extract($request);
    
    // Escape all variables
    $name = database_escape($db, $name);
    
    // Insert product into products table
    $result = mysqli_query($db, "INSERT INTO `brands` (name) VALUES ('{$name}')");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het toevoegen van het merk');
        return route_link('/admin/brands/create');
    }
    
    alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/brands');
}

function edit()
{
    $db = database_connect();
    
    $id = database_escape($db, $_GET['id']);
    
    $brand = database_query($db, "SELECT `id`, `name` FROM brands WHERE id=$id");
    
    // If no rows are returned
    if(!isset($brand[0]))
        return route_link('/admin/brands');
    
    mysqli_close($db);
    
    require_page('admin.brands.edit', [
        'brand' => $brand[0]
    ]);
}

function update()
{
    $db = database_connect();
    
    $request = _validation(true);
    
    if($request === false)
        return previous_url();
    
    extract($request);
    
    $id   = database_escape($db, $id);
    $name = database_escape($db, $name);
    
    $result = mysqli_query($db, "UPDATE `brands` SET `name` = '{$name}' WHERE `id` = $id");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het bewerken van dit merk');
        return previous_url();
    }
    
    alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/brands');
}

function delete()
{
    $db = database_connect();
    
    $id = database_escape($db, $_POST['id']);
    
    $result = mysqli_query($db, "DELETE FROM brands WHERE id=$id");
    
    if($result)
        alert('success','Het merk is succesvol verwijderd');
    else
        alert('error','Oeps er ging iets mis tijdens het verwijderen');
    
    mysqli_close($db);
    
    return previous_url();
}

function _validation($isUpdate = false)
{
    if(empty($_POST)) {
        alert('error', 'Onjuiste gegevens verstuurd.');
        return [];
    }
    
    $request = array(
        'name' => $_POST[ 'name' ] ?? null,
        'id' => $_POST['id'] ?? null,
    );
    
    $rules = ['name' => 'string|min:1|max:45'];
    
    if($isUpdate) $rules['id'] = 'numeric';
    
    return validate($request, $rules);
}