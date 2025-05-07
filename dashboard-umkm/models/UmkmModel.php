<?php
class UmkmModel {


    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUmkmById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM umkm WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUmkm($id, $nama, $kategori, $pemilik, $lokasi, $kontak, $status) {
        $stmt = $this->conn->prepare("UPDATE umkm SET nama = :nama, kategori = :kategori, pemilik = :pemilik, lokasi = :lokasi, kontak = :kontak, status = :status WHERE id = :id");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':pemilik', $pemilik);
        $stmt->bindParam(':lokasi', $lokasi);
        $stmt->bindParam(':kontak', $kontak);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUmkm($id) {
        $stmt = $this->conn->prepare("DELETE FROM umkm WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function countUniquePemilik() {
        $stmt = $this->conn->prepare("SELECT COUNT(DISTINCT pemilik) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function calculateTotalModal() {
        $stmt = $this->conn->prepare("SELECT SUM(modal) FROM umkm");
        $stmt->execute();
        return $stmt->fetchColumn() ?: 0;
    }

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
            LIMIT :limit";
       
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFilteredUmkm($search, $kategori, $lokasi, $page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $conditions = [];
    
        if (!empty($search)) {
            $conditions[] = "(u.nama LIKE :search OR u.pemilik LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
    
        if (!empty($kategori)) {
            $conditions[] = "u.kategori_umkm_id = :kategori";
            $params[':kategori'] = $kategori;
        }
    
        if (!empty($lokasi)) {
            $conditions[] = "u.kabkota_id = :lokasi";
            $params[':lokasi'] = $lokasi;
        }
    
        $whereClause = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";
    
        $query = "
            SELECT u.id, u.nama, u.pemilik,
                   k.nama AS kategori_nama, kk.nama AS lokasi_nama
            FROM umkm u
            LEFT JOIN kategori_umkm k ON u.kategori_umkm_id = k.id
            LEFT JOIN kabkota kk ON u.kabkota_id = kk.id
            $whereClause
            ORDER BY u.nama ASC
            LIMIT :limit OFFSET :offset
        ";
    
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countFilteredUmkm($search, $kategori, $lokasi) {
        $params = [];
        $conditions = [];
    
        if (!empty($search)) {
            $conditions[] = "(nama LIKE :search OR pemilik LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
    
        if (!empty($kategori)) {
            $conditions[] = "kategori_umkm_id = :kategori";
            $params[':kategori'] = $kategori;
        }
    
        if (!empty($lokasi)) {
            $conditions[] = "kabkota_id = :lokasi";
            $params[':lokasi'] = $lokasi;
        }
    
        $whereClause = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";
    
        $query = "SELECT COUNT(*) FROM umkm $whereClause";
    
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
       

    // Insert new UMKM
    public function createUmkm($nama, $kategori, $pemilik, $lokasi, $kontak, $status) {
        $stmt = $this->conn->prepare("
            INSERT INTO umkm (nama, kategori, pemilik, lokasi, kontak, status)
            VALUES (:nama, :kategori, :pemilik, :lokasi, :kontak, :status)
        ");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':pemilik', $pemilik);
        $stmt->bindParam(':lokasi', $lokasi);
        $stmt->bindParam(':kontak', $kontak);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    

    // Get all UMKM
    public function getAllUmkm() {
        $stmt = $this->conn->query("SELECT * FROM umkm ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Optional: Search UMKM
    public function searchUmkm($keyword) {
        $stmt = $this->conn->prepare("
            SELECT * FROM umkm 
            WHERE nama LIKE :keyword OR pemilik LIKE :keyword 
            ORDER BY id DESC
        ");
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
