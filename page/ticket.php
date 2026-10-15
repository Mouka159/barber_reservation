
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ticket de réservation</title>
</head>
<body>
 
        <h1> Ticket de réservation</h1>
         
        <p><strong>Code :</strong> RES-<?= $reservation['id_reservation']; ?></p>
         
        <p><strong>Nom du client :</strong>
        <?= htmlspecialchars($reservation['nom_user']); ?>
        </p>
         
        <p><strong>Service :</strong>
        <?= htmlspecialchars($reservation['nom_service']); ?>
        </p>
         
        <p><strong>Email :</strong>
        <?= htmlspecialchars($reservation['email_user']); ?>
        </p>
         
        <p><strong>Téléphone :</strong>
        <?= htmlspecialchars($reservation['telephone']); ?>
        </p>
         
        <p><strong>Barbier :</strong>
        <?= htmlspecialchars($reservation['nom_employe']); ?>
        </p>
         
        <p>
            <strong>Date :</strong>
        <?= htmlspecialchars($reservation['date_rdv']); ?>
        </p>
 
        <p>
            <strong>Heure :</strong>
            <?= htmlspecialchars($reservation['heure_rdv']); ?>
        </p>
             
        <h3>Coupe choisie</h3>
             
            <?= htmlspecialchars($reservation['photo_style']); ?> width="250"
            alt="Style choisi">
             
            <p style="color:green;">
             Réservation confirmée
            </p>
 
</body>
</html>

│
