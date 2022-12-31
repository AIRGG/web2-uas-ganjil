-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 02:31 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_web2_uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dosen`
--

CREATE TABLE `tbl_dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip` varchar(40) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_dosen`
--

INSERT INTO `tbl_dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `nohp`, `alamat`) VALUES
(32, '101', 'Pak Anggi', 'mail@pnj.ac.id', '081234567890', 'Bogor'),
(33, '102', 'Pak Budi', 'budi@gmail.com', '09876542321', 'Jakarta'),
(34, '123123', 'sadasd', 'asdasd', 'sdas', 'dasdasd'),
(35, 'asd', 'asd', 'asd', 'asd', 'asd'),
(36, 'qwe', 'aaxc', 'asd', 'qwe', 'asd'),
(37, 'zxc', 'zxc', 'zxc', 'zxc', 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id_kelas` int(11) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id_kelas`, `kode_kelas`, `nama_kelas`) VALUES
(6, 'TI CCIT 5', 'Teknik Informatika CCIT 5'),
(7, 'TI CCIT 3', 'Teknik Informatika CCIT 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matkul`
--

CREATE TABLE `tbl_matkul` (
  `id_matkul` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `id_ruang` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `waktu` varchar(15) NOT NULL,
  `matkul` varchar(100) NOT NULL,
  `jj` varchar(10) NOT NULL,
  `ta` varchar(20) NOT NULL,
  `sem` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_matkul`
--

INSERT INTO `tbl_matkul` (`id_matkul`, `id_dosen`, `id_ruang`, `id_kelas`, `hari`, `waktu`, `matkul`, `jj`, `ta`, `sem`) VALUES
(3, 32, 11, 6, 'Senin', '08:00 - 11:00', 'Web Programming 2', '6', '2022 - 2023', 'Ganjil'),
(4, 32, 13, 7, 'Selasa', '08:00 - 11:00', 'Web Programming 1', '6', '2022 - 2023', 'Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ruang`
--

CREATE TABLE `tbl_ruang` (
  `id_ruang` int(11) NOT NULL,
  `kode_ruang` varchar(10) NOT NULL,
  `nama_ruang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ruang`
--

INSERT INTO `tbl_ruang` (`id_ruang`, `kode_ruang`, `nama_ruang`) VALUES
(11, 'AA01', 'Gedung AA Lantai 1'),
(12, 'AA02', 'Gedung AA Lantai 2'),
(13, 'AA03', 'Gedung AA Lantai 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Administrator', 'admin'),
(2, 'budi', '202cb962ac59075b964b07152d234b70', 'Budiantoro', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  ADD PRIMARY KEY (`id_matkul`),
  ADD KEY `id_dosen` (`id_dosen`),
  ADD KEY `id_ruang` (`id_ruang`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tbl_ruang`
--
ALTER TABLE `tbl_ruang`
  ADD PRIMARY KEY (`id_ruang`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_ruang`
--
ALTER TABLE `tbl_ruang`
  MODIFY `id_ruang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
