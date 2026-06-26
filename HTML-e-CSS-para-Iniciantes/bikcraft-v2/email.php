<?php

/* Carregando Variáveis de Ambiente */
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $_ENV[$k] = $v;
    }
}

/* Configurações do Servidor SMTP  */
$host = $_ENV['SMTP_HOST'] ?? '';
$port = (int)($_ENV['SMTP_PORT'] ?? 587);
$user = $_ENV['SMTP_USER'] ?? '';
$pass = $_ENV['SMTP_PASS'] ?? '';
$from = $_ENV['SMTP_FROM'] ?? '';

/* Corpo da Mensagem do Email */
$body = "";

foreach ($_POST as $label => $value) {
    $body .= filter_var($label, FILTER_SANITIZE_STRING) . ": " . filter_var($value, FILTER_SANITIZE_STRING) . "<br>";
}

$email_contato = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$email_valid = filter_var($email_contato, FILTER_SANITIZE_EMAIL);

if (!$email_valid) {
    throw new Exception("Email inválido");
}

/* Configurações do PHPMailer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;              //Enable verbose debug output
    $mail->isSMTP();                                    //Send using SMTP
    $mail->Host       = $host;                          //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                           //Enable SMTP authentication
    $mail->Username   = $user;                          //SMTP username
    $mail->Password   = $pass;                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption;
    $mail->Port       = $port;                          //TCP port to connect to
    $mail->CharSet    = "utf-8";

    //Recipients
    $mail->setFrom($from, 'Bikcraft');
    $mail->addAddress($from, 'Bikcraft');
    $mail->addReplyTo($email_contato);

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Formulário de Contato';
    $mail->Body    = $body;

    $mail->send();

    $link = "http://$_SERVER[HTTP_HOST]";
    header("Location: " . $link . "?status=ok");
    exit;
} catch (Exception $e) {
    header("Location: index.html?status=erro");
    exit;
}
