<?php
session_start();

$loggedIn = isset($_SESSION['user']);
$userRole = $loggedIn && isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : null;
?>

<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UMKMku - Manajemen UMKM Terpadu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex-shrink-0">
          <a href="#" class="text-2xl font-bold text-indigo-600">UMKMku</a>
        </div>

        <nav class="hidden md:flex space-x-6 items-center">
          <a href="#beranda" class="text-gray-700 hover:text-indigo-600 transition">Beranda</a>
          <a href="#fitur" class="text-gray-700 hover:text-indigo-600 transition">Fitur</a>
          <a href="#tentang" class="text-gray-700 hover:text-indigo-600 transition">Tentang</a>
          <a href="#kontak" class="text-gray-700 hover:text-indigo-600 transition">Kontak</a>
          <?php if ($loggedIn): ?>
            <?php if ($userRole == "admin"): ?>
              <a href="/dashboard/index.php" class="text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
            <?php elseif ($userRole == "user"): ?>
              <a href="form_umkm.php" class="text-gray-700 hover:text-indigo-600 transition">Buat UMKM</a>
            <?php endif; ?>
            <a href="logout.php" class="text-gray-700 hover:text-indigo-600 transition">Logout</a>
          <?php else: ?>
            <a href="login.php" class="text-gray-700 hover:text-indigo-600 transition">Login</a>
            <a href="daftar.php"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition">Daftar</a>
          <?php endif; ?>
        </nav>

        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
      <a href="#beranda" class="block py-2 text-gray-700 hover:text-indigo-600">Beranda</a>
      <a href="#fitur" class="block py-2 text-gray-700 hover:text-indigo-600">Fitur</a>
      <a href="#tentang" class="block py-2 text-gray-700 hover:text-indigo-600">Tentang</a>
      <a href="#kontak" class="block py-2 text-gray-700 hover:text-indigo-600">Kontak</a>
      <?php if ($loggedIn): ?>
        <?php if ($userRole == "admin"): ?>
          <a href="dashboard.php" class="block py-2 text-gray-700 hover:text-indigo-600">Dashboard</a>
        <?php elseif ($userRole == "user"): ?>
          <a href="form_umkm.php" class="block py-2 text-gray-700 hover:bg-indigo-600">Buat UMKM</a>
        <?php endif; ?>
        <a href="logout.php" class="block py-2 text-gray-700 hover:text-indigo-600">Logout</a>
      <?php else: ?>
        <a href="login.php" class="block py-2 text-gray-700 hover:text-indigo-600">Login</a>
        <a href="daftar.php" class="block py-2 text-indigo-600 font-semibold">Daftar</a>
      <?php endif; ?>
    </div>

    <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    </script>
  </header>

  <!-- Hero -->
  <section class="bg-gradient-to-r from-teal-500 to-blue-600 text-white py-20 px-6">
    <div class="max-w-6xl mx-auto text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">UMKMku</h1>
      <p class="text-xl md:text-2xl mb-6">Platform Digital untuk Manajemen dan Pendataan UMKM</p>
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="py-20 bg-white px-6">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Fitur Utama</h2>
      <p class="text-gray-600">Solusi lengkap untuk pendataan dan pengelolaan UMKM daerah</p>
    </div>

    <div class="grid md:grid-cols-4 gap-8 max-w-6xl mx-auto">
      <!-- Kategori UMKM -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-pink-500 mb-4">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-0.553 1.894L15 20m-6 0v-4a2 2 0 014 0v4" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Kategori UMKM</h3>
        <p class="text-gray-600">Kelompokkan usaha berdasarkan sektor: Kuliner, Fashion, Kerajinan, dll.</p>
      </div>

      <!-- Lokasi -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-green-500 mb-4">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 10c-4.418 0-8-4-8-8 0-4.418 3.582-8 8-8s8 3.582 8 8c0 4-3.582 8-8 8z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Lokasi UMKM</h3>
        <p class="text-gray-600">Identifikasi dan pantau UMKM berdasarkan kecamatan atau desa.</p>
      </div>

      <!-- Pembina UMKM -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-blue-500 mb-4">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M5.121 17.804A6.978 6.978 0 0112 15a6.978 6.978 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Data Pembina</h3>
        <p class="text-gray-600">Kelola informasi pembina atau pendamping UMKM secara terstruktur.</p>
      </div>

      <!-- Data UMKM -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-yellow-500 mb-4">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 7v13h18V7H3zm3 3h12v7H6v-7zM16 3h-1V1H9v2H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Profil UMKM</h3>
        <p class="text-gray-600">Lihat dan kelola profil lengkap tiap pelaku usaha yang tergabung.</p>
      </div>
    </div>
  </section>

  <!-- Tentang Kami -->
  <section id="tentang" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-indigo-600 mb-4">Tentang UMKMku</h2>
      <p class="text-gray-600 text-lg max-w-3xl mx-auto">
        UMKMku adalah platform digital yang dirancang untuk membantu manajemen dan pengembangan Usaha Mikro, Kecil, dan
        Menengah (UMKM) di seluruh Indonesia. Kami menyediakan akses informasi, pembinaan, dan pendataan berbasis lokasi
        untuk mendukung pertumbuhan UMKM lokal.
      </p>

      <div class="mt-10 grid md:grid-cols-3 gap-8 text-left">
        <div>
          <h3 class="text-xl font-semibold text-indigo-500 mb-2">Visi</h3>
          <p class="text-gray-600">
            Menjadi platform utama pendukung UMKM untuk berkembang secara digital, inklusif, dan berdaya saing tinggi.
          </p>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-indigo-500 mb-2">Misi</h3>
          <p class="text-gray-600">
            Memberikan kemudahan akses data, pembinaan berkelanjutan, dan jangkauan pemasaran bagi pelaku UMKM di
            Indonesia.
          </p>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-indigo-500 mb-2">Nilai Kami</h3>
          <p class="text-gray-600">
            Kolaborasi, inovasi, dan pemberdayaan masyarakat lokal adalah inti dari setiap langkah yang kami ambil.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Kontak Kami -->
  <section id="kontak" class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-indigo-600 mb-4">Hubungi Kami</h2>
      <p class="text-gray-600 text-lg mb-10">
        Ingin bekerja sama, bertanya, atau memberikan masukan? Jangan ragu untuk menghubungi kami!
      </p>

      <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
        <div class="md:col-span-2">
          <input type="text" name="nama" placeholder="Nama Lengkap"
            class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required>
        </div>
        <div>
          <input type="email" name="email" placeholder="Email"
            class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required>
        </div>
        <div>
          <input type="text" name="subjek" placeholder="Subjek"
            class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required>
        </div>
        <div class="md:col-span-2">
          <textarea name="pesan" rows="5" placeholder="Pesan"
            class="w-full border border-gray-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required></textarea>
        </div>
        <div class="md:col-span-2 text-center">
          <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-md hover:bg-indigo-700 transition">
            Kirim Pesan
          </button>
        </div>
      </form>
    </div>
  </section>



  <!-- CTA -->
  <section class="bg-gradient-to-r from-teal-500 to-blue-600 text-white py-16 px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">Yuk, Bangun Ekonomi Bersama UMKM</h2>
    <p class="mb-6 text-lg">Daftarkan UMKM kamu hari ini dan nikmati fitur manajemen terintegrasi.</p>
    <a href="#"
      class="bg-white text-indigo-600 px-6 py-3 rounded-full font-semibold shadow hover:bg-gray-100 transition">Daftar
      Sekarang</a>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 text-center text-sm">
    <p>&copy; 2025 UMKMku. Dibuat dengan ❤️ untuk pelaku usaha Indonesia.</p>
  </footer>

</body>

</html>