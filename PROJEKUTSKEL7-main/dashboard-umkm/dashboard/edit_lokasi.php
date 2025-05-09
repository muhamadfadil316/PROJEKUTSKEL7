<?php
require_once '../config/database.php';
require_once '../models/LocationModel.php';

header('Content-Type: application/json');

$locationModel = new LocationModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'] ?? null;
    
    if ($id && $nama) {
        // Anda mungkin perlu menambahkan provinsi_id jika ingin mengubah provinsi juga
        $success = $locationModel->updateLocation($id, $nama, $_POST['provinsi_id'] ?? null);
        echo json_encode([
            'success' => $success,
            'message' => $success ? '' : 'Gagal memperbarui lokasi'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID dan nama lokasi diperlukan'
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Metode request tidak valid'
]);