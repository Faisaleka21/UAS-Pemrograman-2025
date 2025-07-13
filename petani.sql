-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2025 pada 05.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petani`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `commodities`
--

CREATE TABLE `commodities` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `commodities`
--

INSERT INTO `commodities` (`id`, `nama`) VALUES
(1, 'Beras'),
(2, 'Cabai'),
(3, 'Jagung'),
(4, 'Ketan'),
(5, 'Tomat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `commodity_prices`
--

CREATE TABLE `commodity_prices` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `commodity_prices`
--

INSERT INTO `commodity_prices` (`id`, `grade_id`, `tanggal`, `harga`) VALUES
(1, 1, '2025-07-09', 12500),
(2, 2, '2025-07-09', 11200),
(3, 3, '2025-07-09', 9800),
(4, 4, '2025-07-09', 45000),
(5, 5, '2025-07-09', 39000),
(6, 6, '2025-07-09', 34000),
(7, 7, '2025-07-09', 7200),
(8, 8, '2025-07-09', 6600),
(9, 9, '2025-07-09', 5900),
(10, 10, '2025-07-09', 15000),
(11, 11, '2025-07-09', 13800),
(12, 12, '2025-07-09', 12200),
(13, 13, '2025-07-09', 11000),
(14, 14, '2025-07-09', 9900),
(15, 15, '2025-07-09', 8700),
(16, 1, '2025-07-08', 12300),
(17, 2, '2025-07-08', 11000),
(18, 3, '2025-07-08', 9500),
(19, 4, '2025-07-08', 43000),
(20, 5, '2025-07-08', 38500),
(21, 6, '2025-07-08', 33000),
(22, 7, '2025-07-08', 7000),
(23, 8, '2025-07-08', 6400),
(24, 9, '2025-07-08', 5700),
(25, 10, '2025-07-08', 14800),
(26, 11, '2025-07-08', 13500),
(27, 12, '2025-07-08', 12000),
(28, 13, '2025-07-08', 10800),
(29, 14, '2025-07-08', 9600),
(30, 15, '2025-07-08', 8500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `commodity_id` int(11) DEFAULT NULL,
  `nama_grade` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `grades`
--

INSERT INTO `grades` (`id`, `commodity_id`, `nama_grade`) VALUES
(1, 1, 'Premium'),
(2, 1, 'Medium'),
(3, 1, 'Ekonomis'),
(4, 2, 'Premium'),
(5, 2, 'Medium'),
(6, 2, 'Ekonomis'),
(7, 3, 'Premium'),
(8, 3, 'Medium'),
(9, 3, 'Ekonomis'),
(10, 4, 'Premium'),
(11, 4, 'Medium'),
(12, 4, 'Ekonomis'),
(13, 5, 'Premium'),
(14, 5, 'Medium'),
(15, 5, 'Ekonomis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','petani') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `nama`, `username`, `password`, `role`) VALUES
(1, 'faisal', 'faisal', 'faisal', 'petani'),
(2, 'admin', 'admin', 'admin123', 'admin'),
(3, 'a', 'a', 'a', 'petani'),
(4, 'Faisal Eka Nur Irawan ', '23', '23', 'petani');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `commodity_prices`
--
ALTER TABLE `commodity_prices`
  ADD KEY `commodity_prices_ibfk_1` (`grade_id`);

--
-- Indeks untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_ibfk_1` (`commodity_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `commodity_prices`
--
ALTER TABLE `commodity_prices`
  ADD CONSTRAINT `commodity_prices_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`commodity_id`) REFERENCES `commodities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
