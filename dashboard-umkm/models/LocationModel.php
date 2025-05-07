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
    /**
 * Get all kabupaten/kota with their corresponding province names
 * @return array All location data
 */
public function getAllLokasi() {
    $query = "
        SELECT 
            k.id,
            k.nama AS nama,
            p.nama AS provinsi
        FROM kabkota k
        JOIN provinsi p ON k.provinsi_id = p.id
        ORDER BY k.nama
    ";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    
    $results = $stmt->fetchAll();

    // Optional: return mock if empty
    if (empty($results)) {
        return [
            ['id' => 1, 'nama' => 'Jakarta', 'provinsi' => 'DKI Jakarta'],
            ['id' => 2, 'nama' => 'Bandung', 'provinsi' => 'Jawa Barat'],
            ['id' => 3, 'nama' => 'Surabaya', 'provinsi' => 'Jawa Timur'],
            ['id' => 4, 'nama' => 'Semarang', 'provinsi' => 'Jawa Tengah'],
            ['id' => 5, 'nama' => 'Medan', 'provinsi' => 'Sumatera Utara'],
        ];
    }

    return $results;
}

}