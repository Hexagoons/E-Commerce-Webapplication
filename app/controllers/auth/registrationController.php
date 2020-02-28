<?php
function get()
{
    require_page('register');
}

function register()
{
    // Validation
    if(empty($_POST)) {
        alert('error', 'Onjuiste gegevens verstuurd.');
        return route_link('/register');
    }
    
    $request = validate(
        array(
            'first_name'   => $_POST[ 'first_name' ] ?? null,
            'last_name'    => $_POST[ 'last_name' ] ?? null,
            'password'     => $_POST[ 'password' ] ?? null,
            'telephone'    => $_POST[ 'telephone' ] ?? null,
            'gender'       => $_POST[ 'gender' ] ?? null,
            'email'        => $_POST[ 'email' ] ?? null,
            'street'       => $_POST[ 'street' ] ?? null,
            'house_number' => $_POST[ 'house_number' ] ?? null,
            'city'         => $_POST[ 'city' ] ?? null,
            'zipcode'      => $_POST[ 'zipcode' ] ?? null
        ),
        array(
            'first_name'   => 'name|min:1|max:45',
            'last_name'    => 'name|min:1|max:45',
            'password'     => 'string|min:8|max:20',
            'telephone'    => 'numeric|tel',
            'gender'       => 'in_array:Male,Female',
            'email'        => 'string|email',
            'street'       => 'name|string|min:1|max:255',
            'house_number' => 'basic_string|min:1|max:10',
            'city'         => 'name|min:1|max:255',
            'zipcode'      => 'basic_string|min:4|max:6'
        )
    );
    
    if($request === false)
        return route_link('/register');
    
    // Check passwords
    if($_POST[ 'password' ] !== $_POST[ 'cpassword' ]) {
        alert('error', 'Uw opgegeven wachtwoorden zijn niet gelijk');
        return route_link('/register');
    }
    
    extract($request);
    
    // Database
    $db = database_connect();
    
    $first_name   = database_escape($db, $first_name);
    $last_name    = database_escape($db, $last_name);
    $password     = database_escape($db, $password);
    $telephone    = database_escape($db, $telephone);
    $gender       = database_escape($db, $gender);
    $email        = database_escape($db, $email);
    $street       = database_escape($db, $street);
    $house_number = database_escape($db, $house_number);
    $city         = database_escape($db, $city);
    $zipcode      = database_escape($db, $zipcode);
    
    if(!is_unique_email($db, $email)) {
        alert("error", "Sorry, dit e-mailadres is al ingebruik");
        
        return route_link('/register');
    }
    
    $result = mysqli_query($db,"INSERT INTO addresses (zipcode, house_number, streetname, city, country)
                                       VALUES (REPLACE('{$zipcode}', ' ', ''), '{$house_number}', '{$street}', '{$city}', 'NL' ) ");
    
    if(!$result) {
        alert('error', 'Oeps, er ging iets mis tijdens het registeren van uw account');
        return route_link('/register');
    }
    
    $address_id = mysqli_insert_id($db);
    
    $result = mysqli_query($db,"INSERT INTO customers (gender, first_name, last_name, email, phonenumber, password, role, address_id)
                                       VALUES ('{$gender}', '{$first_name}', '{$last_name}', '{$email}', REPLACE('{$telephone}', ' ', ''), '{$password}', 'Guest', {$address_id})");
    
    if(!$result) {
        alert('error', 'Oeps, er ging iets mis tijdens het registeren van uw account');
        return route_link('/register');
    }

    alert("success", "U account is succesvol geregisteerd");
    
    return route_link('/register');
}
