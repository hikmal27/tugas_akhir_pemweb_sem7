<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/services/ItemService.php';

$pdo = DatabaseConfig::getConnection();
$itemService = new ItemService($pdo);

$data = [];
try {
    $result = $itemService->findAll();
    $data = $result;
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<div class="">
    <div class="flex justify-between items-center mb-10">
        <h3 class="text-2xl font-bold text-gray-800">Daftar Item</h3>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="?page=dashboard" class="hover:text-blue-600 transition">
                <i class="fas fa-home"></i>
                <span class="ml-1">MyApps</span>
            </a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <a href="?page=items" class="hover:text-blue-600 transition">Item</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <span class="text-gray-800 font-medium">Index</span>
        </div>
    </div>

    <a href="?page=tambah-item">
        <section class="max-w-max bg-green-600/10 text-green-600 hover:bg-green-600/30 px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah Item
        </section>
    </a>

    <section class="mt-5">
        <table>
            <thead class="bg-gray-50 border-b border-gray-200">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Rak</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php foreach($data as $index => $item): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['code'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['item_name'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['unit'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['shelf_location'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['system_stock'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $item['notes'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex justify-center space-x-2">
                                <a href="?page=tambah-item&item_id=<?php echo $item['id'] ?? $index; ?>" 
                                    class="text-yellow-600 hover:text-yellow-900 transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" 
                                    onclick="confirmDelete(<?php echo $item['id'] ?? $index; ?>)" 
                                    class="text-red-600 hover:text-red-900 transition"
                                    title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>