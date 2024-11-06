-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 09:57 AM
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
-- Database: `dispensasi`
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
(1, 'Dr. Bambang Sudibyo', 'bambang@univ.ac.id', '197505021993021001'),
(2, 'Dr. Maria Indriati', 'maria@univ.ac.id', '198008152005012001');

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
  `dokumen_lampiran` varchar(255) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_disetujui` date DEFAULT NULL,
  `keputusan_admin` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `angkatan` varchar(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `user_id`, `angkatan_id`, `dosen_id`, `alasan`, `tanggal_pengajuan`, `dokumen_lampiran`, `status`, `tanggal_disetujui`, `keputusan_admin`, `updated_at`, `nama_lengkap`, `nim`, `angkatan`, `email`, `jurusan`) VALUES
(1, 1, NULL, NULL, 'gfgfg', '0000-00-00', '', 'pending', NULL, NULL, '2024-10-28 04:33:42', 'adrian', '12345', '2021', 'sumitraadriansyah@gmail.com', ''),
(2, 1, NULL, NULL, 'izin', '2024-10-11', '2022-06-21.png', 'disetujui', NULL, NULL, '2024-10-28 06:28:10', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', ''),
(3, 2, NULL, NULL, 'izin', '2024-10-11', '2022-06-21.png', 'disetujui', NULL, NULL, '2024-10-28 06:47:17', 'sumitra', '123456', '2021', 'sumitraadriansyah@gmail.com', ''),
(4, 2, NULL, NULL, 'izin', '2024-11-11', '2022-06-28 (1).png', 'disetujui', NULL, NULL, '2024-10-28 06:41:33', 'adrian', '12345', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Elektro'),
(5, 2, NULL, NULL, 'izin karena keperluan orang tua', '2024-05-11', '', 'disetujui', NULL, NULL, '2024-10-28 06:36:32', 'sumitra', '123456', '2021', 'mondardi@gmail.com', 'Teknik Informatika'),
(6, 2, NULL, NULL, 'izin', '2024-10-30', '', 'disetujui', NULL, NULL, '2024-10-28 06:16:36', 'adrian', '123456', '2021', 'mondardi@gmail.com', 'Teknik Informatika'),
(7, 2, NULL, NULL, 'izin', '2024-10-31', '', 'pending', NULL, NULL, '2024-10-28 04:56:16', 'sumitra', '123456', '2021', 'sumitraadriansyahmuhammad25@gmail.com', 'Biologi'),
(8, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-10-28 06:55:48', 'adrian', '12345', '2021', 'adriansyahsumitra@gmail.com', 'Teknik Elektro'),
(9, 2, NULL, NULL, 'hjhdghnkgfn', '2024-10-28', '', 'disetujui', NULL, NULL, '2024-10-28 05:57:26', 'sumitra', '123456', '2021', 'sumitraadriansyahmuhammad25@gmail.com', 'Teknik Informatika'),
(10, 2, NULL, NULL, 'ubjv', '2024-10-28', '', 'disetujui', NULL, NULL, '2024-10-28 06:11:15', 'sumitra', '12345', '2021', 'mondardi@gmail.com', 'Teknik Informatika'),
(11, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-10-28 06:19:49', 'Sumitra Adriansyah', '1217050137', '2021', 'sumitraadriansyah@gmail.com', 'Teknik Informatika'),
(12, 2, NULL, NULL, 'izin', '2024-10-31', '', 'disetujui', NULL, NULL, '2024-10-28 06:50:54', 'Sumitra Adriansyah', '1217050137', '2021', 'mondardi@gmail.com', 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('mahasiswa','admin') DEFAULT 'mahasiswa',
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `created_at`) VALUES
(1, 'mahasiswa1', '12345', 'mahasiswa', 'mahasiswa1@univ.ac.id', '2024-10-27 17:35:12'),
(2, 'admin1', 'admin123', 'admin', 'admin@univ.ac.id', '2024-10-27 17:35:12');

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
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `angkatan_id` (`angkatan_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`angkatan_id`) REFERENCES `angkatan` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
