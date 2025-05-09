<?php
class LocationModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Get all provinces
     * @return array Provinces data
     */
    public function getProvinces() {
        $stmt = $this->conn->prepare("SELECT * FROM provinsi ORDER BY nama");
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        
        // If no results, use mock data
        if (empty($results)) {
            return $this->getMockProvinces();
        }
        
        return $results;
    }
    
    /**
     * Get kabupaten/kota by province ID
     * @param int $provinceId Province ID
     * @return array Kabupaten/Kota data
     */
    public function getKabkotaByProvince($provinceId) {
        $stmt = $this->conn->prepare("SELECT * FROM kabkota WHERE provinsi_id = :provinsi_id ORDER BY nama");
        $stmt->bindParam(':provinsi_id', $provinceId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get location details for a specific kabupaten/kota
     * @param int $kabkotaId Kabupaten/Kota ID
     * @return array Location details
     */
    public function getLocationDetails($kabkotaId) {
        $query = "
            SELECT 
                k.id,
                k.nama AS kabkota_nama,
                p.nama AS provinsi_nama,
                k.latitude,
                k.longitude
            FROM kabkota k
            JOIN provinsi p ON k.provinsi_id = p.id
            WHERE k.id = :kabkota_id
            LIMIT 1
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kabkota_id', $kabkotaId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Generate mock province data
     * @return array Mock province data
     */
    private function getMockProvinces() {
        return [
            ['id' => 1, 'nama' => 'DKI Jakarta', 'ibukota' => 'Jakarta', 'latitude' => -6.2088, 'longitude' => 106.8456],
            ['id' => 2, 'nama' => 'Jawa Barat', 'ibukota' => 'Bandung', 'latitude' => -6.9175, 'longitude' => 107.6191],
            ['id' => 3, 'nama' => 'Jawa Timur', 'ibukota' => 'Surabaya', 'latitude' => -7.2575, 'longitude' => 112.7521],
            ['id' => 4, 'nama' => 'Jawa Tengah', 'ibukota' => 'Semarang', 'latitude' => -7.0051, 'longitude' => 110.4381],
            ['id' => 5, 'nama' => 'Sumatera Utara', 'ibukota' => 'Medan', 'latitude' => 3.5952, 'longitude' => 98.6722]
        ];
    }
    // Tambahkan method berikut ke class LocationModel
    public function insertKabKota($nama, $provinsiId, $latitude, $longitude) {
        $stmt = $this->conn->prepare("INSERT INTO kabkota (nama, provinsi_id, latitude, longitude) VALUES (:nama, :provinsi_id, :latitude, :longitude)");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':provinsi_id', $provinsiId);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':longitude', $longitude);
        return $stmt->execute();
    }
    
/**
 * Delete a location (kabupaten/kota)
 * @param int $id Kabupaten/Kota ID
 * @return bool True if successful
 */
public function deleteLocation($id) {
    // First check if location is used in other tables
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM umkm WHERE lokasi_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return false; // Can't delete location that's in use
    }

    $stmt = $this->conn->prepare("DELETE FROM kabkota WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Update a location (kabupaten/kota)
 * @param int $id Kabupaten/Kota ID
 * @param string $nama New name
 * @param int $provinsiId Province ID
 * @return bool True if successful
 */
public function updateLocation($id, $nama, $provinsiId) {
    $stmt = $this->conn->prepare("UPDATE kabkota SET nama = :nama, provinsi_id = :provinsi_id WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
    $stmt->bindParam(':provinsi_id', $provinsiId, PDO::PARAM_INT);
    return $stmt->execute();
}
}