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
    <img src="../img/logo.png" alt="Success" width="50" height="50">
    <h1>Bonjour<?= htmlspecialchars($nom_client); ?></h1>
    <p>Merci d’avoir réservé chez nous. Votre demande a bien été enregistrée.</p>
     <?= htmlspecialchars($date_reservation); ?> est confirmée.</p>
    <a href="acceuil.php" class="btn">Retour à l’accueil</a>
  </div> 
</body>
</html>
