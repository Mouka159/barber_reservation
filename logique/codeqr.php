<?php 
require_once dirname(__DIR__) . '/admis/db.php';
require_once __DIR__ . '/../lib/qrlib.php';

// url du ticket
$id_reservation = 123;
$data = 'https://localhost/barber-shop/ticket.php?id=' . $id_reservation;

// Génère le SVG sans dépendre de l'extension GD.
$modules = QRcode::text($data, false, QR_ECLEVEL_L);
$quietZone = 4;
$size = count($modules) + 2 * $quietZone;
$path = [];

foreach ($modules as $y => $row) {
    foreach (str_split($row) as $x => $module) {
        if ($module === '1') {
            $path[] = 'M' . ($x + $quietZone) . ' ' . ($y + $quietZone) . 'h1v1h-1z';
        }
    }
}

$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $size . ' ' . $size . '" shape-rendering="crispEdges">'
    . '<rect width="100%" height="100%" fill="#fff"/>'
    . '<path d="' . implode('', $path) . '" fill="#000"/>'
    . '</svg>';

$fileQR = dirname(__DIR__) . '/qrcode/qrcode_' . date('Ymd') . '.svg';
if (file_put_contents($fileQR, $svg) === false) {
    throw new RuntimeException('Unable to write QR code to ' . $fileQR);
}

?>
