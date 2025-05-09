<?php

class KategoriModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM kategori_umkm");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count ? $count : 5;
    }

    public function getCategories($limit = 9) {
        $query = "
            SELECT 
                k.id,
                k.nama,
                COUNT(u.id) AS total
            FROM kategori_umkm k
            LEFT JOIN umkm u ON k.id = u.kategori_umkm_id
            GROUP BY k.id, k.nama
            ORDER BY id ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();

        if (empty($results)) {
            return $this->getMockCategories($limit);
        }

        return $results;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kategori_umkm WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateKategori($id, $nama) {
        $stmt = $this->conn->prepare("UPDATE kategori_umkm SET nama = :nama WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteKategori($id) {
        // First check if any UMKM is using this category
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM umkm WHERE kategori_umkm_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false; // Can't delete category that's in use
        }

        $stmt = $this->conn->prepare("DELETE FROM kategori_umkm WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function getMockCategories($count = 5) {
        $categories = [
            ['id' => 1, 'nama' => 'Kuliner', 'total' => 24],
            ['id' => 2, 'nama' => 'Fashion', 'total' => 18],
            ['id' => 3, 'nama' => 'Kerajinan', 'total' => 15],
            ['id' => 4, 'nama' => 'Teknologi', 'total' => 8],
            ['id' => 5, 'nama' => 'Agribisnis', 'total' => 12]
        ];
        return array_slice($categories, 0, $count);
    }

    public function tambahKategori($nama) {
        $stmt = $this->conn->prepare("INSERT INTO kategori_umkm (nama) VALUES (:nama)");
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        return $stmt->execute();
    }
}