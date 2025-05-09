<?php
// Database connection
require_once '../config/database.php';
require_once '../models/UmkmModel.php';
require_once '../models/KategoriModel.php';
require_once '../models/PembinaModel.php';
require_once '../models/LocationModel.php';

// Initialize models
$umkmModel = new UmkmModel($conn);
$kategoriModel = new KategoriModel($conn);
$pembinaModel = new PembinaModel($conn);
$locationModel = new LocationModel($conn);

// Get dashboard statistics
$totalUmkm = $umkmModel->countAll();
$activePemilik = $umkmModel->countUniquePemilik();
$availableCategories = $kategoriModel->countAll();
$monthlyRevenue = $umkmModel->calculateTotalModal();

// Get latest UMKM listings
$latestUmkm = $umkmModel->getLatestUmkm(3);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM</title>
    <link href="assets/img/logo.png" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <div class="lg:pl-64">
            <!-- Header -->
            <?php include '../components/header.php'; ?>

            <main class="p-6 space-y-4">
                <!-- Stat Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total UMKM Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm">Total UMKM</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-building2 h-6 w-6 text-blue-500">
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                <path d="M10 6h4"></path>
                                <path d="M10 10h4"></path>
                                <path d="M10 14h4"></path>
                                <path d="M10 18h4"></path>
                            </svg>
                        </div>
                        <p id="total-umkm" class="text-2xl font-semibold mt-2"><?php echo $totalUmkm; ?></p>
                        <p class="text-green-500 text-sm mt-2">+2.5% dari bulan sebelumnya</p>
                    </div>

                    <!-- Pemilik UMKM Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm">Pemilik UMKM</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users h-6 w-6 text-blue-500">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <p id="active-tenants" class="text-2xl font-semibold mt-2"><?php echo $activePemilik; ?></p>
                        <p class="text-green-500 text-sm mt-2">+4.3% dari bulan sebelumnya</p>
                    </div>

                    <!-- Kategori UMKM Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm">Kategori UMKM</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layout-grid h-6 w-6 text-blue-500">
                                <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                                <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                            </svg>
                        </div>
                        <p id="available-categories" class="text-2xl font-semibold mt-2">
                            <?php echo $availableCategories; ?></p>
                        <p class="text-blue-500 text-sm mt-2">Total kategori terdaftar</p>
                    </div>

                    <!-- Modal UMKM Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-gray-500 text-sm">Total Modal UMKM</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-wallet h-6 w-6 text-blue-500">
                                <path
                                    d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1">
                                </path>
                                <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"></path>
                            </svg>
                        </div>
                        <p id="monthly-revenue" class="text-2xl font-semibold mt-2">Rp
                            <?php echo number_format($monthlyRevenue, 0, ',', '.'); ?></p>
                        <p class="text-green-500 text-sm mt-2">+12.5% dari bulan sebelumnya</p>
                    </div>
                </div>

                <!-- UMKM Modal -->
                <div id="modal-overlay"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div id="modal-content"
                        class="bg-white rounded-lg max-w-2xl w-full mx-4 overflow-y-auto h-[calc(100vh-4rem)] shadow-xl">
                        <div class="p-4 border-b flex justify-between items-center">
                            <h2 id="modal-title" class="text-xl font-semibold"></h2>
                            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-6">
                            <img id="modal-image" src="" alt="UMKM" class="w-full h-64 object-cover rounded-lg">
                            <div class="mt-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold text-gray-600">Lokasi</h3>
                                        <p id="modal-location" class="text-gray-800 text-lg"></p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-600">Modal</h3>
                                        <p id="modal-price" class="text-blue-600 font-semibold text-lg"></p>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-600">Pemilik</h3>
                                    <p id="modal-owner" class="text-gray-800 text-lg"></p>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-600">Rating</h3>
                                    <div id="modal-rating" class="flex items-center mt-1"></div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-600">Kontak</h3>
                                    <p id="modal-contact" class="text-gray-600 mt-1"></p>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-600">Kategori</h3>
                                    <span id="modal-category"
                                        class="inline-block px-3 py-1 rounded-full text-sm mt-1 bg-blue-100 text-blue-800"></span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-600">Alamat</h3>
                                    <p id="modal-address" class="text-gray-600 mt-1"></p>
                                </div>
                                <div class="flex justify-end mt-6">
                                    <button onclick="closeModal()"
                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest UMKM Listings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h2 class="text-lg font-semibold">Daftar UMKM Terbaru</h2>
                        <a href="umkm.php" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="listings-container">
                            <?php foreach ($latestUmkm as $umkm): ?>
                                <div class="bg-white border rounded-lg overflow-hidden cursor-pointer transform transition-all duration-300 hover:scale-105 hover:shadow-lg"
                                    onclick="openModal(<?php echo htmlspecialchars(json_encode($umkm)); ?>)">
                                    <img src="../img/fashion.png"
                                        alt="<?php echo htmlspecialchars($umkm['nama']); ?>"
                                        class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($umkm['nama']); ?>
                                        </h3>
                                        <p class="text-gray-500 text-sm mt-1">
                                            <?php echo htmlspecialchars($umkm['lokasi']); ?></p>
                                        <div class="flex items-center justify-between mt-4">
                                            <span class="text-blue-600 font-semibold">Rp
                                                <?php echo number_format($umkm['modal'], 0, ',', '.'); ?></span>
                                            <div class="flex">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= $umkm['rating']): ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Pembina Panel -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pembina UMKM</h3>
                        <a href="pembina.php" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        $pembinas = $pembinaModel->getPembinas(3);
                        foreach ($pembinas as $pembina):
                            ?>
                            <div class="p-4 bg-gray-50 rounded-lg border flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium text-gray-700"><?php echo htmlspecialchars($pembina['nama']); ?>
                                    </h4>
                                    <p class="text-sm text-gray-500">Keahlian:
                                        <?php echo htmlspecialchars($pembina['keahlian']); ?></p>
                                </div>
                                <button
                                    class="px-3 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Detail</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Kategori UMKM Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Kategori UMKM</h3>
                        <a href="kategori.php" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <ul class="space-y-4">
                        <?php
                        $categories = $kategoriModel->getCategories(2);
                        foreach ($categories as $category):
                            ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-700"><?php echo htmlspecialchars($category['nama']); ?>
                                    </h4>
                                    <p class="text-sm text-gray-500"><?php echo $category['total']; ?> UMKM terdaftar</p>
                                </div>
                                <a href="kategori.php?id=<?php echo $category['id']; ?>"
                                    class="px-3 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                                    Lihat UMKM
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Function to open modal with UMKM details
        function openModal(umkm) {
            const modal = document.getElementById('modal-overlay');

            // Update modal content
            document.getElementById('modal-title').textContent = umkm.nama;
            document.getElementById('modal-image').src = `assets/img/umkm/${umkm.id % 3 + 1}.jpg`;
            document.getElementById('modal-location').textContent = umkm.lokasi;
            document.getElementById('modal-price').textContent = `Rp ${formatNumber(umkm.modal)}`;
            document.getElementById('modal-owner').textContent = umkm.pemilik;
            document.getElementById('modal-address').textContent = umkm.alamat;
            document.getElementById('modal-contact').textContent = `Email: ${umkm.email} | Website: ${umkm.website || '-'}`;
            document.getElementById('modal-category').textContent = umkm.kategori;

            // Generate rating stars
            const ratingElement = document.getElementById('modal-rating');
            ratingElement.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const starColor = i <= umkm.rating ? 'text-yellow-400' : 'text-gray-300';
                ratingElement.innerHTML += `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${starColor}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                `;
            }

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        // Function to close modal
        function closeModal() {
            const modal = document.getElementById('modal-overlay');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Format number with thousand separator
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Close modal when clicking outside
        document.getElementById('modal-overlay').addEventListener('click', (e) => {
            if (e.target === document.getElementById('modal-overlay')) {
                closeModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Logo animation on scroll
        window.addEventListener("scroll", () => {
            const logo = document.getElementById("logo");
            if (window.scrollY > 50) {
                logo.classList.add("w-8");
                logo.classList.remove("w-10");
            } else {
                logo.classList.add("w-10");
                logo.classList.remove("w-8");
            }
        });
    </script>
</body>

</html>