<?php
session_start();

$loggedIn = isset($_SESSION['user']);
$userRole = $loggedIn && isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UMKMku - Solusi Digital untuk UMKM Indonesia</title>
  <meta name="description" content="Platform manajemen dan pendataan UMKM terintegrasi untuk pengembangan usaha kecil dan menengah">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
              50: '#f5f3ff',
              100: '#ede9fe',
              200: '#ddd6fe',
              300: '#c4b5fd',
              400: '#a78bfa',
              500: '#8b5cf6',
              600: '#7c3aed',
              700: '#6d28d9',
              800: '#5b21b6',
              900: '#4c1d95',
            },
          }
        }
      }
    }
  </script>
  <style>
    .hero-gradient {
      background: linear-gradient(135deg, #0ea5e9 0%, #7c3aed 100%);
    }
    .feature-card {
      transition: all 0.3s ease;
      background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .stats-item {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }
    .testimonial-card {
      background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    }
    .cta-gradient {
      background: linear-gradient(135deg, #0ea5e9 0%, #7c3aed 100%);
    }
  </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased">
  <!-- Navigation -->
  <header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <div class="flex-shrink-0 flex items-center">
          <a href="#" class="text-2xl font-bold text-primary-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-secondary-600" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
            </svg>
            UMKM<span class="text-secondary-600">ku</span>
          </a>
        </div>

        <nav class="hidden md:flex space-x-8 items-center">
          <a href="#beranda" class="text-gray-700 hover:text-primary-600 transition font-medium">Beranda</a>
          <a href="#fitur" class="text-gray-700 hover:text-primary-600 transition font-medium">Fitur</a>
          <a href="#keunggulan" class="text-gray-700 hover:text-primary-600 transition font-medium">Keunggulan</a>
          <a href="#testimoni" class="text-gray-700 hover:text-primary-600 transition font-medium">Testimoni</a>
          <a href="#kontak" class="text-gray-700 hover:text-primary-600 transition font-medium">Kontak</a>
          <?php if ($loggedIn): ?>
            <?php if ($userRole == "admin"): ?>
              <a href="/dashboard/index.php" class="text-gray-700 hover:text-primary-600 transition font-medium">Dashboard</a>
            <?php elseif ($userRole == "user"): ?>
              <a href="form_umkm.php" class="text-gray-700 hover:text-primary-600 transition font-medium">Buat UMKM</a>
            <?php endif; ?>
            <a href="logout.php" class="px-4 py-2 rounded-md font-medium border border-primary-600 text-primary-600 hover:bg-primary-50 transition">Logout</a>
          <?php else: ?>
            <a href="login.php" class="text-gray-700 hover:text-primary-600 transition font-medium">Login</a>
            <a href="daftar.php" class="bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white px-6 py-2 rounded-md font-medium transition shadow-md">Daftar Gratis</a>
          <?php endif; ?>
        </nav>

        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 bg-white shadow-lg">
      <div class="pt-2 pb-3 space-y-1">
        <a href="#beranda" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Beranda</a>
        <a href="#fitur" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Fitur</a>
        <a href="#keunggulan" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Keunggulan</a>
        <a href="#testimoni" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Testimoni</a>
        <a href="#kontak" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Kontak</a>
        <?php if ($loggedIn): ?>
          <?php if ($userRole == "admin"): ?>
            <a href="dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Dashboard</a>
          <?php elseif ($userRole == "user"): ?>
            <a href="form_umkm.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Buat UMKM</a>
          <?php endif; ?>
          <a href="logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Logout</a>
        <?php else: ?>
          <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50">Login</a>
          <a href="daftar.php" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gradient-to-r from-primary-600 to-secondary-600">Daftar Gratis</a>
        <?php endif; ?>
      </div>
    </div>

    <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    </script>
  </header>

  <!-- Hero Section -->
  <section id="beranda" class="hero-gradient text-white py-24 px-6">
    <div class="max-w-7xl mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">Tingkatkan Bisnis UMKM Anda dengan Solusi Digital</h1>
          <p class="text-xl mb-8 text-primary-100 max-w-lg">Platform terintegrasi untuk manajemen, pemasaran, dan pendataan UMKM. Dapatkan akses ke berbagai fitur yang akan membantu bisnis Anda berkembang.</p>
          <div class="flex flex-wrap gap-4">
            <a href="<?php echo $loggedIn ? 'form_umkm.php' : 'daftar.php'; ?>" class="bg-white text-primary-600 px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">
              Mulai Sekarang
            </a>
            <a href="#fitur" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:bg-opacity-10 transition transform hover:-translate-y-1">
              Pelajari Fitur
            </a>
          </div>
        </div>
        <div class="flex justify-center">
          <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Hero Image" class="rounded-xl shadow-2xl w-full max-w-md object-cover h-96">
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="bg-white py-16 px-6 shadow-sm">
    <div class="max-w-7xl mx-auto">
      <div class="grid md:grid-cols-4 gap-8">
        <div class="stats-item p-6 rounded-xl text-center border border-gray-100">
          <div class="text-4xl font-bold text-primary-600 mb-2">1.200+</div>
          <div class="text-gray-600">UMKM Terdaftar</div>
        </div>
        <div class="stats-item p-6 rounded-xl text-center border border-gray-100">
          <div class="text-4xl font-bold text-primary-600 mb-2">85+</div>
          <div class="text-gray-600">Kota/Kabupaten</div>
        </div>
        <div class="stats-item p-6 rounded-xl text-center border border-gray-100">
          <div class="text-4xl font-bold text-primary-600 mb-2">24/7</div>
          <div class="text-gray-600">Dukungan Pelanggan</div>
        </div>
        <div class="stats-item p-6 rounded-xl text-center border border-gray-100">
          <div class="text-4xl font-bold text-primary-600 mb-2">99%</div>
          <div class="text-gray-600">Kepuasan Pengguna</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Fitur Section -->
  <section id="fitur" class="py-20 bg-gray-50 px-6">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <span class="text-primary-600 font-semibold">FITUR UNGGULAN</span>
        <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-4">Apa yang Kami Tawarkan</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Platform kami menyediakan berbagai fitur lengkap untuk membantu pengembangan bisnis UMKM Anda</p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Fitur 1 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Pendataan UMKM Terstruktur</h3>
          <p class="text-gray-600">Kelola data UMKM secara terpusat dengan sistem yang terorganisir dan mudah diakses.</p>
        </div>

        <!-- Fitur 2 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Analisis Pasar</h3>
          <p class="text-gray-600">Dapatkan insight pasar dan tren terkini untuk pengambilan keputusan bisnis yang lebih baik.</p>
        </div>

        <!-- Fitur 3 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Laporan Keuangan</h3>
          <p class="text-gray-600">Pantau kesehatan keuangan bisnis Anda dengan laporan yang komprehensif dan real-time.</p>
        </div>

        <!-- Fitur 4 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Manajemen Inventori</h3>
          <p class="text-gray-600">Kelola stok barang dengan sistem yang efisien dan terintegrasi.</p>
        </div>

        <!-- Fitur 5 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Pembayaran Digital</h3>
          <p class="text-gray-600">Sistem pembayaran terintegrasi yang aman dan mudah untuk transaksi bisnis Anda.</p>
        </div>

        <!-- Fitur 6 -->
        <div class="feature-card p-8 rounded-xl shadow-md">
          <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mb-3">Jadwal Pembinaan</h3>
          <p class="text-gray-600">Atur jadwal pembinaan dan pendampingan UMKM dengan sistem yang terprogram.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Keunggulan Section -->
  <section id="keunggulan" class="py-20 bg-white px-6">
    <div class="max-w-7xl mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <span class="text-primary-600 font-semibold">KENAPA MEMILIH KAMI</span>
          <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-6">Solusi Terbaik untuk Pengembangan UMKM</h2>
          <p class="text-gray-600 mb-8">Kami memberikan berbagai keunggulan yang tidak dimiliki oleh platform lainnya, membantu Anda fokus pada pengembangan bisnis.</p>
          
          <div class="space-y-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-md bg-primary-600 text-white">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Antarmuka User-Friendly</h3>
                <p class="mt-1 text-gray-600">Desain yang intuitif dan mudah digunakan bahkan untuk pemula.</p>
              </div>
            </div>
            
            <div class="flex">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-md bg-primary-600 text-white">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Integrasi Lengkap</h3>
                <p class="mt-1 text-gray-600">Semua kebutuhan UMKM dalam satu platform terintegrasi.</p>
              </div>
            </div>
            
            <div class="flex">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-md bg-primary-600 text-white">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Dukungan 24/7</h3>
                <p class="mt-1 text-gray-600">Tim support siap membantu kapan saja Anda membutuhkan.</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="relative">
          <div class="relative rounded-xl overflow-hidden shadow-2xl">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Team Collaboration" class="w-full h-auto">
            <div class="absolute inset-0 bg-primary-600 opacity-20"></div>
          </div>
          <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-lg w-3/4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tingkatkan Penjualan Hingga 200%</h3>
            <p class="text-gray-600 text-sm">UMKM yang menggunakan platform kami mengalami peningkatan penjualan signifikan dalam 3 bulan pertama.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimoni Section -->
  <section id="testimoni" class="py-20 bg-gray-50 px-6">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <span class="text-primary-600 font-semibold">APA KATA MEREKA</span>
        <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-4">Testimoni Pengguna</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Lihat apa yang dikatakan oleh pelaku UMKM tentang pengalaman mereka menggunakan platform kami</p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Testimoni 1 -->
        <div class="testimonial-card p-8 rounded-xl shadow-md">
          <div class="flex items-center mb-6">
            <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Testimoni 1">
            <div>
              <h4 class="font-semibold">Sarah Wijaya</h4>
              <p class="text-gray-500 text-sm">Pemilik Toko Kue</p>
            </div>
          </div>
          <p class="text-gray-600 italic">"Platform ini sangat membantu saya dalam mengelola inventori dan penjualan. Sekarang bisnis saya lebih terorganisir dan penjualan meningkat 40%."</p>
          <div class="flex mt-4 text-yellow-400">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
        
        <!-- Testimoni 2 -->
    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
      <div class="flex items-center mb-6">
        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/men/45.jpg" alt="Budi Santoso">
        <div>
          <h4 class="font-semibold text-gray-800">Budi Santoso</h4>
          <p class="text-sm text-gray-500">Pemilik Usaha Kerajinan</p>
        </div>
      </div>
      <p class="italic text-gray-600">"Sistem pembayaran digitalnya sangat memudahkan transaksi dengan pelanggan. Sekarang saya bisa menerima pembayaran dari mana saja dengan aman."</p>
      <div class="flex mt-4 text-yellow-400">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        <template x-for="i in 5"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="..." /></svg></template>
      </div>
    </div>

    <!-- Testimoni 3 -->
    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
      <div class="flex items-center mb-6">
        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/65.jpg" alt="Lina Marlina">
        <div>
          <h4 class="font-semibold text-gray-800">Lina Marlina</h4>
          <p class="text-sm text-gray-500">Pemilik Kedai Kopi</p>
        </div>
      </div>
      <p class="italic text-gray-600">"Fitur laporan penjualan sangat membantu saya memantau perkembangan usaha setiap hari. Platform ini benar-benar memudahkan pengambilan keputusan."</p>
      <div class="flex mt-4 text-yellow-400">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        <template x-for="i in 5"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="..." /></svg></template>
      </div>
    </div>
  </div>

  
  <!-- CTA Ajak Gabung -->
  <div class="text-center mt-16 bg-indigo-600 text-white py-12 px-6 rounded-2xl shadow-lg">
    <h3 class="text-2xl md:text-3xl font-bold mb-4">Yuk, Bangun Ekonomi Bersama!</h3>
    <p class="mb-6 text-lg">Daftarkan UMKM kamu hari ini dan nikmati fitur manajemen terintegrasi.</p>
    <a href="#" class="inline-block bg-white text-indigo-600 font-semibold px-6 py-3 rounded-full hover:bg-indigo-100 transition">Daftar Sekarang</a>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
  <div class="container mx-auto px-6 md:px-20 grid md:grid-cols-3 gap-12">
    <!-- Brand -->
    <div>
      <h4 class="text-xl font-bold mb-4">UMKMku</h4>
      <p class="text-gray-400 text-sm">Solusi digital untuk UMKM berkembang. Kelola bisnis Anda lebih mudah, aman, dan efisien.</p>
    </div>

    <!-- Link Navigasi -->
    <div>
      <h5 class="font-semibold mb-3">Navigasi</h5>
      <ul class="space-y-2 text-sm text-gray-400">
        <li><a href="#" class="hover:text-white">Beranda</a></li>
        <li><a href="#" class="hover:text-white">Fitur</a></li>
        <li><a href="#" class="hover:text-white">Keunggulan</a></li>
        <li><a href="#" class="hover:text-white">Kontak</a></li>
      </ul>
    </div>

    <!-- Kontak -->
    <div>
      <h5 class="font-semibold mb-3">Hubungi Kami</h5>
      <p class="text-gray-400 text-sm">Email: support@umkmku.id</p>
      <p class="text-gray-400 text-sm">Telepon: +62 812 3456 7890</p>
      <div class="flex mt-4 space-x-4">
        <a href="#" class="hover:text-blue-400">Facebook</a>
        <a href="#" class="hover:text-blue-400">Instagram</a>
        <a href="#" class="hover:text-blue-400">LinkedIn</a>
      </div>
    </div>
  </div>

  <div class="mt-12 text-center text-gray-500 text-sm">
    &copy; 2025 UMKMku. All rights reserved.
  </div>
</footer>

</body>
</html>