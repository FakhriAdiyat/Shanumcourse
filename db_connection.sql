-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2024 at 08:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_connection`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int NOT NULL,
  `email_pemateri` varchar(255) NOT NULL,
  `nama_kursus` varchar(255) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `waktu` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `email_pemateri`, `nama_kursus`, `hari`, `waktu`, `created_at`) VALUES
(1, 'fadil@gmail.com', 'kursus1', 'Senin', '07:00:00', '2024-12-28 08:00:18'),
(2, 'fadil@gmail.com', 'words', 'Selasa', '12:00:00', '2024-12-29 05:00:02'),
(3, 'fadil@gmail.com', 'words', 'Selasa', '14:00:00', '2024-12-29 06:45:50'),
(4, 'fadil@gmail.com', 'words', 'Senin', '14:00:00', '2024-12-29 07:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id` int NOT NULL,
  `nama_kursus` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `dibuat_oleh` int NOT NULL,
  `tanggal_dibuat` date NOT NULL DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`id`, `nama_kursus`, `deskripsi`, `kategori`, `dibuat_oleh`, `tanggal_dibuat`) VALUES
(1, 'kursus1', '1', 'materi', 1, '2024-12-17'),
(2, 'kursus2', 'materi', 'materi', 1, '2024-12-20'),
(3, 'kursus2', 'materi', 'materi', 1, '2024-12-20'),
(4, 'kursus3', 'baru', 'materi', 1, '2024-12-28'),
(5, 'kursus3', 'baru', 'materi', 1, '2024-12-28'),
(6, 'kursus3', 'baru', 'materi', 1, '2024-12-28'),
(7, 'kursus3', 'baru', 'materi', 1, '2024-12-28'),
(8, 'wordss', 'apa aja', 'materi', 1, '2024-12-29'),
(9, 'history', 'oeauhas', 'materi', 1, '2024-12-29'),
(10, 'history2', 'sejarah', 'materi', 1, '2024-12-29'),
(11, 'bahasa', 'bahasa', 'materi', 1, '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `kursus_user`
--

CREATE TABLE `kursus_user` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_kursus` int NOT NULL,
  `status` enum('aktif','selesai') NOT NULL DEFAULT 'aktif',
  `progres` int DEFAULT '0',
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kursus_user`
--

INSERT INTO `kursus_user` (`id`, `id_user`, `id_kursus`, `status`, `progres`, `tanggal_daftar`) VALUES
(1, 2, 2, 'aktif', 0, '2024-12-20 20:45:39'),
(2, 3, 2, 'aktif', 0, '2024-12-20 20:45:39'),
(3, 2, 3, 'aktif', 0, '2024-12-20 20:45:45'),
(4, 3, 3, 'aktif', 0, '2024-12-20 20:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `kursus_id` int NOT NULL,
  `diunggah_oleh` int NOT NULL,
  `tanggal_diunggah` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `judul`, `deskripsi`, `file_path`, `kursus_id`, `diunggah_oleh`, `tanggal_diunggah`) VALUES
(1, 'materi1', 'materi', 'Double_LInked_List_FakhriAdiyatFirdaus_23416255201125_23C.pdf', 1, 1, '2024-12-19 11:21:31'),
(2, 'materi2', 'materi', 'entity relationship diagram -  ERD.pdf', 1, 1, '2024-12-19 11:22:50'),
(3, 'kelilit Python', 'k', 'Double_LInked_List_FakhriAdiyatFirdaus_23416255201125_23C.pdf', 2, 1, '2024-12-20 13:51:16'),
(4, 'Ternak Lele', 'selamat belajar', 'entity relationship diagram -  ERD.pdf', 1, 1, '2024-12-28 04:59:33'),
(5, 'Ternak Lele', 'selamat belajar', 'entity relationship diagram -  ERD.pdf', 1, 1, '2024-12-28 04:59:43'),
(6, 'materi2', 'link', 'ADBO Pertemuan 7 Activity Diagram.pptx', 8, 1, '2024-12-29 04:57:34'),
(7, 'materi1', 'link', 'ADBO Pertemuan 7 Activity Diagram.pptx', 9, 1, '2024-12-29 06:44:17'),
(8, 'materi2', 'link', 'ADBO Pertemuan 7 Activity Diagram.pptx', 10, 1, '2024-12-29 07:19:10'),
(9, 'kelilit Python', 'link', 'ADBO Pertemuan 7 Activity Diagram.pptx', 11, 1, '2024-12-31 08:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `dana_phone` varchar(20) NOT NULL,
  `dana_account_number` varchar(20) NOT NULL,
  `payment_proof` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `email`, `province`, `dana_phone`, `dana_account_number`, `payment_proof`, `created_at`) VALUES
(1, 'Jojo.petualangan.aneh@gmail.com', 'Jawa Tengah', '085711269810', '081234567890', 'uploads/discount.png', '2024-12-28 08:57:58'),
(2, 'padil@gmail.com', 'DKI Jakarta', '085711269810', '081234567890', 'uploads/discount.png', '2024-12-29 04:48:53'),
(3, 'fadik@gmail.com', 'DKI Jakarta', '085711269810', '081234567890', 'uploads/discount.png', '2024-12-29 06:38:16'),
(4, 'gilang@gmail.com', 'Jawa Tengah', '085711269810', '081234567890', 'uploads/discount.png', '2024-12-29 07:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','pemateri','admin') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `is_subscribed` tinyint(1) DEFAULT '0',
  `subscription_expiry` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone_number`, `username`, `email`, `password`, `created_at`, `role`, `is_subscribed`, `subscription_expiry`) VALUES
(1, 'fadil gaming', '122443', 'fadil', 'fadil@gmail.com', '$2y$10$Wppi39maNqQ2W1NQWrKC..L8wfEnZEJk0ZQwDrwU9wFihAybobQkK', '2024-12-08 07:27:08', 'pemateri', 0, NULL),
(2, 'apa aja', '477366276', 'Apa', 'apa@gmail.com', '$2y$10$MX7GXw1HX.re0tLx3.UCNuHKNC3OThyLcJboIWnRanFOXibKNtlOa', '2024-12-10 08:09:38', 'user', 0, NULL),
(3, 'adminYami', '093838', 'adminyami', 'admin@gmail.com', '$2y$10$wSd80LzlcgOskzAekl5g9.rWXkD3lcKwrhos8IwSWCKheySbgwwOq', '2024-12-19 11:44:58', 'admin', 0, NULL),
(4, 'Ahmad', '92083877492', 'Ahmad', 'ahmad@gmail.com', '$2y$10$dHfIM2sKf00MbC3qbGnwIeWxYawdoMz1lSQlbRHB47clZYS0tRYGi', '2024-12-22 12:15:08', 'user', 1, '2025-03-22'),
(5, 'dimmas', '938727366263864', 'dim', 'dimas@gmail.com', '$2y$10$xBiBJCLOy6K2GXdoXfDchOv6g0ZoOA.U7h3n/efb0X8bYSiLLuQgG', '2024-12-28 03:53:25', 'user', 1, '2024-12-31'),
(6, 'Jojo Jostar', '029378347', 'Jojo', 'Jojo.petualangan.aneh@gmail.com', '$2y$10$VNI0R6Tn9dvKnz6TewU2hOyUlvjlkJkqhdBGv3crW8d1sKJhjtsvC', '2024-12-28 08:22:27', 'user', 0, NULL),
(7, 'fadil gaming', '847386463', 'padil', 'padil@gmail.com', '$2y$10$bCtSSVLlgL/cXrUjrZYWO.ffx27CPWiJqTBu01Ctc0TI/zN9IRjzm', '2024-12-29 04:46:48', 'user', 1, '2025-06-28'),
(8, 'fadik', '38323728373', 'fadik', 'fadik@gmail.com', '$2y$10$i2DV4mSGIJCohHpyDffieeNEfGtNvum9MpHL5FGjqO.r4pw/Yl1.a', '2024-12-29 06:36:28', 'user', 1, '2025-08-28'),
(9, 'gilang gaming', '838374672', 'Gilang', 'gilang@gmail.com', '$2y$10$YPYA7AJzGgdjljR28qWvN.UjlgBeUOsYOJkKaNH3EqgaDkRBfIs3S', '2024-12-29 07:11:32', 'user', 1, '2025-08-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `kursus_user`
--
ALTER TABLE `kursus_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kursus_id` (`kursus_id`),
  ADD KEY `diunggah_oleh` (`diunggah_oleh`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kursus_user`
--
ALTER TABLE `kursus_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kursus`
--
ALTER TABLE `kursus`
  ADD CONSTRAINT `kursus_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kursus_user`
--
ALTER TABLE `kursus_user`
  ADD CONSTRAINT `kursus_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `kursus_user_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kursus_id`) REFERENCES `kursus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materi_ibfk_2` FOREIGN KEY (`diunggah_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
