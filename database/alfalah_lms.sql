-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 01:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alfalah_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `nip` varchar(50) NOT NULL,
  `kode_mapel` varchar(50) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `kode_mapel` varchar(50) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tanggal_unggah` date NOT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `topik_id` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `nis` varchar(50) NOT NULL,
  `kode_mapel` varchar(50) NOT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `id_kelas` int(11) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `tanggal_input` date DEFAULT NULL,
  `pengetahuan` decimal(5,2) DEFAULT NULL,
  `keterampilan` decimal(5,2) DEFAULT NULL,
  `predikat` varchar(10) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `topik_id` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `tugas_text` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `tanggal_pengumpulan` date NOT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_tugas`
--

CREATE TABLE `penilaian_tugas` (
  `nis_siswa` varchar(50) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nilai_tugas` decimal(5,2) DEFAULT NULL,
  `tanggal_penilaian` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nama_wali_kelas` varchar(100) DEFAULT NULL,
  `angkatan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `tahun_ajaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topik`
--

CREATE TABLE `topik` (
  `topik_id` int(11) NOT NULL,
  `nama_topik` varchar(255) NOT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `opsi_tugas` varchar(100) DEFAULT NULL,
  `tanggal_tenggat` date DEFAULT NULL,
  `topik_id` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`nip`,`kode_mapel`,`hari`,`id_kelas`,`waktu_mulai`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`nama_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `tahun_ajaran` (`tahun_ajaran`),
  ADD KEY `kelas_ibfk_2` (`nama_jurusan`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`kode_mapel`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `topik_id` (`topik_id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`nis`,`kode_mapel`,`id_kelas`,`tahun_ajaran`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `tahun_ajaran` (`tahun_ajaran`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`topik_id`,`id_tugas`,`nis`,`tanggal_pengumpulan`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `nis` (`nis`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `penilaian_tugas`
--
ALTER TABLE `penilaian_tugas`
  ADD PRIMARY KEY (`nis_siswa`,`id_tugas`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`tahun_ajaran`);

--
-- Indexes for table `topik`
--
ALTER TABLE `topik`
  ADD PRIMARY KEY (`topik_id`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `topik_id` (`topik_id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `kode_mapel` (`kode_mapel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topik`
--
ALTER TABLE `topik`
  MODIFY `topik_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`tahun_ajaran`) REFERENCES `tahun_ajaran` (`tahun_ajaran`),
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`nama_jurusan`) REFERENCES `jurusan` (`nama_jurusan`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `materi_ibfk_2` FOREIGN KEY (`topik_id`) REFERENCES `topik` (`topik_id`),
  ADD CONSTRAINT `materi_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`tahun_ajaran`) REFERENCES `tahun_ajaran` (`tahun_ajaran`),
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `nilai_ibfk_5` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`);

--
-- Constraints for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_1` FOREIGN KEY (`topik_id`) REFERENCES `topik` (`topik_id`),
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_2` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`),
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_3` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_4` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_5` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `penilaian_tugas`
--
ALTER TABLE `penilaian_tugas`
  ADD CONSTRAINT `penilaian_tugas_ibfk_1` FOREIGN KEY (`nis_siswa`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_2` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_3` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `topik`
--
ALTER TABLE `topik`
  ADD CONSTRAINT `topik_ibfk_1` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `topik_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`topik_id`) REFERENCES `topik` (`topik_id`),
  ADD CONSTRAINT `tugas_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `tugas_ibfk_3` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
