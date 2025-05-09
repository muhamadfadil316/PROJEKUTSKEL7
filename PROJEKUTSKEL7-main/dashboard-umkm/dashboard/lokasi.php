<?php
require_once '../config/database.php';
require_once '../models/LocationModel.php';

$locationModel = new LocationModel($conn);

// Handle delete action
if (isset($_POST['hapus_id'])) {
    $id = $_POST['hapus_id'];
    // Anda perlu menambahkan method deleteLocation di LocationModel
    $success = $locationModel->deleteLocation($id);
    if ($success) {
        $message = "Lokasi berhasil dihapus";
    } else {
        $error = "Gagal menghapus lokasi. Mungkin lokasi masih terkait dengan data lain.";
    }
}

$provinces = $locationModel->getProvinces();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmDelete(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus lokasi "${nama}"?`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function editLocation(id, currentName) {
            const newName = prompt("Edit nama lokasi:", currentName);
            if (newName !== null && newName !== currentName && newName.trim() !== '') {
                fetch('edit_lokasi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&nama=${encodeURIComponent(newName)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Lokasi berhasil diperbarui");
                        location.reload();
                    } else {
                        alert("Gagal memperbarui lokasi: " + (data.message || "Terjadi kesalahan"));
                    }
                })
                .catch(error => {
                    alert("Terjadi kesalahan: " + error);
                });
            }
        }

        function loadKabKota(provinsiId) {
            if (provinsiId) {
                fetch(`get_kabkota.php?provinsi_id=${provinsiId}`)
                    .then(response => response.json())
                    .then(data => {
                        const kabkotaSelect = document.getElementById('kabkota');
                        kabkotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                        
                        data.forEach(kabkota => {
                            const option = document.createElement('option');
                            option.value = kabkota.id;
                            option.textContent = kabkota.nama;
                            kabkotaSelect.appendChild(option);
                        });
                    });
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex">

    <?php include '../components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Lokasi</h1>
                <a href="tambah_lokasi.php" class="bg-blue-600 hover:bg-blue-700 transition-colors text-white px-4 py-2 rounded-lg shadow-md">
                    + Tambah Lokasi
                </a>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-6 py-8">
            <?php if (isset($message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Filter Lokasi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <select onchange="loadKabKota(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Provinsi</option>
                            <?php foreach ($provinces as $province): ?>
                                <option value="<?php echo $province['id']; ?>"><?php echo htmlspecialchars($province['nama']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                        <select id="kabkota" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kabupaten/Kota</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Provinsi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Koordinat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Data akan diisi via AJAX atau PHP -->
                        <?php 
                        // Contoh menampilkan semua kabupaten dari provinsi pertama
                        if (!empty($provinces)) {
                            $kabkotaList = $locationModel->getKabkotaByProvince($provinces[0]['id']);
                            foreach ($kabkotaList as $kabkota): 
                                $detail = $locationModel->getLocationDetails($kabkota['id']);
                        ?>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $kabkota['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($kabkota['nama']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($detail['provinsi_nama']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php echo $detail['latitude'] ? $detail['latitude'].', '.$detail['longitude'] : '-'; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        <button onclick="editLocation(<?php echo $kabkota['id']; ?>, '<?php echo htmlspecialchars($kabkota['nama'], ENT_QUOTES); ?>')" 
                                                class="bg-green-500 hover:bg-green-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Edit
                                        </button>
                                        <form id="delete-form-<?php echo $kabkota['id']; ?>" method="POST" style="display: none;">
                                            <input type="hidden" name="hapus_id" value="<?php echo $kabkota['id']; ?>">
                                        </form>
                                        <button onclick="confirmDelete(<?php echo $kabkota['id']; ?>, '<?php echo htmlspecialchars($kabkota['nama'], ENT_QUOTES); ?>')" 
                                                class="bg-red-500 hover:bg-red-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; 
                        } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>