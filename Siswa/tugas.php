<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjakan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
include '../navbar/navSiswa.php';
include '../db.php';
include '../navbar/navFooter.php';

// Ambil topik_id dan kode_mapel dari URL
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];

// Ambil NIS siswa dari session
$nis_siswa = $_SESSION['nis_siswa'];

// Query untuk mendapatkan tugas berdasarkan topik_id
$query_tugas = "
    SELECT id_tugas, judul, keterangan, tanggal_tenggat, opsi_tugas
    FROM tugas
    WHERE topik_id = '$topik_id' AND kode_mapel = '$kode_mapel'
";
$result_tugas = mysqli_query($conn, $query_tugas);
$tugas = mysqli_fetch_assoc($result_tugas);
?>

<div class="container mt-2">
    <h2>Mengerjakan Tugas</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($tugas['judul']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($tugas['keterangan']); ?></p>
            <p class="card-text"><strong>Tanggal Tenggat:</strong> <?php echo htmlspecialchars($tugas['tanggal_tenggat']); ?></p>
            
            <!-- Form Mengerjakan Tugas -->
            <form action="kirim_tugas.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tugas_id" value="<?php echo htmlspecialchars($tugas['id_tugas']); ?>">
                <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">
                <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                <input type="hidden" name="nis_siswa" value="<?php echo htmlspecialchars($nis_siswa); ?>">

                <!-- Opsi Tugas -->
                <?php if ($tugas['opsi_tugas'] == 'teks'): ?>
                    <div class="mb-3">
                        <label for="jawaban" class="form-label">Jawaban:</label>
                        <textarea class="form-control" id="jawaban" name="jawaban" rows="5"></textarea>
                    </div>
                <?php elseif ($tugas['opsi_tugas'] == 'upload'): ?>
                    <div class="mb-3">
                        <label for="file_tugas" class="form-label">Unggah File Tugas:</label>
                        <input class="form-control" type="file" id="file_tugas" name="file_tugas">
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Kirim Tugas</button>
                <button type="submit" class="btn btn-success">Materi Tugas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
