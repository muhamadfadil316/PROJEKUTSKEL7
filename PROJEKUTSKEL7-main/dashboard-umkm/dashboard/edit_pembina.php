<?php
require_once '../config/database.php';
require_once '../models/PembinaModel.php';

header('Content-Type: application/json');

$pembinaModel = new PembinaModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'] ?? null;
    
    if ($id && $nama) {
        // Anda bisa menambahkan parameter lain sesuai kebutuhan
        $success = $pembinaModel->updatePembina($id, $nama, $_POST['gender'] ?? 'L', $_POST['keahlian'] ?? '');
        echo json_encode([
            'success' => $success,
            'message' => $success ? '' : 'Gagal memperbarui pembina'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID dan nama pembina diperlukan'
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Metode request tidak valid'
]);