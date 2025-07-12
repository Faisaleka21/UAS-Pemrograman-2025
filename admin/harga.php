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
                    <a href="pengguna.php" class="flex items-center p-2 rounded hover:bg-purple-600">
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

        <!-- Input Harga Pangan -->
        <div class="card p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Input Harga Pangan Pasar</h2>
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Komoditas</label>
                    <select name="komoditas" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Komoditas --</option>
                        <option value="beras">Beras</option>
                        <option value="jagung">Jagung</option>
                        <option value="cabai">Cabai</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border rounded px-3 py-2" required>
                </div>
                <button type="submit" name="submit_harga" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded">Simpan</button>
            </form>

            <?php
            // Proses input harga pangan
            if (isset($_POST['submit_harga'])) {
                $id_komoditas = $_POST['komoditas']; // isinya id_komoditas
                $id_pasar     = $_POST['pasar'];     // isinya id_pasar
                $harga        = $_POST['harga'];
                $tanggal      = $_POST['tanggal'];
                $stmt = $conn->prepare("INSERT INTO harga (id_komoditas, id_pasar, tanggal, harga) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iisi", $id_komoditas, $id_pasar, $tanggal, $harga);
                if ($stmt->execute()) {
                    echo '<p class="text-green-600 mt-2">Data harga berhasil disimpan.</p>';
                } else {
                    echo '<p class="text-red-600 mt-2">Gagal menyimpan data: ' . $stmt->error . '</p>';
                }
                $stmt->close();
            }
            ?>
        </div>

        <!-- Filter dan Grafik Harga Pangan -->
        <div class="card p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Grafik Harga Pangan</h2>
            <form method="GET" class="mb-4 flex items-center gap-4">
                <label class="font-medium">Filter Komoditas:</label>
                <select name="filter_komoditas" class="border rounded px-3 py-2">
                    <option value="">Semua</option>
                    <option value="beras" <?php if (isset($_GET['filter_komoditas']) && $_GET['filter_komoditas'] == 'beras') echo 'selected'; ?>>Beras</option>
                    <option value="jagung" <?php if (isset($_GET['filter_komoditas']) && $_GET['filter_komoditas'] == 'jagung') echo 'selected'; ?>>Jagung</option>
                    <option value="cabai" <?php if (isset($_GET['filter_komoditas']) && $_GET['filter_komoditas'] == 'cabai') echo 'selected'; ?>>Cabai</option>
                </select>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Tampilkan</button>
            </form>
            <canvas id="hargaChart" height="100"></canvas>
            <?php
            $filter = isset($_GET['filter_komoditas']) ? $_GET['filter_komoditas'] : '';
$params = [];

$sql = "SELECT h.tanggal, h.harga, k.nama_komoditas 
        FROM harga h
        JOIN komoditas k ON h.id_komoditas = k.id_komoditas";

if ($filter) {
    $sql .= " WHERE k.nama_komoditas = ?";
    $params[] = $filter;
}

$sql .= " ORDER BY h.tanggal ASC";
$stmt = $conn->prepare($sql);

if ($filter) {
    $stmt->bind_param("s", $filter);
}
$stmt->execute();

$result = $stmt->get_result();
$labels = [];
$data_beras = [];
$data_jagung = [];
$data_cabai = [];

while ($row = $result->fetch_assoc()) {
    $tanggal = $row['tanggal'];
    $komoditas = strtolower($row['nama_komoditas']);

    if (!in_array($tanggal, $labels)) {
        $labels[] = $tanggal;
    }

    if ($komoditas == 'beras') {
        $data_beras[$tanggal] = $row['harga'];
    } elseif ($komoditas == 'jagung') {
        $data_jagung[$tanggal] = $row['harga'];
    } elseif ($komoditas == 'cabai') {
        $data_cabai[$tanggal] = $row['harga'];
    }
}

// Pastikan semua tanggal urut dan data terisi sesuai tanggal
sort($labels);
$beras = [];
$jagung = [];
$cabai = [];

foreach ($labels as $tgl) {
    $beras[]  = isset($data_beras[$tgl]) ? $data_beras[$tgl] : null;
    $jagung[] = isset($data_jagung[$tgl]) ? $data_jagung[$tgl] : null;
    $cabai[]  = isset($data_cabai[$tgl]) ? $data_cabai[$tgl] : null;
}

            ?>
            <script>
                const ctx = document.getElementById('hargaChart').getContext('2d');
                const hargaChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [
                            <?php if (!$filter || $filter == 'beras'): ?> {
                                    label: 'Beras',
                                    data: <?php echo json_encode($beras); ?>,
                                    borderColor: '#6366f1',
                                    backgroundColor: 'rgba(99,102,241,0.1)',
                                    spanGaps: true
                                },
                            <?php endif; ?>
                            <?php if (!$filter || $filter == 'jagung'): ?> {
                                    label: 'Jagung',
                                    data: <?php echo json_encode($jagung); ?>,
                                    borderColor: '#f59e42',
                                    backgroundColor: 'rgba(245,158,66,0.1)',
                                    spanGaps: true
                                },
                            <?php endif; ?>
                            <?php if (!$filter || $filter == 'cabai'): ?> {
                                    label: 'Cabai',
                                    data: <?php echo json_encode($cabai); ?>,
                                    borderColor: '#ef4444',
                                    backgroundColor: 'rgba(239,68,68,0.1)',
                                    spanGaps: true
                                }
                            <?php endif; ?>
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
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
            </script>
        </div>


    </div>



</body>

</html>