<?php
session_start();
require_once 'auth.php';

// Jika user sudah login, arahkan sesuai role
if (isset($_SESSION['user'])) {
    redirectToRole($_SESSION['user']['role']);
}

// Tangkap error dari URL (jika ada)
$errorMsg = $_GET['error'] ?? '';
?>
  
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HargaPangan Desa - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
            background-image: linear-gradient(to bottom right, #f7fafc, #e2e8f0);
        }
        .login-container {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .login-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .input-field:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .farmer-illustration {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-container bg-white rounded-2xl overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
        <!-- Kiri - Ilustrasi -->
        <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-indigo-500 to-purple-600 p-10 flex flex-col justify-center items-center text-white">
            <div class="farmer-illustration mb-8">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/03b93c5b-7c51-4817-b1f7-c0089816e20c.png" alt="Ilustrasi Petani" class="rounded-lg shadow-xl"/>
            </div>
            <h2 class="text-3xl font-bold mb-4 text-center">Selamat Datang di HargaPangan Desa</h2>
            <p class="text-center text-indigo-100">Sistem Informasi Harga Pangan Real-Time untuk Petani Indonesia</p>
        </div>

        <!-- Kanan - Form Login -->
        <div class="w-full md:w-1/2 p-10">
            <!-- pesaaaaaaan  -->
            <?php if ($errorMsg): ?>
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6 text-center">
                    <?= htmlspecialchars($errorMsg) ?>
                </div>
            <?php endif; ?>

            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Masuk ke Akun Anda</h1>
            <p class="text-gray-600 mb-8 text-center">Kelola informasi harga pangan terkini untuk desa Anda</p>

            <form method="post" action="auth.php" class="space-y-6">

                <div>
                    <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" required>
                </div>

                <div class="relative">
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" required>
                    <button type="button" class="absolute right-3 top-10 text-gray-500 hover:text-indigo-600" onclick="togglePasswordVisibility()">
                        <!-- Icon mata -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-lg text-white font-semibold btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Belum memiliki akun? 
                    <a href="registrasi.php" class="font-medium text-indigo-600 hover:text-indigo-500">Daftar sekarang</a>
                </p>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-500 text-center">© 2023 HargaPangan Desa</p>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan/sembunyikan password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
