<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$mapel_id = $_GET['mapel_id'];
$topik_id = $_GET['topik_id'];

// Query untuk mendapatkan topik
$sqlTopik = "SELECT * FROM topik WHERE id = ?";
$stmtTopik = $conn->prepare($sqlTopik);
$stmtTopik->bind_param("i", $topik_id);
$stmtTopik->execute();
$topik = $stmtTopik->get_result()->fetch_assoc();

// Query untuk mendapatkan materi dan tugas berdasarkan mata pelajaran dan topik
$sqlMateri = "
    SELECT * FROM materi 
    WHERE mata_pelajaran_id = ? AND topik_id = ?
";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("ii", $mapel_id, $topik_id);
$stmtMateri->execute();
$resultMateri = $stmtMateri->get_result();

$sqlTugas = "
    SELECT * FROM tugas 
    WHERE mata_pelajaran_id = ? AND topik_id = ?
";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("ii", $mapel_id, $topik_id);
$stmtTugas->execute();
$resultTugas = $stmtTugas->get_result();
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
        <h4>Topik: <?php echo htmlspecialchars($topik['nama_topik']); ?></h4>
        <a href="tambah_materi_tugas.php?mapel_id=<?php echo $mapel_id; ?>&topik_id=<?php echo $topik_id; ?>" class="btn btn-primary mb-3">Tambah Materi/Tugas</a>
        
        <h5>Materi</h5>
        <div class="row">
            <?php while ($row = $resultMateri->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Gambar Placeholder">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['keterangan']); ?></p>
                            <?php if ($row['file_path']): ?>
                                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary" target="_blank">Lihat File</a>
                            <?php endif; ?>
                            <p class="card-text"><small class="text-muted">Tanggal Tenggat: <?php echo htmlspecialchars($row['tanggal_tenggat']); ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <h5>Tugas</h5>
        <div class="row">
            <?php while ($row = $resultTugas->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['keterangan']); ?></p>
                            <p class="card-text">Opsi Tugas: <?php echo htmlspecialchars($row['opsi_tugas']); ?></p>
                            <p class="card-text"><small class="text-muted">Tanggal Tenggat: <?php echo htmlspecialchars($row['tanggal_tenggat']); ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
