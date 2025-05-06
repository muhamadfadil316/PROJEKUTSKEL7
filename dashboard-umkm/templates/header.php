<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="logo.png" alt="Logo" class="h-8 w-8 mr-2"> <!-- Ganti dengan path logo Anda -->
                <span class="text-xl font-bold">Dashboard UMKM</span>
            </div>
            <div class="space-x-4">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="profile.php" class="hover:underline">Profile</a>
                <a href="logout.php" class="hover:underline">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="flex container mx-auto my-6">
        <!-- Sidebar Navigasi -->
        <aside class="w-1/4 bg-white shadow-md rounded-lg p-4">
            <h2 class="font-bold text-lg mb-4">Navigasi</h2>
            <ul class="space-y-2">
                <li>
                    <a href="products.php" class="block p-2 rounded hover:bg-blue-500 hover:text-white">Produk</a>
                </li>
                <li>
                    <a href="reports.php" class="block p-2 rounded hover:bg-blue-500 hover:text-white">Laporan</a>
                </li>
                <li>
                    <a href="orders.php" class="block p-2 rounded hover:bg-blue-500 hover:text-white">Pesanan</a>
                </li>
                <li>
                    <a href="customers.php" class="block p-2 rounded hover:bg-blue-500 hover:text-white">Pelanggan</a>
                </li>
                <li>
                    <a href="settings.php" class="block p-2 rounded hover:bg-blue-500 hover:text-white">Pengaturan</a>
                </li>
            </ul>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 bg-white shadow-md rounded-lg p-4 ml-4">
            <h2 class="font-bold text-xl mb-4">Selamat Datang di Dashboard UMKM</h2>
            <p>Ini adalah tempat Anda dapat mengelola semua aspek bisnis Anda.</p>
            <!-- Konten dashboard akan ditampilkan di sini -->
        </main>
    </div>
</body>
</html>