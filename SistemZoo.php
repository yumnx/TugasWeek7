<?php
require_once 'Karnivora.php';
require_once 'Herbivora.php';
require_once 'Omnivora.php';

class SistemZoo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getHewanByZona($tipe) {
        $query = "SELECT id, nama, jenis_makanan, tipe, favorit, emoticon FROM hewan WHERE tipe = :tipe";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipe", $tipe);
        $stmt->execute();
        
        $hewanArray = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['tipe'] == 'Karnivora') {
                $hewanArray[] = new Karnivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            } elseif ($row['tipe'] == 'Herbivora') {
                $hewanArray[] = new Herbivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            } elseif ($row['tipe'] == 'Omnivora') {
                $hewanArray[] = new Omnivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            }
        }
        return $hewanArray;
    }

    public function registrasiPengunjung($nama, $zona) {
        $query = "INSERT INTO pengunjung (nama_pengunjung, zona_pilihan) VALUES (:nama, :zona)";
        $stmt = $this->conn->prepare($query);
        
        $nama = htmlspecialchars(strip_tags($nama));
        $zona = htmlspecialchars(strip_tags($zona));

        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":zona", $zona);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getDaftarPengunjung() {
        $query = "SELECT id, nama_pengunjung, zona_pilihan, tgl_registrasi 
                  FROM pengunjung 
                  ORDER BY tgl_registrasi DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getPengunjungById($id) {
        $query = "SELECT id, nama_pengunjung, zona_pilihan FROM pengunjung WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePengunjung($id, $nama, $zona) {
        $query = "UPDATE pengunjung SET nama_pengunjung = :nama, zona_pilihan = :zona WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $nama = htmlspecialchars(strip_tags($nama));
        $zona = htmlspecialchars(strip_tags($zona));

        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':zona', $zona);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deletePengunjung($id) {
        $query = "DELETE FROM pengunjung WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>