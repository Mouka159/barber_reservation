<?php
require_once("../admis/db.php");

if(isset($_POST['submit'])) {
    $nom = trim($_POST['nom_user'] ?? '');
    $nom_service = trim($_POST['nom_service'] ?? '');
    $email = trim($_POST['email_user'] ?? '');
    $tel = trim($_POST['telephone'] ?? '');
    $nom_employe = trim($_POST['nom_employe'] ?? '' );
    $date_reservation = trim($_POST['date_rdv'] ?? '');
    $heure_reservation = trim($_POST['heure_rdv'] ?? '');
    $photo_style = $_FILES['photo_style']['name'] ?? '';

    

    // Déplacer la photo uploadée
    if (!empty($photo_style)) {
        $target = "../img/" . basename($photo_style);
        move_uploaded_file($_FILES['photo_style']['tmp_name'], $target);
    }

    $sql = "INSERT INTO reservation (nom_user, nom_service, email_user, telephone, nom_employe, date_rdv, heure_rdv, photo_style)
            VALUES (:nom_user, :nom_service, :email_user, :telephone, :nom_employe, :date_reservation, :heure_reservation, :photo_style)";

    $stmt = $pdo->prepare($sql);
   $stmt->execute([
    ':nom_user' => $nom,
    ':nom_service' => $nom_service,
    ':email_user' => $email,
    ':telephone' => $tel,
    ':nom_employe' => $nom_employe,
    ':date_reservation' => $date_reservation,
    ':heure_reservation' => $heure_reservation,
    ':photo_style' => $photo_style,
]);


    header("Location: ../acceuil.php");
    exit();
}
