<?php
include_once '../config/database.php';
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: ../login.php');
    exit;
}

// Data user
$email = $_SESSION['email'] ?? 'Pengguna';
$umkm_name = $_SESSION['user']['umkm_name'] ?? 'UMKM Saya';

$query = "SELECT k.id, k.nama, COUNT(u.id) as jumlah_umkm 
FROM kategori_umkm k 
LEFT JOIN umkm u ON u.kategori_umkm_id = k.id 
GROUP BY k.id, k.nama";
$stmt = $conn->query($query);
$kategori_umkm = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM - <?php echo htmlspecialchars($umkm_name); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.9) 0%, rgba(124, 58, 237, 0.9) 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .category-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(124, 58, 237, 0.1) 100%);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px) scale(1.02);
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-icon {
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.2);
        }

        .nav-shadow {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
        }

        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }

        .wave-shape .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Header/Navbar -->
    <header class="bg-white sticky top-0 z-50 nav-shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-primary-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-secondary-600"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                        <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary-600">UMKM</span><span
                            class="text-secondary-600">ku</span>
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    <span class="hidden md:inline text-gray-700 font-medium">Selamat datang,
                        <?php echo htmlspecialchars($email); ?></span>
                    <div
                        class="w-10 h-10 rounded-full user-avatar text-white flex items-center justify-center font-bold shadow-md">
                        <?php echo strtoupper(substr($email, 0, 1)); ?>
                    </div>
                    <a href="../logout.php"
                        class="hidden md:block px-4 py-2 rounded-lg font-medium border border-primary-600 text-primary-600 hover:bg-primary-50 transition hover:shadow-md">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                    <button class="md:hidden text-gray-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative hero-gradient text-white pt-16 pb-32">
        <div class="wave-shape">

        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 pt-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Dashboard <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-yellow-500"><?php echo htmlspecialchars($umkm_name); ?></span>
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">Kelola UMKM Anda dengan lebih mudah dan efisien
                    menggunakan platform kami</p>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                    <div class="stats-card p-4 text-center">
                        <div class="text-2xl font-bold text-primary-600">24</div>
                        <div class="text-sm text-gray-600">Produk</div>
                    </div>
                    <div class="stats-card p-4 text-center">
                        <div class="text-2xl font-bold text-secondary-600">156</div>
                        <div class="text-sm text-gray-600">Pelanggan</div>
                    </div>
                    <div class="stats-card p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">Rp12.5jt</div>
                        <div class="text-sm text-gray-600">Pendapatan</div>
                    </div>
                    <div class="stats-card p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">8.9</div>
                        <div class="text-sm text-gray-600">Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-20">
        <!-- Features Section -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Fitur Unggulan Kami</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-primary-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Analisis Bisnis</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Pantau perkembangan bisnis Anda dengan grafik dan analisis real-time
                        untuk pengambilan keputusan yang lebih baik.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-boxes text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Manajemen Produk</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Kelola katalog produk dengan mudah, termasuk stok, harga, dan
                        deskripsi produk secara terpusat.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Manajemen Pelanggan</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Simpan data pelanggan dan riwayat transaksi untuk membangun hubungan
                        yang lebih baik dengan pelanggan.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-file-invoice-dollar text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Pembuatan Faktur</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Buat faktur profesional dalam hitungan detik dan kirim langsung ke
                        email pelanggan Anda.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-bullhorn text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Pemasaran Digital</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Alat pemasaran siap pakai untuk membantu Anda menjangkau lebih banyak
                        pelanggan potensial.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-mobile-alt text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Aplikasi Mobile</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Kelola bisnis Anda dari mana saja dengan aplikasi mobile kami yang
                        responsif dan mudah digunakan.</p>
                    <a href="#"
                        class="text-primary-600 font-medium inline-flex items-center hover:text-primary-800 transition">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Kategori UMKM</h2>
                <a href="#" class="text-primary-600 font-medium hover:text-primary-800 transition">Lihat semua <i
                        class="fas fa-chevron-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php if (!empty($kategori_umkm)): ?>
                    <?php foreach ($kategori_umkm as $kategori): ?>
                        <div class="category-card p-6 text-center cursor-pointer"
                            onclick="window.location.href='kategori.php?cat=<?= urlencode(strtolower(str_replace('/', '-', $kategori['nama']))) ?>'">
                            <div class="category-icon text-4xl mb-3">
                                <?= $kategori_emoji[$kategori['nama']] ?? '🏷️' ?>
                            </div>
                            <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($kategori['nama']) ?></h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <?= htmlspecialchars($kategori['jumlah_umkm']) ?> UMKM
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 col-span-full">Tidak ada kategori UMKM yang tersedia.</p>
                <?php endif; ?>
        </section>

        <!-- Recent Activity Section -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800">Aktivitas Terkini</h2>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    <!-- Recent Orders -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-lg text-gray-800">Pesanan Terbaru</h3>
                            <span class="text-xs bg-primary-100 text-primary-800 px-2 py-1 rounded-full">5 baru</span>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-shopping-bag text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Pesanan #1256</p>
                                    <p class="text-sm text-gray-500">Rp 450.000 • 2 produk</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-shopping-bag text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Pesanan #1255</p>
                                    <p class="text-sm text-gray-500">Rp 1.250.000 • 5 produk</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Lihat semua pesanan <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Recent Customers -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-lg text-gray-800">Pelanggan Baru</h3>
                            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">3 baru</span>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-purple-100 text-purple-800 flex items-center justify-center font-bold mr-3">
                                    A
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Andi Wijaya</p>
                                    <p class="text-sm text-gray-500">andi@email.com</p>
                                </div>
                            </li>
                            <li class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center font-bold mr-3">
                                    S
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Siti Rahayu</p>
                                    <p class="text-sm text-gray-500">siti@email.com</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Lihat semua pelanggan <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Recent Products -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-lg text-gray-800">Produk Populer</h3>
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">2 baru</span>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-box-open text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Kursi Kayu Jati</p>
                                    <p class="text-sm text-gray-500">Terjual 45x • Stok 12</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-box-open text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Meja Makan Minimalis</p>
                                    <p class="text-sm text-gray-500">Terjual 28x • Stok 5</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#"
                            class="mt-4 inline-flex items-center text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Lihat semua produk <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-xl font-bold mb-4">UMKMku</h3>
                    <p class="text-gray-400">Platform manajemen UMKM terintegrasi untuk membantu bisnis Anda tumbuh dan
                        berkembang.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Perusahaan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Produk</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Harga</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Integrasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pembaruan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Komunitas</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Webinar</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Dukungan</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">&copy; <?php echo date('Y'); ?> UMKMku. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

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
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        },
                        gradient: {
                            start: '#4f46e5',
                            end: '#7c3aed',
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>