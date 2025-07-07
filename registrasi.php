
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        .input-field {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
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
        <!-- Left Side - Illustration -->
        <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-indigo-500 to-purple-600 p-10 flex flex-col justify-center items-center text-white">
            <div class="farmer-illustration mb-8">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/03b93c5b-7c51-4817-b1f7-c0089816e20c.png" alt="Petani sedang memeriksa harga pangan di pasar digital, dengan latar belakang sawah dan gunung di Bali" class="rounded-lg shadow-xl"/>
            </div>
            <h2 class="text-3xl font-bold mb-4 text-center">Selamat Datang di HargaPangan Desa</h2>
            <p class="text-center text-indigo-100">Sistem Informasi Harga Pangan Real-Time untuk Petani Indonesia</p>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="w-full md:w-1/2 p-10">
            <div class="flex justify-center mb-6 md:hidden">
                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/22b5fe39-1352-4a07-ab72-bf2a7e42700a.png" alt="Logo HargaPangan Desa - Siluet petani dengan grafik pertumbuhan" class="h-12"/>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Daftar Akun Baru</h1>
            <p class="text-gray-600 mb-8 text-center">Buat akun untuk mengelola harga pangan desa Anda</p>
            
            <!-- Registration form -->
            <form method="post" action="koneksi/add.php" id="registerForm" class="space-y-6">
                <div>
                    <label for="role" class="block text-gray-700 font-medium mb-1">Daftar Sebagai</label>
                    <select id="role" name="role" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none">
                        <option value="users">Admin</option>
                        <option value="admin">Petani</option>
                    </select>
                </div>
                 <div>
                    <label for="nama" class="block text-gray-700 font-medium mb-1">nama</label>
                    <input type="text" id="nama" name="nama" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" placeholder="contoh: bambang paisal">
                </div>
                <div>
                <div>
                    <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" placeholder="contoh: petani@desa.id">
                </div>
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" placeholder="Masukkan password">
                </div>
                <div>
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-3 rounded-lg border border-gray-300 input-field focus:outline-none" placeholder="Ulangi password">
                </div>
                <button type="submit" class="w-full py-3 px-4 rounded-lg text-white font-semibold btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Daftar
                </button>
            </form>
            <!-- Registration form end -->
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Sudah punya akun? 
                    <a href="index.php" class="font-medium text-indigo-600 hover:text-indigo-500">Masuk di sini</a>
                    </p>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-500 text-center">© 2023 HargaPangan Desa - Sistem Informasi untuk Petani Mandiri</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (!username || !password || !confirmPassword) {
                alert('Semua field wajib diisi!');
                e.preventDefault();
                return;
            }
            if (password !== confirmPassword) {
                alert('Password dan konfirmasi password tidak sama!');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>

