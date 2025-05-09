<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';

$kategoriModel = new KategoriModel($conn);

$categories = $kategoriModel->getCategories(2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <?php include 'components/sidebar.php'; ?>

    <div class="flex-1 min-h-screen flex flex-col ml-64"> <!-- Tambahin ml-64 -->
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
