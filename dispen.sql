-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 02:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dispen`
--

-- --------------------------------------------------------

--
-- Table structure for table `angkatan`
--

CREATE TABLE `angkatan` (
  `id` int(11) NOT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angkatan`
--

INSERT INTO `angkatan` (`id`, `tahun`) VALUES
(1, 2019),
(2, 2020),
(3, 2021),
(4, 2022);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nama_dosen`, `email`, `nip`) VALUES
(1, 'Dian Sa’adillah Maylawati, S.Kom., M.T., Ph.D', 'dian@univ.ac.id', '198905262019032023'),
(2, 'Eki Ahmad Zaki Hamidi, S.T., M.T.', 'eki@univ.ac.id', '197602222011011008');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `ketua_jurusan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama_jurusan`, `ketua_jurusan_id`) VALUES
(1, 'Teknik Informatika', 1),
(2, 'Teknik Elektro', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `angkatan_id` int(11) DEFAULT NULL,
  `dosen_id` int(11) DEFAULT NULL,
  `alasan` text NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `dokumen_lampiran` varchar(255) NOT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_disetujui` date DEFAULT NULL,
  `keputusan_admin` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `angkatan` varchar(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `wakil_dekan_id` int(11) DEFAULT NULL,
  `tanggal_acc_ketua_jurusan` date DEFAULT NULL,
  `tanggal_acc_wakil_dekan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `user_id`, `angkatan_id`, `dosen_id`, `alasan`, `tanggal_pengajuan`, `dokumen_lampiran`, `status`, `tanggal_disetujui`, `keputusan_admin`, `updated_at`, `nama_lengkap`, `nim`, `angkatan`, `email`, `jurusan`, `jurusan_id`, `wakil_dekan_id`, `tanggal_acc_ketua_jurusan`, `tanggal_acc_wakil_dekan`) VALUES
(2, 1, NULL, NULL, 'izin', '2024-10-11', '2022-06-21.png', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', '', 1, NULL, NULL, NULL),
(3, 2, NULL, NULL, 'izin', '2024-10-11', '2022-06-21.png', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', '', 1, NULL, NULL, NULL),
(4, 2, NULL, NULL, 'izin', '2024-11-11', '2022-06-28 (1).png', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'adrian', '12345', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Elektro', 1, NULL, NULL, NULL),
(5, 2, NULL, NULL, 'izin karena keperluan orang tua', '2024-05-11', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'mondardi@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(6, 2, NULL, NULL, 'izin', '2024-10-30', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'adrian', '123456', '2021', 'mondardi@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(7, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'sumitraadriansyahmuhammad25@gmail.com', 'Biologi', 1, NULL, NULL, NULL),
(8, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'adrian', '12345', '2021', 'adriansyahsumitra@gmail.com', 'Teknik Elektro', 1, NULL, NULL, NULL),
(9, 2, NULL, NULL, 'hjhdghnkgfn', '2024-10-28', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'sumitraadriansyahmuhammad25@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(12, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'Sumitra Adriansyah', '1217050137', '2021', 'mondardi@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(13, 1, NULL, NULL, 'ngh', '2024-10-30', '', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'mondardi@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(14, 1, NULL, NULL, 'ssfedgfd', '2024-10-30', '2022-09-19.png', 'pending', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'adriansyahsumitra@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(15, 1, NULL, NULL, 'ssfedgfd', '2024-10-30', '2022-09-19.png', 'disetujui', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'adriansyahsumitra@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(16, 1, NULL, NULL, 'ssfedgfd', '2024-10-30', '2022-09-19.png', 'pending', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'adriansyahsumitra@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(17, 1, NULL, NULL, 'jiohh', '2024-10-30', '2022-06-28 (3).png', 'pending', NULL, NULL, '2024-11-06 10:15:34', 'sumitra', '123456', '2021', 'adriansyahsumitra@gmail.com', 'Agroteknologi', 1, NULL, NULL, NULL),
(19, 3, NULL, NULL, 'mengikuti job fair', '2024-11-14', '2022-09-19.png', 'pending', NULL, NULL, '2024-11-06 10:15:34', 'Sumitra Adriansyah', '1217050137', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Informatika', 1, NULL, NULL, NULL),
(20, 3, NULL, NULL, 'izin mengikuti lomba', '2024-11-30', '2022-06-21.png', 'pending', NULL, NULL, '2024-11-06 10:47:09', 'Sumitra Adriansyah', '1217050137', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Informatika', NULL, NULL, NULL, NULL),
(21, 3, NULL, NULL, 'izin', '2024-11-06', '2022-06-28 (3).png', 'pending', NULL, NULL, '2024-11-06 11:05:12', 'Sumitra Adriansyah', '1217050137', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Informatika', NULL, NULL, NULL, NULL),
(22, 3, NULL, NULL, 'izin', '2024-11-22', '2022-06-28.png', 'pending', NULL, NULL, '2024-11-06 11:16:38', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Informatika', NULL, NULL, NULL, NULL),
(23, 3, NULL, NULL, 'izin', '2024-11-06', '1663260369-picsay.jpg', 'pending', NULL, NULL, '2024-11-06 11:28:09', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', '', 1, NULL, NULL, NULL),
(24, 3, NULL, NULL, 'sakit', '2024-11-06', '166326567780369-picsay.jpg', 'pending', NULL, NULL, '2024-11-06 11:28:53', 'adrian', '12345', '2021', 'sumitraadriansyah@gmail.com', '', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('mahasiswa','admin','kajur','wakil_dekan') DEFAULT 'mahasiswa',
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dosen_id` int(11) DEFAULT NULL,
  `wakil_dekan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `created_at`, `dosen_id`, `wakil_dekan_id`) VALUES
(1, 'mahasiswa1', '12345', 'mahasiswa', 'mahasiswa1@univ.ac.id', '2024-10-27 17:35:12', NULL, NULL),
(2, 'admin1', '$2y$10$5Uk1QauK5XyB5g5OFjAy7eBedcgTzzvoKSZSEYCabP1KjhA8RKrl6', 'admin', 'admin@univ.ac.id', '2024-10-27 17:35:12', NULL, NULL),
(3, '1217050137', '$2y$10$zoXjeOKjQFfbgY4BwxsJ.uL7pYtqAeQrl0Y8x8rlyIFlrwPAmU5.K', 'mahasiswa', 'sumitraadriansyah@gmail.com', '2024-11-06 05:02:38', NULL, NULL),
(11, '198905262019032023', '$2y$10$EF4VuxlnT21LdqQUcE0Na.GtMHBkST9.LLgbxIJDejvGe.grBWG52', 'kajur', 'kajur01@university.com', '2024-11-06 12:35:20', 1, NULL),
(12, '197602222011011008', '$2y$10$RhIZd55m4uinXLknAlrhleFv5d5EcdoEKxOiB4lEwlFH6fEAsIify', 'kajur', 'kajur01@university.com', '2024-11-06 12:36:41', 2, NULL),
(13, '197909302009121002', '$2y$10$B7PyRPHKOtKqE81YYcsxuep14IawaNFuXQ/iUzSSvWnajzK.RLoIS', 'wakil_dekan', 'wadek01@university.com', '2024-11-06 05:38:35', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wakil_dekan`
--

CREATE TABLE `wakil_dekan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wakil_dekan`
--

INSERT INTO `wakil_dekan` (`id`, `nama`, `email`, `nip`) VALUES
(1, 'Undang Syaripudin, M.Kom.', 'wakildekan@univ.ac.id', '197909302009121002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angkatan`
--
ALTER TABLE `angkatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ketua_jurusan_id` (`ketua_jurusan_id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `angkatan_id` (`angkatan_id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `pengajuan_ibfk_4` (`jurusan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dosen_id` (`dosen_id`),
  ADD KEY `fk_wakil_dekan_id` (`wakil_dekan_id`);

--
-- Indexes for table `wakil_dekan`
--
ALTER TABLE `wakil_dekan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angkatan`
--
ALTER TABLE `angkatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wakil_dekan`
--
ALTER TABLE `wakil_dekan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_ibfk_1` FOREIGN KEY (`ketua_jurusan_id`) REFERENCES `dosen` (`id`);

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`angkatan_id`) REFERENCES `angkatan` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_4` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_dosen_id` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`),
  ADD CONSTRAINT `fk_wakil_dekan_id` FOREIGN KEY (`wakil_dekan_id`) REFERENCES `wakil_dekan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
