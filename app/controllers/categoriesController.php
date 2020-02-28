<?php

/**
 *
 */
function get()
{
    // Database connection example
    $db = database_connect();
    $categories = database_query($db, "SELECT * FROM categories");

    mysqli_close($db);

    require_page('categories', [
        'categories' => $categories
    ]);
}