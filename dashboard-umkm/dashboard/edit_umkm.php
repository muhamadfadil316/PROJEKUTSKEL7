<?php
require_once '../config/database.php';
require_once '../models/UMKMModel.php';

$umkmModel = new UmkmModel($conn);

// Get UMKM by ID
$id = $_GET['id'] ?? null;
$umkm = $id ? $umkmModel->getUmkmById($id) : null;

if (!$umkm) {
    echo "UMKM tidak ditemukan.";
    exit;
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $pemilik = $_POST['pemilik'];
    $lokasi = $_POST['lokasi'];
    $kontak = $_POST['kontak'];
    $status = $_POST['status'];

    $umkmModel->updateUmkm($id, $nama, $kategori, $pemilik, $lokasi, $kontak, $status);
    header("Location: umkm.php");
    exit;
}
?>

<form method="POST">
    <label>Nama UMKM</label>
    <input type="text" name="nama" value="<?= $umkm['nama'] ?>" required><br>

    <label>Kategori</label>
    <input type="text" name="kategori" value="<?= $umkm['kategori'] ?>" required><br>

    <label>Pemilik</label>
    <input type="text" name="pemilik" value="<?= $umkm['pemilik'] ?>" required><br>

    <label>Lokasi</label>
    <input type="text" name="lokasi" value="<?= $umkm['lokasi'] ?>" required><br>

    <label>Kontak</label>
    <input type="text" name="kontak" value="<?= $umkm['kontak'] ?>" required><br>

    <label>Status</label>
    <select name="status" required>
        <option value="Aktif" <?= $umkm['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
        <option value="Tidak Aktif" <?= $umkm['status'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
    </select><br>

    <button type="submit">Simpan Perubahan</button>
</form>
