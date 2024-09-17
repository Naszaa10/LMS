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
                <a href="index.php" class="list-group-item list-group-item-action">Dashboard</a>
                <!-- Dropdown Data Akun -->
                <div class="dropdown">
                    <a href="dataGuru.php" class="list-group-item list-group-item-action dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#dataAkunSubmenu" aria-expanded="false">
                        Data Akun
                    </a>
                    <ul id="dataAkunSubmenu" class="list-group collapse">
                    <li class="list-group-item list-group-item-action">
                            <a href="dataGuruSiswa.php">Data Guru</a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="dataGuru.php">Data Guru</a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <a href="dataSiswa.php">Data Siswa</a>
                        </li>
                    </ul>
                </div>
                <a href="tambahKelas.php" class="list-group-item list-group-item-action">Tambah Kelas</a>
                <a href="tambah_matapelajaran.php" class="list-group-item list-group-item-action">Menambah Mata Pelajaran</a>
                <a href="kelolaJadwal.php" class="list-group-item list-group-item-action">Kelola Jadwal</a>
                <a href="tahunAjaran.php" class="list-group-item list-group-item-action">Tahun Ajaran</a>
                <a href="#" class="list-group-item list-group-item-action">Data Nilai</a>
                <a href="rapot.php" class="list-group-item list-group-item-action">Cetak Raport</a>
                <a href="#" class="list-group-item list-group-item-action">Berita/Pengumuman</a>
            </div>
        </div>
        

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
                    <!-- <button class="btn btn-primary" id="menu-toggle">☰</i></button> -->
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
                                        <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Profile Image">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><a class="dropdown-item" href="#">Settings</a></li>
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
