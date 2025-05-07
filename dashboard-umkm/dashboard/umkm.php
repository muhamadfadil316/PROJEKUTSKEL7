<?php
require_once '../config/database.php';
require_once '../models/UMKMModel.php';
require_once '../models/KategoriModel.php';
require_once '../models/LocationModel.php';

$umkmModel = new UMKMModel($conn);
$kategoriModel = new KategoriModel($conn);
$lokasiModel = new LocationModel($conn);

// Get filter parameters
$search = $_GET['search'] ?? '';
$kategoriFilter = $_GET['kategori'] ?? '';
$lokasiFilter = $_GET['lokasi'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;

$umkms = $umkmModel->getFilteredUmkm($search, $kategoriFilter, $lokasiFilter, $page, $perPage);
$totalUmkms = $umkmModel->countFilteredUmkm($search, $kategoriFilter, $lokasiFilter);
$kategories = $kategoriModel->getAllKategori();
$lokasis = $lokasiModel->getAllLokasi();

$totalPages = ceil($totalUmkms / $perPage);
$prevPage = ($page > 1) ? $page - 1 : null;
$nextPage = ($page < $totalPages) ? $page + 1 : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 w-64 bg-[#213555] shadow-lg">
    <div class="p-6 text-white font-bold text-lg flex items-center space-x-2">
        <img src="img/fafo.png" alt="Logo" class="w-10">
        <span>UMKM Dashboard</span>
    </div>
    <nav class="px-4">
        <?php
        $navItems = [
            ['url' => 'index.php', 'text' => 'Dashboard', 'icon' => 'fas fa-home'],
            ['url' => 'umkm.php', 'text' => 'Data UMKM', 'icon' => 'fas fa-store'],
            ['url' => 'kategori.php', 'text' => 'Kategori', 'icon' => 'fas fa-tags'],
            ['url' => 'pembina.php', 'text' => 'Pembina', 'icon' => 'fas fa-users'],
            ['url' => 'lokasi.php', 'text' => 'Lokasi', 'icon' => 'fas fa-map-marker-alt'],
            ['url' => 'laporan.php', 'text' => 'Laporan', 'icon' => 'fas fa-file-alt'],
        ];
        $currentPage = basename($_SERVER['PHP_SELF']);
        foreach ($navItems as $item) {
            $isActive = ($currentPage === $item['url']) ? 'bg-gray-100 text-gray-800' : 'text-white hover:bg-[#78B3CE]';
            echo "<a href='{$item['url']}' class='flex items-center px-4 py-3 rounded-lg {$isActive}'>
                    <i class='{$item['icon']} mr-3'></i>{$item['text']}
                  </a>";
        }
        ?>
        <a href="logout.php" class="flex items-center px-4 py-3 text-white hover:bg-[#78B3CE] rounded-lg mt-4">
            <i class="fas fa-sign-out-alt mr-3"></i> Logout
        </a>
    </nav>
</aside>

<!-- Main Content -->
<div class="ml-64 p-6">
    <header class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data UMKM</h1>
        <a href="tambah_umkm.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah UMKM
        </a>
    </header>

    <!-- Filter Form -->
    <form method="GET" action="umkm.php" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari UMKM..."
               class="px-4 py-2 border rounded w-full sm:w-64">
        <select name="kategori" class="px-4 py-2 border rounded w-full sm:w-48">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategories as $k): ?>
                <option value="<?= $k['id'] ?>" <?= $kategoriFilter == $k['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="lokasi" class="px-4 py-2 border rounded w-full sm:w-48">
            <option value="">Semua Lokasi</option>
            <?php foreach ($lokasis as $l): ?>
                <option value="<?= $l['id'] ?>" <?= $lokasiFilter == $l['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($l['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
    </form>

    <!-- UMKM Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <?php if (empty($umkms)): ?>
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-store-slash text-4xl mb-4"></i><br>
                Tidak ada data UMKM ditemukan.
            </div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Nama UMKM</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($umkms as $umkm): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm"><?= htmlspecialchars($umkm['id']) ?></td>
                            <td class="px-6 py-4 text-sm font-medium"><?= htmlspecialchars($umkm['nama']) ?></td>
                            <td class="px-6 py-4 text-sm"><?= htmlspecialchars($umkm['kategori_nama']) ?></td>
                            <td class="px-6 py-4 text-sm"><?= htmlspecialchars($umkm['pemilik']) ?></td>
                            <td class="px-6 py-4 text-sm"><?= htmlspecialchars($umkm['lokasi_nama']) ?></td>
                            <td class="px-6 py-4 text-sm">
                                <a href="tel:<?= htmlspecialchars($umkm['kontak']) ?>" class="text-blue-600 hover:underline">
                                    <?= htmlspecialchars($umkm['kontak']) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?php if ($umkm['status'] === 'Aktif'): ?>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full">Aktif</span>
                                <?php else: ?>
                                    <span class="bg-red-100 text-red-800 px-2 py-1 text-xs rounded-full">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-1">
                                <a href="detail_umkm.php?id=<?= $umkm['id'] ?>" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="edit_umkm.php?id=<?= $umkm['id'] ?>" class="bg-yellow-400 text-white px-2 py-1 rounded text-xs">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_umkm.php?id=<?= $umkm['id'] ?>" onclick="return confirm('Yakin ingin menghapus UMKM ini?');"
                                   class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalUmkms > 0): ?>
        <div class="mt-6 flex justify-between items-center text-sm">
            <div>
                Menampilkan <?= (($page - 1) * $perPage) + 1 ?> - <?= min($page * $perPage, $totalUmkms) ?> dari <?= $totalUmkms ?> data
            </div>
            <div class="flex space-x-1">
                <?php
                $query = $_GET;
                $query['page'] = 1;
                $first = http_build_query($query);
                $query['page'] = $prevPage;
                $prev = http_build_query($query);
                $query['page'] = $nextPage;
                $next = http_build_query($query);
                $query['page'] = $totalPages;
                $last = http_build_query($query);
                ?>
                <a href="?<?= $first ?>" class="px-2 py-1 border rounded <?= !$prevPage ? 'opacity-50 cursor-not-allowed' : '' ?>"><i class="fas fa-angle-double-left"></i></a>
                <a href="?<?= $prev ?>" class="px-2 py-1 border rounded <?= !$prevPage ? 'opacity-50 cursor-not-allowed' : '' ?>"><i class="fas fa-angle-left"></i></a>
                <span class="px-3 py-1"><?= $page ?></span>
                <a href="?<?= $next ?>" class="px-2 py-1 border rounded <?= !$nextPage ? 'opacity-50 cursor-not-allowed' : '' ?>"><i class="fas fa-angle-right"></i></a>
                <a href="?<?= $last ?>" class="px-2 py-1 border rounded <?= !$nextPage ? 'opacity-50 cursor-not-allowed' : '' ?>"><i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
