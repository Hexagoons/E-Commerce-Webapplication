<?php

/*
|--------------------------------------------------------------------------
| Register Routes
|--------------------------------------------------------------------------
|
| This is where you can register routes for this application. These routes are used by
| the public/index.php file to handle requests. The array needs to be structured as follows:
|
| [ Request Method => [ Route => Controller@Function ]
|
*/
return [
    "GET" => [
        "/" => "homeController@get",
        "/categories" => "categoriesController@get",
        "/login" => "auth.loginController@get",
        "/logout" => "auth.loginController@logout",
		"/passreset" => "auth.loginController@passreset",
        "/register" => "auth.registrationController@get",
        "/my-account" => "myaccountController@get",
        "/products" => "productsController@overview",
        "/products/show" => "productsController@show",
        "/about" => "aboutController@get",
        "/contact" => "contactController@get",
        "/shoppingcart" => "shoppingcartController@overview",
        "/order" => "ordersController@overview",
        
        // Admin
        "/admin" => "admin.dashboardController@overview",
        "/admin/customers/edit" => "admin.customersController@edit",
        "/admin/orders" => "admin.ordersController@overview",
        "/admin/orders/show" => "admin.ordersController@show",
        "/admin/products" => "admin.productsController@overview",
        "/admin/products/create" => "admin.productsController@create",
        "/admin/products/edit" => "admin.productsController@edit",
        "/admin/categories" => "admin.categoriesController@overview",
        "/admin/categories/create" => "admin.categoriesController@create",
        "/admin/categories/edit" => "admin.categoriesController@edit",
        "/admin/brands" => "admin.brandsController@overview",
        "/admin/brands/create" => "admin.brandsController@create",
        "/admin/brands/edit" => "admin.brandsController@edit",
        "/shoppingcart/delete" => "shoppingcartController@delete"
    ],
    "POST" => [
        "/login" => "auth.loginController@submit",
		"/passreset" => "auth.loginController@passreset_submit",
        "/register" => "auth.registrationController@register",
        "/my-account" => "myaccountController@update",
        "/shoppingcart" => "shoppingcartController@add",
        "/contact" => "contactController@send_mail",
        "/order" => "ordersController@store",
        "/admin/customer/edit" => "admin.customersController@update",
        "/admin/orders/update" => "admin.ordersController@update",
        "/admin/products/create" => "admin.productsController@store",
        "/admin/products/edit" => "admin.productsController@update",
        "/admin/products/delete" => "admin.productsController@delete",
        "/admin/categories/create" => "admin.categoriesController@store",
        "/admin/categories/edit" => "admin.categoriesController@update",
        "/admin/categories/delete" => "admin.categoriesController@delete",
        "/admin/brands/create" => "admin.brandsController@store",
        "/admin/brands/edit" => "admin.brandsController@update",
        "/admin/brands/delete" => "admin.brandsController@delete"
    ]
];