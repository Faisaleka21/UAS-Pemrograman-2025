-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2025 at 06:15 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

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
-- Table structure for table `commodities`
--

CREATE TABLE `commodities` (
  `id` int NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commodities`
--

INSERT INTO `commodities` (`id`, `nama`) VALUES
(1, 'Beras'),
(2, 'Cabai'),
(3, 'Jagung'),
(4, 'Ketan'),
(5, 'Tomat');

-- --------------------------------------------------------

--
-- Table structure for table `commodity_prices`
--

CREATE TABLE `commodity_prices` (
  `id` int NOT NULL,
  `grade_id` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commodity_prices`
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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int NOT NULL,
  `commodity_id` int DEFAULT NULL,
  `nama_grade` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `commodity_id`, `nama_grade`) VALUES
(1, 1, 'Premium'),
(2, 1, 'Medium'),
(3, 1, 'Rendah'),
(4, 2, 'Premium'),
(5, 2, 'Medium'),
(6, 2, 'Rendah'),
(7, 3, 'Premium'),
(8, 3, 'Medium'),
(9, 3, 'Rendah'),
(10, 4, 'Premium'),
(11, 4, 'Medium'),
(12, 4, 'Rendah'),
(13, 5, 'Premium'),
(14, 5, 'Medium'),
(15, 5, 'Rendah');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petani','pedagang') DEFAULT 'petani'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', '123', 'admin'),
(2, 'Pak Budi', 'budi', 'budi123', 'petani'),
(3, 'jono', 'sari', 'jono123', 'pedagang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `commodity_prices`
--
ALTER TABLE `commodity_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grade_id` (`grade_id`,`tanggal`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commodity_id` (`commodity_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commodities`
--
ALTER TABLE `commodities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `commodity_prices`
--
ALTER TABLE `commodity_prices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commodity_prices`
--
ALTER TABLE `commodity_prices`
  ADD CONSTRAINT `commodity_prices_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`commodity_id`) REFERENCES `commodities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
