<?php
    function get()
    {
        require_page('contact');
    }
    
    function send_mail()
    {
        if(!empty($_POST)){
            $emailFrom = $_POST["emailadres"];
            $emailTo = APP['content_email'];
            $name = $_POST["naam"];
            $subject = $_POST["subject"];
            $melding = $_POST["melding"];
            $header = "From: ".$emailFrom;
            $txt = "U heeft een email van ".$name.".\n\n".$melding;
            $smtp = "X-MAILER: PHP/versie " .phpversion();
            ini_set("SMTP","SMTP-server.nl");
            ini_set("smtp_port","25");
            ini_set("sendmail_from","webmaster@panoramix.com");

            $mailen = mail($emailTo, $subject, $txt, $header, $smtp);

            if(!$mailen){
                alert("error","Er is een fout opgetreden bij het verzenden van uw email");
            } else{
                alert("succes","Uw email is verzonden");
            }
        }
        
        return route_link('/contact');
    }