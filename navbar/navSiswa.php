<?php
session_start();
include '../db.php'; // Koneksi database

// Pastikan siswa sudah login
if (!isset($_SESSION['nis_siswa'])) {
    header("Location:../login_siswa.php");
    exit();
}

// Ambil NIS dari sesi (asumsi Anda menyimpan NIS siswa di session)
$nis_siswa = $_SESSION['nis_siswa'];

// Query untuk mendapatkan data siswa
$querySiswa = "SELECT foto_profil FROM siswa WHERE nis = '$nis_siswa'";
$resultSiswa = mysqli_query($conn, $querySiswa);
$siswa = mysqli_fetch_assoc($resultSiswa);
$fotoProfil = !empty($siswa['foto_profil']) ? '../uploads/profile/' . $siswa['foto_profil'] : 'https://via.placeholder.com/30';

// Atur zona waktu ke Jakarta
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SMK AL FALAH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">
                <img src="../uploads/gambar/SMK_AF.png" alt="Logo" class="logo-img">
                <h4 class="mt-2">SMK AL FALAH</h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="dasboardSiswa.php" class="sidebar-item">
                    <i class="fas fa-home-alt"></i> Dashboard
                </a>
                <a href="index.php" class="sidebar-item">
                    <i class="fas fa-book"></i> Mata Pelajaran
                </a>
                <a href="jadwalSiswa.php" class="sidebar-item">
                    <i class="fas fa-calendar-alt"></i> Jadwal
                </a>
                <a href="nilaiSiswa.php" class="sidebar-item">
                    <i class="fas fa-graduation-cap"></i> Nilai
                </a>
                <a href="nilaiTugas.php" class="sidebar-item">
                    <i class="fas fa-pencil-alt"></i> Nilai Tugas
                </a>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">☰</button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="https://www.smkalfalahbandung.sch.id/konten/kontak">Kontak : <span>smkalfalah@yahoo.com</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item-dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo $fotoProfil; ?>" class="rounded-circle" alt="Profile Image" style="width: 30px; height: 30px;">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                                    <li><a class="dropdown-item" href="profileSiswa.php">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        



