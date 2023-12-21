-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2023 at 05:49 AM
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
(1, 3, 'Agent Sumber Jaya', 'Jl. MT Haryono No. 1 Kota Jakarta', '0812345678', '001234567890', 'BCA', 'Sumber Jaya'),
(2, 4, 'Agen Joyo Makmur', 'Jl. Soekarno Hatta No. 2 Kota Jakarta', '0812345678', '001234567890', 'BRI', 'Joyo Makmur'),
(3, 5, 'Agen Sumber Rejeki', 'Jl. Menteng No. 3 Kota Jakarta', '0812345678', '001234567890', 'BNI', 'Sumber Rejeki');

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
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id`, `nama`, `tarif`) VALUES
(1, 'Keterlambatan', 100000),
(2, 'Kerusakan', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `jaminan`
--

CREATE TABLE `jaminan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jaminan`
--

INSERT INTO `jaminan` (`id`, `nama`) VALUES
(1, 'KTP'),
(2, 'KK'),
(3, 'NPWP'),
(4, 'Perhiasan');

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
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `nama`) VALUES
(1, 'Transfer Bank'),
(2, 'Tunai');

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
(3, '2023_11_20_001442_jaminan', 1),
(4, '2023_11_22_062725_tipe_mobi', 1),
(5, '2023_11_23_053535_cc', 1),
(6, '2023_11_23_145803_agen', 1),
(7, '2023_11_23_150759_warna', 1),
(8, '2023_11_23_151055_transmisi', 1),
(9, '2023_11_23_151832_jenis__mobil', 1),
(10, '2023_11_23_152134_merk_mobil', 1),
(11, '2023_11_23_152650_mobil', 1),
(12, '2023_11_30_045924_status_pembayaran', 1),
(13, '2023_11_30_053815_status_pengembalian', 1),
(14, '2023_11_30_055138_metode_pembayaran', 1),
(15, '2023_11_30_055444_denda', 1),
(16, '2023_11_30_060007_transaksi', 1);

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
  `tipe_id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `mobil` (`id`, `agen_id`, `merk_id`, `jenis_id`, `transmisi_id`, `warna_id`, `cc_id`, `tipe_id`, `nama`, `plat_nomor`, `tahun`, `harga`, `kapasitas`, `foto`, `status`) VALUES
(1, 1, 1, 1, 1, 1, 1, 2, 'Avanza', 'B 1234 ABC', '2019', 50000, 8, NULL, 'available'),
(2, 1, 2, 2, 2, 2, 2, 2, 'Xenia', 'B 1411 AG', '2018', 70000, 8, NULL, 'available'),
(3, 1, 3, 1, 2, 3, 3, 2, 'Terios', 'L 121 AB', '2022', 100000, 6, NULL, 'available'),
(4, 1, 4, 2, 1, 4, 4, 1, 'Ertiga', 'B 1234 ABC', '2019', 60000, 8, NULL, 'available'),
(5, 1, 5, 1, 2, 5, 5, 1, 'Xpander', 'B 6511 AG', '2018', 120000, 8, NULL, 'available'),
(6, 2, 6, 2, 1, 6, 6, 1, 'Livina', 'L 7454 AB', '2022', 100000, 6, NULL, 'available'),
(7, 2, 7, 1, 2, 7, 7, 2, 'Mobilio', 'B 1255 ABC', '2019', 80000, 8, NULL, 'available'),
(8, 2, 8, 2, 1, 8, 8, 2, 'BRV', 'B 1411 AG', '2018', 70000, 8, NULL, 'available'),
(9, 2, 9, 1, 2, 9, 9, 2, 'Rush', 'L 2132 AB', '2022', 100000, 6, NULL, 'available'),
(10, 3, 1, 2, 1, 1, 1, 1, 'Grand Livina', 'B 1212 BG', '2019', 50000, 8, NULL, 'available'),
(11, 3, 2, 1, 2, 2, 2, 1, 'Grand Xenia', 'B 1411 AG', '2018', 70000, 8, NULL, 'available'),
(12, 3, 3, 2, 1, 3, 3, 2, 'Terios', 'L 121 AB', '2022', 100000, 6, NULL, 'available'),
(13, 3, 4, 1, 2, 4, 4, 2, 'Ertiga', 'B 1234 ABC', '2019', 60000, 8, NULL, 'available'),
(14, 3, 5, 2, 1, 5, 5, 1, 'Xpander', 'B 6511 AG', '2018', 120000, 8, NULL, 'available');

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
-- Table structure for table `status_pembayaran`
--

CREATE TABLE `status_pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pembayaran`
--

INSERT INTO `status_pembayaran` (`id`, `status_pembayaran`) VALUES
(1, 'Belum Bayar'),
(2, 'Sedang Dikonfirmasi'),
(3, 'Ditolak'),
(4, 'Belum Lunas'),
(5, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `status_pengembalian`
--

CREATE TABLE `status_pengembalian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_pengembalian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pengembalian`
--

INSERT INTO `status_pengembalian` (`id`, `status_pengembalian`) VALUES
(1, 'Belum Diambil'),
(2, 'Sedang Disewa'),
(3, 'Sudah Dikembalikan');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_mobil`
--

CREATE TABLE `tipe_mobil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipe_mobil`
--

INSERT INTO `tipe_mobil` (`id`, `nama`) VALUES
(1, 'Tinggi'),
(2, 'Sedang'),
(3, 'Rendah');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobil_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agen_id` bigint(20) UNSIGNED NOT NULL,
  `metode_pembayaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_pembayaran_id` bigint(20) UNSIGNED NOT NULL,
  `status_pengembalian_id` bigint(20) UNSIGNED NOT NULL,
  `jaminan_id` bigint(20) UNSIGNED NOT NULL,
  `denda_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `alamat_penerima` varchar(255) NOT NULL,
  `no_hp_penerima` varchar(255) NOT NULL,
  `tanggal_sewa` datetime NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL,
  `tanggal_pengembalian` datetime DEFAULT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `diskon` int(11) DEFAULT NULL,
  `persentase_dp` int(11) DEFAULT NULL,
  `jumlah_dp` int(11) DEFAULT NULL,
  `bukti_dp` varchar(255) DEFAULT NULL,
  `tanggal_dp` datetime DEFAULT NULL,
  `jumlah_bayar_lunas` int(11) DEFAULT NULL,
  `bukti_bayar_lunas` varchar(255) DEFAULT NULL,
  `tanggal_bayar_lunas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `mobil_id`, `user_id`, `agen_id`, `metode_pembayaran_id`, `status_pembayaran_id`, `status_pengembalian_id`, `jaminan_id`, `denda_id`, `kode_transaksi`, `nama_penerima`, `alamat_penerima`, `no_hp_penerima`, `tanggal_sewa`, `tanggal_pemesanan`, `tanggal_pengembalian`, `jumlah_hari`, `total_harga`, `diskon`, `persentase_dp`, `jumlah_dp`, `bukti_dp`, `tanggal_dp`, `jumlah_bayar_lunas`, `bukti_bayar_lunas`, `tanggal_bayar_lunas`) VALUES
(1, 1, 2, 1, 1, 5, 3, 1, NULL, 'TRX1221053441496', 'John Doe', 'Jl. Mawar', '08123456789', '2023-12-21 00:00:00', '2023-12-21 05:34:41', '2023-12-21 05:44:38', 3, 150000, NULL, 50, 75000, 'images/bukti/6583c0aa197d4.jpg', '2023-12-21 05:35:54', 75000, 'images/bukti/6583c30a2c622.jpg', '2023-12-21 05:46:02'),
(2, 6, 2, 2, 1, 5, 3, 2, NULL, 'TRX1221053456943', 'John Doe', 'Jl. Mawar', '08123456789', '2023-12-21 00:00:00', '2023-12-21 05:34:56', '2023-12-21 05:41:56', 2, 200000, NULL, 50, 100000, 'images/bukti/6583c0a2c0ebc.jpg', '2023-12-21 05:35:46', 100000, 'images/bukti/6583c30418752.jpg', '2023-12-21 05:45:56'),
(3, 11, 2, 3, 1, 5, 3, 3, NULL, 'TRX1221053519475', 'John Doe', 'Jl. Mawar', '08123456789', '2023-12-21 00:00:00', '2023-12-21 05:35:19', '2023-12-21 05:42:39', 5, 350000, NULL, 100, 350000, 'images/bukti/6583c09b8b620.jpg', '2023-12-21 05:35:39', NULL, NULL, NULL),
(4, 14, 6, 3, 1, 5, 3, 1, NULL, 'TRX1221053739934', 'Joko Widodo', 'Jalan Soekarno Hatta No. 123 Jakarta Pusat', '088127182381', '2023-12-25 00:00:00', '2023-12-21 05:37:39', '2023-12-21 05:45:03', 2, 240000, NULL, 25, 60000, 'images/bukti/6583c139f2414.jpg', '2023-12-21 05:38:17', 180000, 'images/bukti/6583c328c3993.jpg', '2023-12-21 05:46:32'),
(5, 10, 6, 3, 1, 5, 3, 3, NULL, 'TRX1221053802847', 'Joko Widodo', 'Jalan Soekarno Hatta No. 123 Jakarta Pusat', '088127182381', '2023-12-24 00:00:00', '2023-12-21 05:38:02', '2023-12-21 05:45:01', 2, 100000, NULL, 50, 50000, 'images/bukti/6583c132e6a96.jpg', '2023-12-21 05:38:10', 50000, 'images/bukti/6583c322b5013.jpg', '2023-12-21 05:46:26'),
(6, 9, 6, 2, 1, 5, 3, 1, NULL, 'TRX1221053842506', 'Joko Widodo', 'Jalan Soekarno Hatta No. 123 Jakarta Pusat', '088127182381', '2023-12-31 00:00:00', '2023-12-21 05:38:42', '2023-12-21 05:45:25', 10, 1000000, NULL, 50, 500000, 'images/bukti/6583c1601f44b.jpg', '2023-12-21 05:38:56', 500000, 'images/bukti/6583c31bf3b5f.jpg', '2023-12-21 05:46:19');

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
(1, 'Administator', 'admin@gmail.com', '$2y$12$OPoJ1D4HGBFa/Yz6nSP1teqLtG3bBn3HSa4cApy4oQzeJzt6qFdmW', 'Jl. Raya Cikarang', '081234567890', NULL, 'administrator'),
(2, 'John Doe', 'customer@gmail.com', '$2y$12$4UO4Nei/BrFEEDky8uUzneFWtgYj.wJwT3EZGe48sPi/yPRqNwxzq', 'Jl. Mawar', '08123456789', NULL, 'customer'),
(3, 'Agent Sumber Jaya', 'sumberjaya@gmail.com', '$2y$12$WcMSeIPojZX0IRCK0DfVqeWvErSuql56RsZNonGujtOBPXcQapJfS', 'Jl. Melati', '0812345678', NULL, 'agent'),
(4, 'Agen Joyo Makmur', 'joyomakmur@gmail.com', '$2y$12$gC0zOqjpry7dJKorERsyYOXkj0wf.hl/K.HLgu2zsgce72Wz7MbkG', 'Jl. Melati', '0812345678', NULL, 'agent'),
(5, 'Agen Sumber Rejeki', 'sumberrejeki@gmail.com', '$2y$12$SVqVWXbathOuoSquS4IPwuxT8L2n450fxjk84pDncv53kfm87TRFe', 'Jl. Melati', '0812345678', NULL, 'agent'),
(6, 'Joko Widodo', 'joko@gmail.com', '$2y$10$CYA6hHa8KGEUyZHx2bIBI.AQoxGDKcpfgvvwwOGwQM32IwbbxHzvi', 'Jalan Soekarno Hatta No. 123 Jakarta Pusat', '088127182381', NULL, 'customer');

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
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jaminan`
--
ALTER TABLE `jaminan`
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
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
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
  ADD KEY `mobil_cc_id_foreign` (`cc_id`),
  ADD KEY `mobil_tipe_id_foreign` (`tipe_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `status_pembayaran`
--
ALTER TABLE `status_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_pengembalian`
--
ALTER TABLE `status_pengembalian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipe_mobil`
--
ALTER TABLE `tipe_mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_mobil_id_foreign` (`mobil_id`),
  ADD KEY `transaksi_user_id_foreign` (`user_id`),
  ADD KEY `transaksi_agen_id_foreign` (`agen_id`),
  ADD KEY `transaksi_metode_pembayaran_id_foreign` (`metode_pembayaran_id`),
  ADD KEY `transaksi_status_pembayaran_id_foreign` (`status_pembayaran_id`),
  ADD KEY `transaksi_status_pengembalian_id_foreign` (`status_pengembalian_id`),
  ADD KEY `transaksi_jaminan_id_foreign` (`jaminan_id`),
  ADD KEY `transaksi_denda_id_foreign` (`denda_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cc`
--
ALTER TABLE `cc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jaminan`
--
ALTER TABLE `jaminan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_pembayaran`
--
ALTER TABLE `status_pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `status_pengembalian`
--
ALTER TABLE `status_pengembalian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipe_mobil`
--
ALTER TABLE `tipe_mobil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transmisi`
--
ALTER TABLE `transmisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `mobil_tipe_id_foreign` FOREIGN KEY (`tipe_id`) REFERENCES `tipe_mobil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_transmisi_id_foreign` FOREIGN KEY (`transmisi_id`) REFERENCES `transmisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobil_warna_id_foreign` FOREIGN KEY (`warna_id`) REFERENCES `warna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_agen_id_foreign` FOREIGN KEY (`agen_id`) REFERENCES `agen` (`id`),
  ADD CONSTRAINT `transaksi_denda_id_foreign` FOREIGN KEY (`denda_id`) REFERENCES `denda` (`id`),
  ADD CONSTRAINT `transaksi_jaminan_id_foreign` FOREIGN KEY (`jaminan_id`) REFERENCES `jaminan` (`id`),
  ADD CONSTRAINT `transaksi_metode_pembayaran_id_foreign` FOREIGN KEY (`metode_pembayaran_id`) REFERENCES `metode_pembayaran` (`id`),
  ADD CONSTRAINT `transaksi_mobil_id_foreign` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`),
  ADD CONSTRAINT `transaksi_status_pembayaran_id_foreign` FOREIGN KEY (`status_pembayaran_id`) REFERENCES `status_pembayaran` (`id`),
  ADD CONSTRAINT `transaksi_status_pengembalian_id_foreign` FOREIGN KEY (`status_pengembalian_id`) REFERENCES `status_pengembalian` (`id`),
  ADD CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
