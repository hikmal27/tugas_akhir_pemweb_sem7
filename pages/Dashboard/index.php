<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/services/UserService.php';
require_once __DIR__ . '/../../includes/services/ItemService.php';

$pdo = DatabaseConfig::getConnection();
$userService = new UserService($pdo);
$itemService = new ItemService($pdo);

// Total User
$total_users = $userService->countAll();

// Total Item
$total_items = $itemService->countAll();

// Total Transaksi
$total_transactions = 1250; // SELECT COUNT(*) FROM transactions

// Total Pendapatan
$total_revenue = 25750000; // SELECT SUM(total) FROM transactions

// Data untuk chart penjualan minggu ini
$sales_data = [
    'Senin' => 3500000,
    'Selasa' => 4200000,
    'Rabu' => 3800000,
    'Kamis' => 5100000,
    'Jumat' => 4700000,
    'Sabtu' => 6200000,
    'Minggu' => 5500000
];

// Item terlaris (top 5)
$top_items = [
    ['name' => 'Laptop ASUS ROG', 'sold' => 45, 'revenue' => 67500000],
    ['name' => 'Mouse Logitech MX', 'sold' => 120, 'revenue' => 12000000],
    ['name' => 'Keyboard Mechanical', 'sold' => 85, 'revenue' => 8500000],
    ['name' => 'Monitor LG 27"', 'sold' => 32, 'revenue' => 16000000],
    ['name' => 'Webcam HD', 'sold' => 78, 'revenue' => 7800000]
];

// Aktivitas terbaru
$recent_activities = [
    ['user' => 'John Doe', 'action' => 'Membeli Laptop ASUS ROG', 'time' => '5 menit yang lalu', 'icon' => 'shopping-cart', 'color' => 'green'],
    ['user' => 'Jane Smith', 'action' => 'Menambahkan produk baru', 'time' => '15 menit yang lalu', 'icon' => 'plus-circle', 'color' => 'blue'],
    ['user' => 'Bob Johnson', 'action' => 'Mengupdate stok item', 'time' => '30 menit yang lalu', 'icon' => 'edit', 'color' => 'yellow'],
    ['user' => 'Alice Brown', 'action' => 'Membeli Mouse Logitech', 'time' => '1 jam yang lalu', 'icon' => 'shopping-cart', 'color' => 'green'],
    ['user' => 'Charlie Wilson', 'action' => 'Registrasi user baru', 'time' => '2 jam yang lalu', 'icon' => 'user-plus', 'color' => 'purple']
];
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Tanggal: <?php echo date('d F Y'); ?></p>
            <p class="text-sm text-gray-500">Waktu: <span id="current-time"><?php echo date('H:i:s'); ?></span></p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total User -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total User</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo number_format($total_users); ?></h3>
                    <p class="text-blue-100 text-xs mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>+12% dari bulan lalu
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Item -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Item</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo number_format($total_items); ?></h3>
                    <p class="text-green-100 text-xs mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>+8% dari bulan lalu
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-box text-3xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk update waktu real-time -->
<script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }
    
    // Update setiap detik
    setInterval(updateTime, 1000);
    updateTime();
</script>