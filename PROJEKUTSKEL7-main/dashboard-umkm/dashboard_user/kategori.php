<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$email = $_SESSION['email'];
$umkm_name = $_SESSION['user']['umkm_name'] ?? 'UMKM Saya';
$kategori = $_GET['cat'] ?? 'umum';

function getUmkmByKategori($kategori) {
    include_once '../config/database.php';
    
    // Query untuk mengambil data UMKM berdasarkan kategori
    $stmt = $conn->prepare("
        SELECT u.id, u.nama, u.modal, u.pemilik, u.alamat, u.website, u.email, u.rating, u.kontak
        FROM umkm u
        JOIN kategori_umkm k ON u.kategori_umkm_id = k.id
        WHERE k.nama = :kategori
    ");
    $stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ambil hasil sebagai array
    $umkmList = [];
    foreach ($result as $row) {
        $umkmList[] = $row;
    }

    return $umkmList;
}

$umkmList = getUmkmByKategori($kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori: <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $kategori))); ?> | <?php echo htmlspecialchars($umkm_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font dan Tailwind CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        secondary: {
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        glass: 'rgba(255, 255, 255, 0.6)'
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-blue-50 via-white to-purple-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-primary-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-secondary-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                </svg>
                UMKM<span class="text-secondary-600">ku</span>
            </a>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Hi, <?php echo htmlspecialchars($email); ?></span>
                <a href="../logout.php" class="px-4 py-2 rounded-md font-medium bg-primary-600 text-white hover:bg-primary-700 transition">Logout</a>
            </div>
        </div>
    </header>

    <!-- Konten -->
    <main class="max-w-6xl mx-auto px-4 py-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Kategori: <span class="text-secondary-600"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $kategori))); ?></span></h1>
            <p class="text-gray-600 mt-2">Menampilkan informasi dan UMKM yang tergabung dalam kategori ini.</p>
        </div>

        <!-- Contoh Kartu UMKM -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php if (empty($umkmList)): ?>
                <div class="col-span-full text-center h-screen">
                    <p class="text-gray-600 text-lg">Tidak ada UMKM yang ditemukan dalam kategori ini.</p>
                </div>
            <?php else: ?>
                <?php foreach ($umkmList as $umkm): ?>
                    <div class="glass-card p-6 rounded-xl shadow-md border border-white"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($umkm['nama']); ?></h3>
                        <p class="text-gray-600 mb-2"><strong>Pemilik:</strong> <?php echo htmlspecialchars($umkm['pemilik']); ?></p>
                        <p class="text-gray-600 mb-2"><strong>Alamat:</strong> <?php echo htmlspecialchars($umkm['alamat']); ?></p>
                        <p class="text-gray-600 mb-2"><strong>Rating:</strong> <?php echo htmlspecialchars($umkm['rating']); ?>/5</p>
                        <p class="text-gray-600 mb-4"><strong>Kontak:</strong> <?php echo htmlspecialchars($umkm['kontak']); ?></p>
                        <a href="<?php echo htmlspecialchars($umkm['website']); ?>" target="_blank" class="inline-block px-4 py-2 rounded bg-secondary-600 text-white hover:bg-secondary-700 transition">Kunjungi Website</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6">
        <p>&copy; <?php echo date('Y'); ?> UMKMku. All rights reserved.</p>
    </footer>
</body>
</html>
