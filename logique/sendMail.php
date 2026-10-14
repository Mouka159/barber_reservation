<?php
 require('../admis/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assure-toi que PHPMailer est installé via Composer

// Variables récupérées depuis ta réservation
$nom_user = "Jean Dupont";
$email_user = "client@example.com";
$date_reservation = "2026-10-15";
$heure_reservation = "14:30";
$id_reservation = 123; // ID en base
$fileQR = "../img/qrcode_20261013.png"; // QR code généré
$photo_style = "../img/style_20261013.png"; // Image uploadée

$mail = new PHPMailer(true);

try {
    // Paramètres SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'moukailatovo9@gmail.com'; // ton email
    $mail->Password   = 'mtxydetytmroepfg ';     // mot de passe ou App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Expéditeur et destinataire
    $mail->setFrom('moukailatovo9@gmail.com', 'Barber & Coiffeuse');
    $mail->addAddress($email_user, $nom_user);

    // Contenu du mail
    $mail->isHTML(true);
    $mail->Subject = 'Confirmation de réservation - Barber & Coiffeuse';
    $mail->Body    = "
        <h2>Bonjour $nom_user</h2>
        <p>Votre réservation du <strong>$date_reservation</strong> à <strong>$heure_reservation</strong> est confirmée.</p>
        <p>Veuillez présenter ce QR code lors de votre rendez-vous :</p>
        <img src='cid:qrcode'>
        <p>Style choisi :</p>
        <img src='cid:style' style='width:200px;'>
        <p>Vous pouvez aussi consulter votre ticket en ligne :</p>
        <a href='https://tonsite.com/ticket.php?id=$id_reservation'>Voir mon ticket</a>
        <br><br>
        <p>À bientôt,<br>L’équipe Barber & Coiffeuse</p>
    ";

    // Attacher QR code et image de style
    $mail->addEmbeddedImage($fileQR, 'qrcode');
    $mail->addEmbeddedImage($photo_style, 'style');

    // Envoi
    $mail->send();
    echo "Email envoyé avec succès.";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
}
?>
