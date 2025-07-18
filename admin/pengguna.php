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
            background: linear-gradient(to bottom right, #5046E5, #7c3aed);
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
   <div class="sidebar fixed top-0 left-0 w-64 h-screen p-5 overflow-y-auto">
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
                    <a href="harga.php" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-chart-line icon"></i>
                        Harga Komoditas
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
    <div class="flex-1 p-10 ml-64">
    <div class="flex items-center space-x-2 mb-2 md:mb-4 ">
        <i class="fas fa-leaf text-3xl"></i>
        <h1 class="text-3xl font-bold text-gray-800">Sistem Informasi Harga Pangan Desa</h1>

      </div>
        <!-- pengguna -->
        <div class="card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Statistik Pengguna</h2>
            <?php
            // Query jumlah pengguna terdaftar
            $result_total = $conn->query("SELECT COUNT(*) as total FROM users");
            $total_users = $result_total ? $result_total->fetch_assoc()['total'] : 0;

            // Query jumlah admin
            $result_admin = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
            $total_admin = $result_admin ? $result_admin->fetch_assoc()['total'] : 0;

            // Query jumlah petani (user)
            $result_petani = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'petani'");
            $total_petani = $result_petani ? $result_petani->fetch_assoc()['total'] : 0;
            ?>

            <p class="text-gray-600 mb-2">Jumlah pengguna terdaftar: <strong><?php echo $total_users; ?></strong></p>
            <p class="text-gray-600 mb-2">Jumlah admin: <strong><?php echo $total_admin; ?></strong></p>
            <p class="text-gray-600 mb-2">Jumlah petani: <strong><?php echo $total_petani; ?></strong></p>
        </div>


        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Pengguna</h2>
            <!-- Input pencarian -->
                <div class="mb-4">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fas fa-search"></i>
        </span>
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Cari nama atau username..." 
            onkeyup="liveSearch()"
            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out bg-white"
        >
    </div>
</div>

                <script>
                    function liveSearch() {
                        const input = document.getElementById("searchInput");
                        const filter = input.value.toLowerCase();
                        const rows = document.querySelectorAll(".trow");

                        rows.forEach(row => {
                            const name = row.cells[1].textContent.toLowerCase();
                            const username = row.cells[2].textContent.toLowerCase();

                            if (name.includes(filter) || username.includes(filter)) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    }
                </script>
                <!-- pencarian end -->

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
                    require_once __DIR__ . "/../koneksi/conn.php";
                    $sql_query = "SELECT * FROM users"; // query untuk mengambil data dari tabel dokter
                    if ($result = $conn->query($sql_query)) {
                        while ($row = $result->fetch_assoc()) {
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
                                    <!-- Tombol Edit -->
                                    <button onclick="openModal<?php echo $id; ?>()" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded mr-2 transition duration-200" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Tombol Delete -->
                                    <a href="../koneksi/delete.php?id=<?php echo $id; ?>" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded transition duration-200" title="Delete" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>

                                    <!-- Modal Edit -->
                                    <!-- Modal Edit User -->
                                    <div id="modalEdit<?php echo $id; ?>" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                        <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative animate-fade-in">
                                            <!-- Tombol close pojok kanan -->
                                            <button onclick="closeModal<?php echo $id; ?>()" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>

                                            <h3 class="text-2xl font-semibold text-indigo-700 mb-4 border-b pb-2">Edit Data Pengguna</h3>

                                            <form method="POST" action="../koneksi/update.php" class="space-y-4">
                                                <!-- Hidden ID -->
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                                <!-- Nama -->
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                                </div>

                                                <!-- Username -->
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                                                    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                                </div>

                                                <!-- Password -->
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                                    <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                                </div>

                                                <!-- Role -->
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                                                    <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                                        <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                                                        <option value="petani" <?php if ($role == 'petani') echo 'selected'; ?>>Petani</option>
                                                    </select>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div class="flex justify-end gap-3 pt-3 border-t mt-4">
                                                    <button type="button" onclick="closeModal<?php echo $id; ?>()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md font-semibold transition">Batal</button>
                                                    <button type="submit" name="update_user" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold transition">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Script modal -->
                                    <script>
                                        function openModal<?php echo $id; ?>() {
                                            document.getElementById('modalEdit<?php echo $id; ?>').classList.remove('hidden');
                                            document.getElementById('modalEdit<?php echo $id; ?>').classList.add('flex');
                                        }

                                        function closeModal<?php echo $id; ?>() {
                                            document.getElementById('modalEdit<?php echo $id; ?>').classList.add('hidden');
                                            document.getElementById('modalEdit<?php echo $id; ?>').classList.remove('flex');
                                        }
                                    </script>
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
    



</body>

</html>