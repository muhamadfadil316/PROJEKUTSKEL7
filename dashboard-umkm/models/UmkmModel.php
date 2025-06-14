<?php
class UmkmModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Count total number of UMKM entries
     * @return int Total count
     */
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    /**
     * Count unique UMKM owners
     * @return int Count of unique owners
     */
    public function countUniquePemilik() {
        $stmt = $this->conn->prepare("SELECT COUNT(DISTINCT pemilik) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    /**
     * Calculate total modal of all UMKM
     * @return float Total modal amount
     */
    public function calculateTotalModal() {
        $stmt = $this->conn->prepare("SELECT SUM(modal) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }
    
    /**
     * Get latest UMKM entries with category and location data
     * @param int $limit Number of entries to fetch
     * @return array Latest UMKM data
     */
    public function getLatestUmkm($limit = 6) {
        $query = "
            SELECT 
                u.id,
                u.nama,
                u.modal,
                u.pemilik,
                u.alamat,
                u.website,
                u.email,
                u.rating,
                k.nama AS kategori,
                CONCAT(kk.nama, ', ', p.nama) AS lokasi
            FROM umkm u
            LEFT JOIN kategori_umkm k ON u.kategori_umkm_id = k.id
            LEFT JOIN kabkota kk ON u.kabkota_id = kk.id
            LEFT JOIN provinsi p ON kk.provinsi_id = p.id
            ORDER BY u.id DESC
            LIMIT :limit
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        
        // If no results or missing joins, use mock data
        if (empty($results)) {
            return $this->getMockUmkmData($limit);
        }
        
        return $results;
    }
    
    /**
     * Get UMKM data by ID
     * @param int $id UMKM ID
     * @return array|bool UMKM data or false if not found
     */
    public function getById($id) {
        $query = "
            SELECT 
                u.id,
                u.nama,
                u.modal,
                u.pemilik,
                u.alamat,
                u.website,
                u.email,
                u.rating,
                k.nama AS kategori,
                kk.nama AS kota,
                p.nama AS provinsi
            FROM umkm u
            LEFT JOIN kategori_umkm k ON u.kategori_umkm_id = k.id
            LEFT JOIN kabkota kk ON u.kabkota_id = kk.id
            LEFT JOIN provinsi p ON kk.provinsi_id = p.id
            WHERE u.id = :id
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Generate mock UMKM data if database is empty
     * @param int $count Number of mock entries
     * @return array Mock UMKM data
     */
    private function getMockUmkmData($count = 3) {
        $mockData = [];
        $categories = ['Kuliner', 'Fashion', 'Kerajinan', 'Teknologi', 'Agribisnis'];
        $locations = ['Jakarta Selatan, DKI Jakarta', 'Bandung, Jawa Barat', 'Surabaya, Jawa Timur', 'Medan, Sumatera Utara'];
        
        for ($i = 1; $i <= $count; $i++) {
            $mockData[] = [
                'id' => $i,
                'nama' => 'UMKM ' . $i,
                'modal' => rand(5000000, 50000000),
                'pemilik' => 'Pemilik ' . $i,
                'alamat' => 'Jl. Contoh No. ' . $i,
                'website' => 'www.umkm' . $i . '.com',
                'email' => 'kontak@umkm' . $i . '.com',
                'rating' => rand(3, 5),
                'kategori' => $categories[array_rand($categories)],
                'lokasi' => $locations[array_rand($locations)]
            ];
        }
        
        return $mockData;
    }
}