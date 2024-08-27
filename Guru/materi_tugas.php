<?php
session_start();
include '../db.php';

$topik_id = $_GET['topik_id'] ?? '';
$kode_mapel = $_GET['kode_mapel'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? '';

// Query untuk mendapatkan materi berdasarkan topik_id
$sqlMateri = "SELECT * FROM materi WHERE topik_id = ?";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("i", $topik_id);
$stmtMateri->execute();
$resultMateri = $stmtMateri->get_result();

// Query untuk mendapatkan tugas berdasarkan topik_id
$sqlTugas = "SELECT * FROM tugas WHERE topik_id = ?";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("i", $topik_id);
$stmtTugas->execute();
$resultTugas = $stmtTugas->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi dan Tugas Topik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Materi dan Tugas</h2>
        <h4>Topik: <?php echo htmlspecialchars($topik_id); ?></h4>
        
        <!-- Form Tambah Materi -->
        <h5>Tambah Materi</h5>
        <form action="proses_tambah_materi.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">
            <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
            <input type="hidden" name="kelas_id" value="<?php echo htmlspecialchars($kelas_id); ?>">
            <div class="mb-3">
                <label for="judul_materi" class="form-label">Judul Materi</label>
                <input type="text" class="form-control" id="judul_materi" name="judul_materi" required>
            </div>
            <div class="mb-3">
                <label for="keterangan_materi" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan_materi" name="keterangan_materi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">File Materi (opsional)</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Materi</button>
        </form>
        
        <!-- Form Tambah Tugas -->
        <h5 class="mt-4">Tambah Tugas</h5>
        <form action="proses_tambah_tugas.php" method="post">
            <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">
            <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
            <input type="hidden" name="kelas_id" value="<?php echo htmlspecialchars($kelas_id); ?>">
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">Judul Tugas</label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" required>
            </div>
            <div class="mb-3">
                <label for="keterangan_tugas" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan_tugas" name="keterangan_tugas" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="opsi_tugas" class="form-label">Opsi Tugas</label>
                <select class="form-control" id="opsi_tugas" name="opsi_tugas" required>
                    <option value="upload">Upload</option>
                    <option value="ketik">Ketik Langsung</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_tenggat" class="form-label">Tanggal Tenggat</label>
                <input type="date" class="form-control" id="tanggal_tenggat" name="tanggal_tenggat" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Tugas</button>
        </form>
        
        <!-- Menampilkan Materi -->
        <h5 class="mt-4">Materi</h5>
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
                            <a href="proses_hapus_materi.php?materi_id=<?php echo urlencode($row['id']); ?>&topik_id=<?php echo urlencode($topik_id); ?>" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">Hapus Materi</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Menampilkan Tugas -->
        <h5 class="mt-4">Tugas</h5>
        <div class="row">
            <?php while ($row = $resultTugas->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['keterangan']); ?></p>
                            <p class="card-text">Opsi Tugas: <?php echo htmlspecialchars($row['opsi_tugas']); ?></p>
                            <p class="card-text"><small class="text-muted">Tanggal Tenggat: <?php echo htmlspecialchars($row['tanggal_tenggat']); ?></small></p>
                            <a href="proses_hapus_tugas.php?tugas_id=<?php echo urlencode($row['id']); ?>&topik_id=<?php echo urlencode($topik_id); ?>" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">Hapus Tugas</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
