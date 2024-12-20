<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Profile and Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/landingpage.css">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <img src="uploads\gambar\SMK_AF.png" alt="logoalfalah">
        <a href="index.php" class="navbar-logo">SMK<span>Al Falah</span></a>
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Kontak : <span>smkalfalah@yahoo.com</span></a>
                    </li>
                </ul>
            </div>
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <button type="button" class="btn btn-dark">Masuk</button>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                        <li><a class="dropdown-item" href="login_siswa.php">Login</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="register.php">Register</a>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

