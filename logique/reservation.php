<?php
require_once("../admis/db.php");

if(isset($_POST['submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email_client'] ?? '');
    $tel = trim($_POST['tel_client'] ?? '');
    $id_employe = (int)($_POST['id_employe'] ?? 0);
    $date_reservation = trim($_POST['date_reservation'] ?? '');
    $heure_reservation = trim($_POST['heure_reservation_time'] ?? '');
    $photo_style = trim($_POST['photo_style'] ?? '');

    if ($nom === '' || $email === '' || $tel === '' || $id_employe <= 0 || $date_reservation === '' || $heure_reservation === '') {
        http_response_code(400);
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    $sql = "INSERT INTO reservations (nom, email_client, tel_client, id_employe, date_reservation, heure_reservation, photo_style)
            VALUES (:nom, :email_client, :tel_client, :id_employe, :date_reservation, :heure_reservation, :photo_style)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':email_client' => $email,
        ':tel_client' => $tel,
        ':id_employe' => $id_employe,
        ':date_reservation' => $date_reservation,
        ':heure_reservation' => $heure_reservation,
        ':photo_style' => $photo_style,
    ]);

    echo "Réservation effectuée avec succès !";

}
