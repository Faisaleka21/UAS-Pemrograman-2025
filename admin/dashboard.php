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
    <div class="sidebar fixed top-0 left-0 w-64 h-screen p-5 overflow-y-auto">
        <h2 class="text-2xl font-bold text-white mb-6">Dashboard Admin</h2>
        <nav>
            <ul>
                <li class="mb-4">
                    <a href="#" class="flex items-center p-2 rounded hover:bg-purple-600">
                        <i class="fas fa-tachometer-alt icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="pengguna.php" class="flex items-center p-2 rounded hover:bg-purple-600">
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
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang</h1>
        
        <div class="flex items-center gap-6 mb-8">
                    <?php
                    // Jumlah Komoditas
                    $sql_komoditas_count = "SELECT COUNT(*) AS total_komoditas FROM commodities";
                    $result_komoditas_count = $conn->query($sql_komoditas_count);
                    $total_komoditas = $result_komoditas_count ? $result_komoditas_count->fetch_assoc()['total_komoditas'] : 0;

                    // Jumlah Pengguna
                    $sql_pengguna_count = "SELECT COUNT(*) AS total_pengguna FROM users";
                    $result_pengguna_count = $conn->query($sql_pengguna_count);
                    $total_pengguna = $result_pengguna_count ? $result_pengguna_count->fetch_assoc()['total_pengguna'] : 0;
                    ?>

                    <div class="flex items-center bg-indigo-100 rounded-lg p-4 w-1/2">
                        <div class="bg-indigo-500 text-white rounded-full p-3 mr-4">
                            <i class="fas fa-lemon fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-indigo-700"><?= $total_komoditas ?></div>
                            <div class="text-gray-600 text-sm">Total Komoditas</div>
                        </div>
                    </div>
                    <div class="flex items-center bg-yellow-100 rounded-lg p-4 w-1/2">
                        <div class="bg-yellow-400 text-white rounded-full p-3 mr-4">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-700"><?= $total_pengguna ?></div>
                            <div class="text-gray-600 text-sm">Total Pengguna</div>
                        </div>
                    </div>
                </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
                
            <div class="card p-6">

                <!-- presentase -->
                <?php
                require_once '../koneksi/conn.php';

                // Ambil semua komoditas
                $sql_komoditas = "SELECT id, nama FROM commodities ORDER BY nama";
                $komoditas_result = $conn->query($sql_komoditas);
                ?>

                <div class="bg-gray-100 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Perubahan Harga per Komoditas</h3>

                    <?php while ($komoditas = $komoditas_result->fetch_assoc()):
                        $komoditas_id = $komoditas['id'];
                        $komoditas_nama = $komoditas['nama'];

                        // Ambil semua grade untuk komoditas ini
                        $sql_grades = "SELECT id, nama_grade FROM grades WHERE commodity_id = ? ORDER BY nama_grade";
                        $stmt_grade = $conn->prepare($sql_grades);
                        $stmt_grade->bind_param("i", $komoditas_id);
                        $stmt_grade->execute();
                        $grades_result = $stmt_grade->get_result();
                    ?>

                        <div class="mb-4">
                            <h4 class="text-lg font-semibold text-indigo-700 mb-1"><?= htmlspecialchars($komoditas_nama); ?></h4>
                            <ul class="pl-4 list-disc text-sm space-y-1">
                                <?php while ($grade = $grades_result->fetch_assoc()):
                                    $grade_id = $grade['id'];
                                    $grade_nama = $grade['nama_grade'];

                                    // Ambil 2 harga terakhir
                                    $sql_harga = "SELECT harga FROM commodity_prices WHERE grade_id = ? ORDER BY tanggal DESC LIMIT 2";
                                    $stmt_harga = $conn->prepare($sql_harga);
                                    $stmt_harga->bind_param("i", $grade_id);
                                    $stmt_harga->execute();
                                    $result_harga = $stmt_harga->get_result();

                                    $harga_akhir = $harga_awal = null;
                                    if ($row1 = $result_harga->fetch_assoc()) $harga_akhir = $row1['harga'];
                                    if ($row2 = $result_harga->fetch_assoc()) $harga_awal = $row2['harga'];

                                    if ($harga_akhir !== null && $harga_awal !== null && $harga_awal > 0) {
                                        $selisih = $harga_akhir - $harga_awal;
                                        $persen = round(($selisih / $harga_awal) * 100, 2);
                                        $warna = $persen > 0 ? 'text-green-600' : ($persen < 0 ? 'text-red-600' : 'text-gray-500');
                                        $tanda = $persen > 0 ? '+' : '';
                                    } else {
                                        $persen = 0;
                                        $warna = 'text-gray-500';
                                        $tanda = '';
                                    }
                                ?>
                                    <li><span class="<?= $warna ?> font-semibold"><?= $grade_nama ?>: <?= $tanda . $persen ?>%</span></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>

                    <?php endwhile; ?>
                </div>


            </div>

            <!-- grafik -->
            <div class="card p-6">
                <?php
                require_once '../koneksi/conn.php';

                $chartData = [];
                $tanggal_labels = [];

                $sql = "SELECT 
                    c.nama AS komoditas,
                    g.nama_grade AS grade,
                    cp.tanggal,
                    cp.harga
                    FROM commodity_prices cp
                    JOIN grades g ON cp.grade_id = g.id
                    JOIN commodities c ON g.commodity_id = c.id
                    ORDER BY c.nama, g.nama_grade, cp.tanggal";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $komoditas = $row['komoditas'];
                    $grade     = $row['grade'];
                    $tanggal   = $row['tanggal'];
                    $harga     = (int)$row['harga'];
                    // Simpan tanggal ke global jika belum ada
                    if (!in_array($tanggal, $tanggal_labels)) {
                        $tanggal_labels[] = $tanggal;
                    }
                    // Simpan harga per komoditas > grade > tanggal
                    $chartData[$komoditas][$grade][$tanggal] = $harga;
                }
                // Urutkan tanggal
                sort($tanggal_labels);
                ?>
                <?php foreach ($chartData as $komoditas => $grades): ?>
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-indigo-700 mb-2"><?= $komoditas ?></h4>
                        <canvas id="chart_<?= strtolower(str_replace(' ', '_', $komoditas)); ?>" height="100"></canvas>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- end grafik -->
        </div>

        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Pengguna Terbaru</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    require_once __DIR__ . "/../koneksi/conn.php";
                    $sql_query = "SELECT * FROM users ORDER BY id_users DESC LIMIT 3";
                    if ($result = $conn->query($sql_query)) {
                        while ($row = $result->fetch_assoc()) {
                            //yg dlm kurung siku disamakan harus sesuai nama kolom di database
                            $name = $row['nama'];
                            $username = $row['username'];
                            $password = $row['password'];
                            $role = $row['role'];
                    ?>

                            <tr class="trow">
                                <td class="px-4 py-2 text-center"><?php echo $no++; ?></td>
                                <td class="px-4 py-2"><?php echo $name; ?></td>
                                <td class="px-4 py-2"><?php echo $username; ?></td>
                                <td class="px-4 py-2"><?php echo $password; ?></td>
                                <td class="px-4 py-2 text-center"><?php echo $role; ?></td>
                            </tr>

                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        <?php
        $colors = ['#6366f1', '#f59e0b', '#10b981', '#ef9929', '#8b5cf6', '#f43f5e'];
        $colorIndex = 0;
        ?>

        <?php foreach ($chartData as $komoditas => $grades):
            $datasets = [];
            foreach ($grades as $grade => $tanggalHarga) {
                $data = [];
                foreach ($tanggal_labels as $tgl) {
                    $data[] = isset($tanggalHarga[$tgl]) ? $tanggalHarga[$tgl] : null;
                }

                $datasets[] = [
                    'label' => $grade,
                    'data' => $data,
                    'borderColor' => $colors[$colorIndex % count($colors)],
                    'backgroundColor' => $colors[$colorIndex % count($colors)] . '33',
                    'tension' => 0.4,
                    'fill' => false,
                    'spanGaps' => true
                ];
                $colorIndex++;
            }
        ?>

            const ctx_<?= strtolower(str_replace(' ', '_', $komoditas)); ?> = document.getElementById('chart_<?= strtolower(str_replace(' ', '_', $komoditas)); ?>').getContext('2d');
            new Chart(ctx_<?= strtolower(str_replace(' ', '_', $komoditas)); ?>, {
                type: 'line',
                data: {
                    labels: <?= json_encode($tanggal_labels); ?>,
                    datasets: <?= json_encode($datasets); ?>
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Harga (Rp)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });
        <?php endforeach; ?>
    </script>




</body>

</html>