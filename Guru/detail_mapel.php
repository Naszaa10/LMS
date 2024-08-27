<?php
session_start();
include '../db.php';

$kode_mapel = $_GET['kode_mapel'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? ''; // Ambil ID Kelas dari Session

// Query untuk mendapatkan detail mata pelajaran
$sql = "SELECT * FROM mata_pelajaran WHERE kode_mapel = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode_mapel);
$stmt->execute();
$result = $stmt->get_result();
$mapel = $result->fetch_assoc();

if (!$mapel) {
    die('Data mata pelajaran tidak ditemukan.');
}

// Query untuk mendapatkan topik berdasarkan kode_mapel dan kelas_id
$sqlTopik = "SELECT * FROM topik WHERE kode_mapel = ? AND kelas_id = ? ORDER BY nama_topik";
$stmtTopik = $conn->prepare($sqlTopik);
$stmtTopik->bind_param("si", $kode_mapel, $kelas_id);
$stmtTopik->execute();
$resultTopik = $stmtTopik->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Detail Mata Pelajaran</h2>
        <h4>Nama Mata Pelajaran: <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h4>
        <a href="tambah_topik.php?kode_mapel=<?php echo urlencode($kode_mapel); ?>&kelas_id=<?php echo urlencode($kelas_id); ?>" class="btn btn-primary mb-3">Tambah Topik</a>

        <!-- Menampilkan Topik -->
        <?php if ($resultTopik->num_rows > 0): ?>
            <h5>Topik</h5>
            <div class="row">
                <?php while ($topik = $resultTopik->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($topik['nama_topik']); ?></h5>
                                <a href="materi_tugas.php?topik_id=<?php echo urlencode($topik['id']); ?>&kode_mapel=<?php echo urlencode($kode_mapel); ?>&kelas_id=<?php echo urlencode($kelas_id); ?>" class="btn btn-primary">Lihat Materi & Tugas</a>
                                <a href="hapus_topik.php?topik_id=<?php echo urlencode($topik['id']); ?>&kode_mapel=<?php echo urlencode($kode_mapel); ?>&kelas_id=<?php echo urlencode($kelas_id); ?>" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus topik ini?');">Hapus Topik</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Belum ada topik untuk mata pelajaran ini di kelas ini.
        <?php endif; ?>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>


<?php
// Tutup koneksi database
$conn->close();
?>
