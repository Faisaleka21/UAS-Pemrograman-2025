<?php
require_once '../koneksi/conn.php';
require_once '../../auth.php';
requireLogin('user');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HargaPangan Desa - Sistem Informasi Harga Pangan Real-Time untuk Petani</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
  </header>

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

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8">
    <!-- Price Overview Cards -->
    <section class="mb-12">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-chart-line mr-3 text-primary"></i>
        Ringkasan Harga Hari Ini
      </h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Beras -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-bold text-lg text-gray-800">Beras</h4>
              <p class="text-gray-600 text-sm">Medium</p>
            </div>
            <i class="fas fa-rice text-3xl text-primary"></i>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold">Rp12,500</p>
            <p class="text-sm flex items-center mt-1">
              <span class="price-up mr-1"><i class="fas fa-arrow-up"></i> 2.5%</span>
              <span class="text-gray-600 ml-2">dari kemarin</span>
            </p>
          </div>
          <div class="chart-container mt-4 flex space-x-1 items-end">
            <div class="chart-bar" style="height:40%"></div>
            <div class="chart-bar" style="height:60%"></div>
            <div class="chart-bar" style="height:75%"></div>
            <div class="chart-bar" style="height:100%"></div>
            <div class="chart-bar" style="height:80%"></div>
          </div>
        </div>
        
        <!-- Cabai Merah -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-bold text-lg text-gray-800">Cabai Merah</h4>
              <p class="text-gray-600 text-sm">Kualitas A</p>
            </div>
            <i class="fas fa-pepper-hot text-3xl text-red-500"></i>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold">Rp35,000</p>
            <p class="text-sm flex items-center mt-1">
              <span class="price-down mr-1"><i class="fas fa-arrow-down"></i> 5.2%</span>
              <span class="text-gray-600 ml-2">dari kemarin</span>
            </p>
          </div>
          <div class="chart-container mt-4 flex space-x-1 items-end">
            <div class="chart-bar" style="height:100%"></div>
            <div class="chart-bar" style="height:95%"></div>
            <div class="chart-bar" style="height:85%"></div>
            <div class="chart-bar" style="height:70%"></div>
            <div class="chart-bar" style="height:60%"></div>
          </div>
        </div>
        
        <!-- Bawang Merah -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-bold text-lg text-gray-800">Bawang Merah</h4>
              <p class="text-gray-600 text-sm">Lokal</p>
            </div>
            <i class="fas fa-onion text-3xl text-purple-500"></i>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold">Rp27,800</p>
            <p class="text-sm flex items-center mt-1">
              <span class="price-stable mr-1"><i class="fas fa-equals"></i></span>
              <span class="text-gray-600 ml-2">stabil</span>
            </p>
          </div>
          <div class="chart-container mt-4 flex space-x-1 items-end">
            <div class="chart-bar" style="height:90%"></div>
            <div class="chart-bar" style="height:85%"></div>
            <div class="chart-bar" style="height:87%"></div>
            <div class="chart-bar" style="height:88%"></div>
            <div class="chart-bar" style="height:90%"></div>
          </div>
        </div>
        
        <!-- Jagung -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-bold text-lg text-gray-800">Jagung</h4>
              <p class="text-gray-600 text-sm">Kualitas B</p>
            </div>
            <i class="fas fa-corn text-3xl text-yellow-600"></i>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold">Rp7,200</p>
            <p class="text-sm flex items-center mt-1">
              <span class="price-up mr-1"><i class="fas fa-arrow-up"></i> 1.8%</span>
              <span class="text-gray-600 ml-2">dari kemarin</span>
            </p>
          </div>
          <div class="chart-container mt-4 flex space-x-1 items-end">
            <div class="chart-bar" style="height:70%"></div>
            <div class="chart-bar" style="height:65%"></div>
            <div class="chart-bar" style="height:75%"></div>
            <div class="chart-bar" style="height:80%"></div>
            <div class="chart-bar" style="height:85%"></div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Full Price Table -->
    <section class="mb-12">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-table mr-3 text-primary"></i>
        Daftar Lengkap Harga Komoditas
      </h3>
      
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-primary text-white">
              <tr>
                <th class="py-3 px-4 text-left">No</th>
                <th class="py-3 px-4 text-left">Komoditas</th>
                <th class="py-3 px-4 text-left">Kualitas</th>
                <th class="py-3 px-4 text-right">Harga (Rp)</th>
                <th class="py-3 px-4 text-right">Perubahan</th>
                <th class="py-3 px-4 text-left">Pasar</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="py-3 px-4">1</td>
                <td class="py-3 px-4 font-medium">Beras</td>
                <td class="py-3 px-4">Medium</td>
                <td class="py-3 px-4 text-right">12,500</td>
                <td class="py-3 px-4 text-right price-up"><i class="fas fa-arrow-up mr-1"></i> 2.5%</td>
                <td class="py-3 px-4">Pasar Induk</td>
              </tr>
              <tr class="bg-gray-50">
                <td class="py-3 px-4">2</td>
                <td class="py-3 px-4 font-medium">Cabai Merah</td>
                <td class="py-3 px-4">Kualitas A</td>
                <td class="py-3 px-4 text-right">35,000</td>
                <td class="py-3 px-4 text-right price-down"><i class="fas fa-arrow-down mr-1"></i> 5.2%</td>
                <td class="py-3 px-4">Pasar Desa</td>
              </tr>
              <tr>
                <td class="py-3 px-4">3</td>
                <td class="py-3 px-4 font-medium">Bawang Merah</td>
                <td class="py-3 px-4">Lokal</td>
                <td class="py-3 px-4 text-right">27,800</td>
                <td class="py-3 px-4 text-right price-stable"><i class="fas fa-equals mr-1"></i> stabil</td>
                <td class="py-3 px-4">Pasar Induk</td>
              </tr>
              <tr class="bg-gray-50">
                <td class="py-3 px-4">4</td>
                <td class="py-3 px-4 font-medium">Jagung</td>
                <td class="py-3 px-4">Kualitas B</td>
                <td class="py-3 px-4 text-right">7,200</td>
                <td class="py-3 px-4 text-right price-up"><i class="fas fa-arrow-up mr-1"></i> 1.8%</td>
                <td class="py-3 px-4">Pasar Desa</td>
              </tr>
              <tr>
                <td class="py-3 px-4">5</td>
                <td class="py-3 px-4 font-medium">Kedelai</td>
                <td class="py-3 px-4">Lokal</td>
                <td class="py-3 px-4 text-right">9,500</td>
                <td class="py-3 px-4 text-right price-down"><i class="fas fa-arrow-down mr-1"></i> 3.1%</td>
                <td class="py-3 px-4">Pasar Induk</td>
              </tr>
              <tr class="bg-gray-50">
                <td class="py-3 px-4">6</td>
                <td class="py-3 px-4 font-medium">Gula Pasir</td>
                <td class="py-3 px-4">Rafinasi</td>
                <td class="py-3 px-4 text-right">14,300</td>
                <td class="py-3 px-4 text-right price-stable"><i class="fas fa-equals mr-1"></i> stabil</td>
                <td class="py-3 px-4">Pasar Induk</td>
              </tr>
              <tr>
                <td class="py-3 px-4">7</td>
                <td class="py-3 px-4 font-medium">Minyak Goreng</td>
                <td class="py-3 px-4">Kemasan</td>
                <td class="py-3 px-4 text-right">18,000</td>
                <td class="py-3 px-4 text-right price-up"><i class="fas fa-arrow-up mr-1"></i> 0.9%</td>
                <td class="py-3 px-4">Pasar Desa</td>
              </tr>
              <tr class="bg-gray-50">
                <td class="py-3 px-4">8</td>
                <td class="py-3 px-4 font-medium">Telur Ayam</td>
                <td class="py-3 px-4">Ras</td>
                <td class="py-3 px-4 text-right">26,500</td>
                <td class="py-3 px-4 text-right price-down"><i class="fas fa-arrow-down mr-1"></i> 2.3%</td>
                <td class="py-3 px-4">Pasar Desa</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
    
    <!-- Price Trends Section -->
    <section class="mb-12">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-chart-area mr-3 text-primary"></i>
        Tren Harga 7 Hari Terakhir
      </h3>
      
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-wrap -mx-4">
          <div class="w-full md:w-1/2 px-4 mb-6 md:mb-0">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Beras (Rp/kg)</h4>
            <div class="chart-container" id="berasChart"></div>
          </div>
          <div class="w-full md:w-1/2 px-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Cabai Merah (Rp/kg)</h4>
            <div class="chart-container" id="cabeChart"></div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Market Info Section -->
    <section class="mb-12">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-store mr-3 text-primary"></i>
        Informasi Pasar Terkini
      </h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/cb3b7a54-87bb-47c7-abb9-0db50c0a117c.png" alt="Pasar tradisional yang sibuk dengan para pedagang dan pembeli, berbagai sayuran dan buah terlihat segar di atas meja" class="w-full h-48 object-cover" />
          <div class="p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Pasar Induk Desa</h4>
            <p class="text-gray-600 mb-4">Update terakhir: Hari ini, 08.45 WIB</p>
            <p class="text-gray-700">Harga cenderung stabil untuk komoditas pokok, dengan peningkatan permintaan pada beras dan minyak goreng.</p>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/1cd4981c-6e3a-481c-9cc8-f6be24d21153.png" alt="Pasar desa sederhana dengan para petani menjual hasil tani langsung, suasana ramah dan alami" class="w-full h-48 object-cover" />
          <div class="p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Pasar Tani Desa</h4>
            <p class="text-gray-600 mb-4">Update terakhir: Hari ini, 09.30 WIB</p>
            <p class="text-gray-700">Pasokan cabai merah meningkat menyebabkan penurunan harga, sedangkan bawang merah tetap stabil.</p>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Notification Section -->
    <section class="mb-12">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-bell mr-3 text-primary"></i>
        Notifikasi Harga
      </h3>
      
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
          <p class="font-medium">Dapatkan notifikasi saat harga komoditas Anda berubah</p>
          <button class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
            Aktifkan Notifikasi
          </button>
        </div>
        
        <div class="relative">
          <input type="text" placeholder="Masukkan email atau nomor WhatsApp Anda" class="w-full p-4 pr-32 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
          <button class="absolute right-2 top-2 bg-primary text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            Daftar
          </button>
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
</body>
</html>

