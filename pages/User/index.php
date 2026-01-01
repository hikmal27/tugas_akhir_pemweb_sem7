<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/services/UserService.php';

$pdo = DatabaseConfig::getConnection();
$userService = new UserService($pdo);

$data = [];
try {
    $result = $userService->findAll();
    $data = $result;
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<div>
    <div class="flex justify-between items-center mb-10">
        <h3 class="text-2xl font-bold text-gray-800">Daftar User</h3>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="?page=dashboard" class="hover:text-blue-600 transition">
                <i class="fas fa-home"></i>
                <span class="ml-1">MyApps</span>
            </a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <a href="?page=user" class="hover:text-blue-600 transition">User</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <span class="text-gray-800 font-medium">Index</span>
        </div>
    </div>

    <a href="?page=tambah-user">
        <section class="max-w-max bg-green-600/10 text-green-600 hover:bg-green-600/30 px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah User
        </section>
    </a>

    <section class="mt-5">
        <table>
            <thead class="bg-gray-50 border-b border-gray-200">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Register</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php foreach($data as $index => $user): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $user['name'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $user['username'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $user['password_str'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <section class="p-1 px-2 text-center rounded-2xl <?= ($user['status'] == 'Active') ? 'bg-green-600/20 text-green-600' : 'bg-red-600/20 text-red-600' ?>"><?= $user['status'] ?></section>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $user['register_date'] ?? "-" ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex justify-center space-x-2">
                                <a href="?page=tambah-user&id=<?php echo $user['id'] ?? $index; ?>" 
                                    class="text-yellow-600 hover:text-yellow-900 transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" 
                                    onclick="confirmDelete(<?php echo $user['id'] ?? $index; ?>)" 
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