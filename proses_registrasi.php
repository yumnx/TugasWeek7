<?php
session_start(); 
require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $zona = $_POST['zona'];

    if (!empty($nama) && !empty($zona)) {
        $database = new Database();
        $db = $database->getConnection();
        
        $sistem = new SistemZoo($db);

        if ($sistem->registrasiPengunjung($nama, $zona)) {
            $_SESSION['nama_pengunjung'] = $nama;
            $_SESSION['zona_pilihan'] = $zona;
            
            header("Location: zona.php");
            exit;
        } else {
            echo "Registrasi gagal. Silakan coba lagi.";
        }
    } else {
        echo "Semua field wajib diisi.";
    }
} else {
    header("Location: register.php");
    exit;
}
?>