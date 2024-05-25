<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../config/config.php';

require '../vendor/autoload.php';

function sanitizeInputs($input): string
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

if (isset($_POST['send_email'])) {
    $name = sanitizeInputs($_POST['name_contact']);
    $email = sanitizeInputs($_POST['email_contact']);
    $message = sanitizeInputs($_POST['texte_contact']);
    $errors = [];

    if(empty($name)){
        $name = "Inconnu";
    }
    if(empty($email)){
        $errors[] = "Email vide";
    }
    if(empty($message)){
        $errors[] = "Message vide";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email non valide";
    }

    if(!empty($errors)){
        $_SESSION['error_message'] = "<p class='text-danger text-center'>Les informations entrées sont incorrectes, veuillez réessayer.</p>";
    } else {
        $subject = "Nouvelle demande de contact";

        $new_mail = new PHPMailer(true);

        try {
            $new_mail->isSMTP();
            $new_mail->SMTPAuth = true;
            $new_mail->Host = MAILHOST;
            $new_mail->Port = '587';
            $new_mail->Username = USERNAME;
            $new_mail->Password = PASSWORD;
            $new_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $new_mail->setFrom($email);
            $new_mail->addAddress(USERNAME, 'Mecamot');
            $new_mail->isHTML(true);

            $new_mail->Subject = $subject;
            $new_mail->Body = "<p>Nom : {$name}</p><p>Email : {$email}</p><p>Message : {$message}</p>";
            $new_mail->CharSet = 'UTF-8';
            $new_mail->Encoding = 'base64';

            $new_mail->send();

            $_SESSION['error_message'] = "<p class='text-success text-center'>Merci de nous avoir contactés !</p>";
        } catch (\Exception $e){
            $_SESSION['error_message'] = "<p class='text-danger text-center'>Oups, quelque chose ne s'est pas déroulé correctement, réessayez plus tard</p>";
        }
    }
    header("location:index.html");
} else {
    header("location:index.html");
}