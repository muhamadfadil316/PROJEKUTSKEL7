<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';

header('Content-Type: application/json');

$kategoriModel = new KategoriModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'] ?? null;
    
    if ($id && $nama) {
        $berhasil = $kategoriModel->updateKategori($id, $nama);
        echo json_encode([
            'berhasil' => $berhasil,
            'pesan' => $berhasil ? '' : 'Gagal memperbarui kategori'
        ]);
    } else {
        echo json_encode([
            'berhasil' => false,
            'pesan' => 'ID dan nama kategori harus diisi'
        ]);
    }
    exit;
}

echo json_encode([
    'berhasil' => false,
    'pesan' => 'Metode request tidak valid'
]);