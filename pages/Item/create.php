<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/services/ItemService.php';

$pdo = DatabaseConfig::getConnection();
$itemService = new ItemService($pdo);

$options = [
    '' => 'Pilih Satuan',
    'PCS' => 'PCS',
    'BOX' => 'BOX',
    'SET' => 'SET',
    'PKG' => 'PKG',
    'MTR' => 'MTR',
];
$rakOpt = [
    '' => 'Pilih Rak',
    'RAK A' => 'RAK A',
    'RAK B' => 'RAK B',
];

$item_id = $_GET['item_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    $itemName = $_POST['item_name'] ?? '';
    $unit = $_POST['codeUnit'] ?? '';
    $stok = $_POST['stok'] ?? null;
    $rak = $_POST['rak'] ?? '';
    $keterangan = $_POST['notes'] ?? '';
    
    try {
        if ($item_id != null) {
            $data = [
                "code" => $_POST['code'] ?? '',
                "item_name" => $_POST['item_name'] ?? '',
                "unit" => $_POST['codeUnit'] ?? '',
                "shelf_location" => $_POST['rak'] ?? '',
                "system_stock" => $_POST['stok'] ?? null,
                "notes" => $_POST['notes'] ?? ''
            ];
            $itemService->update($item_id, $data);
            $success = "Update berhasil!";
            header( "Location: ?page=item");
            exit;
        } else {
            $itemService->insert($code, $itemName, $unit, $rak, $stok, $keterangan);
            $success = "Item berhasil ditambahkan!";
            header("Location: ?page=item");
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if ($item_id != null) {
    try {
        $result = $itemService->findById($item_id);
        $data = $result;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div>
    <div class="flex justify-between items-center mb-10">
        <h3 class="text-2xl font-bold text-gray-800">Create</h3>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="?page=dashboard" class="hover:text-blue-600 transition">
                <i class="fas fa-home"></i>
                <span class="ml-1">MyApps</span>
            </a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <a href="?page=item" class="hover:text-blue-600 transition">Item</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <span class="text-gray-800 font-medium">Tambah</span>
        </div>
    </div>

    <div>
        <h3 class="font-semibold mb-5"># Informasi Item</h3>
        <form method="POST" action="">
            <div class="grid grid-cols-2 gap-5">
                <section class="space-y-1">
                    <label for="code" class="text-gray-500">Kode Item</label><br>
                    <input id="code" name="code" type="text" class="w-full rounded-lg border border-gray-300 p-3" value="<?= htmlspecialchars($data['code'] ?? '') ?>" />
                </section>
                <section class="space-y-1">
                    <label for="">Nama Item</label><br>
                    <input type="text" name="item_name" class="w-full rounded-lg border border-gray-300 p-3" value="<?= htmlspecialchars($data['item_name'] ?? '') ?>" />
                </section>
                <section class="space-y-1">
                    <label for="">Unit</label><br>
                    <select id="codeUnit" name="codeUnit" class="w-full rounded-lg border border-gray-300 p-3">
                        <?php foreach ($options as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= $data['unit'] ?? '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </section>

                <section class="space-y-1">
                    <label for="">Lokasi Rak</label><br>
                    <select id="rak" name="rak" class="w-full rounded-lg border border-gray-300 p-3">
                        <?php foreach ($rakOpt as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= $data['shelf_location'] ?? '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </section>
                <section class="space-y-1">
                    <label for="">Stok</label><br>
                    <input type="text" name="stok" class="w-full rounded-lg border border-gray-300 p-3" value="<?= htmlspecialchars($data['system_stock'] ?? '') ?>" />
                </section>
                <section class="space-y-1">
                    <label for="">Keterangan</label><br>
                    <input type="text" name="notes" class="w-full rounded-lg border border-gray-300 p-3" value="<?= htmlspecialchars($data['notes'] ?? '') ?>" />
                </section>
            </div>

            <section class="mt-7 flex  space-x-3">
                <!-- <button class="max-w-max border border-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</button> -->
                <a href="?page=item">
                    <section class="max-w-max border border-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        </i>Cancel
                    </section>
                </a>
                <button type="submit" class="max-w-max border border-green-600/10 bg-green-600/10 text-green-600 hover:bg-green-600/30 px-4 py-2 rounded-lg">Submit</button>
            </section>
        </form>
    </div>
</div>