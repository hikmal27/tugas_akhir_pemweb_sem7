<?php
// Simulasi data dari database
// Ganti dengan query database yang sebenarnya

// Total User
$total_users = 150; // SELECT COUNT(*) FROM users

// Total Item
$total_items = 450; // SELECT COUNT(*) FROM items

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
            <p class="text-gray-600 mt-1">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['username']); ?>! 👋</p>
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

        <!-- Total Transaksi -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo number_format($total_transactions); ?></h3>
                    <p class="text-purple-100 text-xs mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>+15% dari bulan lalu
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></h3>
                    <p class="text-orange-100 text-xs mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>+20% dari bulan lalu
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Penjualan -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-chart-line text-green-600 mr-2"></i>
                    Penjualan Minggu Ini
                </h2>
                <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            
            <div class="space-y-4">
                <?php 
                $max_value = max($sales_data);
                foreach ($sales_data as $day => $value): 
                    $percentage = ($value / $max_value) * 100;
                ?>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700"><?php echo $day; ?></span>
                        <span class="text-sm font-bold text-green-600">Rp <?php echo number_format($value, 0, ',', '.'); ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-500 shadow-md" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-between">
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Minggu Ini</p>
                    <p class="text-xl font-bold text-gray-800">Rp <?php echo number_format(array_sum($sales_data), 0, ',', '.'); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Rata-rata/Hari</p>
                    <p class="text-xl font-bold text-gray-800">Rp <?php echo number_format(array_sum($sales_data) / count($sales_data), 0, ',', '.'); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Hari Tertinggi</p>
                    <p class="text-xl font-bold text-green-600"><?php echo array_search(max($sales_data), $sales_data); ?></p>
                </div>
            </div>
        </div>

        <!-- Item Terlaris -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-fire text-orange-500 mr-2"></i>
                Item Terlaris
            </h2>
            
            <div class="space-y-4">
                <?php foreach ($top_items as $index => $item): ?>
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold">
                        <?php echo $index + 1; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($item['name']); ?></p>
                        <p class="text-xs text-gray-500">Terjual: <?php echo $item['sold']; ?> unit</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-green-600">Rp <?php echo number_format($item['revenue'] / 1000); ?>k</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <a href="?page=item" class="mt-6 block text-center py-3 bg-green-50 text-green-600 rounded-lg font-semibold hover:bg-green-100 transition">
                Lihat Semua Item <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-clock text-blue-600 mr-2"></i>
                Aktivitas Terbaru
            </h2>
            <a href="#" class="text-sm text-green-600 hover:text-green-700 font-semibold">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="space-y-4">
            <?php foreach ($recent_activities as $activity): ?>
            <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-<?php echo $activity['color']; ?>-100 flex items-center justify-center">
                    <i class="fas fa-<?php echo $activity['icon']; ?> text-<?php echo $activity['color']; ?>-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">
                        <?php echo htmlspecialchars($activity['user']); ?>
                    </p>
                    <p class="text-sm text-gray-600">
                        <?php echo htmlspecialchars($activity['action']); ?>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="fas fa-clock mr-1"></i><?php echo $activity['time']; ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="?page=tambah-item" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition flex items-center space-x-3 group">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition">
                <i class="fas fa-plus text-green-600 group-hover:text-white transition"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Tambah Item</p>
                <p class="text-xs text-gray-500">Item baru</p>
            </div>
        </a>

        <a href="?page=tambah-user" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition flex items-center space-x-3 group">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-600 transition">
                <i class="fas fa-user-plus text-blue-600 group-hover:text-white transition"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Tambah User</p>
                <p class="text-xs text-gray-500">User baru</p>
            </div>
        </a>

        <a href="?page=item" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition flex items-center space-x-3 group">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">
                <i class="fas fa-box text-purple-600 group-hover:text-white transition"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Kelola Item</p>
                <p class="text-xs text-gray-500">Lihat semua item</p>
            </div>
        </a>

        <a href="?page=user" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition flex items-center space-x-3 group">
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center group-hover:bg-orange-600 transition">
                <i class="fas fa-users text-orange-600 group-hover:text-white transition"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Kelola User</p>
                <p class="text-xs text-gray-500">Lihat semua user</p>
            </div>
        </a>
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