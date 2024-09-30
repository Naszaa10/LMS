<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\dashboardAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php 
session_start();

if (!isset($_SESSION['nis_siswa'])) {
    header("Location: ../login.php");
    exit();
}

include '../navbar/navSiswa.php'; 
include '../db.php'; // Termasuk koneksi database

// Ambil NIS dari session
$nis = $_SESSION['nis_siswa']; // Mengasumsikan NIS disimpan dalam session

// Query untuk mendapatkan id_kelas berdasarkan NIS
$queryKelas = "SELECT id_kelas FROM siswa WHERE nis = '$nis'";
$resultKelas = mysqli_query($conn, $queryKelas);
$rowKelas = mysqli_fetch_assoc($resultKelas);
$id_kelas = $rowKelas['id_kelas'];

// Query untuk mendapatkan jumlah mata pelajaran unik dari tabel jadwal
$queryMataPelajaran = "SELECT COUNT(DISTINCT kode_mapel) as jumlah FROM jadwal WHERE id_kelas = '$id_kelas'";
$resultMataPelajaran = mysqli_query($conn, $queryMataPelajaran);
$rowMataPelajaran = mysqli_fetch_assoc($resultMataPelajaran);
$jumlahMataPelajaran = $rowMataPelajaran['jumlah'];

// Query untuk mendapatkan jumlah jadwal
$queryJadwal = "SELECT COUNT(*) as jumlah FROM jadwal WHERE id_kelas = '$id_kelas'";
$resultJadwal = mysqli_query($conn, $queryJadwal);
$rowJadwal = mysqli_fetch_assoc($resultJadwal);
$jumlahJadwal = $rowJadwal['jumlah'];

// Query untuk mendapatkan pengumuman terbaru
$queryPengumuman = "SELECT isi_pengumuman FROM pengumuman WHERE (role = 'siswa' OR role = 'semua') ORDER BY tanggal DESC LIMIT 1";
$resultPengumuman = mysqli_query($conn, $queryPengumuman);

// Periksa apakah ada pengumuman
if (mysqli_num_rows($resultPengumuman) > 0) {
    $rowPengumuman = mysqli_fetch_assoc($resultPengumuman);
    $isiPengumuman = $rowPengumuman['isi_pengumuman'];
} else {
    $isiPengumuman = "Belum ada pengumuman.";
}
?>

<div id="mainContent" class="container-fluid mt-1">
    <h1 class="mt-4">Dashboard Siswa</h1>
    <p>Selamat datang di dashboard Siswa. Di sini Anda dapat melihat informasi penting.</p>
    
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

    <h2 class="mt-4">Pengumuman</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Pengumuman Terbaru</h5>
            <textarea class="form-control" rows="5" readonly><?php echo $isiPengumuman; ?></textarea>
        </div>
    </div>
</div>

<!-- Bootstrap JS dan custom JS -->
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
