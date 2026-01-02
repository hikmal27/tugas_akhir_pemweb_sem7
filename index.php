<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/services/AuthService.php';
$pdo = DatabaseConfig::getConnection();

$page = $_GET['page'] ?? 'dashboard';
if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header('Location: ?page=login');
    exit();
}

if (isset($_SESSION['user_id']) && $page === 'login') {
    header('Location: ?page=dashboard');
    exit;
}

if (isset($_SESSION['user_id']) && isset($_SESSION['login_time'])) {
    $timeout = 1800;
    if ((time() - $_SESSION['login_time']) > $timeout) {
        session_destroy();
        header('Location: ?page=login&timeout=1');
        exit;
    }
    $_SESSION['login_time'] = time();
}

if ($page === 'logout') {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_destroy();
    header('Location: ?page=login');
    exit;
}

// Proses login
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $authService = new AuthService($pdo);
        $result = $authService->login($username, $password);
        if ($result) {
            header('Location: ?page=dashboard');
            exit;
        }
    } catch (Exception $e) {
        $login_error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen p-5">
    <?php if ($page === 'login'): ?>
        <!-- Halaman Login -->
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-green-600 mb-2">MyApp</h1>
                        <p class="text-gray-600">Silakan login untuk melanjutkan</p>
                    </div>

                    <?php if (isset($login_error)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo htmlspecialchars($login_error); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['timeout'])): ?>
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-clock mr-2"></i>
                        Sesi Anda telah berakhir. Silakan login kembali.
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="?page=login" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-green-600"></i>Username
                            </label>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Masukkan username"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-green-600"></i>Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Masukkan password"
                            >
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-lg hover:shadow-xl"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </button>
                    </form>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Demo Login:</strong><br>
                            Username: supersu<br>
                            Password: supersecret
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Halaman Dashboard -->
        <div class="relative max-w-6xl min-h-screen mx-auto">
            <aside id="sidebar" class="absolute left-0 top-0 h-full w-64 border-r border-gray-300 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
                <div class="flex items-center justify-center h-16 border-b border-gray-300">
                    <h1 class="text-2xl font-bold text-green-600">MyApp</h1>
                </div>

                <nav class="mt-10">
                    <ul>
                        <li>
                            <a href="?page=dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 transition hover:bg-gray-600/10">
                                <i class="fas fa-home mr-2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=item" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 transition hover:bg-gray-600/10">
                                <i class="fas fa-box mr-2"></i>
                                <span>Item</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=user" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 transition hover:bg-gray-600/10">
                                <i class="fas fa-box mr-2"></i>
                                <span>User</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="absolute bottom-10 w-full border-t border-gray-300 p-4">
                    <div class="flex items-center justify-between text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-2xl mr-2"></i>
                            <span class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </div>
                        <a href="?page=logout" class="text-red-500 hover:text-red-700 transition" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </aside>

            <main class="ml-64 min-h-screen">
                <div class="p-6">
                    <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

                        switch($page) {
                            case 'dashboard':
                                include 'pages/Dashboard/index.php';
                                break;
                            case 'item':
                                include 'pages/Item/index.php';
                                break;
                            case 'tambah-item':
                                include 'pages/Item/create.php';
                                break;
                            case 'user':
                                include 'pages/User/index.php';
                                break;
                            case 'tambah-user':
                                include 'pages/User/create.php';
                                break;
                            default:
                                echo '<div class="text-center py-20">';
                                echo '<i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>';
                                echo '<h2 class="text-2xl font-bold text-gray-700">Halaman tidak ditemukan</h2>';
                                echo '</div>';
                        }
                    ?>
                </div>
            </main>
        </div>
    <?php endif; ?>
</body>
</html>