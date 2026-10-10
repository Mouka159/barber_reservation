<?php
session_start();

$confirmation = $_SESSION['reservation_confirmation'] ?? null;
unset($_SESSION['reservation_confirmation']);

if ($confirmation === null) {
    header("Location: reservation.php");
    exit();
}

$nom_user = $confirmation['nom_user'];
$date_reservation = $confirmation['date_reservation'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réservation </title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      text-align: center;
      padding: 50px;
    }
    .success-box {
      background: #fff;
      border: 2px solid #4CAF50;
      border-radius: 8px;
      padding: 30px;
      display: inline-block;
    }
    .success-box h1 {
      color: #4CAF50;
    }
    .success-box p {
      font-size: 18px;
      margin: 15px 0;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <img src="../img/logo.png" alt="Success" width="120" height="99" style="margin-left: -20px;">
    <div class="confirmation">
      <span>Barber & Coiffeuse</span>
          <h1>Bonjour <?= htmlspecialchars($nom_user, ENT_QUOTES, 'UTF-8'); ?></h1>
          <p>Merci d’avoir réservé chez nous. Votre demande a bien été enregistrée.</p>
          <p>Votre réservation du <?= htmlspecialchars($date_reservation, ENT_QUOTES, 'UTF-8'); ?> à <?= htmlspecialchars($heure_reservation, ENT_QUOTES, 'UTF-8'); ?> est confirmée.</p>
         <p>📧 Veuillez vérifier votre email : vous y trouverez les détails de la réservation ainsi que votre ticket.</p>
         <a href="acceuil.php" class="btn">Retour à l’accueil</a>
  </div>
  </div>
</body>
</html>
