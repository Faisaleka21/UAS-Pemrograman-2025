<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('petani');

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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HargaPangan Desa - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
    .dropdown:hover .dropdown-menu {
      display: block;
    }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- Header -->
  <header class="bg-primary text-white py-4 shadow">
    <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <div class="flex items-center space-x-2 mb-2 md:mb-0">
        <i class="fas fa-leaf text-2xl"></i>
        <h1 class="text-2xl font-bold">HargaPangan Desa</h1>
      </div>
      <nav class="relative">
        <ul class="flex space-x-6 font-medium items-center">
          <li><a href="home.php" class="hover:text-accent transition"><i class="fas fa-home mr-1"></i>Beranda</a></li>
          
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

          <li><a href="tentang.php" class="hover:text-accent transition"><i class="fas fa-info-circle mr-1"></i>Tentang</a></li>
        </ul>
      </nav>
      <a href="../logout.php" class="mt-2 md:mt-0 bg-accent hover:bg-green-600 text-white px-4 py-2 rounded transition">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </a>
    </div>
  </header>

  <!-- Hero -->
  <section class="bg-gradient-to-r from-primary to-secondary text-white py-16">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
      <h2 class="text-4xl font-bold mb-4">Sistem Informasi Harga Pangan Desa</h2>
      <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Dapatkan informasi harga pangan terkini untuk komoditas pertanian Anda secara real-time.</p>
      <img src="../image/sawah.png" alt="Ilustrasi sawah" class="mx-auto rounded-lg shadow-lg border-4 border-white max-w-xs" />
    </div>
  </section>

  <!-- Insight Harga -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4">
      <h3 class="text-2xl font-bold text-center mb-10">Harga Komoditas Terbaru</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($data_terbaru as $row): ?>
          <div class="bg-white rounded-lg shadow p-4 text-center">
            <h4 class="font-semibold text-lg mb-1"><?= $row['komoditas'] ?> (<?= $row['nama_grade'] ?>)</h4>
            <p class="text-2xl font-bold text-primary">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
            <p class="text-sm text-gray-500 mt-1"><?= $row['tanggal'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Tentang -->
  <section class="py-16 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h3 class="text-2xl font-bold mb-4">Tentang HargaPangan Desa</h3>
        <p class="mb-4">HargaPangan Desa adalah sistem informasi harga pangan real-time yang dirancang khusus untuk membantu petani dan pelaku usaha pertanian memahami dinamika harga pasar.</p>
        <p>Dengan data yang diperbarui setiap hari dari berbagai pasar di wilayah desa, kami memberikan informasi yang akurat dan terpercaya untuk membantu pengambilan keputusan.</p>
      </div>
      <img src="../image/sawah.jpg" class="w-60 mx-auto rounded-lg shadow" />
    </div>
  </section>

  <!-- Fitur -->
  <section class="py-16 bg-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">
      <h3 class="text-2xl font-bold text-center mb-10">Fitur Unggulan</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded shadow text-center">
          <i class="fas fa-sync fa-2x text-primary mb-4"></i>
          <h4 class="font-semibold mb-2">Data Real-Time</h4>
          <p class="text-sm text-gray-600">Harga diperbarui setiap hari secara otomatis.</p>
        </div>
        <div class="bg-white p-6 rounded shadow text-center">
          <i class="fas fa-shield-alt fa-2x text-primary mb-4"></i>
          <h4 class="font-semibold mb-2">Valid dan Terpercaya</h4>
          <p class="text-sm text-gray-600">Sumber data resmi dari pasar lokal desa.</p>
        </div>
        <div class="bg-white p-6 rounded shadow text-center">
          <i class="fas fa-chart-line fa-2x text-primary mb-4"></i>
          <h4 class="font-semibold mb-2">Tren Harga</h4>
          <p class="text-sm text-gray-600">Pantau pergerakan harga komoditas dengan mudah.</p>
        </div>
        <div class="bg-white p-6 rounded shadow text-center">
          <i class="fas fa-mobile-alt fa-2x text-primary mb-4"></i>
          <h4 class="font-semibold mb-2">Akses Mudah</h4>
          <p class="text-sm text-gray-600">Tersedia di berbagai perangkat, desktop maupun mobile.</p>
        </div>
      </div>
    </div>
  </section>

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

</body>
</html>
