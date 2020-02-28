<?php
function overview()
{
    $db = database_connect();
    
    $sql = "SELECT `id`, `name` FROM categories";
    
    if(isset($_GET['query'])) {
        $query = database_escape($db, $_GET['query']);
        $sql .= " WHERE name LIKE '%{$query}%' OR id = " . (int) $query . " OR id = " . sprintf('%03d', $query);
    }
    
    $categories = database_paginate($db, $sql, $_GET['page'] ?? 1);
    
    mysqli_close($db);
    
    require_page('admin.categories.overview', [
        'categories' => $categories['result'],
        'pageCount' => $categories['pageCount']
    ]);
}

function create()
{
    require_page('admin.categories.create');
}

function store()
{
    $db = database_connect();
    
    $request = _validation();
    
    if($request === false)
        return route_link('/admin/categories/create');
    
    extract($request);
    
    // Escape all variables
    $name = database_escape($db, $name);
    
    // Insert product into products table
    $result = mysqli_query($db, "INSERT INTO `categories` (name) VALUES ('{$name}')");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het toevoegen van de categorie');
        return route_link('/admin/categories/create');
    }
    
    alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/categories');
}

function edit()
{
    $db = database_connect();
    
    $id = database_escape($db, $_GET['id']);
    
    $category = database_query($db, "SELECT `id`, `name` FROM categories WHERE id=$id");
    
    // If no rows are returned
    if(!isset($category[0]))
        return route_link('/admin/categories');
    
    mysqli_close($db);
    
    require_page('admin.categories.edit', [
        'category' => $category[0]
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
    
    $result = mysqli_query($db, "UPDATE `categories` SET `name` = '{$name}' WHERE `id` = $id");
    
    if(!$result) {
        alert('error','Oeps er ging iets mis tijdens het bewerken van de categorie');
        return previous_url();
    }
    
    alert('success','Uw wijzingen zijn succesvol opgeslagen');
    
    mysqli_close($db);
    
    return route_link('/admin/categories');
}

function delete()
{
    $db = database_connect();
    
    $id = database_escape($db, $_POST['id']);
    
    $result = mysqli_query($db, "DELETE FROM categories WHERE id=$id");
    
    if($result)
        alert('success','De categorie is succesvol verwijderd');
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