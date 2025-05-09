<?php
require_once '../config/database.php';
require_once '../models/UmkmModel.php';
require_once '../models/KategoriModel.php';
require_once '../models/LocationModel.php';

$umkmModel = new UmkmModel($conn);
$kategoriModel = new KategoriModel($conn);
$locationModel = new LocationModel($conn);

$id = $_GET['id'] ?? null;
$umkm = $id ? $umkmModel->getById($id) : null;

if (!$umkm) {
    header("Location: umkm.php");
    exit;
}

$kategories = $kategoriModel->getCategories();
$provinces = $locationModel->getProvinces();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => $_POST['nama'] ?? '',
        'pemilik' => $_POST['pemilik'] ?? '',
        'alamat' => $_POST['alamat'] ?? '',
        'website' => $_POST['website'] ?? '',
        'email' => $_POST['email'] ?? '',
        'kategori_id' => $_POST['kategori_id'] ?? null,
        'kabkota_id' => $_POST['kabkota_id'] ?? null,
        'modal' => $_POST['modal'] ?? 0,
        'rating' => $_POST['rating'] ?? 0
    ];

    if (!empty($data['nama']) && !empty($data['pemilik'])) {
        if ($umkmModel->updateUmkm($id, $data)) {
            header("Location: umkm.php?success=1");
            exit;
        }
    }
    
    $error = "Gagal memperbarui UMKM. Pastikan semua field wajib diisi.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function updateModalDisplay(input) {
            const value = input.value.replace(/\D/g, '');
            input.value = value;
            document.getElementById('modal-display').textContent = formatRupiah(value || 0);
        }

        function loadKabKota(provinsiId) {
            if (provinsiId) {
                fetch(`get_kabkota.php?provinsi_id=${provinsiId}`)
                    .then(response => response.json())
                    .then(data => {
                        const kabkotaSelect = document.getElementById('kabkota_id');
                        kabkotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                        
                        data.forEach(kabkota => {
                            const option = document.createElement('option');
                            option.value = kabkota.id;
                            option.textContent = kabkota.nama;
                            option.selected = kabkota.id == <?php echo $umkm['kabkota_id'] ?? 0; ?>;
                            kabkotaSelect.appendChild(option);
                        });
                    });
            }
        }

        // Load kabupaten/kota when page loads if provinsi is selected
        window.onload = function() {
            const provinsiSelect = document.getElementById('provinsi_id');
            if (provinsiSelect.value) {
                loadKabKota(provinsiSelect.value);
            }
        };
    </script>
</head>
<body class="bg-gray-100 flex">

    <?php include '../components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-800">Edit UMKM</h1>
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
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama UMKM*</label>
                            <input type="text" id="nama" name="nama" required 
                                   value="<?php echo htmlspecialchars($umkm['nama']); ?>"
                                   class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="pemilik" class="block text-sm font-medium text-gray-700">Nama Pemilik*</label>
                            <input type="text" id="pemilik" name="pemilik" required 
                                   value="<?php echo htmlspecialchars($umkm['pemilik']); ?>"
                                   class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                   class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($umkm['alamat']); ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" id="website" name="website" 
                                       value="<?php echo htmlspecialchars($umkm['website']); ?>"
                                       class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($umkm['email']); ?>"
                                       class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori*</label>
                                <select id="kategori_id" name="kategori_id" required 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategories as $kategori): ?>
                                        <option value="<?php echo $kategori['id']; ?>" 
                                            <?php echo ($kategori['id'] == $umkm['kategori_umkm_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($kategori['nama']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                <select id="rating" name="rating" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="0" <?php echo ($umkm['rating'] == 0) ? 'selected' : ''; ?>>Tidak ada rating</option>
                                    <option value="1" <?php echo ($umkm['rating'] == 1) ? 'selected' : ''; ?>>1 Bintang</option>
                                    <option value="2" <?php echo ($umkm['rating'] == 2) ? 'selected' : ''; ?>>2 Bintang</option>
                                    <option value="3" <?php echo ($umkm['rating'] == 3) ? 'selected' : ''; ?>>3 Bintang</option>
                                    <option value="4" <?php echo ($umkm['rating'] == 4) ? 'selected' : ''; ?>>4 Bintang</option>
                                    <option value="5" <?php echo ($umkm['rating'] == 5) ? 'selected' : ''; ?>>5 Bintang</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="provinsi_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <select id="provinsi_id" name="provinsi_id" onchange="loadKabKota(this.value)"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach ($provinces as $province): ?>
                                        <option value="<?php echo $province['id']; ?>"
                                            <?php echo ($province['id'] == $umkm['provinsi_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($province['nama']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="kabkota_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                                <select id="kabkota_id" name="kabkota_id" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="modal" class="block text-sm font-medium text-gray-700">Modal (Rp)</label>
                            <input type="text" id="modal" name="modal" oninput="updateModalDisplay(this)"
                                   class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Nilai: <span id="modal-display">Rp0</span></p>
                        </div>

                        <div class="flex justify-end">
                            <a href="umkm.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>