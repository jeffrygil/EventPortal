<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de incluir PHPMailer

$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '@gmail.com'; //  Gmail
    $mail->Password = ''; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinatario y contenido
    $mail->setFrom('email@gmail.com', ' Nombre');
    $mail->addAddress('@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Mensaje de Contacto';
    $mail->Body    = 'Este es el mensaje de contacto.';

    $mail->send();
    echo 'Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
}
?>
