<?php
require_once '../koneksi/conn.php';
require_once '../auth.php';
requireLogin('petani');
?>
 <!-- data insight -->
<?php
include '../koneksi.php';

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
  <title>HargaPangan Desa - Sistem Informasi Harga Pangan Real-Time untuk Petani</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


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
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
      animation: fadeIn 0.5s ease-out forwards;
    }
    
    .price-up {
      color: #d32f2f;
    }
    
    .price-down {
      color: #388e3c;
    }
    
    .price-stable {
      color: #ffa000;
    }
    
    .chart-container {
      height: 200px;
      position: relative;
    }
    
    .chart-bar {
      position: absolute;
      bottom: 0;
      width: 20px;
      background-color: #8bc34a;
      transition: height 0.5s ease;
    }
    
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
          <li>
            <a href="home.php" class="hover:text-accent transition flex items-center">
              <i class="fas fa-home mr-1"></i> Beranda
            </a>
          </li>
          <li>
            <a href="harga.php" class="hover:text-accent transition flex items-center">
              <i class="fas fa-tags mr-1"></i> Harga Komoditas
            </a>
          </li>
          <li>
            <a href="tentang.php" class="hover:text-accent transition flex items-center">
              <i class="fas fa-info-circle mr-1"></i> Tentang
            </a>
          </li>
        </ul>
        <div>
          <a href="../logout.php" class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded transition flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </div>
    </nav>
  </header>
<!-- header end -->

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-primary to-secondary text-white py-12 px-4">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-4 animate-fadeIn">Sistem Informasi Harga Pangan Desa</h2>
      <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90 animate-fadeIn" style="animation-delay: 0.2s;">
        Dapatkan informasi harga pangan terkini untuk komoditas pertanian Anda secara real-time
      </p>
      <div class="mt-8 animate-fadeIn" style="animation-delay: 0.4s;">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/6699f243-6b49-4dc9-9de3-db23ae840a04.png" alt="Ilustrasi sawah dengan petani sedang bekerja di bawah sinar matahari terbit dengan latar belakang pegunungan" class="rounded-lg shadow-xl mx-auto border-4 border-white" />
      </div>
    </div>
  </section>
  <!-- insight Section -->
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
          <?php
          $no = 1;
          foreach ($data_terbaru as $row): ?>
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

    <!-- About Section -->
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
          <div class="flex space-x-4">
            <a href="#" class="text-primary hover:underline font-medium">Kebijakan Privasi</a>
            <a href="#" class="text-primary hover:underline font-medium">Syarat & Ketentuan</a>
          </div>
        </div>
        
        <div>
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/38f2a92c-3acd-4f47-a384-1a7653682c18.png" alt="Tim HargaPangan Desa sedang bekerja di kantor lapangan, menganalisis data harga komoditas" class="rounded-lg shadow-md w-full" />
        </div>
      </div>
    </section>
  </main>
  
  <!-- Footer -->
  <footer class="bg-primary text-white py-8">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
          <div class="flex items-center space-x-2">
            <i class="fas fa-leaf text-2xl"></i>
            <h3 class="text-xl font-bold">HargaPangan Desa</h3>
          </div>
          <p class="mt-2 text-sm opacity-80">Membantu petani dengan informasi harga real-time</p>
        </div>
        
        <div class="flex space-x-6">
          <a href="#" class="hover:text-accent transition" title="Facebook">
            <i class="fab fa-facebook-f text-xl"></i>
          </a>
          <a href="#" class="hover:text-accent transition" title="WhatsApp">
            <i class="fab fa-whatsapp text-xl"></i>
          </a>
          <a href="#" class="hover:text-accent transition" title="Telegram">
            <i class="fab fa-telegram-plane text-xl"></i>
          </a>
        </div>
      </div>
      
      <div class="border-t border-white border-opacity-20 mt-8 pt-6 text-center text-sm opacity-80">
        <p>© 2023 HargaPangan Desa. Seluruh hak cipta dilindungi.</p>
      </div>
    </div>
  </footer>
  
  <script>
    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      // Set last update time
      const now = new Date();
      document.getElementById('lastUpdate').textContent = `Diperbarui: ${formatTime(now)}`;
      
      // Initialize charts
      initCharts();
      
      // Theme toggle functionality
      const themeToggle = document.getElementById('themeToggle');
      const themeIcon = document.getElementById('themeIcon');
      let darkMode = false;
      
      themeToggle.addEventListener('click', function() {
        darkMode = !darkMode;
        if (darkMode) {
          document.body.classList.add('dark-mode');
          themeIcon.classList.remove('fa-moon');
          themeIcon.classList.add('fa-sun');
        } else {
          document.body.classList.remove('dark-mode');
          themeIcon.classList.remove('fa-sun');
          themeIcon.classList.add('fa-moon');
        }
      });
      
      // Simulate real-time price updates
      setInterval(updateRandomPrice, 30000);
    });
    
    function formatTime(date) {
      const hours = date.getHours().toString().padStart(2, '0');
      const minutes = date.getMinutes().toString().padStart(2, '0');
      return `${hours}:${minutes} WIB`;
    }
    
    function initCharts() {
      // Beras chart data
      const berasData = [12000, 12300, 12150, 12200, 12350, 12400, 12500];
      const cabeData = [38000, 37000, 36000, 35500, 35000, 34500, 35000];
      
      // Render simple bar charts
      renderChart('berasChart', berasData);
      renderChart('cabeChart', cabeData);
    }
    
    function renderChart(elementId, dataPoints) {
      const container = document.getElementById(elementId);
      container.innerHTML = '';
      
      // Find max value for scaling
      const maxValue = Math.max(...dataPoints);
      const minHeight = 5; // Minimum bar height percentage
      
      // Create bars
      const barWidth = 90 / dataPoints.length;
      
      for(let i = 0; i < dataPoints.length; i++) {
        const height = minHeight + ((dataPoints[i] / maxValue) * (100 - minHeight));
        const bar = document.createElement('div');
        bar.className = 'chart-bar';
        bar.style.left = `${i * barWidth + 5}%`; // Add 5% offset from left
        bar.style.width = `${barWidth * 0.8}%`; // 80% of allocated space
        bar.style.height = `${height}%`;
        
        // Add tooltip
        bar.dataset.tooltip = `Rp${formatNumber(dataPoints[i])}`;
        container.appendChild(bar);
      }
    }
    
    function formatNumber(num) {
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    function updateRandomPrice() {
      // Simulate price change for demonstration
      const priceCards = document.querySelectorAll('.bg-white.rounded-lg.shadow-md');
      
      priceCards.forEach(card => {
        // 30% chance of change
        if (Math.random() < 0.3) {
          const priceElement = card.querySelector('p.text-2xl');
          const changeElement = card.querySelector('.text-sm.flex.items-center span');
          
          // Get current price
          let price = parseInt(priceElement.textContent.replace(/[^\d]/g, ''));
          
          // Random change between -3% to +3%
          const changePercent = (Math.random() * 6 - 3);
          const newPrice = Math.round(price * (1 + changePercent/100));
          
          // Update price display
          priceElement.textContent = `Rp${formatNumber(newPrice)}`;
          
          // Update change indicator
          if (changePercent > 0) {
            changeElement.className = 'price-up mr-1';
            changeElement.innerHTML = `<i class="fas fa-arrow-up"></i> ${changePercent.toFixed(1)}%`;
          } else if (changePercent < 0) {
            changeElement.className = 'price-down mr-1';
            changeElement.innerHTML = `<i class="fas fa-arrow-down"></i> ${Math.abs(changePercent).toFixed(1)}%`;
          } else {
            changeElement.className = 'price-stable mr-1';
            changeElement.innerHTML = '<i class="fas fa-equals"></i> stabil';
          }
          
          // Update last updated time
          const now = new Date();
          document.getElementById('lastUpdate').textContent = `Diperbarui: ${formatTime(now)}`;
        }
      });
    }
  </script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables + Bootstrap 5 integration -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>

