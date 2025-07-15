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

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tailwind -->
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
    .bg-primary {
      background-color: #5046E5 !important;
    }
    .bg-secondary {
      background-color: #7A3AED !important;
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

<!-- Tentang Aplikasi -->
<!-- Tentang HargaPangan Desa -->
<section class="py-20 bg-gradient-to-b from-white via-gray-50 to-gray-100">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-extrabold text-primary mb-4">🌾 Tentang <span class="text-accent">HargaPangan Desa</span></h2>
      <p class="text-gray-600 max-w-3xl mx-auto">Sebuah platform real-time yang membantu petani, pelaku pasar, dan masyarakat desa untuk memantau harga pangan lokal dengan mudah dan transparan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <!-- Ilustrasi -->
      <div>
        <img src="../image/gambar3.jpg" alt="Ilustrasi Pertanian" class="w-full rounded-2xl shadow-lg border-4 border-white">
      </div>

      <!-- Konten -->
      <div class="space-y-6">
        <div class="flex items-start gap-4">
          <div class="bg-accent text-white p-3 rounded-full">
            <i class="fas fa-sync-alt text-lg"></i>
          </div>
          <div>
            <h4 class="text-xl font-semibold text-primary">Update Harga Harian</h4>
            <p class="text-gray-600">Data harga diperbarui otomatis dari pasar desa secara real-time.</p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="bg-yellow-400 text-white p-3 rounded-full">
            <i class="fas fa-chart-bar text-lg"></i>
          </div>
          <div>
            <h4 class="text-xl font-semibold text-primary">Visualisasi Tren Harga</h4>
            <p class="text-gray-600">Tampilan grafik tren harga per komoditas dan grade memudahkan analisa pasar.</p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="bg-indigo-500 text-white p-3 rounded-full">
            <i class="fas fa-mobile-alt text-lg"></i>
          </div>
          <div>
            <h4 class="text-xl font-semibold text-primary">Desain Mobile Friendly</h4>
            <p class="text-gray-600">Akses informasi di mana saja melalui desktop atau perangkat mobile.</p>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="bg-rose-500 text-white p-3 rounded-full">
            <i class="fas fa-hand-holding-heart text-lg"></i>
          </div>
          <div>
            <h4 class="text-xl font-semibold text-primary">Memberdayakan Petani</h4>
            <p class="text-gray-600">Dukung kesejahteraan petani dengan data harga yang transparan dan akurat.</p>
          </div>
        </div>
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
