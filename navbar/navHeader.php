<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];

// Query untuk mendapatkan data guru
$queryGuru = "SELECT foto_profil FROM guru WHERE nip = '$nip'";
$resultGuru = mysqli_query($conn, $queryGuru);
$guru = mysqli_fetch_assoc($resultGuru);
$fotoProfil = !empty($guru['foto_profil']) ? '../uploads/profile/' . $guru['foto_profil'] : 'https://via.placeholder.com/30';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Screen Responsive Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\styles.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">
                <img src="..\uploads\gambar\logo.png" alt="Logo" class="logo-img">
                <h4 class="mt-2">SMK AlFALAH</h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="dashboardGuru.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="index.php" class="list-group-item list-group-item-action">Mata Pelajaran</a>
                <a href="jadwalGuru.php" class="list-group-item list-group-item-action">Jadwal</a>
                <a href="nilaiGuru.php" class="list-group-item list-group-item-action">Nilai</a>
                <a href="nilaiTugasGuru.php" class="list-group-item list-group-item-action">Nilai Tugas</a>
                <a href="#" class="list-group-item list-group-item-action">Berita/Pengumuman</a>
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
                                <a class="nav-link" aria-current="page" href="#">Kontak : <span>Alfalah@sakola.coid</span></a>
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

        <!-- <footer>
        <p>&copy; 2024 LMS SMK AL FALAH. All rights reserved.</p>
    </footer> -->
</body>
</html>
