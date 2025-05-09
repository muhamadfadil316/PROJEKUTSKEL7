<?php
require_once '../config/database.php';
require_once '../models/UmkmModel.php';

$umkmModel = new UmkmModel($conn);

// Handle delete action
if (isset($_POST['hapus_id'])) {
    $id = $_POST['hapus_id'];
    // Anda perlu menambahkan method deleteUmkm di UmkmModel
    $success = $umkmModel->deleteUmkm($id);
    if ($success) {
        $message = "UMKM berhasil dihapus";
    } else {
        $error = "Gagal menghapus UMKM. Mungkin UMKM masih terkait dengan data lain.";
    }
}

$umkms = $umkmModel->getLatestUmkm(10);
$totalUmkm = $umkmModel->countAll();
$totalPemilik = $umkmModel->countUniquePemilik();
$totalModal = $umkmModel->calculateTotalModal();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmDelete(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus UMKM "${nama}"?`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }
    </script>
</head>
<body class="bg-gray-100 flex">

    <?php include '../components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Daftar UMKM</h1>
                <a href="tambah_umkm.php" class="bg-blue-600 hover:bg-blue-700 transition-colors text-white px-4 py-2 rounded-lg shadow-md">
                    + Tambah UMKM
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

            <!-- Statistik UMKM -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-gray-500">Total UMKM</h3>
                    <p class="text-3xl font-bold text-gray-800"><?php echo $totalUmkm; ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-gray-500">Total Pemilik</h3>
                    <p class="text-3xl font-bold text-gray-800"><?php echo $totalPemilik; ?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-gray-500">Total Modal</h3>
                    <p class="text-3xl font-bold text-gray-800">
                        <script>document.write(formatRupiah(<?php echo $totalModal; ?>))</script>
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama UMKM</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Modal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($umkms as $umkm): ?>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $umkm['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <a href="detail_umkm.php?id=<?php echo $umkm['id']; ?>" class="text-blue-600 hover:text-blue-800">
                                        <?php echo htmlspecialchars($umkm['nama']); ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($umkm['pemilik']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <script>document.write(formatRupiah(<?php echo $umkm['modal']; ?>))</script>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($umkm['kategori']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($umkm['lokasi']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $umkm['rating'] ? '★' : '☆';
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        <a href="edit_umkm.php?id=<?php echo $umkm['id']; ?>" class="bg-green-500 hover:bg-green-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Edit
                                        </a>
                                        <form id="delete-form-<?php echo $umkm['id']; ?>" method="POST" style="display: none;">
                                            <input type="hidden" name="hapus_id" value="<?php echo $umkm['id']; ?>">
                                        </form>
                                        <button onclick="confirmDelete(<?php echo $umkm['id']; ?>, '<?php echo htmlspecialchars($umkm['nama'], ENT_QUOTES); ?>')" 
                                                class="bg-red-500 hover:bg-red-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>