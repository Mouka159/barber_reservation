<?php
require_once("../admis/db.php");

$id = $_GET['id_reservation'] ?? null;

if ($id) {
    $sql = "SELECT * FROM reservation WHERE id_reservation = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo "<h2> Ticket de réservation</h2>";
        echo "<p><strong>Nom du client :</strong> " . htmlspecialchars($row['nom_user']) . "</p>";
        echo "<p><strong>Nom du service :</strong> " . htmlspecialchars($row['nom_service']) . "</p>";
        echo "<p><strong>Email :</strong> " . htmlspecialchars($row['email_user']) . "</p>";
        echo "<p><strong>Téléphone :</strong> " . htmlspecialchars($row['telephone']) . "</p>";
        echo "<p><strong>Nom de l'employé :</strong> " . htmlspecialchars($row['nom_employe']) . "</p>";
        echo "<p><strong>Date de réservation :</strong> " . htmlspecialchars($row['date_rdv']) . "</p>";
        echo "<p><strong>Heure de réservation :</strong> " . htmlspecialchars($row['heure_rdv']) . "</p>";
        echo "<img src='" . htmlspecialchars($row['photo_style']) . "' alt='Style choisi' style='width:200px;'>";
    } else {
        echo "<p>Aucune réservation trouvée pour cet ID.</p>";
    }
} else {
    echo "<p>ID de réservation manquant.</p>";
}
?>My_streams!159
