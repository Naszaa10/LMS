-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 12:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `email`, `nama_admin`) VALUES
('admin', '$2y$10$wcLKIragMbGklsXKWW2uY.m3gZE3qiLdAeFbv2UjqdHP8rZfd9JO.', 'admin@gmail.com', 'Rian Kurnia');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_jurusan` int(3) DEFAULT NULL,
  `foto_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `password`, `nama_guru`, `email`, `id_jurusan`, `foto_profil`) VALUES
('NIP001', '$2y$10$XUwwAXO2WDJuclBBCuZDj.om1cyybHbH..ksg6mmsq579cDWhxE.C', 'Lela Rohayati, S.Pd', 'lelar@gmail.com', 1, 'NIP001_1727692670.jpg'),
('NIP002', '$2y$10$FFynyYTXShvKm/end8IMDeBUCm6t28j16H0fdVi9T41r85O31utuu', 'Rian Kurnia', 'guru2@gmail.com', 2, 'user.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `waktu_mulai` varchar(11) DEFAULT NULL,
  `waktu_selesai` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `nip`, `kode_mapel`, `hari`, `id_kelas`, `waktu_mulai`, `waktu_selesai`) VALUES
(1, 'NIP001', 'WB001', 'Senin', 5, '10.00 WIB', '11.00 WIB'),
(2, 'NIP001', 'KL001', 'Sabtu', 5, '10.00 WIB', '11.00 WIB'),
(3, 'NIP001', 'WB001', 'Selasa', 5, '10.00 WIB', '11.00 WIB'),
(4, 'NIP002', 'ZZ003', 'Kamis', 5, '11.00 WIB', '19.00 WIB');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(3) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'Teknik Komputer'),
(2, 'Teknik Mesin'),
(3, 'Teknik Otomotif'),
(4, 'Teknik Listrik');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `jenjang` int(2) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `id_jurusan` int(4) NOT NULL,
  `id_tahun_ajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `jenjang`, `nama_kelas`, `id_jurusan`, `id_tahun_ajaran`) VALUES
(1, 0, '10 K3', 1, 2),
(3, 0, '10 K1', 3, 1),
(4, 0, '10 L1', 4, 1),
(5, 11, 'K4', 4, 4);

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

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`kode_mapel`, `nama_mapel`, `deskripsi`, `jenis`, `gambar`) VALUES
('KL001', 'Kelistrikan', 'belajar', 'Teknik Listrik', '../uploads/gambar_mapel/logo.png'),
('WB001', 'Desain Web', 'awdada', 'Teknik Komputer', '../uploads/gambar_mapel/banner.png'),
('ZZ003', 'Matematika', 'sadscxacadads', 'Umum', '../uploads/gambar_mapel/respon.png');

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
  `id_kelas` int(11) DEFAULT NULL,
  `is_downloaded` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `judul`, `file`, `tanggal_unggah`, `kode_mapel`, `topik_id`, `id_kelas`, `is_downloaded`) VALUES
(2, 'Rekayasa Fitur', '../uploads/materi/Pertemuan 11 Sumber Daya Manusia Proyek.pptx', '2024-09-10', 'WB001', 2, 1, 0),
(3, 'Front End dan Back End', '../uploads/materi/NASZA DWI PRAYOGA CV (1).docx', '2024-09-10', 'WB001', 1, 1, 0),
(4, 'Laravel', '../uploads/materi/supardiiiiiiiiiiiiiiiiiiiiiiiiii (1).pptx', '2024-09-24', 'WB001', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `nis` varchar(20) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nilai` float NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_tahun_ajaran` int(11) NOT NULL,
  `tanggal_input` date NOT NULL,
  `pengetahuan` float NOT NULL,
  `keterampilan` float NOT NULL,
  `predikat` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`nis`, `nip`, `kode_mapel`, `nilai`, `id_kelas`, `id_tahun_ajaran`, `tanggal_input`, `pengetahuan`, `keterampilan`, `predikat`) VALUES
('12341234', 'NIP001', 'KL001', 89, 1, 2, '2024-09-24', 70, 89, 'A'),
('12341234', 'NIP001', 'WB001', 80, 1, 2, '2024-09-23', 80, 85, 'A'),
('12345678', 'NIP001', 'KL001', 90, 1, 2, '2024-09-24', 90, 90, 'A'),
('12345678', 'NIP001', 'WB001', 90, 1, 2, '2024-09-23', 87, 88, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id_pengupulantugas` int(11) NOT NULL,
  `topik_id` int(11) DEFAULT NULL,
  `id_tugas` int(11) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `tugas_text` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `tanggal_pengumpulan` date DEFAULT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumpulan_tugas`
--

INSERT INTO `pengumpulan_tugas` (`id_pengupulantugas`, `topik_id`, `id_tugas`, `nis`, `tugas_text`, `file_path`, `tanggal_pengumpulan`, `kode_mapel`, `id_kelas`) VALUES
(3, 1, 1, '12345678', NULL, 'Nilai_2024_2025 Genap.pdf', '2024-09-10', 'WB001', 1),
(4, 2, 2, '12345678', 'Menganalisis Musik Untuk Data Mining', NULL, '2024-09-10', 'WB001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(3) NOT NULL,
  `judul_pengumuman` varchar(255) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `role` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul_pengumuman`, `isi_pengumuman`, `role`, `tanggal`) VALUES
(5, 'asdssssssssssssssssss', 'vvvvvvvvvvvvvvvvvvvvvvvvv', 'semua', '2024-09-29'),
(6, 'ssssssssssssssssssssssss', 'cccccccccccccccccccccccccccccccc', 'guru', '2024-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `pengunduhan_materi`
--

CREATE TABLE `pengunduhan_materi` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `tanggal_unduh` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_tugas`
--

CREATE TABLE `penilaian_tugas` (
  `id_nilai_tugas` int(11) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `id_tugas` int(11) DEFAULT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nilai_tugas` int(4) DEFAULT NULL,
  `tanggal_penilaian` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian_tugas`
--

INSERT INTO `penilaian_tugas` (`id_nilai_tugas`, `nis`, `id_tugas`, `kode_mapel`, `id_kelas`, `nilai_tugas`, `tanggal_penilaian`) VALUES
(1, '12345678', 1, 'WB001', 1, 90, NULL);

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
  `angkatan` varchar(10) DEFAULT NULL,
  `id_jurusan` int(3) NOT NULL,
  `foto_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `password`, `nama_siswa`, `email`, `id_kelas`, `nama_wali_kelas`, `angkatan`, `id_jurusan`, `foto_profil`) VALUES
('12341234', '$2y$10$0XlShYY.sMRR0wpaXiAJ2.qZqcZs6/MZsTg238sX9VM.ccUWfyXjq', 'Nugroho', 'akbar123@gmail.com', 1, 'Nasza Dwi Prayoga', '2017', 1, ''),
('12345', '$2y$10$Gm.8c6K6bcvYTqmIpYs28.JNlRvdu1O4ZJxkdrj9Ji.FSmbgVqbuC', 'Akbar Krisdayanto', 'siswa3@gmail.com', 4, 'Nasza Dwi Prayoga', '2023', 4, 'user.jpg'),
('12345678', '$2y$10$NX6uW7ukCCIgL/4qUho5nO940/J2WN5DYDsVO8UwXIq9xBuJ/OSJ6', 'Nasza Dwi Prayoga', 'siswa@gmail.com', 5, 'Faliq Zuldan Akbar', '2017', 1, '12345678_12-31-59-000000.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun_ajaran` int(11) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajaran`, `tahun_ajaran`) VALUES
(1, '2025/2026 Ganjil'),
(2, '2025/2026 Genap'),
(3, '2026/2027 Ganjil'),
(4, '2026/2027 Genap');

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

--
-- Dumping data for table `topik`
--

INSERT INTO `topik` (`topik_id`, `nama_topik`, `kode_mapel`, `id_kelas`) VALUES
(1, 'Web Desain', 'WB001', 1),
(2, 'Rekayasa Perangkat', 'WB001', 1),
(3, 'Back-End', 'WB001', 1);

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
  `kode_mapel` varchar(50) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `judul`, `keterangan`, `opsi_tugas`, `tanggal_tenggat`, `topik_id`, `id_kelas`, `kode_mapel`, `is_completed`) VALUES
(1, 'Tugas 1', NULL, 'upload', '2024-09-11', 1, 1, 'WB001', 0),
(2, 'Analisi Musik', NULL, 'teks', '2024-09-11', 2, 1, 'WB001', 0),
(3, 'Analisi Musik', NULL, 'upload', '2024-09-26', 1, 1, 'WB001', 0),
(4, 'Tugas 1', NULL, 'upload', '2024-09-25', 3, 1, 'WB001', 0);

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
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `nip` (`nip`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kelas_ibfk_2` (`id_tahun_ajaran`),
  ADD KEY `kelas_ibfk_1` (`id_jurusan`);

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
  ADD UNIQUE KEY `nis` (`nis`,`kode_mapel`),
  ADD KEY `nip` (`nip`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_tahun_ajaran` (`id_tahun_ajaran`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id_pengupulantugas`),
  ADD KEY `topik_id` (`topik_id`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `nis` (`nis`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_materi` (`id_materi`);

--
-- Indexes for table `penilaian_tugas`
--
ALTER TABLE `penilaian_tugas`
  ADD PRIMARY KEY (`id_nilai_tugas`),
  ADD UNIQUE KEY `nis` (`nis`,`kode_mapel`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `siswa_ibfk_2` (`id_jurusan`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);

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
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id_pengupulantugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penilaian_tugas`
--
ALTER TABLE `penilaian_tugas`
  MODIFY `id_nilai_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_tahun_ajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topik`
--
ALTER TABLE `topik`
  MODIFY `topik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`),
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tahun_ajaran` (`id_tahun_ajaran`);

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
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `nilai_ibfk_5` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tahun_ajaran` (`id_tahun_ajaran`);

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
-- Constraints for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  ADD CONSTRAINT `pengunduhan_materi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `pengunduhan_materi_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`);

--
-- Constraints for table `penilaian_tugas`
--
ALTER TABLE `penilaian_tugas`
  ADD CONSTRAINT `penilaian_tugas_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_2` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_3` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `penilaian_tugas_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`);

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
