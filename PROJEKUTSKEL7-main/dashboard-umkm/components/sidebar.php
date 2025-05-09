<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#213555] shadow-lg transform transition-transform duration-300 ease-in-out translate-x-0 lg:translate-x-0">
    <div class="h-full flex flex-col">
        <div class="px-6 py-4 border-b border-gray-700">
            <div class="flex items-center space-x-2 p-4">
                <img id="logo" src="../img/fafo.png" alt="Logo" class="w-10 h-auto object-contain">
                <span class="font-bold text-white">UMKM Dashboard</span>
            </div>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <?php
            // Define navigation items
            $navItems = [
                ['url' => 'index.php', 'text' => 'Dashboard', 'active' => true],
                ['url' => 'umkm.php', 'text' => 'Data UMKM', 'active' => false],
                ['url' => 'kategori.php', 'text' => 'Kategori', 'active' => false],
                ['url' => 'pembina.php', 'text' => 'Pembina', 'active' => false],
                ['url' => 'lokasi.php', 'text' => 'Lokasi', 'active' => false],
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