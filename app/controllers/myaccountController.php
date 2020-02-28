<?php

function get ()
{
    if (!isset($_SESSION['user']))
        return route_link('/login');

    $db = database_connect();

    $result = database_query($db, 'SELECT c.first_name, c.last_name, c.email, c.phonenumber, c.gender, a.streetname, 
                                                    a.zipcode, a.house_number, a.city, a.country
                                             FROM customers c
                                             JOIN addresses a
                                             ON c.address_id = a.id
                                             WHERE c.id = '. $_SESSION['user']['id']);

    if (count($result) == 0) {
        unset($_SESSION['user']);
        return route_link('/login');
    }

    $customer = $result[0];

    require_page('myaccount', [
        "customer" => $customer,
    ]);
}

function update()
{
    $db = database_connect();

    $request = _validation();

    if ($request === false)
        return route_link('/my-account');

    extract($request);

    $first_name = database_escape($db, $first_name);
    $last_name = database_escape($db, $last_name);
    $email = database_escape($db, $email);
    $phone_number = database_escape($db, $phone_number);
    $gender = database_escape($db, $gender);
    $password = database_escape($db, $password);

    $street_name = database_escape($db, $street_name);
    $house_number = database_escape($db, $house_number);
    $zip_code = database_escape($db, $zipcode);
    $city = database_escape($db, $city);
    $country = database_escape($db, $country);

    $address = database_query($db, "SELECT id FROM addresses WHERE streetname = '{$street_name}' AND zipcode = '{$zip_code}' 
      AND house_number = '{$house_number}' AND city = '{$city}' AND country = '{$country}'")[0]['id'];

    if (count($address) == 0) {
        mysqli_query($db, "INSERT INTO addresses VALUES(NULL, '{$zip_code}', '{$house_number}', '{$street_name}', '{$city}', '{$country}')");
        $address = mysqli_insert_id($db);
    }

    if ($password == null)
        $password_query = '';
    else
        $password_query = "`password` = '{$password}',";

    $result = mysqli_query($db, "UPDATE customers SET `first_name` = '{$first_name}', `last_name` = '{$last_name}', `email` = '{$email}',
      `phonenumber` = '{$phone_number}', {$password_query} `gender` = '{$gender}', `address_id` = {$address} WHERE id = {$_SESSION['user']['id']}");

    if (!$result)
        alert('error', 'Oops! Er is iets mis gegaan tijdens het wijzigen van uw gegevens.');
    else
        alert('succes', 'Uw gegevens zijn succesvol gewijzigd.');

    return route_link('/my-account');
}

function _validation($isUpdate = false)
{
    if(empty($_POST)) {
        return [];
    }

    $request = array(
        'first_name'    => $_POST['first_name'] ?? null,
        'last_name'     => $_POST['last_name'] ?? null,
        'email'         => $_POST['email'] ?? null,
        'phone_number'  => $_POST['phone_number'] ?? null,
        'gender'        => $_POST['gender'] ?? null,
        'password'      => $_POST['password'] ?? null,

        'street_name'   => $_POST['street_name'] ?? null,
        'zipcode'       => $_POST['zipcode'] ?? null,
        'house_number'  => $_POST['house_number'] ?? null,
        'city'          => $_POST['city'] ?? null,
        'country'       => $_POST['country'] ?? null,
    );

    $rules = [
        'first_name'    => 'name|max:255',
        'last_name'     => 'name|max:255',
        'email'         => 'email|max:255',
        'phone_number'  => 'tel',
        'gender'        => 'in_array:Male,Female',
        'password'      => 'string|min:8|nullable',

        'street_name'   => 'name|max:255',
        'zipcode'       => 'basic_string|max:15|nullable',
        'house_number'  => 'basic_string|max:10',
        'city'          => 'name|max:255',
        'country'       => 'name|size:2',
    ];

    return validate($request, $rules);
}