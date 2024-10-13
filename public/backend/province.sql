-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2024 at 04:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dawala`
--

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `nama` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `country_id`, `nama`) VALUES
(11, 1, 'Aceh'),
(12, 1, 'Sumatera Utara'),
(13, 1, 'Sumatera Barat'),
(14, 1, 'Riau'),
(15, 1, 'Jambi'),
(16, 1, 'Sumatera Selatan'),
(17, 1, 'Bengkulu'),
(18, 1, 'Lampung'),
(19, 1, 'Kepulauan Bangka Belitung'),
(21, 1, 'Kepulauan Riau'),
(31, 1, 'DKI Jakarta'),
(32, 1, 'Jawa Barat'),
(33, 1, 'Jawa Tengah'),
(34, 1, 'DI Yogyakarta'),
(35, 1, 'Jawa Timur'),
(36, 1, 'Banten'),
(51, 1, 'Bali'),
(52, 1, 'Nusa Tenggara Barat'),
(53, 1, 'Nusa Tenggara Timur'),
(61, 1, 'Kalimantan Barat'),
(62, 1, 'Kalimantan Tengah'),
(63, 1, 'Kalimantan Selatan'),
(64, 1, 'Kalimantan Timur'),
(65, 1, 'Kalimantan Utara'),
(71, 1, 'Sulawesi Utara'),
(72, 1, 'Sulawesi Tengah'),
(73, 1, 'Sulawesi Selatan'),
(74, 1, 'Sulawesi Tenggara'),
(75, 1, 'Gorontalo'),
(76, 1, 'Sulawesi Barat'),
(81, 1, 'Maluku'),
(82, 1, 'Maluku Utara'),
(91, 1, 'Papua Barat'),
(92, 1, 'Papua');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
