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
        
        // If no results, use mock data
        if (empty($results)) {
            return $this->getMockPembinas($limit);
        }
        
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
}