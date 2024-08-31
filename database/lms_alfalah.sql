-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2024 at 01:38 PM
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
-- Database: `lms_alfalah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `nama`) VALUES
(1, 'nasza', '$2y$10$Xg5t3BwL8UBJV0Dy517Atu3J1gSEOolgRtPJy9OscX3/PeZSChKni', '', 'Nasza');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jurusan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `password`, `nama_guru`, `email`, `jurusan`) VALUES
(1, 'NIP001', '$2y$10$m10qCuerdBxLaxkhmVv12.LdybpfOImyQIESEdJwl8KaYcgI9Pify', 'Nasza', 'guru@gmail.com', 'Rekayasa Perangkat Lunak'),
(3, 'NIP002', '$2y$10$PkbmGsNp1aN7C7KGNb2kF.TRW3zshhVjBSo3EhgToXa.pM9OkUlfi', 'Rian', 'guru2@gmail.com', 'Teknik Komputer');

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel_kelas`
--

CREATE TABLE `guru_mapel_kelas` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `mata_pelajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `nip_guru` varchar(20) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `nip_guru`, `kode_mapel`, `hari`, `id_kelas`, `waktu_mulai`, `waktu_selesai`) VALUES
(9, 'NIP002', 'MT001', 'Selasa', 2, '06:37:00', '07:35:00'),
(19, 'NIP001', 'MT001', 'Selasa', 1, '14:45:00', '15:45:00'),
(20, 'NIP002', 'WB001', 'Senin', 1, '19:13:00', '07:13:00'),
(21, 'NIP002', 'KL001', 'Kamis', 2, '12:31:00', '00:31:00'),
(22, 'NIP001', 'WB001', 'Rabu', 1, '16:33:00', '16:33:00'),
(23, 'NIP001', 'WB001', 'Senin', 2, '17:38:00', '05:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`) VALUES
(1, '10 K1'),
(2, '10 K2');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis` varchar(30) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama_mapel`, `deskripsi`, `jenis`, `gambar`, `tahun_ajaran`) VALUES
(1, 'MT001', 'Matematika', 'Belajar menghitung', 'Umum', 'mapel.jpeg', '2024/2025 Genap'),
(2, 'WB001', 'Desain Web', 'Belajar membuat desain untuk web', 'Teknik Informatika', 'mapel.jpeg', '2024/2025 Ganjil'),
(3, 'KL001', 'Kelistrikan', 'Menyusun listrik', 'Teknik Listrik', 'mapel.jpeg', '2024/2025 Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran_kelas`
--

CREATE TABLE `mata_pelajaran_kelas` (
  `id` int(11) NOT NULL,
  `mata_pelajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tanggal_unggah` timestamp NOT NULL DEFAULT current_timestamp(),
  `kode_mapel` varchar(50) DEFAULT NULL,
  `topik_id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `judul`, `file`, `tanggal_unggah`, `kode_mapel`, `topik_id`, `id_kelas`) VALUES
(1, 'Front End ', '../uploads/NASZA DWI PRAYOGA CV.docx', '2024-08-31 07:47:19', 'MT001', 1, 1),
(2, 'Database', '../uploads/Article+0106-897-906.pdf', '2024-08-31 09:13:57', 'MT001', 2, 2),
(3, 'Rekayasa Fitur', '../uploads/106-689-1-PB (1).pdf', '2024-08-31 09:15:04', 'MT001', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `kode_mapel` varchar(50) NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `nis`, `kode_mapel`, `nilai`, `id_kelas`, `tahun_ajaran`, `tanggal_input`) VALUES
(1, 1231231, 'MT001', 80, 1, '2024/2025 Genap', '2024-08-31 17:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id` int(11) NOT NULL,
  `topik_id` int(11) DEFAULT NULL,
  `tugas_id` int(5) NOT NULL,
  `nis_siswa` varchar(20) DEFAULT NULL,
  `tugas_text` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `tanggal_pengumpulan` date NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengunduhan_materi`
--

CREATE TABLE `pengunduhan_materi` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_tokens`
--

CREATE TABLE `reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('siswa','guru','admin') NOT NULL,
  `token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nama_wali_kelas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `password`, `nama_siswa`, `email`, `id_kelas`, `nama_wali_kelas`) VALUES
(1, '1231231', '$2y$10$JMdOAn9Aibyj9.va48.omO2RkG9fiGh/grEn1nZf7jfO9qdLsfqjW', 'M Akbar Krisdayanto', 'siswa@gmail.com', 1, 'Nasza Dwi Prayoga'),
(2, '324234', '$2y$10$CW5//KzbPw50FSb0RMgcsOGuKjWLB6eCtwxjhSCAb46kHDp/ksWQi', 'Nass', 'rizki1245@gmail.com', 2, 'Fauzan Fadhil Moricio'),
(3, '12345678', '$2y$10$T6iHKKGiUy720cS11VMVJuox5d2.fneh.kAbzKvDAh3qURke8SBHy', 'Nugroho', 'siswa3@gmail.com', 1, 'Faliq Zuldan Akbar');

-- --------------------------------------------------------

--
-- Table structure for table `topik`
--

CREATE TABLE `topik` (
  `id` int(11) NOT NULL,
  `nama_topik` varchar(255) NOT NULL,
  `kode_mapel` varchar(50) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topik`
--

INSERT INTO `topik` (`id`, `nama_topik`, `kode_mapel`, `kelas_id`) VALUES
(1, 'Web Desain', 'MT001', 1),
(2, 'Web Desain', 'MT001', 2),
(3, 'Rekayasa Perangkat', 'MT001', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `opsi_tugas` text DEFAULT NULL,
  `tanggal_tenggat` date DEFAULT NULL,
  `topik_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) NOT NULL,
  `kode_mapel` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id`, `judul`, `keterangan`, `opsi_tugas`, `tanggal_tenggat`, `topik_id`, `kelas_id`, `kode_mapel`) VALUES
(1, 'Tugas 1', NULL, 'upload', '2024-09-05', 1, 1, 'MT001'),
(2, 'Tugas 1', NULL, 'upload', '2024-09-02', 2, 2, 'MT001'),
(3, 'Rekayasa Fitur', NULL, 'teks', '2024-09-04', 3, 2, 'MT001');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_siswa`
--

CREATE TABLE `tugas_siswa` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `file_tugas` varchar(255) DEFAULT NULL,
  `text_tugas` text DEFAULT NULL,
  `tanggal_pengumpulan` datetime NOT NULL,
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guru_mapel_kelas`
--
ALTER TABLE `guru_mapel_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `mata_pelajaran_id` (`mata_pelajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nip_guru` (`nip_guru`),
  ADD KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `mata_pelajaran_kelas`
--
ALTER TABLE `mata_pelajaran_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mata_pelajaran_id` (`mata_pelajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topik_id` (`topik_id`);

--
-- Indexes for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nis` (`nis`),
  ADD KEY `materi_id` (`materi_id`);

--
-- Indexes for table `reset_tokens`
--
ALTER TABLE `reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `topik`
--
ALTER TABLE `topik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topik_id` (`topik_id`);

--
-- Indexes for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guru_mapel_kelas`
--
ALTER TABLE `guru_mapel_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mata_pelajaran_kelas`
--
ALTER TABLE `mata_pelajaran_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reset_tokens`
--
ALTER TABLE `reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `topik`
--
ALTER TABLE `topik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru_mapel_kelas`
--
ALTER TABLE `guru_mapel_kelas`
  ADD CONSTRAINT `guru_mapel_kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`),
  ADD CONSTRAINT `guru_mapel_kelas_ibfk_2` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`),
  ADD CONSTRAINT `guru_mapel_kelas_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`nip_guru`) REFERENCES `guru` (`nip`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `mata_pelajaran_kelas`
--
ALTER TABLE `mata_pelajaran_kelas`
  ADD CONSTRAINT `mata_pelajaran_kelas_ibfk_1` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`),
  ADD CONSTRAINT `mata_pelajaran_kelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`kode_mapel`) REFERENCES `mata_pelajaran` (`kode_mapel`);

--
-- Constraints for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `pengumpulan_tugas_ibfk_1` FOREIGN KEY (`topik_id`) REFERENCES `topik` (`id`);

--
-- Constraints for table `pengunduhan_materi`
--
ALTER TABLE `pengunduhan_materi`
  ADD CONSTRAINT `pengunduhan_materi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `pengunduhan_materi_ibfk_2` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`);

--
-- Constraints for table `reset_tokens`
--
ALTER TABLE `reset_tokens`
  ADD CONSTRAINT `reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reset_tokens_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reset_tokens_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `topik`
--
ALTER TABLE `topik`
  ADD CONSTRAINT `topik_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`topik_id`) REFERENCES `topik` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tugas_siswa`
--
ALTER TABLE `tugas_siswa`
  ADD CONSTRAINT `tugas_siswa_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`),
  ADD CONSTRAINT `tugas_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
