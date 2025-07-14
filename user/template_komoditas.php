<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HargaPangan Desa - Dashboard <?= htmlspecialchars($komoditas_nama) ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1e293b',
            secondary: '#475569',
            accent: '#22c55e',
          }
        }
      }
    }
  </script>
  <style>
    .bg-primary {
      background-color: #5046E5 !important;
    }
    .bg-secondary {
      background-color: #7A3AED !important;
    }
  </style>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-primary text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <i class="fas fa-leaf text-2xl"></i>
        <h1 class="text-xl md:text-2xl font-bold">HargaPangan Desa</h1>
      </div>
      <div class="text-sm opacity-80">Diperbarui: <?= date('H:i') ?> WIB</div>
    </div>

    <!-- Navigasi -->
    <nav class="bg-secondary bg-opacity-50">
      <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <ul class="flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-accent transition flex items-center"><i class="fas fa-home mr-1"></i> Beranda</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle hover:text-accent transition flex items-center" href="#" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-seedling mr-1"></i> Komoditas
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item<?= $komoditas_nama == 'Beras' ? ' active' : '' ?>" href="beras.php">Beras</a></li>
              <li><a class="dropdown-item<?= $komoditas_nama == 'Cabai' ? ' active' : '' ?>" href="cabai.php">Cabai</a></li>
              <li><a class="dropdown-item<?= $komoditas_nama == 'Jagung' ? ' active' : '' ?>" href="jagung.php">Jagung</a></li>
              <li><a class="dropdown-item<?= $komoditas_nama == 'Ketan' ? ' active' : '' ?>" href="ketan.php">Ketan</a></li>
              <li><a class="dropdown-item<?= $komoditas_nama == 'Tomat' ? ' active' : '' ?>" href="tomat.php">Tomat</a></li>
            </ul>
          </li>
        </ul>
        <a href="../logout.php" class="mt-2 md:mt-0 bg-accent hover:bg-green-600 text-white px-4 py-2 rounded transition">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </nav>
  </header>

  <!-- Konten -->
  <div class="container py-10">
    <h1 class="text-3xl font-bold mb-10 text-center">Harga <?= $komoditas_nama ?></h1>

    <?php foreach ($grades as $grade): ?>
      <section class="py-10 px-6 mb-12 rounded-lg shadow bg-white">
        <div class="grid md:grid-cols-2 gap-8 items-start">
          <!-- Chart -->
          <div>
            <h3 class="text-xl font-semibold mb-3">Grade: <?= htmlspecialchars($grade['nama_grade']) ?></h3>
            <canvas id="chart_<?= $grade['id'] ?>" class="w-full h-64"></canvas>
          </div>

          <!-- Highlight -->
          <div class="bg-gray-100 p-6 rounded-lg text-center">
            <?php
              $harga_chart = $data_chart[$grade['id']];
              if (count($harga_chart) >= 2) {
                $awal = $harga_chart[0]['harga'];
                $akhir = $harga_chart[count($harga_chart) - 1]['harga'];
                $selisih = $akhir - $awal;
                $persen = $awal != 0 ? round(($selisih / $awal) * 100, 2) : 0;
                $arah = $selisih >= 0 ? 'naik' : 'turun';
                $warna = $selisih >= 0 ? 'text-green-600' : 'text-red-600';
              } else {
                $persen = 0;
                $arah = '-';
                $warna = 'text-gray-500';
                $awal = $akhir = 0;
              }
            ?>
            <p class="text-sm text-gray-600">Pergerakan 7 hari terakhir</p>
            <p class="text-3xl font-bold <?= $warna ?> mt-2"><?= ($persen >= 0 ? '+' : '') . $persen ?>%</p>
            <p class="mt-2 text-sm text-gray-500">Harga <?= $arah ?> dari Rp<?= number_format($awal, 0, ',', '.') ?> ke Rp<?= number_format($akhir, 0, ',', '.') ?></p>
          </div>
        </div>

        <!-- Tabel -->
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

   <!-- Footer -->
  <footer class="bg-primary text-white py-8">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
      <div class="flex justify-center mb-4 items-center space-x-2">
        <i class="fas fa-leaf text-2xl"></i>
        <span class="text-xl font-bold">HargaPangan Desa</span>
      </div>
      <p class="text-sm opacity-80">© 2025 HargaPangan Desa. hak cipta dilindungi.</p>
    </div>
  </footer>

  <!-- Script -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
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
          borderColor: 'rgba(55, 206, 211, 0.91)',
          backgroundColor: 'rgba(13, 127, 131, 0.1)',
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
