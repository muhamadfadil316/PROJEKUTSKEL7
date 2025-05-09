<?php
session_start();
require_once 'config/database.php';
require_once 'models/UserModel.php';

$userModel = new UserModel($conn);
$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $role = $_POST['role'] ?? 'user';
        $user = $userModel->login($email, $password);

        if ($user && password_verify($password, $user['password'])) {
            if (strtolower($user['role']) === strtolower($role)) {
                $_SESSION['user'] = $user;

                if ($role === 'admin') {
                    header('Location: dashboard/index.php');
                } elseif ($role === 'user') {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['email'] = $email;
                    header('Location: dashboard_user/index.php');
                }
                exit;
            } else {
                $loginError = 'Role tidak sesuai dengan akun.';
            }
        }

    } catch (Exception $e) {
        $loginError = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UMKMku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="favicon.ico">
</head>

<body class="bg-gradient-to-r from-teal-500 to-blue-600 min-h-screen flex flex-col gap-12">

    <header class="bg-white shadow-md  z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="index.php" class="text-2xl font-bold text-indigo-600">UMKMku</a>
                </div>

                <nav class="hidden md:flex space-x-6">
                    <a href="index.php/#beranda" class="text-gray-700 hover:text-indigo-600 transition">Beranda</a>
                    <a href="index.php/#fitur" class="text-gray-700 hover:text-indigo-600 transition">Fitur</a>
                    <a href="index.php/#tentang" class="text-gray-700 hover:text-indigo-600 transition">Tentang</a>
                    <a href="index.php/#kontak" class="text-gray-700 hover:text-indigo-600 transition">Kontak</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="login.php" class="text-gray-700 hover:text-indigo-600 transition">Login</a>
                    <a href="daftar.php"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition">Daftar</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
            <a href="#beranda" class="block py-2 text-gray-700 hover:text-indigo-600">Beranda</a>
            <a href="#fitur" class="block py-2 text-gray-700 hover:text-indigo-600">Fitur</a>
            <a href="#tentang" class="block py-2 text-gray-700 hover:text-indigo-600">Tentang</a>
            <a href="#kontak" class="block py-2 text-gray-700 hover:text-indigo-600">Kontak</a>
            <a href="/login" class="block py-2 text-gray-700 hover:text-indigo-600">Login</a>
            <a href="/register" class="block py-2 text-indigo-600 font-semibold">Daftar</a>
        </div>

        <script>
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');

            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        </script>
    </header>

    <div class="flex justify-center items-center flex-grow">
        <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-md">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-indigo-600">Selamat Datang 👋</h1>
                <p class="text-gray-500 mt-2">Silakan login untuk mengakses UMKMku</p>
            </div>

            <?php if ($loginError): ?>
                <div class="mb-4 text-red-600 text-sm text-center">
                    <?= htmlspecialchars($loginError) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Login sebagai</label>
                    <select id="role" name="role" required
                        class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>



                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="accent-indigo-600">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-indigo-600 hover:underline">Lupa sandi?</a>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-md hover:bg-indigo-700 transition-all duration-200">
                    Login
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum punya akun? <a href="daftar.php" class="text-indigo-600 hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>

</html>