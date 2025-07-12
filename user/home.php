<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('petani');

// Ambil data harga terbaru per grade per komoditas
$query = "
    SELECT c.nama AS komoditas, g.nama_grade, cp.harga, cp.tanggal 
    FROM commodity_prices cp
    INNER JOIN grades g ON cp.grade_id = g.id
    INNER JOIN commodities c ON g.commodity_id = c.id
    WHERE cp.tanggal = (
        SELECT MAX(tanggal)
        FROM commodity_prices cp2
        WHERE cp2.grade_id = cp.grade_id
    )
    ORDER BY c.nama, g.nama_grade;
";

$result = mysqli_query($conn, $query);
$data_terbaru = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_terbaru[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HargaPangan Desa - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Bootstrap & DataTables -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- Tailwind (optional styling) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2e7d32',
            secondary: '#689f38',
            accent: '#8bc34a',
          }
        }
      }
    }
  </script>

  <style>
    .dark-mode {
      background-color: #1a252f;
      color: #ffffff;
    }
    .dark-mode .bg-white {
      background-color: #2c3e50 !important;
      color: #ffffff;
    }
    .dark-mode .text-gray-800 {
      color: #ffffff !important;
    }
  </style>
</head>
<body class="bg-gray-50">
  <!-- Header -->
  <header class="bg-primary text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <i class="fas fa-leaf text-2xl"></i>
        <h1 class="text-xl md:text-2xl font-bold">HargaPangan Desa</h1>
      </div>
      <div class="flex items-center space-x-4">
        <button id="themeToggle" class="p-2 rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
          <i class="fas fa-moon" id="themeIcon"></i>
        </button>
        <span id="lastUpdate" class="text-sm opacity-80"></span>
      </div>
    </div>

    <nav class="bg-secondary bg-opacity-90">
      <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <ul class="flex space-x-6 font-medium">
          <li><a href="home.php" class="hover:text-accent transition flex items-center"><i class="fas fa-home mr-1"></i> Beranda</a></li>
          <li><a href="harga.php" class="hover:text-accent transition flex items-center"><i class="fas fa-tags mr-1"></i> Harga Komoditas</a></li>
          <li><a href="tentang.php" class="hover:text-accent transition flex items-center"><i class="fas fa-info-circle mr-1"></i> Tentang</a></li>
        </ul>
        <div>
          <a href="../logout.php" class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded transition flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </div>
    </nav>
  </header>

 
  <!-- Hero -->
<section class="bg-gradient-to-r from-primary to-secondary text-white py-12 px-4">
  <div class="container mx-auto text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">Sistem Informasi Harga Pangan Desa</h2>
    <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90">
      Dapatkan informasi harga pangan terkini untuk komoditas pertanian Anda secara real-time.
    </p>
    <div class="mt-8">
      <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/6699f243-6b49-4dc9-9de3-db23ae840a04.png" 
           alt="Ilustrasi sawah dengan petani sedang bekerja di bawah sinar matahari terbit dengan latar belakang pegunungan" 
           class="rounded-lg shadow-xl mx-auto border-4 border-white max-w-full" />
    </div>
  </div>
</section>


  <!-- Insight Section -->
  <main>
    <section id="insight" class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center mb-4">Insight Harga Terbaru</h2>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="insightTable">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Komoditas</th>
                <th>Grade</th>
                <th>Harga (Rp)</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($data_terbaru as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['komoditas'] ?></td>
                <td><?= $row['nama_grade'] ?></td>
                <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['tanggal'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Tentang -->
    <section class="mb-12 bg-primary bg-opacity-10 rounded-lg p-6">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-info-circle mr-3 text-primary"></i>
        Tentang HargaPangan Desa
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <p class="text-gray-700 mb-4">
            HargaPangan Desa adalah sistem informasi harga pangan real-time yang dirancang khusus untuk membantu petani dan pelaku usaha pertanian memahami dinamika harga pasar.
          </p>
          <p class="text-gray-700 mb-4">
            Dengan data yang diperbarui setiap hari dari berbagai pasar di wilayah desa, kami memberikan informasi yang akurat dan terpercaya untuk membantu pengambilan keputusan.
          </p>
        </div>
        <div>
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/38f2a92c-3acd-4f47-a384-1a7653682c18.png" alt="Tim HargaPangan Desa" class="rounded-lg shadow-md w-full" />
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-primary text-white py-8">
    <div class="container mx-auto px-4 text-center">
      <div class="flex justify-center mb-4">
        <i class="fas fa-leaf text-2xl mr-2"></i>
        <span class="text-xl font-bold">HargaPangan Desa</span>
      </div>
      <p class="text-sm opacity-80">© 2023 HargaPangan Desa. Seluruh hak cipta dilindungi.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const now = new Date();
      document.getElementById('lastUpdate').textContent = `Diperbarui: ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')} WIB`;

      const themeToggle = document.getElementById('themeToggle');
      const themeIcon = document.getElementById('themeIcon');
      let darkMode = false;

      themeToggle.addEventListener('click', () => {
        darkMode = !darkMode;
        document.body.classList.toggle('dark-mode', darkMode);
        themeIcon.classList.toggle('fa-sun', darkMode);
        themeIcon.classList.toggle('fa-moon', !darkMode);
      });
    });
  </script>

  <!-- jQuery & DataTables -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#insightTable').DataTable({
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
  </script>
</body>
</html>
