<?php
 require('../admis/db.php');
 require('../logique/reservation.php');

require_once('../PHPMailer/src/Exception.php');
require_once('../PHPMailer/src/PHPMailer.php');
require_once('../PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//creer l instance phpmailer 
$mail = new PHPMailer(true);

try {
    // Récupération des données de réservation
    $nom_user = $_POST['nom_user'] ?? '';
    $email_user = $_POST['email_user'] ?? '';
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
        <h2>Bonjour $nom_user,</h2><br>
         <p>Votre réservation a été confirmée.</p><br>
         <p>Présentez le QR Code ci-dessous lors de votre arrivée au salon.</p><br>
         <p>Voici le QR Code ici :</p><br>
         <p>cid:qrcode</p>
        <p>Merci de votre confiance.</p>
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
