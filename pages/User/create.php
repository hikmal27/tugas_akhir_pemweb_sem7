<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/services/UserService.php';

$pdo = DatabaseConfig::getConnection();
$userService = new UserService($pdo);

$user_id = $_GET['id'] ?? null;
$dataUser = [];
$selectedStatus = '';
$alertType = '';
$error = '';
$success = '';

if ($user_id != null) {
    try {
        $result = $userService->findById($user_id);
        $data = $result;
        $selectedStatus = $data['status'];
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordStr = $_POST['password'] ?? '';
    $status = $_POST['status'] ?? '';
    
    try {
        if ($user_id != null) {
            $data = [
                "name" => $name = $_POST['name'] ?? '',
                "username" => $_POST['username'] ?? '',
                "password" => $_POST['password'] ?? '',
                "passwordStr" => $_POST['password'] ?? '',
                "status" => $_POST['status'] ?? ''
            ];
            $userService->updateUser($user_id, $data);
            $success = "Update berhasil!";
        } else {
            $userService->register($name, $username, $password, $passwordStr, $status);
            $success = "Registrasi berhasil! Silakan login.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$statusOpt = [
    '' => 'Pilih Status',
    'Active' => 'Active',
    'Inactive' => 'Inactive',
];
?>

<div>
    <div class="flex justify-between items-center mb-10">
        <h3 class="text-2xl font-bold text-gray-800">Register <?= $data['password_str'] ?></h3>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="?page=dashboard" class="hover:text-blue-600 transition">
                <i class="fas fa-home"></i>
                <span class="ml-1">MyApps</span>
            </a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <a href="?page=user" class="hover:text-blue-600 transition">Users</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <span class="text-gray-800 font-medium">Tambah</span>
        </div>
    </div>

    <div>
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $alertType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <h3 class="font-semibold mb-5"># Informasi User</h3>
        <form method="POST" action="">
            <div class="grid grid-cols-2 gap-5">
                <section class="space-y-1">
                    <label for="code" class="text-gray-500">Nama</label><br>
                    <input id="name" name="name" type="text" value="<?= htmlspecialchars($data['name']) ?>" class="w-full rounded-lg border border-gray-300 p-3" required />
                </section>
                <section class="space-y-1">
                    <label for="" class="text-gray-500">Username</label><br>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($data['username']) ?>" class="w-full rounded-lg border border-gray-300 p-3" required />
                </section>
                <section class="space-y-1">
                    <label for="" class="text-gray-500">Password</label><br>
                    <input type="text" id="password" name="password" value="<?= htmlspecialchars($data['password_str']) ?>" class="w-full rounded-lg border border-gray-300 p-3" required />
                </section>
                <section class="space-y-1">
                    <label class="text-gray-500">Status</label><br>
                    <select id="status" name="status" class="w-full rounded-lg border border-gray-300 p-3">
                        <?php foreach ($statusOpt as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>">
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </section>
            </div>
            <section class="mt-7 flex  space-x-3">
                <!-- <button class="max-w-max border border-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</button> -->
                <a href="?page=user">
                    <section class="max-w-max border border-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        </i>Cancel
                    </section>
                </a>
                <button type="submit" class="max-w-max border border-green-600/10 bg-green-600/10 text-green-600 hover:bg-green-600/30 px-4 py-2 rounded-lg">Submit</button>
            </section>
        </form>
    </div>
</div>