-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_03_131052_create_pelanggans_table', 2),
(5, '2026_05_03_134656_create_pakets_table', 3),
(6, '2026_05_03_140452_create_transaksis_table', 4),
(7, '2026_05_07_040606_create_notifications_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `judul`, `pesan`, `tipe`, `sudah_dibaca`, `created_at`, `updated_at`) VALUES
(1, 'Pelanggan Baru Terdaftar', 'Ahmad Kurnia baru saja mendaftar sebagai pelanggan.', 'pelanggan', 1, '2026-05-07 01:07:48', '2026-05-07 01:09:44'),
(2, 'Pesanan Baru Masuk', 'Pesanan baru dari Ahmad Kurnia telah dibuat.', 'transaksi', 1, '2026-05-07 01:08:46', '2026-05-07 01:09:44'),
(3, 'Pembayaran Berhasil', 'Pembayaran Desti Widia Sari sebesar Rp 40.000 telah dikonfirmasi.', 'pembayaran', 1, '2026-05-07 01:09:25', '2026-05-07 01:09:44'),
(4, 'Pelanggan Baru Terdaftar', 'Deza Arl baru saja mendaftar sebagai pelanggan.', 'pelanggan', 1, '2026-05-07 03:15:50', '2026-05-07 03:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `pakets`
--

CREATE TABLE `pakets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `harga_per_kg` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pakets`
--

INSERT INTO `pakets` (`id`, `nama_paket`, `harga_per_kg`, `created_at`, `updated_at`) VALUES
(2, 'Cuci Kering', 7000, '2026-05-03 07:01:34', '2026-05-03 07:01:34'),
(3, 'Cuci Setrika', 10000, '2026-05-03 07:01:51', '2026-05-03 07:02:02'),
(4, 'Cuci Setrika Kilat', 14000, '2026-05-03 07:02:17', '2026-05-03 07:02:33'),
(5, 'Bedcover', 30000, '2026-05-03 07:02:44', '2026-05-03 07:02:52'),
(6, 'Sprei (Single Size)', 12000, '2026-05-03 18:31:00', '2026-05-03 18:31:00'),
(7, 'Sprei (Big Size)', 20000, '2026-05-03 20:59:12', '2026-05-03 20:59:12'),
(8, 'Jas', 8000, '2026-05-05 09:55:08', '2026-05-05 09:55:08'),
(9, 'Songket', 8000, '2026-05-07 01:08:23', '2026-05-07 01:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `nama_pelanggan`, `nomor_telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Hana Fortuna', '089673907250', 'Jl. Suka Pindah', '2026-05-03 06:37:00', '2026-05-03 06:42:53'),
(2, 'Desti Widia Sari', '089671237254', 'Jl. Bukit Asam', '2026-05-03 08:15:02', '2026-05-03 08:15:02'),
(3, 'Niken Trifaizah', '089673908907', 'Jl. Nusantara', '2026-05-03 08:15:27', '2026-05-03 08:15:27'),
(4, 'Naomira Fitri', '084783907321', 'Jl. Melati', '2026-05-03 08:15:53', '2026-05-03 08:15:53'),
(5, 'Nyimas Ayu', '082246075512', 'Jl. Bantu Lambang, No.29', '2026-05-03 17:05:07', '2026-05-03 17:05:07'),
(7, 'Bima Ardiansyah', '082246077766', 'Jl. Persada No.2207', '2026-05-03 18:10:24', '2026-05-03 18:10:24'),
(10, 'Ahmad Kurnia', '089634907204', 'Jl. Benka Kos', '2026-05-07 01:07:48', '2026-05-07 01:07:48'),
(11, 'Deza Arl', '082273907387', 'Jl. Komplek Persada 1', '2026-05-07 03:15:50', '2026-05-07 03:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DdMbBO5UnqnxaCrEklsvokFEbwATKNtBTvyLnXrL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQTlMNTdqcFJmemFxZG1DWkRqc084YlE2elFaMXF2S3hUcURRS2ZuRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZWxhbmdnYW4iO3M6NToicm91dGUiO3M6MTU6InBlbGFuZ2dhbi5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778127468),
('HYIzN9NKQ2otit84UAfR4wQ4XxL8MUNgDkiku9Uv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmxzTUtKeXZOeFd2bjJiRUpVTVh1anFTUVJwZVFtR25Gbmd2RmxLUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778146499),
('LP3P3cxe56eig12AETddIP3GXs0dDE5BWE1VPatI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmRQemwyMGFzSVJESkJmQUx1WGpHMnlDeTBoNDYwTWRSUWdBb1pweCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1778142605),
('XGEHo7k0uE0xoQiKJ7rAxLj83fzaSoiDCBYKcjiG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkVnUWZnOFFyY1NHTHVSYzVRdjB3bVVzQUc1dnFGYUQyb3pxMldJOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1778149359);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL,
  `paket_id` bigint(20) UNSIGNED NOT NULL,
  `berat` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL DEFAULT 'Belum Lunas',
  `status_cucian` varchar(255) NOT NULL DEFAULT 'Dalam Proses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `pelanggan_id`, `paket_id`, `berat`, `total_harga`, `tanggal_masuk`, `tanggal_selesai`, `status_pembayaran`, `status_cucian`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 14000, '2026-05-03', '2026-05-06', 'Lunas', 'Dalam Proses', '2026-05-03 07:11:40', '2026-05-03 16:45:18'),
(2, 3, 2, 5, 35000, '2026-05-03', '2026-05-06', 'Lunas', 'Dalam Proses', '2026-05-03 08:16:14', '2026-05-03 16:45:24'),
(3, 4, 5, 1, 30000, '2026-05-03', '2026-05-06', 'Lunas', 'Dalam Proses', '2026-05-03 16:59:37', '2026-05-05 09:35:31'),
(4, 1, 2, 4, 28000, '2026-05-04', '2026-05-07', 'Lunas', 'Dalam Proses', '2026-05-03 17:02:30', '2026-05-03 17:58:51'),
(5, 5, 3, 2, 20000, '2026-05-04', '2026-05-07', 'Lunas', 'Dalam Proses', '2026-05-03 17:25:04', '2026-05-03 19:21:22'),
(6, 2, 3, 3, 30000, '2026-05-04', '2026-05-07', 'Belum Lunas', 'Dalam Proses', '2026-05-03 17:58:20', '2026-05-03 17:58:20'),
(7, 2, 3, 2, 20000, '2026-05-04', '2026-05-07', 'Lunas', 'Dalam Proses', '2026-05-03 19:20:37', '2026-05-03 21:00:26'),
(9, 5, 7, 2, 40000, '2026-05-05', '2026-05-08', 'Lunas', 'Dalam Proses', '2026-05-05 05:34:57', '2026-05-05 05:35:26'),
(10, 7, 4, 2, 28000, '2026-05-05', '2026-05-08', 'Belum Lunas', 'Dalam Proses', '2026-05-05 08:28:57', '2026-05-05 08:28:57'),
(11, 7, 3, 2, 20000, '2026-05-05', '2026-05-08', 'Belum Lunas', 'Dalam Proses', '2026-05-05 08:29:27', '2026-05-05 08:29:27'),
(12, 4, 3, 2, 20000, '2026-05-05', '2026-05-06', 'Belum Lunas', 'Dalam Proses', '2026-05-05 08:37:17', '2026-05-05 08:37:17'),
(13, 7, 3, 2, 20000, '2026-05-05', '2026-05-08', 'Belum Lunas', 'Dalam Proses', '2026-05-05 08:37:59', '2026-05-05 08:37:59'),
(14, 5, 4, 1, 14000, '2026-05-05', '2026-05-07', 'Lunas', 'Dalam Proses', '2026-05-05 08:38:28', '2026-05-05 09:31:14'),
(15, 1, 2, 2, 14000, '2026-05-07', '2026-05-09', 'Lunas', 'Dalam Proses', '2026-05-06 20:23:07', '2026-05-06 20:24:08'),
(16, 2, 3, 4, 40000, '2026-05-07', '2026-05-10', 'Lunas', 'Dalam Proses', '2026-05-06 20:27:16', '2026-05-07 01:09:25'),
(17, 1, 7, 1, 20000, '2026-05-07', '2026-05-09', 'Lunas', 'Dalam Proses', '2026-05-06 20:33:19', '2026-05-06 20:44:48'),
(18, 10, 4, 2, 28000, '2026-05-07', '2026-05-10', 'Belum Lunas', 'Dalam Proses', '2026-05-07 01:08:46', '2026-05-07 01:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Nisa', 'AdminNisa123', 'admin@elaundry.com', NULL, '$2y$12$BNtYHDa.idocoIB5Q/xU3uwkHNUgqTUVtuQCu7XNHqUF05CgzQ43C', NULL, '2026-05-03 05:15:06', '2026-05-03 05:15:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pakets`
--
ALTER TABLE `pakets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `transaksis_paket_id_foreign` (`paket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `pakets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
