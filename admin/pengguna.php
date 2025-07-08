<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('admin');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - HargaPangan Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
        }
        .sidebar {
            background: linear-gradient(to bottom right, #4f46e5, #7c3aed);
        }
        .sidebar a {
            color: white;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar .icon {
            width: 24px;
            margin-right: 10px;
        }
        .sidebar h2 {
            font-size: 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.08);
            transition: box-shadow 0.3s;
        }
        .card:hover {
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.12);
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="sidebar w-64 h-screen p-5">
        <h2 class="text-2xl font-bold text-white mb-6">Dashboard Admin</h2>
        <nav>
            <ul>
                <li class="mb-4">
                    <a href="dashboard.php" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-tachometer-alt icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-users icon"></i>
                        Kelola Pengguna
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-chart-line icon"></i>
                        Laporan Harga Pangan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-cog icon"></i>
                        Pengaturan
                    </a>
                </li>
                <li>
                    <a href="../logout.php" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-sign-out-alt icon"></i>
                        Keluar
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, Admin!</h1>

          <!-- pengguna -->
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4">Statistik Pengguna</h2>
            <p class="text-gray-600 mb-2">Jumlah pengguna terdaftar: <strong>150</strong></p>
            <p class="text-gray-600 mb-2">Jumlah pengguna aktif: <strong>120</strong></p>
            <p class="text-gray-600 mb-2">Jumlah pengguna tidak aktif: <strong>30</strong></p>
        </div>

      
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Pengguna</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                        require_once __DIR__. "/../koneksi/conn.php";
                        $sql_query = "SELECT * FROM users"; // query untuk mengambil data dari tabel dokter
                        if ($result = $conn ->query($sql_query)) {
                            while ($row = $result -> fetch_assoc()) { 
                                $id = $row['id_users'];  //yg dlm kurung siku disamakan harus sesuai nama kolom di database
                                $name = $row['nama'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $role = $row['role'];
                    ?>
                    
                    <tr class="trow">
                        <td class="px-4 py-2 text-center"><?php echo $id; ?></td>
                        <td class="px-4 py-2"><?php echo $name; ?></td>
                        <td class="px-4 py-2"><?php echo $username; ?></td>
                        <td class="px-4 py-2"><?php echo $password; ?></td>
                        <td class="px-4 py-2 text-center"><?php echo $role; ?></td>
                        <td class="px-4 py-2 text-center">
                            <a href="update.php?id=<?php echo $id; ?>" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 transition duration-200" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete.php?id=<?php echo $id; ?>" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded transition duration-200" title="Delete" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>

                    <?php
                            } 
                        } 
                    ?>
                    <!-- Tambahkan lebih banyak pengguna di sini -->
                </tbody>
            </table>
        </div>
    </div>

    
<!-- line chart -->
    <script>
        const ctx = document.getElementById('priceChart').getContext('2d');
        const priceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Beras', 'Jagung', 'Kentang', 'Sayuran'], // Label untuk sumbu X
                datasets: [{
                    label: 'Harga Pangan (IDR)',
                    data: [10000, 8000, 12000, 5000], // Data untuk sumbu Y
                    borderColor: 'rgba(79, 70, 229, 1)',
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Harga (IDR)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Pangan'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

