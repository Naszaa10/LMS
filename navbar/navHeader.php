<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location:../login_guru.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];

// Query untuk mendapatkan data guru
$queryGuru = "SELECT foto_profil FROM guru WHERE nip = '$nip'";
$resultGuru = mysqli_query($conn, $queryGuru);
$guru = mysqli_fetch_assoc($resultGuru);
$fotoProfil = !empty($guru['foto_profil']) ? '../uploads/profile/' . $guru['foto_profil'] : 'https://via.placeholder.com/30';

// Atur zona waktu ke Jakarta
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="..\css\test.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <a href="dashboardGuru.php" class="sidebar-item"><i class="fas fa-home-alt"></i> Dashboard</a>
                <a href="index.php" class="sidebar-item"><i class="fas fa-book"></i> Mata Pelajaran</a>
                <a href="jadwalGuru.php" class="sidebar-item"><i class="fas fa-calendar-alt"></i> Jadwal</a>
                <a href="nilaiGuru.php" class="sidebar-item"><i class="fas fa-graduation-cap"></i> Nilai</a>
                <a href="nilaiTugasGuru.php" class="sidebar-item"><i class="fas fa-pencil-alt"></i> Nilai Tugas</a>
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
                                        <img src="<?php echo $fotoProfil; ?>" class="rounded-circle" alt="Profile Image" style="width: 30px; height: 30px;">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                                        <li><a class="dropdown-item" href="profileGuru.php">Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
            </nav>
