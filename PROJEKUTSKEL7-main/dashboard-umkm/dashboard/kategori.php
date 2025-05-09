<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';

$kategoriModel = new KategoriModel($conn);

// Handle delete action
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $success = $kategoriModel->deleteKategori($id);
    if ($success) {
        $message = "Kategori berhasil dihapus";
    } else {
        $error = "Gagal menghapus kategori. Mungkin kategori masih digunakan oleh UMKM.";
    }
}

$categories = $kategoriModel->getCategories(2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmDelete(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus kategori "${nama}"?`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function editCategory(id, currentName) {
            const newName = prompt("Edit nama kategori:", currentName);
            if (newName !== null && newName !== currentName && newName.trim() !== '') {
                // Submit the form via AJAX
                fetch('edit_kategori.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&nama=${encodeURIComponent(newName)}`
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.berhasil) {
                        alert("Kategori berhasil diperbarui");
                        location.reload();
                    } else {
                        alert("Gagal memperbarui kategori: " + (data.message || "Terjadi kesalahan"));
                    }
                })
                .catch(error => {
                    console.log(error)
                    alert("Terjadi kesalahan: " + error);
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
                <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori</h1>
                <a href="tambah_kategori.php" class="bg-blue-600 hover:bg-blue-700 transition-colors text-white px-4 py-2 rounded-lg shadow-md">
                    + Tambah Kategori
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($category['nama']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $category['total']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        <button onclick="editCategory(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['nama'], ENT_QUOTES); ?>')" 
                                                class="bg-green-500 hover:bg-green-600 transition-colors text-white px-3 py-1 rounded-md shadow-sm">
                                            Edit
                                        </button>
                                        <form id="delete-form-<?php echo $category['id']; ?>" method="POST" style="display: none;">
                                            <input type="hidden" name="delete_id" value="<?php echo $category['id']; ?>">
                                        </form>
                                        <button onclick="confirmDelete(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['nama'], ENT_QUOTES); ?>')" 
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