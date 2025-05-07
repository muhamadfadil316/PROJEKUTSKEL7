<?php

class KategoriModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Count total number of categories
     * @return int Total count
     */
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM kategori_umkm");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        // Return a default value if no categories exist
        return $count ? $count : 5;
    }
    
    /**
     * Get categories with UMKM count
     * @param int $limit Number of categories to fetch
     * @return array Categories with UMKM count
     */
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
        
        // If no results, use mock data
        if (empty($results)) {
            return $this->getMockCategories($limit);
        }
        
        return $results;
    }
    
    /**
     * Get category by ID
     * @param int $id Category ID
     * @return array|bool Category data or false if not found
     */
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kategori_umkm WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Generate mock category data if database is empty
     * @param int $count Number of mock categories
     * @return array Mock category data
     */
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
    /**
 * Get all categories from the database
 * @return array List of all categories
 */
public function getAllKategori() {
    $stmt = $this->conn->prepare("SELECT * FROM kategori_umkm ORDER BY nama ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

}