<?php

/**
 * @param $receiver
 * @param $subject
 * @param $content
 *
 * @return bool
 */
function email($receiver, $subject, $content)
{
    ini_set("SMTP", APP[ "smtp" ]);
    ini_set("smtp_port", APP[ "smtp_port" ]);
    ini_set("sendmail_from", APP[ "email" ]);
    
    return mail($receiver, $subject, $content, [
        'From'     => 'no-reply@sportshop.nl',
        'X-Mailer' => 'PHP/'.phpversion()
    ]);
}

/**
 * @param $customer
 *
 * @return bool
 */
function password_reset_email($customer)
{
    $msg = "U heeft uw wachtwoord opgevraagd bij Sportshop.nl. \n\n";
    $msg .= "Uw emailadres voor inloggen is: ".$customer[ 'full_name' ];
    $msg .= "\nUw wachtwoord is: ".$customer[ 'password' ];
    $msg .= "\n\nMet vriendelijke groet,\n\nDe Webmaster-Sportshop.nl";
    $msg .= "\n\n--Dit is een automatisch gegenereerd bericht, antwoorden hierop is helaas niet mogelijk--";
    
    return email($customer[ 'email' ], "Wachtwoord vergeten | SportShop.nl", $msg);
}