<?php
require_once("../admis/db.php");

if(isset($_POST['submit'])) {
    $nom = trim($_POST['nom_client'] ?? '');
    $email = trim($_POST['email_client'] ?? '');
    $tel = trim($_POST['tel_client'] ?? '');
    $date_reservation = trim($_POST['date_reservation'] ?? '');
    $heure_reservation = trim($_POST['heure_reservation_time'] ?? '');
    $photo_style = trim($_FILES['photo_style']['name'] ?? '');

    if(empty($nom) || empty($email) || empty($tel) || empty($id_employe) || empty($date_reservation) || empty($heure_reservation)) {
        die("Tous les champs sont obligatoires.");
    }

    $sql = "INSERT INTO reservations (nom_client,id_service, email_client, tel_client, id_employe, date_reservation, heure_reservation, photo_style)
            VALUES (:nom_client, :id_service, :email_client, :tel_client, :id_employe, :date_reservation, :heure_reservation, :photo_style)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom_client' => $nom,
        ':id_service' => $id_service,
        ':email_client' => $email,
        ':tel_client' => $tel,
        ':id_employe' => $id_employe,
        ':date_reservation' => $date_reservation,
        ':heure_reservation' => $heure_reservation,
        ':photo_style' => $photo_style,
    ]);

    echo "Réservation effectuée avec succès !";

}
