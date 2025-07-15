-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2025 pada 09.05
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
(8, 9, '2025-07-14', 6600),
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
(30, 15, '2025-07-08', 8500),
(0, 1, '2025-07-08', 12000),
(0, 1, '2025-07-09', 12100),
(0, 1, '2025-07-10', 11950),
(0, 1, '2025-07-11', 12050),
(0, 1, '2025-07-12', 12100),
(0, 1, '2025-07-13', 12000),
(0, 1, '2025-07-14', 12200),
(0, 2, '2025-07-08', 11200),
(0, 2, '2025-07-09', 11300),
(0, 2, '2025-07-10', 11250),
(0, 2, '2025-07-11', 11100),
(0, 2, '2025-07-12', 11200),
(0, 2, '2025-07-13', 11350),
(0, 2, '2025-07-14', 11400),
(0, 3, '2025-07-08', 10400),
(0, 3, '2025-07-09', 10500),
(0, 3, '2025-07-10', 10350),
(0, 3, '2025-07-11', 10450),
(0, 3, '2025-07-12', 10300),
(0, 3, '2025-07-13', 10250),
(0, 3, '2025-07-14', 10300),
(0, 4, '2025-07-08', 27000),
(0, 4, '2025-07-09', 26800),
(0, 4, '2025-07-10', 27200),
(0, 4, '2025-07-11', 27500),
(0, 4, '2025-07-12', 27000),
(0, 4, '2025-07-13', 26900),
(0, 4, '2025-07-14', 27100),
(0, 5, '2025-07-08', 25500),
(0, 5, '2025-07-09', 25700),
(0, 5, '2025-07-10', 25400),
(0, 5, '2025-07-11', 25000),
(0, 5, '2025-07-12', 25100),
(0, 5, '2025-07-13', 24900),
(0, 5, '2025-07-14', 25200),
(0, 6, '2025-07-08', 24000),
(0, 6, '2025-07-09', 23800),
(0, 6, '2025-07-10', 23950),
(0, 6, '2025-07-11', 24000),
(0, 6, '2025-07-12', 23700),
(0, 6, '2025-07-13', 23600),
(0, 6, '2025-07-14', 23800),
(0, 7, '2025-07-08', 5300),
(0, 7, '2025-07-09', 5200),
(0, 7, '2025-07-10', 5250),
(0, 7, '2025-07-11', 5350),
(0, 7, '2025-07-12', 5400),
(0, 7, '2025-07-13', 5300),
(0, 7, '2025-07-14', 5450),
(0, 8, '2025-07-08', 5000),
(0, 8, '2025-07-09', 5050),
(0, 8, '2025-07-10', 4900),
(0, 8, '2025-07-11', 4950),
(0, 8, '2025-07-12', 4980),
(0, 8, '2025-07-13', 4930),
(0, 8, '2025-07-14', 4990),
(0, 9, '2025-07-08', 4700),
(0, 9, '2025-07-09', 4720),
(0, 9, '2025-07-10', 4650),
(0, 9, '2025-07-11', 4600),
(0, 9, '2025-07-12', 4620),
(0, 9, '2025-07-13', 4680),
(0, 9, '2025-07-14', 4700),
(0, 10, '2025-07-08', 14500),
(0, 10, '2025-07-09', 14700),
(0, 10, '2025-07-10', 14600),
(0, 10, '2025-07-11', 14450),
(0, 10, '2025-07-12', 14550),
(0, 10, '2025-07-13', 14650),
(0, 10, '2025-07-14', 14750),
(0, 11, '2025-07-08', 13800),
(0, 11, '2025-07-09', 13700),
(0, 11, '2025-07-10', 13900),
(0, 11, '2025-07-11', 13850),
(0, 11, '2025-07-12', 13750),
(0, 11, '2025-07-13', 13650),
(0, 11, '2025-07-14', 13800),
(0, 12, '2025-07-08', 13000),
(0, 12, '2025-07-09', 12950),
(0, 12, '2025-07-10', 13100),
(0, 12, '2025-07-11', 13000),
(0, 12, '2025-07-12', 12800),
(0, 12, '2025-07-13', 12750),
(0, 12, '2025-07-14', 12900),
(0, 13, '2025-07-08', 9200),
(0, 13, '2025-07-09', 9300),
(0, 13, '2025-07-10', 9150),
(0, 13, '2025-07-11', 9100),
(0, 13, '2025-07-12', 9250),
(0, 13, '2025-07-13', 9350),
(0, 13, '2025-07-14', 9400),
(0, 14, '2025-07-08', 8600),
(0, 14, '2025-07-09', 8700),
(0, 14, '2025-07-10', 8650),
(0, 14, '2025-07-11', 8550),
(0, 14, '2025-07-12', 8620),
(0, 14, '2025-07-13', 8700),
(0, 14, '2025-07-14', 8750),
(0, 15, '2025-07-08', 8000),
(0, 15, '2025-07-09', 8100),
(0, 15, '2025-07-10', 8050),
(0, 15, '2025-07-11', 7900),
(0, 15, '2025-07-12', 8000),
(0, 15, '2025-07-13', 7950),
(0, 15, '2025-07-14', 8050),
(0, 8, '2025-07-14', 2300);

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
(3, 'aku', 'aku', 'aku', 'admin');

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
