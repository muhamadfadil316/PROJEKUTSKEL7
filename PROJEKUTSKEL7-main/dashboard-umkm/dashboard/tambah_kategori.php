<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];

    $kategoriModel = new KategoriModel($conn);
    $kategoriModel->tambahKategori($nama); // pastikan method ini ada di KategoriModel

    header('Location: kategori.php'); // redirect setelah tambah
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <form action="" method="POST" class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Tambah Kategori Baru</h2>
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
            <input type="text" id="nama" name="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
    </form>
</body>
</html>
