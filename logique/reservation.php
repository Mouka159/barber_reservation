<?php
require_once("../admis/db.php");

if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom_user'] ?? '');
    $nom_service = trim($_POST['nom_service'] ?? '');
    $email = trim($_POST['email_user'] ?? '');
    $tel = trim($_POST['telephone'] ?? '');
    $nom_employe = trim($_POST['nom_employe'] ?? '');
    $date_reservation = trim($_POST['date_rdv'] ?? '');
    $heure_reservation = trim($_POST['heure_rdv'] ?? '');
    $photo_style = '';
    $uploadedFilePath = null;

    if (isset($_FILES['photo_style']) && $_FILES['photo_style']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = $_FILES['photo_style'];
        if ($upload['error'] !== UPLOAD_ERR_OK) {
            die("L'envoi de l'image a échoué (code " . (int) $upload['error'] . ").");
        }

        if ($upload['size'] > 5 * 1024 * 1024) {
            die("L'image ne doit pas dépasser 5 Mo.");
        }

        $imageInfo = getimagesize($upload['tmp_name']);
        $allowedTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
        ];
        if ($imageInfo === false || !isset($allowedTypes[$imageInfo[2]])) {
            die("Format non autorisé. Seules les images JPG et PNG sont acceptées.");
        }

        $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploade';
        if (!is_dir($targetDir) || !is_writable($targetDir)) {
            die("Le dossier uploade est introuvable ou inaccessible en écriture.");
        }

        $photo_style = 'img_' . date('Ymd_His') . '.' . $allowedTypes[$imageInfo[2]];
        $uploadedFilePath = $targetDir . DIRECTORY_SEPARATOR . $photo_style;
        if (!move_uploaded_file($upload['tmp_name'], $uploadedFilePath)) {
            die("Impossible d'enregistrer l'image dans le dossier uploade.");
        }
    }

    $sql = "INSERT INTO reservation
            (nom_user, nom_service, email_user, telephone, nom_employe, date_rdv, heure_rdv, photo_style)
            VALUES (:nom_user, :nom_service, :email_user, :telephone, :nom_employe, :date_reservation, :heure_reservation, :photo_style)";

    try {
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
    } catch (PDOException $e) {
        if ($uploadedFilePath !== null && is_file($uploadedFilePath)) {
            unlink($uploadedFilePath);
        }
        throw $e;
    }

    header("Location: ../page/acceuil.php");
    exit();
}
