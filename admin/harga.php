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
    <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>

        <!-- Form Input Komoditas -->
        <div class="card p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Input Harga Komoditas</h2>
            <form method="post" action="../koneksi/input_komoditas.php" class="space-y-4">
                <div>
                    <label for="komoditas" class="block text-gray-700 font-medium mb-1">Pilih Komoditas</label>
                    <select name="komoditas" id="komoditas" required class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Komoditas --</option>
                        <option value="Beras">Beras</option>
                        <option value="Jagung">Jagung</option>
                        <option value="Cabai">Cabai</option>
                        <option value="Ketan">Ketan</option>
                        <option value="Tomat">Tomat</option>
                        <!-- Tambahkan komoditas lain sesuai kebutuhan -->
                    </select>
                </div>
                <!-- grade -->
                <div>
                    <label for="grade_id" class="block text-gray-700 font-medium mb-1">Grade</label>
                    <select name="grade_id" id="grade_id" required class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Grade --</option>
                        <?php
                        // Ambil dari JOIN grades dan commodities
                        $query = "SELECT g.id AS id, g.nama_grade, c.nama AS nama_komoditas 
                            FROM grades g
                            JOIN commodities c ON g.commodity_id = c.id
                            ORDER BY c.nama, g.nama_grade";

                        $grade_result = $conn->query($query);

                        while ($row = $grade_result->fetch_assoc()):
                            $id = $row['id'];
                            $label = $row['nama_komoditas'] . ' - ' . $row['nama_grade'];
                        ?>
                            <option value="<?= $id ?>"><?= htmlspecialchars($label) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label for="harga" class="block text-gray-700 font-medium mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" required min="0" class="w-full border rounded px-3 py-2" placeholder="Masukkan harga">
                </div>
                <div>
                    <label for="tanggal" class="block text-gray-700 font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Grafik Harga Komoditas -->
        <div class="card p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Grafik Harga Komoditas</h2>
            <canvas id="hargaChart" height="100"></canvas>
        </div>




        <!-- Daftar Harga Komoditas -->
        <div class="card p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Daftar Harga Komoditas</h2>
            <!-- filter komoditas -->
            <form method="GET" class="mb-4">
                <select name="filter_komoditas" id="filter_komoditas" onchange="this.form.submit()" class="w-full border rounded px-3 py-2 max-w-sm">
                    <option value="">-- Tampilkan Semua Komoditas --</option>
                    <?php
                    // Ambil daftar komoditas
                    $komoditas_result = $conn->query("SELECT id, nama FROM commodities ORDER BY nama");
                    while ($row = $komoditas_result->fetch_assoc()):
                        $selected = (isset($_GET['filter_komoditas']) && $_GET['filter_komoditas'] == $row['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= $row['id'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($row['nama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>

            <!-- table -->
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Komoditas</th>
                        <th class="px-4 py-2">Grade</th>
                        <th class="px-4 py-2">Harga (Rp)</th>
                        <th class="px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil filter jika ada
                    $filter = isset($_GET['filter_komoditas']) ? $_GET['filter_komoditas'] : '';

                    // PAGINATION SETUP
                    $perPage = 25; //jumlah data yg ditampilkan
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $perPage;

                    // Hitung total data
                    $count_sql = "SELECT COUNT(*) as total 
                        FROM commodity_prices cp
                        JOIN grades g ON cp.grade_id = g.id
                        JOIN commodities c ON g.commodity_id = c.id";
                    if ($filter) {
                        $count_sql .= " WHERE c.id = ?";
                        $stmt_count = $conn->prepare($count_sql);
                        $stmt_count->bind_param("i", $filter);
                        $stmt_count->execute();
                        $result_count = $stmt_count->get_result();
                        $totalData = $result_count->fetch_assoc()['total'];
                        $stmt_count->close();
                    } else {
                        $result_count = $conn->query($count_sql);
                        $totalData = $result_count->fetch_assoc()['total'];
                    }
                    $totalPages = ceil($totalData / $perPage);

                    // Query data dengan LIMIT
                    $sql_komoditas = "SELECT 
                                            c.nama AS komoditas, 
                                            g.nama_grade AS grade, 
                                            cp.harga, 
                                            cp.tanggal
                                        FROM commodity_prices cp
                                        JOIN grades g ON cp.grade_id = g.id
                                        JOIN commodities c ON g.commodity_id = c.id";
                    if ($filter) {
                        $sql_komoditas .= " WHERE c.id = ?";
                    }
                    $sql_komoditas .= " ORDER BY cp.tanggal DESC LIMIT ? OFFSET ?";

                    if ($filter) {
                        $stmt = $conn->prepare($sql_komoditas);
                        $stmt->bind_param("iii", $filter, $perPage, $offset);
                        $stmt->execute();
                        $result_komoditas = $stmt->get_result();
                    } else {
                        $stmt = $conn->prepare($sql_komoditas);
                        $stmt->bind_param("ii", $perPage, $offset);
                        $stmt->execute();
                        $result_komoditas = $stmt->get_result();
                    }

                    $no = $offset + 1;
                    $chartData = [];

                    if ($result_komoditas && $result_komoditas->num_rows > 0) {
                        while ($row = $result_komoditas->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="px-4 py-2 text-center">' . $no++ . '</td>';
                            echo '<td class="px-4 py-2">' . htmlspecialchars($row['komoditas']) . '</td>';
                            echo '<td class="px-4 py-2">' . htmlspecialchars($row['grade']) . '</td>';
                            echo '<td class="px-4 py-2">Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>';
                            echo '<td class="px-4 py-2">' . htmlspecialchars($row['tanggal']) . '</td>';
                            echo '</tr>';

                            // Chart prep
                            $chartData[$row['komoditas']][$row['grade']][$row['tanggal']] = $row['harga'];
                        }
                    } else {
                        echo '<tr><td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada data untuk komoditas tersebut.</td></tr>';
                    }
                    ?>
                </tbody>
                </table>
                <!-- PAGINATION LINKS -->
                <div class="mt-4 flex justify-center space-x-2">
                    <?php
                    // Build base URL for pagination (preserve filter)
                    $baseUrl = $_SERVER['PHP_SELF'] . '?';
                    if ($filter) {
                        $baseUrl .= 'filter_komoditas=' . urlencode($filter) . '&';
                    }
                    // Previous button
                    if ($page > 1) {
                        echo '<a href="' . $baseUrl . 'page=' . ($page - 1) . '" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Sebelumnya</a>';
                    }
                    // Numbered links
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            echo '<span class="px-3 py-1 rounded bg-indigo-600 text-white font-bold">' . $i . '</span>';
                        } else {
                            echo '<a href="' . $baseUrl . 'page=' . $i . '" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">' . $i . '</a>';
                        }
                    }
                    // Next button
                    if ($page < $totalPages) {
                        echo '<a href="' . $baseUrl . 'page=' . ($page + 1) . '" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Berikutnya</a>';
                    }
                    ?>
                </div>
            
        </div>


        <script>
            <?php
            // Ambil data tanggal unik
            $all_tanggal = [];
            foreach ($chartData as $komoditas => $grades) {
                foreach ($grades as $grade => $tanggalHarga) {
                    foreach ($tanggalHarga as $tanggal => $harga) {
                        if (!in_array($tanggal, $all_tanggal)) $all_tanggal[] = $tanggal;
                    }
                }
            }
            sort($all_tanggal);

            // Warna default per komoditas
            $colors = [
                'Beras' => 'rgba(79,70,229,0.7)',
                'Jagung' => 'rgba(251,191,36,0.7)',
                'Cabai' => 'rgba(239,68,68,0.7)',
                'Tomat' => 'rgba(16,185,129,0.7)',
                'Ketan' => 'rgba(96,165,250,0.7)'
            ];

            // Ambil nama komoditas terfilter (jika ada)
            $nama_terfilter = '';
            if (!empty($filter)) {
                $get_nama = $conn->query("SELECT nama FROM commodities WHERE id = $filter");
                $nama_row = $get_nama->fetch_assoc();
                $nama_terfilter = $nama_row['nama'] ?? '';
            }

            // Build datasets
            $datasets = [];
            foreach ($chartData as $komoditas => $grades) {
                foreach ($grades as $grade => $tanggalHarga) {
                    $data = [];
                    foreach ($all_tanggal as $tanggal) {
                        $data[] = isset($tanggalHarga[$tanggal]) ? (int)$tanggalHarga[$tanggal] : null;
                    }

                    // Label: Komoditas - Grade
                    $label = $komoditas . ' - ' . $grade;

                    // Jika filter aktif, tonjolkan warna hanya untuk yang cocok
                    if ($nama_terfilter && $komoditas === $nama_terfilter) {
                        $color = $colors[$komoditas] ?? 'rgba(97, 150, 235, 1)';
                    } elseif ($nama_terfilter) {
                        // Grey out lainnya
                        $color = 'rgba(209,213,219,0.3)'; // gray-300 transparan
                    } else {
                        // Jika tidak difilter, pakai warna bawaan
                        $color = $colors[$komoditas] ?? 'rgba(59,130,246,0.7)';
                    }

                    $datasets[] = [
                        'label' => $label,
                        'data' => $data,
                        'borderColor' => $color,
                        'backgroundColor' => $color,
                        'tension' => 0.3,
                        'spanGaps' => true
                    ];
                }
            }
            ?>

            const ctx = document.getElementById('hargaChart').getContext('2d');
            const hargaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($all_tanggal); ?>,
                    datasets: <?php echo json_encode($datasets); ?>
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


</body>

</html>