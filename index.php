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
                    <!-- <li>
                        <a href="?page=item" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 transition hover:bg-gray-600/10">
                            <i class="fas fa-box mr-2"></i>
                            <span>Rak</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="?page=user" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-600 transition hover:bg-gray-600/10">
                            <i class="fas fa-box mr-2"></i>
                            <span>User</span>
                        </a>
                    </li>
                </ul>
            </nav>
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
                            include 'pages/dashboard.php';
                    }
                ?>
            </div>
        </main>
    </div>
</body>
</html>