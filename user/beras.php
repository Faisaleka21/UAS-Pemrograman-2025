<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('petani');

// Ambil ID komoditas untuk "Beras"
$commodity_query = mysqli_query($conn, "SELECT id FROM commodities WHERE nama = 'Beras' LIMIT 1");
$commodity = mysqli_fetch_assoc($commodity_query);
$commodity_id = $commodity['id'];

// Ambil semua grade untuk komoditas Beras
$grade_query = mysqli_query($conn, "SELECT id, nama_grade FROM grades WHERE commodity_id = $commodity_id");
$grades = [];
while ($row = mysqli_fetch_assoc($grade_query)) {
  $grades[] = $row;
}

// Ambil data harga 7 hari terakhir & histori semua data per grade
$data_chart = [];
$data_table = [];
foreach ($grades as $grade) {
  $grade_id = $grade['id'];

  // Harga 7 hari terakhir (untuk chart)
  $chart_query = mysqli_query($conn, "
    SELECT tanggal, harga FROM commodity_prices
    WHERE grade_id = $grade_id
    ORDER BY tanggal DESC
    LIMIT 7
  ");
  $data_chart[$grade_id] = array_reverse(mysqli_fetch_all($chart_query, MYSQLI_ASSOC));

  // Seluruh histori harga (untuk tabel)
  $table_query = mysqli_query($conn, "
    SELECT tanggal, harga FROM commodity_prices
    WHERE grade_id = $grade_id
    ORDER BY tanggal DESC
  ");
  $data_table[$grade_id] = mysqli_fetch_all($table_query, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HargaPangan Desa - Dashboard Beras</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
  <header class="bg-primary text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <i class="fas fa-leaf text-2xl"></i>
        <h1 class="text-xl md:text-2xl font-bold">HargaPangan Desa</h1>
      </div>
      <div class="text-sm opacity-80">Diperbarui: <?= date('H:i') ?> WIB</div>
    </div>

    <nav class="bg-secondary bg-opacity-90">
      <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <ul class="flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-accent transition flex items-center"><i class="fas fa-home mr-1"></i> Beranda</a></li>
          
          <li class="dropdown">
            <a class="dropdown-toggle hover:text-accent transition flex items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-seedling mr-1"></i> Komoditas
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item active" href="beras.php">Beras</a></li>
              <li><a class="dropdown-item" href="cabai.php">Cabai</a></li>
              <li><a class="dropdown-item" href="jagung.php">Jagung</a></li>
              <li><a class="dropdown-item" href="ketan.php">Ketan</a></li>
              <li><a class="dropdown-item" href="tomat.php">Tomat</a></li>
            </ul>
          </li>
          
        </ul>
        <a href="../logout.php" class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded transition flex items-center">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </nav>
  </header>

  <div class="container py-10">
    <h1 class="text-3xl font-bold mb-10 text-center">Dashboard Harga - Beras</h1>

    <?php foreach ($grades as $grade): ?>
      <section class="py-10 px-6 mb-12 rounded-lg shadow bg-white">
        <div class="grid md:grid-cols-2 gap-8 items-start">
          <!-- Kiri: Chart -->
          <div>
            <h3 class="text-xl font-semibold mb-3">Grade: <?= htmlspecialchars($grade['nama_grade']) ?></h3>
            <canvas id="chart_<?= $grade['id'] ?>" class="w-full h-64"></canvas>
          </div>
          <!-- Kanan: Highlight -->
          <div class="bg-gray-100 p-6 rounded-lg text-center">
            <p class="text-sm text-gray-600">Pergerakan 7 hari terakhir</p>
            <p class="text-3xl font-bold text-green-600 mt-2">+3.2%</p>
            <p class="mt-2 text-sm text-gray-500">Harga naik stabil dari Rp12.000 ke Rp12.500</p>
          </div>
        </div>

        <!-- Table -->
        <div class="mt-6">
          <div class="table-responsive">
            <table class="table table-bordered table-striped dataTable" id="table_<?= $grade['id'] ?>">
              <thead class="table-dark">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Harga (Rp)</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($data_table[$grade['id']] as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    <?php endforeach; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.dataTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 20],
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ baris",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          paginate: {
            previous: "Sebelumnya",
            next: "Berikutnya"
          }
        }
      });
    });

    <?php foreach ($grades as $grade): 
      $chartData = $data_chart[$grade['id']];
      $labels = json_encode(array_column($chartData, 'tanggal'));
      $data = json_encode(array_column($chartData, 'harga'));
    ?>
    new Chart(document.getElementById("chart_<?= $grade['id'] ?>"), {
      type: 'line',
      data: {
        labels: <?= $labels ?>,
        datasets: [{
          label: 'Harga (Rp)',
          data: <?= $data ?>,
          fill: true,
          borderColor: '#2e7d32',
          backgroundColor: 'rgba(46, 125, 50, 0.1)',
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          y: {
            ticks: {
              callback: function(value) {
                return 'Rp' + value.toLocaleString();
              }
            }
          }
        }
      }
    });
    <?php endforeach; ?>
  </script>
</body>
</html>
