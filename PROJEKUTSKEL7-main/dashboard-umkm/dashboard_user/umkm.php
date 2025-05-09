<?php
session_start();

// Cek login dan role user
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['user']['username'];
$umkm_name = $_SESSION['user']['umkm_name'] ?? 'UMKM Saya';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Gunakan struktur head yang sama seperti dashboard/index.php -->
    <title>Manajemen UMKM - <?php echo htmlspecialchars($umkm_name); ?></title>
</head>
<body class="font-sans bg-gray-50">
    <!-- Gunakan header yang sama seperti dashboard/index.php -->
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Manajemen UMKM</h1>
        
        <!-- Konten manajemen UMKM -->
        <div class="bg-white shadow rounded-lg p-6">
            <!-- Form untuk mengelola UMKM -->
        </div>
    </main>
    
    <!-- Gunakan footer yang sama -->
</body>
</html>