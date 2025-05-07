<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';
$kategoriModel = new KategoriModel($conn);
$categories = $kategoriModel->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#213555] shadow-lg transform transition-transform duration-300 ease-in-out translate-x-0 lg:translate-x-0">
        <div class="h-full flex flex-col">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center space-x-2 p-4">
                    <img id="logo" src="img/fafo.png" alt="Logo" class="w-10 h-auto object-contain">
                    <span class="font-bold text-white">UMKM Dashboard</span>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <?php
                // Define navigation items
                $navItems = [
                    ['url' => 'index.php', 'text' => 'Dashboard'],
                    ['url' => 'umkm.php', 'text' => 'Data UMKM'],
                    ['url' => 'kategori.php', 'text' => 'Kategori'],
                    ['url' => 'pembina.php', 'text' => 'Pembina'],
                    ['url' => 'lokasi.php', 'text' => 'Lokasi'],
                    ['url' => 'laporan.php', 'text' => 'Laporan'],
                ];
                
                // Determine current page for active state
                $currentPage = basename($_SERVER['PHP_SELF']);
                
                // Render navigation items
                foreach ($navItems as $item) {
                    $isActive = ($currentPage === $item['url']);
                    $activeClass = $isActive
                        ? 'text-gray-700 bg-gray-100'
                        : 'text-white hover:bg-[#78B3CE]';
                    
                    echo '<a href="' . $item['url'] . '" class="flex items-center px-4 py-3 ' . $activeClass . ' rounded-lg">' . $item['text'] . '</a>';
                }
                ?>
            </nav>
            <div class="px-4 py-6 border-t border-gray-700">
                <a href="logout.php" class="flex items-center px-4 py-3 text-white hover:bg-[#78B3CE] rounded-lg w-full">Logout</a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="ml-64 flex-1 min-h-screen flex flex-col">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori</h1>
                <button class="bg-blue-600 hover:bg-blue-700 transition-colors text-white px-4 py-2 rounded-lg shadow-md">
                    + Tambah Kategori
                </button>
            </div>
        </header>
        <main class="flex-grow container mx-auto px-6 py-8">
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah UMKM</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($categories as $category): ?>
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $category['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $category['nama']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $category['total']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        <button class="bg-green-500 hover:bg-green-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Edit
                                        </button>
                                        <button class="bg-red-500 hover:bg-red-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
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