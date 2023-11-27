-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2023 at 09:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `atas_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agen`
--

INSERT INTO `agen` (`id`, `user_id`, `nama`, `alamat`, `telepon`, `no_rekening`, `bank`, `atas_nama`) VALUES
(1, 2, 'Sumber Rejeki', 'Jalan MT. Haryono No.3 Malang', '08885477865', '00829123242', 'BRI', 'Agus Mulyanto');

-- --------------------------------------------------------

--
-- Table structure for table `cc`
--

CREATE TABLE `cc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cc`
--

INSERT INTO `cc` (`id`, `nama`) VALUES
(1, '800'),
(2, '1000'),
(3, '1200'),
(4, '1300'),
(5, '1400'),
(6, '1500'),
(7, '1600'),
(8, '1800'),
(9, '2000'),
(10, '2200'),
(11, '2400'),
(12, '2500'),
(13, '3000'),
(14, '3500'),
(15, '4000'),
(16, '4500'),
(17, '5000'),
(18, '5500'),
(19, '6000'),
(20, '6500'),
(21, '7000'),
(22, '7500'),
(23, '8000'),
(24, '8500'),
(25, '9000'),
(26, '9500'),
(27, '10000'),
(28, '10500'),
(29, '11000'),
(30, '11500'),
(31, '12000'),
(32, '12500'),
(33, '13000'),
(34, '13500'),
(35, '14000'),
(36, '14500'),
(37, '15000'),
(38, '15500'),
(39, '16000');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_mobil`
--

CREATE TABLE `jenis_mobil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_mobil`
--

INSERT INTO `jenis_mobil` (`id`, `nama`) VALUES
(1, 'SUV'),
(2, 'MPV'),
(3, 'Sedan'),
(4, 'Hatchback'),
(5, 'Coupe'),
(6, 'Convertible'),
(7, 'Sport'),
(8, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `merk_mobil`
--

CREATE TABLE `merk_mobil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merk_mobil`
--

INSERT INTO `merk_mobil` (`id`, `nama`) VALUES
(1, 'Toyota'),
(2, 'Honda'),
(3, 'Daihatsu'),
(4, 'Suzuki'),
(5, 'Mitsubishi'),
(6, 'Nissan'),
(7, 'Mazda'),
(8, 'Isuzu'),
(9, 'Mercedes-Benz'),
(10, 'BMW'),
(11, 'Audi'),
(12, 'Volkswagen'),
(13, 'Lexus'),
(14, 'KIA'),
(15, 'Hyundai'),
(16, 'Chevrolet'),
(17, 'Ford'),
(18, 'Jeep'),
(19, 'Datsun'),
(20, 'Subaru'),
(21, 'Peugeot'),
(22, 'Renault'),
(23, 'Ferrari'),
(24, 'Lamborghini'),
(25, 'Porsche'),
(26, 'Jaguar'),
(27, 'Maserati'),
(28, 'Bentley'),
(29, 'Tesla'),
(30, 'Rolls-Royce'),
(31, 'Lotus'),
(32, 'Hummer'),
(33, 'Mini'),
(34, 'Alfa Romeo'),
(35, 'Aston Martin'),
(36, 'Dodge'),
(37, 'Cadillac'),
(38, 'Chrysler'),
(39, 'Infiniti'),
(40, 'Lincoln'),
(41, 'Volvo'),
(42, 'Ssangyong'),
(43, 'Opel'),
(44, 'Citroen'),
(45, 'Smart'),
(46, 'Pontiac'),
(47, 'Saturn'),
(48, 'Saab'),
(49, 'Scion'),
(50, 'Acura'),
(51, 'Daewoo'),
(52, 'Geo'),
(53, 'Plymouth'),
(54, 'Oldsmobile'),
(55, 'Mercury'),
(56, 'MG'),
(57, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_11_23_053535_cc', 1),
(4, '2023_11_23_145803_agen', 1),
(5, '2023_11_23_150759_warna', 1),
(6, '2023_11_23_151055_transmisi', 1),
(7, '2023_11_23_151832_jenis__mobil', 1),
(8, '2023_11_23_152134_merk_mobil', 1),
(9, '2023_11_23_152650_mobil', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agen_id` bigint(20) UNSIGNED NOT NULL,
  `merk_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_id` bigint(20) UNSIGNED NOT NULL,
  `transmisi_id` bigint(20) UNSIGNED NOT NULL,
  `warna_id` bigint(20) UNSIGNED NOT NULL,
  `cc_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `plat_nomor` varchar(255) NOT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `harga` bigint(20) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `agen_id`, `merk_id`, `jenis_id`, `transmisi_id`, `warna_id`, `cc_id`, `nama`, `plat_nomor`, `tahun`, `harga`, `kapasitas`, `foto`, `status`) VALUES
(1, 1, 1, 1, 2, 1, 6, 'Toyota Expander', 'N 1234 AG', '2022', 150000, 6, '', 'available'),
(2, 1, 2, 4, 3, 2, 2, 'Brio', 'B 8287 KL', '2013', 80000, 4, '', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transmisi`
--

CREATE TABLE `transmisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transmisi`
--

INSERT INTO `transmisi` (`id`, `nama`) VALUES
(1, 'Manual'),
(2, 'Automatic'),
(3, 'CVT'),
(4, 'AMT'),
(5, 'DCT'),
(6, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('administrator','agent','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `alamat`, `no_hp`, `foto`, `role`) VALUES
(1, 'Administator', 'admin@gmail.com', '$2y$12$H4qeeBsytKINTgZr5i8UP.78aQQbojRdVSKQbpMMUmkZq.Mcu3wHq', 'Jl. Raya Cikarang', '081234567890', NULL, 'administrator'),
(2, 'Agent Rental Mobil', 'agent@gmail.com', '$2y$12$UtDDpLT4CNqXm4DP0VPoMeFtIc4r7OArw32UJndSQiKR6eWT74n3O', 'Jl. Melati', '0812345678', NULL, 'agent'),
(3, 'John Doe', 'customer@gmail.com', '$2y$12$10hLDZnRPux9E34F7hzHCO78F8B4u74IZy3ugIK1b9XIZsSUPxj8a', 'Jl. Mawar', '08123456789', NULL, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`id`, `nama`, `kode`) VALUES
(1, 'Hitam', '#000000'),
(2, 'Putih', '#ffffff'),
(3, 'Merah', '#ff0000'),
(4, 'Biru', '#0000ff'),
(5, 'Hijau', '#00ff00'),
(6, 'Kuning', '#ffff00'),
(7, 'Abu-abu', '#808080'),
(8, 'Coklat', '#a52a2a'),
(9, 'Navy', '#000080'),
(10, 'Olive', '#808000'),
(11, 'Oranye', '#ffa500'),
(12, 'Ungu', '#800080'),
(13, 'Perak', '#c0c0c0'),
(14, 'Teal', '#008080'),
(15, 'Fuchsia', '#ff00ff'),
(16, 'Lime', '#00ff00'),
(17, 'Maroon', '#800000'),
(18, 'Navy', '#000080'),
(19, 'Olive', '#808000'),
(20, 'Purple', '#800080'),
(21, 'Silver', '#c0c0c0'),
(22, 'Teal', '#008080'),
(23, 'Fuchsia', '#ff00ff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agen_user_id_foreign` (`user_id`);

--
-- Indexes for table `cc`
--
ALTER TABLE `cc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_mobil`
--
ALTER TABLE `jenis_mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merk_mobil`
--
ALTER TABLE `merk_mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobil_agen_id_foreign` (`agen_id`),
  ADD KEY `mobil_merk_id_foreign` (`merk_id`),
  ADD KEY `mobil_jenis_id_foreign` (`jenis_id`),
  ADD KEY `mobil_transmisi_id_foreign` (`transmisi_id`),
  ADD KEY `mobil_warna_id_foreign` (`warna_id`),
  ADD KEY `mobil_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transmisi`
--
ALTER TABLE `transmisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agen`
--
ALTER TABLE `agen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cc`
--
ALTER TABLE `cc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `jenis_mobil`
--
ALTER TABLE `jenis_mobil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `merk_mobil`
--
ALTER TABLE `merk_mobil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transmisi`
--
ALTER TABLE `transmisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warna`
--
ALTER TABLE `warna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agen`
--
ALTER TABLE `agen`
  ADD CONSTRAINT `agen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `mobil_agen_id_foreign` FOREIGN KEY (`agen_id`) REFERENCES `agen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `cc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_jenis_id_foreign` FOREIGN KEY (`jenis_id`) REFERENCES `jenis_mobil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_merk_id_foreign` FOREIGN KEY (`merk_id`) REFERENCES `merk_mobil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_transmisi_id_foreign` FOREIGN KEY (`transmisi_id`) REFERENCES `transmisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_warna_id_foreign` FOREIGN KEY (`warna_id`) REFERENCES `warna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
