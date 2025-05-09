<?php
class PembinaModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Count total number of pembina
     * @return int Total count
     */
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM pembina");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    /**
     * Get pembinas with their details
     * @param int $limit Number of pembinas to fetch
     * @return array Pembina data
     */
    public function getPembinas($limit = 5) {
        $query = "
            SELECT 
                p.id,
                p.nama,
                p.gender,
                p.tgl_lahir,
                p.tmp_lahir,
                p.keahlian,
                COUNT(u.id) AS total_umkm
            FROM pembina p
            LEFT JOIN umkm u ON p.id = u.pembina_id
            GROUP BY p.id, p.nama, p.gender, p.tgl_lahir, p.tmp_lahir, p.keahlian
            ORDER BY total_umkm DESC
            LIMIT :limit
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        
        
        return $results;
    }
    
    /**
     * Get pembina by ID
     * @param int $id Pembina ID
     * @return array|bool Pembina data or false if not found
     */
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM pembina WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Generate mock pembina data if database is empty
     * @param int $count Number of mock entries
     * @return array Mock pembina data
     */
    private function getMockPembinas($count = 3) {
        $keahlian = [
            'Manajemen Bisnis', 
            'Pemasaran Digital', 
            'Keuangan UMKM', 
            'Produksi & Operasional',
            'Ekspor & Impor'
        ];
        
        $pembinas = [];
        for ($i = 1; $i <= $count; $i++) {
            $pembinas[] = [
                'id' => $i,
                'nama' => 'Pembina ' . $i,
                'gender' => ($i % 2 == 0) ? 'P' : 'L',
                'tgl_lahir' => date('Y-m-d', strtotime("-" . (25 + $i) . " years")),
                'tmp_lahir' => 'Jakarta',
                'keahlian' => $keahlian[array_rand($keahlian)],
                'total_umkm' => rand(5, 15)
            ];
        }
        
        return $pembinas;
    }
    // Tambahkan method berikut ke class PembinaModel
public function createPembina($nama,$gender,$tgl_lahir,$tmp_lahir,$keahlian) 
{
    $stmt = $this->conn->prepare("INSERT INTO pembina (nama, gender, tgl_lahir, tmp_lahir, keahlian) VALUES (:nama, :gender, :tgl_lahir, :tmp_lahir, :keahlian)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':tgl_lahir', $tgl_lahir);
    $stmt->bindParam(':tmp_lahir', $tmp_lahir);
    $stmt->bindParam(':keahlian', $keahlian);
    
    if ($stmt->execute()) {
        header("Location: pembina.php?success=1");
        exit;
    }
}
    
/**
 * Delete a pembina
 * @param int $id Pembina ID
 * @return bool True if successful
 */
public function deletePembina($id) {
    // First check if pembina is assigned to any UMKM
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM umkm WHERE pembina_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return false; // Can't delete pembina that's assigned to UMKM
    }

    $stmt = $this->conn->prepare("DELETE FROM pembina WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Update a pembina
 * @param int $id Pembina ID
 * @param string $nama New name
 * @param string $gender Gender
 * @param string $keahlian Expertise
 * @return bool True if successful
 */
public function updatePembina($id, $nama, $gender, $keahlian) {
    $stmt = $this->conn->prepare("UPDATE pembina SET nama = :nama, gender = :gender, keahlian = :keahlian WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':keahlian', $keahlian, PDO::PARAM_STR);
    return $stmt->execute();
}
}