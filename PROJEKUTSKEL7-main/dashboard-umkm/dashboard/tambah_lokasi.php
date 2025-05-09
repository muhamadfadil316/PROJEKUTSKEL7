<?php
require_once '../config/database.php';
require_once '../models/LocationModel.php';

$locationModel = new LocationModel($conn);
$provinces = $locationModel->getProvinces();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $provinsiId = $_POST['provinsi_id'] ?? 0;
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    if (!empty($nama) && $provinsiId > 0) {
        if ($locationModel->insertKabKota($nama, $provinsiId, $latitude, $longitude)) {
            header("Location: lokasi.php?success=1");
            exit;
        }
        
        
        if ($stmt->execute()) {
            header("Location: lokasi.php?success=1");
            exit;
        }
    }
    
    $error = "Gagal menambahkan lokasi. Pastikan semua field diisi dengan benar.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <?php include '../components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Lokasi Baru</h1>
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
                            <label for="provinsi_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <select id="provinsi_id" name="provinsi_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Provinsi</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo $province['id']; ?>"><?php echo htmlspecialchars($province['nama']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kabupaten/Kota</label>
                            <input type="text" id="nama" name="nama" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="lokasi.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md mr-2">
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