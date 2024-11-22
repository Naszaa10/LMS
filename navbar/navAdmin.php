<?php
session_start();
include '../db.php'; // Koneksi database

// Pastikan siswa sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../Admin/login.php");
//     exit();
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\styles.css">
</head>

<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4">
            <img src="..\uploads\gambar\SMK_AF.png" alt="Logo" class="logo-img">
            <h4 class="mt-2">SMK AL FALAH</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="sidebar-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <!-- Dropdown Data Akun -->
            <div class="dropdown">
                <a href="dataGuru.php" class="sidebar-item dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#dataAkunSubmenu" aria-expanded="false">
                    <i class="fas fa-users"></i> Data Akun
                </a>
                <ul id="dataAkunSubmenu" class="list-group collapse">
                    <li class="sidebar-item">
                        <a href="dataGuru.php" class="sidebar-item"><i class="fas fa-chalkboard-teacher"></i> Data Guru</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dataSiswa.php" class="sidebar-item"><i class="fas fa-user-graduate"></i> Data Siswa</a>
                    </li>
                </ul>
            </div>
            <a href="dataKelas.php" class="sidebar-item"><i class="fas fa-school"></i> Data Kelas</a>
            <a href="dataMapel.php" class="sidebar-item"><i class="fas fa-book"></i> Data Mata Pelajaran</a>
            <a href="dataJadwal.php" class="sidebar-item"><i class="fas fa-calendar-alt"></i> Kelola Jadwal</a>
            <a href="tahunAjaran.php" class="sidebar-item"><i class="fas fa-calendar"></i> Tahun Ajaran</a>
            <a href="dataNilaiSiswa.php" class="sidebar-item"><i class="fas fa-graduation-cap"></i> Data Nilai Siswa</a>
            <a href="naikKelas.php" class="sidebar-item"><i class="fas fa-level-up-alt"></i> Naik Kelas</a>
            <a href="rapot.php" class="sidebar-item"><i class="fas fa-print"></i> Cetak Raport</a>
            <a href="pengumuman.php" class="sidebar-item"><i class="fas fa-bullhorn"></i> Berita/Pengumuman</a>
        </div>
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle">☰</button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Kontak : <span>smkalfalah@yahoo.com</span></a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../uploads/profile/admin.png" class="rounded-circle" alt="Profile Image" style="width: 30px; height: 30px;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

