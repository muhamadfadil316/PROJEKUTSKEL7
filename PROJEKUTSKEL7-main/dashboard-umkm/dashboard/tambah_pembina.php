<?php
require_once '../config/database.php';
require_once '../models/PembinaModel.php';

$pembinaModel = new PembinaModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $gender = $_POST['gender'] ?? 'L';
    $tgl_lahir = $_POST['tgl_lahir'] ?? null;
    $tmp_lahir = $_POST['tmp_lahir'] ?? '';
    $keahlian = $_POST['keahlian'] ?? '';

    if (!empty($nama)) {
       $pembinaModel->createPembina($nama, $gender, $tgl_lahir, $tmp_lahir, $keahlian)
       ->updatePembina($kode, $gender, $tgl_lahir, $tmp_lahir, $keahlian);
    }
    
    $error = "Gagal menambahkan pembina. Pastikan semua field diisi dengan benar.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembina Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <?php include '../components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Pembina Baru</h1>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-6 py-8">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="POST">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <div class="mt-1 flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="L" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="P" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="tmp_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" id="tmp_lahir" name="tmp_lahir" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label for="keahlian" class="block text-sm font-medium text-gray-700">Keahlian</label>
                            <input type="text" id="keahlian" name="keahlian" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <a href="pembina.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>