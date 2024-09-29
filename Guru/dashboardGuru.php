<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\dashboardAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php 
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];
include '../navbar/navHeader.php';

// Query untuk mendapatkan jumlah mata pelajaran unik dari tabel jadwal
$queryMataPelajaran = "SELECT COUNT(DISTINCT kode_mapel) as jumlah FROM jadwal WHERE nip = '$nip'";
$resultMataPelajaran = mysqli_query($conn, $queryMataPelajaran);
$rowMataPelajaran = mysqli_fetch_assoc($resultMataPelajaran);
$jumlahMataPelajaran = $rowMataPelajaran['jumlah'];

// Query untuk mendapatkan jumlah jadwal
$queryJadwal = "SELECT COUNT(*) as jumlah FROM jadwal WHERE nip = '$nip'";
$resultJadwal = mysqli_query($conn, $queryJadwal);
$rowJadwal = mysqli_fetch_assoc($resultJadwal);
$jumlahJadwal = $rowJadwal['jumlah'];

// Query untuk mendapatkan pengumuman terbaru
$queryPengumuman = "SELECT isi_pengumuman FROM pengumuman WHERE tanggal = (SELECT MAX(tanggal) FROM pengumuman WHERE role = 'guru' OR 'semua' )";
$resultPengumuman = mysqli_query($conn, $queryPengumuman);

// Periksa apakah ada pengumuman
if (mysqli_num_rows($resultPengumuman) > 0) {
    $rowPengumuman = mysqli_fetch_assoc($resultPengumuman);
    $isiPengumuman = $rowPengumuman['isi_pengumuman'];
} else {
    $isiPengumuman = "Belum ada pengumuman.";
}

?>

<div id="mainContent" class="container-fluid">
    <h1>Dashboard Guru</h1>
    <p>Selamat datang di dashboard guru. Di sini Anda dapat melihat informasi terkini.</p>
    
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-book fa-2x me-3"></i>
                    <div>
                        <h5>Mata Pelajaran</h5>
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlahMataPelajaran; ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-calendar-alt fa-2x me-3"></i>
                    <div>
                        <h5>Jadwal</h5>
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlahJadwal; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <h2>Pengumuman</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pengumuman Terbaru</h5>
            <textarea class="form-control" rows="5" readonly><?php echo $isiPengumuman; ?></textarea>
        </div>
    </div>
</div>

<!-- Bootstrap JS and custom JS -->
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
