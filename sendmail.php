<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
//
////Load Composer's autoloader
//require 'vendor/autoload.php';

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$companyName = $_POST['companyName'];
$email = $_POST['email'];
$website = $_POST['website'];
$region = $_POST['region'];
$tvp = $_POST['tvp'];
$solution = implode(', ',$_POST['solution']);
$agree = $_POST['agree'];

$text = $firstName."|". $lastName."|". $companyName."|". $email."|". $website."|". $region."|". $tvp."|". $solution."|". $agree;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '9483af2c027b59';
    $mail->Password = 'd5cad516f902fa';
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('no-reply@quatroventos.com.br', $name);
    $mail->addAddress('contato@quatroventos.com.br', 'Quatro Ventos');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Novo lead cadastrado no site';
    $mail->Body = '<h1>Um novo cadastro foi feito no site</h1>';
    $mail->Body .= '<strong>Nome:</strong> '.$firstName."<br>";
    $mail->Body .= '<strong>Sobrenome:</strong> '.$lastName."<br>";
    $mail->Body .= '<strong>Email:</strong> '.$email."<br>";
    $mail->Body .= '<strong>Empresa:</strong> '.$companyName."<br>";
    $mail->Body .= '<strong>Site:</strong> '.$website."<br>";
    $mail->Body .= '<strong>Região:</strong> '.$region."<br>";
    $mail->Body .= '<strong>TVP:</strong> '.$tvp."<br>";
    $mail->Body .= '<strong>Solução:</strong> '.$solution."<br>";
    $mail->Body .= '<strong>Aceitou os termos?</strong> '.$agree."<br>";

    $mail->AltBody    = '';

    $mail->send();
    file_put_contents("leads.txt", $text."\n", FILE_APPEND | LOCK_EX);

    header("Location: obrigado.php");
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
