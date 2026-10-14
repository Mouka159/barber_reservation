<?php 
require_once("../admis/db.php");
include "phpqrcode/qrlib.php";

// Données à encoder
$data = "https://tonsite.com/ticket.php?id=123";

// Fichier de sortie
$file = "../img/qrcode_" . date('Ymd_His') . ".png";

// Génération du QR code
QRcode::png($data, $file);

echo "QR code généré : <img src='$file'>";

?>
