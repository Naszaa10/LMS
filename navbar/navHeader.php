<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Profile and Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg custom-bg">
        <button id="sidebarToggle" class="btn btn-primary me-3">☰</button>
        <a href="#" class="navbar-logo">SMK<span>Al Falah</span></a>
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Kontak : <span>Alfalah@sakola.com</span> |</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features | </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing |</a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Profile Image">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                        <li><a class="dropdown-item" href="profileGuru.php">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../Index.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-container">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-2 d-md-block custom-bg sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengumuman.php">Jadwal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nilaiGuru.php">Nilai</a>
                    </li>
                </ul>
            </div>
        </nav>
</body>
</html>
