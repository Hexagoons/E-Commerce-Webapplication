<?php

function get()
{
    require_page('login');
}

function submit()
{
    // Validation
    if(empty($_POST)) {
        alert('error', 'Onjuiste gegevens verstuurd.');
        return route_link('/login');
    }
    
    $request = validate(
        array(
            'email'    => $_POST[ 'email' ] ?? null,
            'password' => $_POST[ 'password' ] ?? null,
        ),
        array(
            'email'    => 'string|max:255|min:1|email',
            'password' => 'string',
        )
    );
    
    if($request === false)
        return route_link('/login');
    
    extract($request);

    // Database
	$db = database_connect();

	$email = database_escape($db, $email);
	$pw    = database_escape($db, $password);

	$query  = "SELECT id, concat(first_name, ' ', last_name) as `full_name`, role FROM customers WHERE email = '$email' AND password = '$pw';";
	$result = database_query($db, $query);

	if(count($result) == 0) {
		alert('error', 'Onjuiste combinatie van e-mail en wachtwoord.');
		return route_link('/login');
	}

	$customer = $result[0];

	// Session
	$_SESSION["user"] = [];
	$_SESSION["user"]["id"]   = $customer['id'];
    $_SESSION["user"]["name"] = $customer['full_name'];
	$role = $_SESSION["user"]["role"] = $customer['role'];

	// Redirect to dashboard or homepage
	if($role == 'Admin') {
		return route_link('/admin');
	}
    
    return route_link('/');
}

function passreset()
{
	require_page('passwordreset');
}

function passreset_submit(){
    // Validation
    if(empty($_POST)) {
        alert('error', 'Onjuiste gegevens verstuurd.');
        return route_link('/login');
    }
    
    $request = validate(
        array('email' => $_POST[ 'email' ] ?? null,),
        array('email' => 'string|max:255|min:1|email',)
    );
    
    if($request === false)
        return route_link('/passreset');
    
    extract($request);
    
	$db = database_connect();
	
	$email = database_escape($db, $email);

	$result = database_query($db, "SELECT concat(first_name, ' ', last_name) as `full_name` , email, password FROM customers WHERE email='{$email}'");

	if(count($result) === 0) {
	    // Prevent hackers to know which email addresses are registered
        alert('success', "Indien het e-mailadres bij ons bekend is, wordt het wachtwoord hiernaartoe verzonden.");
	    return route_link('/passreset');
    }

	if (!password_reset_email($result[0]))
	    alert('error', "Er is helaas een fout opgetreden bij het verzenden van uw wachtwoord, probeer het aub opnieuw.");
	else
	    alert('success', "Indien het e-mailadres bij ons bekend is, wordt het wachtwoord hiernaartoe verzonden.");

	return route_link('/passreset');
}

function logout()
{
    unset($_SESSION['user']);
    
    alert('success', "U bent successvol uitgelogd.");
    
    return route_link('/login');
}