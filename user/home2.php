<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HargaPangan Desa - Sistem Informasi Harga Pangan Real-Time</title>
    <style>
        :root {
            --primary: #2e7d32;
            --secondary: #558b2f;
            --accent: #8bc34a;
            --light: #f1f8e9;
            --dark: #1b5e20;
            --text: #212121;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }

        header {
            background-color: var(--primary);
            color: var(--white);
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background-color: var(--accent);
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .logo-container img {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .sidebar {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: fit-content;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--dark);
            border-bottom: 2px solid var(--accent);
            padding-bottom: 0.5rem;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            margin-bottom: 0.75rem;
        }

        .category-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.5rem 0;
            width: 100%;
            text-align: left;
            transition: all 0.2s ease;
            color: var(--text);
            display: flex;
            align-items: center;
            border-radius: 4px;
        }

        .category-btn:hover {
            background-color: rgba(139, 195, 74, 0.1);
            color: var(--dark);
            font-weight: 500;
        }

        .category-btn.active {
            background-color: var(--accent);
            color: var(--white);
            font-weight: 600;
        }

        .category-icon {
            margin-right: 0.75rem;
            width: 20px;
            height: 20px;
        }

        .main-content {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .price-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .price-title {
            font-size: 1.5rem;
            color: var(--dark);
            font-weight: 600;
        }

        .refresh-btn {
            background-color: var(--accent);
            color: var(--white);
            border: none;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .refresh-btn:hover {
            background-color: var(--secondary);
        }

        .refresh-icon {
            margin-right: 0.5rem;
        }

        .price-table {
            width: 100%;
            border-collapse: collapse;
        }

        .price-table th {
            background-color: var(--secondary);
            color: var(--white);
            padding: 0.75rem;
            text-align: left;
            font-weight: 500;
        }

        .price-table td {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .price-table tr:hover {
            background-color: rgba(139, 195, 74, 0.05);
        }

        .commodity-name {
            font-weight: 500;
            color: var(--dark);
        }

        .price-value {
            font-weight: 600;
        }

        .price-change {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .price-up {
            background-color: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }

        .price-down {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4caf50;
        }

        .price-neutral {
            background-color: rgba(33, 150, 243, 0.1);
            color: #2196f3;
        }

        .last-update {
            margin-top: 1rem;
            font-size: 0.85rem;
            color: #757575;
            text-align: right;
        }

        .footer {
            text-align: center;
            padding: 1.5rem;
            background-color: var(--dark);
            color: var(--white);
            margin-top: 2rem;
        }

        .footer p {
            margin-bottom: 0.5rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .footer-link {
            color: var(--white);
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }

        .footer-link:hover {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            header {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .container {
                padding: 0 1rem;
                margin: 1rem auto;
            }

            .price-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .refresh-btn {
                width: 100%;
                justify-content: center;
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/fc59a124-00be-4283-8144-1f10b957cfe5.png" alt="Logo HargaPangan Desa bergambar ikon pertanian dengan warna hijau dan kuning" />
            <div>
                <h1>HargaPangan Desa</h1>
                <p class="subtitle">Sistem Informasi Harga Pangan Real-Time untuk Petani</p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <h2>Kategori Komoditas</h2>
                <ul class="category-list">
                    <li class="category-item">
                        <button class="category-btn active">
                            <span class="category-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
                                </svg>
                            </span>
                            Semua Komoditas
                        </button>
                    </li>
                    <li class="category-item">
                        <button class="category-btn">
                            <span class="category-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm1-11h-2v3H8v2h3v3h2v-3h3v-2h-3V8z"/>
                                </svg>
                            </span>
                            Tanaman Pangan
                        </button>
                    </li>
                    <li class="category-item">
                        <button class="category-btn">
                            <span class="category-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 2.09.71 2.16 1.96h1.27c-.07-1.46-.87-2.65-2.37-3.03V5h-1.22v2.01c-1.53.42-2.63 1.51-2.63 3.24 0 2.09 1.72 3.06 3.56 3.58 2.14.56 2.38 1.13 2.38 1.84 0 .53-.38 1.43-2.2 1.43-1.56 0-2.35-.82-2.45-2.19H7.7c.1 1.75 1.51 3.01 3.29 3.35V19h1.22v-2.05c1.84-.42 2.93-1.66 2.93-3.39-.01-2.31-1.75-3.08-3.73-3.51z"/>
                                </svg>
                            </span>
                            Hortikultura
                        </button>
                    </li>
                    <li class="category-item">
                        <button class="category-btn">
                            <span class="category-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.55 18.54l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8zM11 22.45h2V19.5h-2v2.95zM4 10.5H1v2h3v-2zm11-4.19V1.5H9v4.81C7.21 7.35 6 9.28 6 11.5c0 3.31 2.69 6 6 6s6-2.69 6-6c0-2.22-1.21-4.15-3-5.19zm5 4.19v2h3v-2h-3zm-2.76 7.66l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4z"/>
                                </svg>
                            </span>
                            Peternakan
                        </button>
                    </li>
                    <li class="category-item">
                        <button class="category-btn">
                            <span class="category-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                                </svg>
                            </span>
                            Perikanan
                        </button>
                    </li>
                </ul>
            </div>

            <div class="main-content">
                <div class="price-header">
                    <h2 class="price-title">Harga Komoditas Hari Ini</h2>
                    <button class="refresh-btn">
                        <span class="refresh-icon">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                            </svg>
                        </span>
                        Perbarui Data
                    </button>
                </div>

                <div class="price-content">
                    <table class="price-table">
                        <thead>
                            <tr>
                                <th>Komoditas</th>
                                <th>Harga (Rp)</th>
                                <th>Perubahan</th>
                                <th>Tren 7 Hari</th>
                            </tr>
                        </thead>
                        <tbody id="price-data">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>

                <p class="last-update">Terakhir diperbarui: <span id="update-time">Memuat...</span></p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>© 2023 HargaPangan Desa - Sistem Informasi Harga Pangan Real-Time untuk Petani</p>
        <p>Data dikumpulkan dari sumber terpercaya dan diperbarui setiap 30 menit</p>
        <div class="footer-links">
            <a href="#" class="footer-link">Tentang Kami</a>
            <a href="#" class="footer-link">Kebijakan Privasi</a>
            <a href="#" class="footer-link">Hubungi Kami</a>
        </div>
    </footer>

    <script>
        // Sample data komoditas
        const commodities = [
            { name: "Beras Premium", category: "Tanaman Pangan", price: 12500, change: 1.5, trend: "up" },
            { name: "Beras Medium", category: "Tanaman Pangan", price: 10500, change: -0.8, trend: "down" },
            { name: "Jagung", category: "Tanaman Pangan", price: 6800, change: 0.3, trend: "neutral" },
            { name: "Kedelai", category: "Tanaman Pangan", price: 9800, change: 2.1, trend: "up" },
            { name: "Cabai Merah", category: "Hortikultura", price: 45000, change: 5.2, trend: "up" },
            { name: "Bawang Merah", category: "Hortikultura", price: 32000, change: -1.8, trend: "down" },
            { name: "Kentang", category: "Hortikultura", price: 17500, change: 0.7, trend: "neutral" },
            { name: "Daging Sapi", category: "Peternakan", price: 125000, change: -0.5, trend: "down" },
            { name: "Telur Ayam", category: "Peternakan", price: 27000, change: 1.2, trend: "up" },
            { name: "Ikan Bandeng", category: "Perikanan", price: 45000, change: 2.3, trend: "up" },
            { name: "Udang", category: "Perikanan", price: 98000, change: -3.2, trend: "down" }
        ];

        // DOM Elements
        const priceTable = document.getElementById('price-data');
        const updateTime = document.getElementById('update-time');
        const refreshBtn = document.querySelector('.refresh-btn');
        const categoryBtns = document.querySelectorAll('.category-btn');

        // Format harga dengan separator ribuan
        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        }

        // Format perubahan harga dengan tanda +/-
        function formatChange(change) {
            return change > 0 ? `+${change}%` : `${change}%`;
        }

        // Tampilkan data komoditas
        function renderCommodities(filterCategory = "Semua Komoditas") {
            priceTable.innerHTML = '';
            
            const filteredCommodities = filterCategory === "Semua Komoditas" 
                ? commodities 
                : commodities.filter(item => item.category === filterCategory);

            filteredCommodities.forEach(item => {
                const row = document.createElement('tr');
                row.classList.add('fade-in');
                
                const trendClass = {
                    'up': 'price-up',
                    'down': 'price-down',
                    'neutral': 'price-neutral'
                }[item.trend];

                row.innerHTML = `
                    <td class="commodity-name">${item.name}</td>
                    <td class="price-value">Rp ${formatPrice(item.price)}</td>
                    <td><span class="price-change ${trendClass}">${formatChange(item.change)}</span></td>
                    <td><span class="price-change ${trendClass}">${item.trend === 'up' ? 'Naik' : item.trend === 'down' ? 'Turun' : 'Stabil'}</span></td>
                `;

                priceTable.appendChild(row);
            });

            updateTime.textContent = new Date().toLocaleString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Event listener untuk tombol refresh
        refreshBtn.addEventListener('click', () => {
            refreshBtn.disabled = true;
            refreshBtn.innerHTML = `
                <span class="refresh-icon">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                        <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
                    </svg>
                </span>
                Memperbarui...
            `;
            
            // Simulasi loading data
            setTimeout(() => {
                // Tambahkan sedikit variasi harga untuk simulasi perubahan real-time
                commodities.forEach(item => {
                    const randomChange = Math.random() * 3 - 1.5; // Nilai antara -1.5 dan 1.5
                    item.price = Math.max(1000, Math.round(item.price * (1 + randomChange/100)));
                    item.change = (item.change + randomChange).toFixed(1);
                    
                    if (randomChange > 0.5) item.trend = 'up';
                    else if (randomChange < -0.5) item.trend = 'down';
                    else item.trend = 'neutral';
                });

                renderCommodities();
                refreshBtn.innerHTML = `
                    <span class="refresh-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                        </svg>
                    </span>
                    Perbarui Data
                `;
                refreshBtn.disabled = false;
            }, 1500);
        });

        // Event listener untuk kategori filter
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const category = btn.textContent.trim();
                renderCommodities(category);
            });
        });

        // Inisialisasi tampilan pertama
        renderCommodities();

        // Simulasi update otomatis setiap 30 detik
        setInterval(() => {
            refreshBtn.click();
        }, 30000);
    </script>
</body>
</html>

