<?php
session_start();
if (!isset($_SESSION['nama_pengunjung']) || !isset($_SESSION['zona_pilihan'])) {
    header("Location: register.php");
    exit;
}

require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

$nama_pengunjung = $_SESSION['nama_pengunjung'];
$zona_pilihan = $_SESSION['zona_pilihan'];

$database = new Database();
$db = $database->getConnection();
$sistem = new SistemZoo($db);

$hewan_zona_pilihan = $sistem->getHewanByZona($zona_pilihan);

$semua_zona = ['Karnivora', 'Herbivora', 'Omnivora'];
$zona_lain = [];
foreach ($semua_zona as $z) {
    if ($z != $zona_pilihan) {
        $zona_lain[] = $z;
    }
}

$hewan_zona_lain_1 = $sistem->getHewanByZona($zona_lain[0]);
$hewan_zona_lain_2 = $sistem->getHewanByZona($zona_lain[1]);

function displayHewanTable($hewanArray) {
    foreach ($hewanArray as $h) {
        echo "<tr>";
        echo "<td>" . $h->getId() . "</td>";
        echo "<td><span class='emoji'>" . htmlspecialchars($h->getEmoticon()) . "</span>" . htmlspecialchars($h->getNama()) . "</td>";
        echo "<td>" . htmlspecialchars($h->getJenisMakanan()) . "</td>";
        echo "<td>";
        if ($h instanceof Karnivora) echo "Mangsa favorit: " . htmlspecialchars($h->getMangsaFavorit());
        elseif ($h instanceof Herbivora) echo "Tumbuhan favorit: " . htmlspecialchars($h->getTumbuhanFavorit());
        elseif ($h instanceof Omnivora) echo "Menu favorit: " . htmlspecialchars($h->getMenuFavorit());
        echo "</td>";
        echo "</tr>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tur Zona Kebun Binatang</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>👋 Selamat Datang, <?= htmlspecialchars($nama_pengunjung); ?>!</h2>
        <p style="text-align: center;">Anda sedang berada di <strong>Zona <?= htmlspecialchars($zona_pilihan); ?></strong>.</p>
        
        <div class="nav">
            <a href="daftar_pengunjung.php">Lihat Daftar Pengunjung</a> |
            <a href="logout.php">Keluar (Logout)</a>
        </div>

        <div class="zona-section">
            <h3>Hewan di Zona Anda (<?= htmlspecialchars($zona_pilihan); ?>)</h3>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th></tr>
                </thead>
                <tbody>
                    <?php displayHewanTable($hewan_zona_pilihan); ?>
                </tbody>
            </table>
        </div>

        <hr>

        <h3>Kunjungi Juga Zona Lainnya!</h3>
        
        <div class="zona-section">
            <h4>Zona <?= htmlspecialchars($zona_lain[0]); ?></h4>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th></tr>
                </thead>
                <tbody>
                    <?php displayHewanTable($hewan_zona_lain_1); ?>
                </tbody>
            </table>
        </div>
        
        <div class="zona-section">
            <h4>Zona <?= htmlspecialchars($zona_lain[1]); ?></h4>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th></tr>
                </thead>
                <tbody>
                    <?php displayHewanTable($hewan_zona_lain_2); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>